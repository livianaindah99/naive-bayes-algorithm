<?php

namespace Livianaindah\NaiveBayes\Tests;

use Livianaindah\NaiveBayes\NaiveBayes;
use PHPUnit\Framework\TestCase;

class NaiveBayesTest extends TestCase {
    public function testPredict()
    {
        $dataLatih = [
            [
                'K1' => 'SUNNY', 'K2' => 'HOT', 'K3' => "HIGH", 'K4' => 'WEAK', NaiveBayes::TARGET_KEY => 'NO' // 1 
            ],
            [
                'K1' => 'SUNNY', 'K2' => 'HOT', 'K3' => "HIGH", 'K4' => 'STRONG', NaiveBayes::TARGET_KEY => 'NO' // 2
            ],
            [
                'K1' => 'OVERCAST', 'K2' => 'HOT', 'K3' => "HIGH", 'K4' => 'WEAK', NaiveBayes::TARGET_KEY => 'YES' //3
            ],
            [
                'K1' => 'RAIN', 'K2' => 'MILD', 'K3' => "HIGH", 'K4' => 'WEAK', NaiveBayes::TARGET_KEY => 'YES' // 4
            ],
            [
                'K1' => 'RAIN', 'K2' => 'COOL', 'K3' => "NORMAL", 'K4' => 'WEAK', NaiveBayes::TARGET_KEY => 'YES' // 5
            ],
            [
                'K1' => 'RAIN', 'K2' => 'COOL', 'K3' => "NORMAL", 'K4' => 'STRONG', NaiveBayes::TARGET_KEY => 'NO' // 6
            ],
            [
                'K1' => 'OVERCAST', 'K2' => 'COOL', 'K3' => "NORMAL", 'K4' => 'STRONG', NaiveBayes::TARGET_KEY => 'YES' // 7
            ],
            [
                'K1' => 'SUNNY', 'K2' => 'MILD', 'K3' => "HIGH", 'K4' => 'WEAK', NaiveBayes::TARGET_KEY => 'NO' // 8
            ],
            [
                'K1' => 'SUNNY', 'K2' => 'COOL', 'K3' => "NORMAL", 'K4' => 'WEAK', NaiveBayes::TARGET_KEY => 'YES' // 9
            ],
            [
                'K1' => 'RAIN', 'K2' => 'MILD', 'K3' => "NORMAL", 'K4' => 'WEAK', NaiveBayes::TARGET_KEY => 'YES' // 10
            ],
            [
                'K1' => 'SUNNY', 'K2' => 'MILD', 'K3' => "NORMAL", 'K4' => 'STRONG', NaiveBayes::TARGET_KEY => 'YES' // 11
            ],
            [
                'K1' => 'OVERCAST', 'K2' => 'MILD', 'K3' => "HIGH", 'K4' => 'STRONG', NaiveBayes::TARGET_KEY => 'YES' // 12
            ],
            [
                'K1' => 'OVERCAST', 'K2' => 'HOT', 'K3' => "NORMAL", 'K4' => 'WEAK', NaiveBayes::TARGET_KEY => 'YES' // 13
            ],
            [
                'K1' => 'RAIN', 'K2' => 'MILD', 'K3' => "HIGH", 'K4' => 'STRONG', NaiveBayes::TARGET_KEY => 'NO' // 14
            ]
        ];
        
        $bayes = new NaiveBayes($dataLatih);
        
        $dataUji = [
            'NO' => [
                ['K1' => 'SUNNY', 'K2' => 'COOL', 'K3' => "HIGH", 'K4' => 'STRONG'],
                ['K1' => 'SUNNY', 'K2' => 'COOL', 'K3' => "HIGH", 'K4' => 'WEAK']
            ]
        ];
        
        foreach ($dataUji as $target => $data) {
            foreach ($data as $uji) {
                $result = $bayes->predict($uji);
                $this->assertEquals($target, $result['result'][NaiveBayes::TARGET_KEY]);
            }     
        }     
    }
}
?>