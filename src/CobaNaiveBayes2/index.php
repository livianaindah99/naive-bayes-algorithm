<html>
    <head>
        <title>
            Naive Bayes Tennis
        </title>
        <style>
            table{
                width: 70%;
                text-align: center;
            }
            table, th, td {
                border: 1px solid black;
            }
        </style>
    </head>

    <body>
    <form method="POST" action="tambahdata.php">
        <b>Tambah Data Latih</b>
            <input type ="text" name="id" placeholder="id">
            <input type ="text" name="Outlook" placeholder="Outlook">
            <input type ="text" name="Temperature" placeholder="Temperature">
            <input type ="text" name="Humidity" placeholder="Humidity">
            <input type ="text" name="Wind" placeholder="Wind">

            Play
            <select name="Play">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
            </select>
            <input type="Submit" value="Tambah">
        </form>

        <br>
            <b>Tabel Data Latih</b>
        <table>
        <tbody>
            <?php
                include("koneksi.php");
                $query = mysqli_query($success, "SELECT * FROM dt_latih");
                echo "<table><tr><th>ID</th><th>Outlook</th><th>Temperature</th><th>Humidity</th><th>Wind</th><th>Play</th></tr>";
                while ($row = mysqli_fetch_array($query)) {
                    echo "<tr><td>" . $row["id"]. "</td><td>" . $row["Outlook"]. "</td><td>" . $row["Temperature"]. "</td><td>" . $row["Humidity"]. "</td><td>" . $row['Wind']. "</td><td>" . $row['Play']. "</td></tr>";
                }
                echo "</table>"
            ?>
        </tbody>
        </table>

        <?php
            //Inisialisasi Data
            include("koneksi.php");
            $YesPlay = "Yes";
            $NoPlay = "No";
            $outlook = "Sunny";
            $temperature = "Cool";
            $humidity = "High";
            $wind = "Strong";
            
            echo "<br><b> Data Set Yang dimasukan adalah : </b><br>Outlook = $outlook <br>Temperature = $temperature <br>Humidity = $humidity <br> Wind = $wind <br><br>";

            //PERHITUNGAN
            //echo "Play = Yes";
            $sql = "SELECT COUNT(*) AS jumlah FROM dt_latih WHERE Play='$YesPlay'";
            $query = mysqli_query($success, $sql);
            $result = mysqli_fetch_assoc($query);
            //echo $result['jumlah'];
            $YesTennis = $result['jumlah'];

            //echo "Play = No";
            $sql = "SELECT COUNT(*) AS jumlah FROM dt_latih WHERE Play='$NoPlay'";
            $query = mysqli_query($success, $sql);
            $result = mysqli_fetch_assoc($query);
            $NoTennis = $result['jumlah'];

            //Jumlah Semua Data Play
            $sql = "SELECT COUNT(Play) AS jumlah FROM dt_latih";
            $query = mysqli_query($success, $sql);
            $result = mysqli_fetch_assoc($query);
            $JumlahPlay = $result['jumlah'];

            //---> Perhitungan Outlook
            //Sunny "Yes"
            $sql = "SELECT COUNT(*) AS jumlah FROM dt_latih WHERE Outlook='$outlook' && Play='$YesPlay'";
            $query = mysqli_query($success, $sql);
            $result = mysqli_fetch_assoc($query);
            $JumlahOLYes=$result['jumlah'];
            //echo "= $JumlahOLYes";

            //Sunny "No"
            $sql = "SELECT COUNT(*) AS jumlah FROM dt_latih WHERE Outlook='$outlook' && Play='$NoPlay'";
            $query = mysqli_query($success, $sql);
            $result = mysqli_fetch_assoc($query);
            $JumlahOLNo=$result['jumlah'];
            //echo "=$JumlahOLNo";

            //---> Perhitungan Temperature
            //Cool "Yes"
            $sql = "SELECT COUNT(*) AS jumlah FROM dt_latih WHERE Temperature='$temperature' && Play='$YesPlay'";
            $query = mysqli_query($success, $sql);
            $result = mysqli_fetch_assoc($query);
            $JumlahTempYes = $result['jumlah'];

            //Cool "No"
            $sql = "SELECT COUNT(*) AS jumlah FROM dt_latih WHERE Temperature='$temperature' && Play='$NoPlay'";
            $query = mysqli_query($success, $sql);
            $result = mysqli_fetch_assoc($query);
            $JumlahTempNo = $result['jumlah'];

            //--> Perhitungan Humidity
            //High "Yes"
            $sql = "SELECT COUNT(*) AS jumlah FROM dt_latih WHERE Humidity='$humidity' && Play='$YesPlay'";
            $query = mysqli_query($success, $sql);
            $result = mysqli_fetch_assoc($query);
            $JumlahHDYes = $result['jumlah'];

            //High "No"
            $sql = "SELECT COUNT(*) AS jumlah FROM dt_latih WHERE Humidity='$humidity' && Play='$NoPlay'";
            $query = mysqli_query($success, $sql);
            $result = mysqli_fetch_assoc($query);
            $JumlahHDNo = $result['jumlah'];

            //---> Perhitungan Wind
            //Strong "Yes"
            $sql = "SELECT COUNT(*) AS jumlah FROM dt_latih WHERE Wind='$wind' && Play='$YesPlay'";
            $query = mysqli_query($success, $sql);
            $result = mysqli_fetch_assoc($query);
            $JumlahWindYes = $result['jumlah'];

            //Strong "No"
            $sql = "SELECT COUNT(*) AS jumlah FROM dt_latih WHERE Wind='$wind' && Play='$NoPlay'";
            $query = mysqli_query($success, $sql);
            $result = mysqli_fetch_assoc($query);
            $JumlahWindNo = $result['jumlah'];

            //---> Perhitungan Naive Bayes
            $ProbYes = ($YesTennis/$JumlahPlay)*($JumlahOLYes/$YesTennis)*($JumlahTempYes/$YesTennis)*($JumlahHDYes/$YesTennis)*($JumlahWindYes/$YesTennis);
            $ProbNo = ($NoTennis/$JumlahPlay)*($JumlahOLNo/$NoTennis)*($JumlahTempNo/$NoTennis)*($JumlahHDNo/$NoTennis)*($JumlahWindNo/$NoTennis);

            $ProbYes = number_format($ProbYes,6);
            $ProbNo = number_format($ProbNo,6);

            echo "<b>Hasil Perhitungan :</b>";
            echo "<br> Probabilitas (Yes) = $ProbYes";
            echo "<br> Probabilitas (No) = $ProbNo";

            //---> Perhitungan Presentase
            $presentaseyes = ($ProbYes/($ProbYes + $ProbNo))*100;
            $presentaseyes = number_format($presentaseyes,2);

            $presentaseno = ($ProbNo/($ProbYes + $ProbNo))*100;
            $presentaseno = number_format($presentaseno,2);

            $totalpresentaseyes = ($presentaseyes/($presentaseyes + $presentaseno));
            //$totalpresentaseyes = number_format($totalpresentaseyes,2);

            $totalpresentaseno = ($presentaseno/($presentaseyes + $presentaseno));
            //$totalpresentaseno = number_format($totalpresentaseno,2);
            
            echo "<br><br><b>Total Presentase :</b>";
            echo "<br> Presentase (Yes) = $totalpresentaseyes";
            echo "<br> Presentase (No) = $totalpresentaseno";
            
            echo "<br><br><b>Kesimpulan : </b>";
            if ($totalpresentaseyes > $totalpresentaseno) {
                echo "<br>Anda Boleh Bermain Tennis (Yes)";
            
            } else {
                echo "<br>Anda Tidak Boleh Bermain Tennis (No)";
            }
        ?>
    </body>
</html>