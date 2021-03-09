<?php

namespace Livianaindah\NaiveBayes;

class NaiveBayes {
    private $trainSheets;
    
    const TARGET_KEY = 'T';
    
    public function __construct(array $trainSheets) 
    {
        $this->trainSheets = $trainSheets;
    }

    public function predict(array $data):array
    {
        $properties = $this->getProperties();
        if (!isset($properties[self::TARGET_KEY])) {
            
            throw new \Exception(sprintf('target key %s is required', self::TARGET_KEY));
        }
        
        $probabilities = $this->getProbabilities($properties);
        
        $this->getPredictProbability($data, $properties, $probabilities);
            
        $this->getResult($probabilities);
        
        return $probabilities;
    }

    protected function getProperties():array
    {
        $criterias = [];
        foreach ($this->trainSheets as $data) {
            
            foreach ($data as $k => $v) {
                
                if(!isset($criterias[$k])) {
                    $criterias[$k] = [];
                }
                
                if (!in_array($v, $criterias[$k])) {
                    $criterias[$k][] = $v;
                }
            }
        }
        
        return $criterias;
    }

    protected function getSeparateByTarget(array $target)
    {
        $datas = [];
        foreach ($target as $v) {
            $datas[$v] = array_filter($this->trainSheets, function ($row) use ($v) {
                if (!isset($row[self::TARGET_KEY])) {
            
                    throw new \Exception(sprintf('target key %s is required', self::TARGET_KEY));
                }
                
                return $row[self::TARGET_KEY] === $v;
            });
        }
           
        return $datas;
    }

    protected function getProbabilities(array $properties):array
    {
        $datas = $this->getSeparateByTarget($properties[self::TARGET_KEY]);
        
        $probabilities = [];
        foreach ($datas as $t => $value) {
            
            $probabilities[self::TARGET_KEY][$t] = count($value) / count($this->trainSheets);
            
            unset($properties[self::TARGET_KEY]);
            foreach ($properties as $label => $propValue) {
                foreach ($propValue as $prop) {
                    $probs = array_filter($value, function ($row) use ($label, $prop) {
                        
                        return ($row[$label] === $prop);
                    });
                    
                    if (!isset($probabilities[$label][$prop])) {
                        $probabilities[$label][$prop] = [];
                    }
                    $key = sprintf('%s|%s', $prop, $t);
                    $probabilities[$label][$prop][$t] = count($probs) / count($value);
                }
            }
        }
        
        return $probabilities;
    }

    protected function getPredictProbability(array $data, array $properties, array &$probabilities)
    {
        foreach ($properties[self::TARGET_KEY] as $output) {
            if (!isset($probabilities['output'][$output])) {
                $probabilities['output'][$output] = 1;
            }
            
            foreach ($data as $k => $v) {
                $probabilities['output'][$output] *= $probabilities[$k][$v][$output];
            }
            
            $probabilities['output'][$output] *= $probabilities[self::TARGET_KEY][$output];
        }
        
        return $probabilities;
    }

    protected function getResult(array &$probabilities)
    {
        $probabilities['result'] = [];
        foreach ($probabilities['output'] as $k => $v) {
            $probabilities['result'][$k] = $v / array_sum($probabilities['output']);
        }
        
        $max = max($probabilities['result']);
        
        $result = array_filter($probabilities['result'], function ($row) use ($max) {
            return $row == $max;
        });
        
        $probabilities['result'][self::TARGET_KEY] = key($result);
        
        return $probabilities;
    }
}

?>