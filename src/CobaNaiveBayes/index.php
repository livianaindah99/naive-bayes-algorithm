<html>
<head>
    <title>
        Naive Bayes
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
        <form method="POST" action="tambah.php">
        <b>Tambah Data Latih</b>
            <input type ="text" name="JenisKelamin" placeholder="Jenis kelamin">
            <input type ="text" name="Pendidikan" placeholder="Pendidikan">
            <input type ="text" name="BPekerjaan" placeholder="Bidang Pekerjaan">
            <input type ="text" name="KUsia" placeholder="Kelompok Usia">

            Kartu Kredit
            <select name="KKredit">
            <option value="True">True</option>
            <option value="False">False</option>
            </select>
            <input type="Submit" value="Tambah">
        </form>

        <br>
            <b>Tabel Data Latih</b>
            
        <tbody>
            <td>
            <?php
                include("koneksi.php");
                $query = mysqli_query($success, "SELECT * FROM datalatih");
                echo "<table><tr><th>Jenis Kelamin</th><th>Pendidikan</th><th>Bidang Pekerjaan</th><th>Kelompok Usia</th><th>Kartu Kredit</th></tr>";
                while ($data = mysqli_fetch_array($query)) {
                    echo "<tr><td>" . $data["JenisKelamin"]. "</td><td>" . $data["Pendidikan"]. "</td><td>" . $data["BPekerjaan"]. "</td><td>" . $data["KUsia"]. "</td><td>" . $data['KKredit']. "</td></tr>";
                }
                echo "</table>"
            ?>
            </td>
        </tbody>
    </table>
    
    <?php
        include('koneksi.php');
        //Inisialisasi Nilai
        $nilaiA="True";
        $nilaiB="False";
        $jenisK="Wanita";
        $Pendidikann="SMA";
        $BPekerjaann="Profesional";
        $KUsiaa="Tua";

        echo "Data Set Yang dimasukan adalah : <br>Jenis Kelamin = $jenisK <br>Pendidikann = $Pendidikann <br>Bidang Pekerjaan = $BPekerjaann <br> Usia = $KUsiaa <br><br>";

        //Perhitungan
        //echo "Kartu Kredit = True";
        $sql = "SELECT count(*) AS jumlah FROM datalatih where KKredit='$nilaiA'";
        $query = mysqli_query($success, $sql);
        $result = mysqli_fetch_assoc($query);
        //echo $result['jumlah'];
        $KKTrue = $result['jumlah'];

        //echo "= $KKTrue";
        //echo "<br>";

        //echo "Kartu Kredit = False";
        $sql = "SELECT count(*) AS jumlah FROM datalatih where KKredit='$nilaiB'";
        $query = mysqli_query($success, $sql);
        $result = mysqli_fetch_assoc($query);
        $KKFalse = $result['jumlah'];

        //echo "= $KKFalse";
        // Jumlah Kartu Kredit True
        //echo "<br>";

        //echo "Jumlah Semua Data Kartu Kredit ";
        $sql = "SELECT COUNT(KKredit) AS jumlah FROM datalatih";
        $query = mysqli_query($success, $sql);
        $result = mysqli_fetch_assoc($query);
        $JumlahKK=$result['jumlah'];
        //echo "= $JumlahKK";
        // Jumlah Kartu Kredit True

        //Perhitungan Jenis Kelamin
        //echo Wanita "Yes";
        $sql = "SELECT count(*) AS jumlah FROM datalatih where JenisKelamin='$jenisK' && KKredit='$nilaiA'";
        $query = mysqli_query($success, $sql);
        $result = mysqli_fetch_assoc($query);
        $JumlahJKTrue=$result['jumlah'];
        //echo "= $JumlahJKTrue";
        // Jumlah Kartu Kredit True
        //echo "<br>";

        //echo "Wanita=No";
        $sql = "SELECT count(*) AS jumlah FROM datalatih where JenisKelamin='$jenisK' && KKredit='$nilaiB'";
        $query = mysqli_query($success, $sql);
        $result = mysqli_fetch_assoc($query);
        $JumlahJKFalse = $result['jumlah'];
        //echo "= $JumlahJKFalse";
        //Jumlah Kartu Kredit False

        //Perhitungan Pendidikan
        //echo "SMA = Yes";
        $sql = "SELECT count(*) AS jumlah FROM datalatih where Pendidikan='$Pendidikann' && KKredit='$nilaiA'";
        $query = mysqli_query($success, $sql);
        $result = mysqli_fetch_assoc($query);
        $JumlahPTrue=$result['jumlah'];
        //echo "= $JumlahPTrue";
        //echo "<br>";

        //echo "SMA = No";
        $sql = "SELECT count(*) AS jumlah FROM datalatih where Pendidikan='$Pendidikann' && KKredit='$nilaiB'";
        $query = mysqli_query($success, $sql);
        $result = mysqli_fetch_assoc($query);
        $JumlahPFalse=$result['jumlah'];
        //echo "= $JumlahPFalse";

        //Perhitungan Pekerjaan
        //echo "Pekerjaan=Yes";
        $sql = "SELECT count(*)AS jumlah FROM datalatih where BPekerjaan='$BPekerjaann' && KKredit='$nilaiA'";
        $query = mysqli_query($success, $sql);
        $result = mysqli_fetch_assoc($query);
        $JumlahPkTrue=$result['jumlah'];
        //echo "= $JumlahPkTrue";
        //echo "<br>";

        //echo "Pekerjaan=No ";
        $sql = "SELECT count(*)AS jumlah FROM datalatih where BPekerjaan='$BPekerjaann' && KKredit='$nilaiB'";
        $query = mysqli_query($success, $sql);
        $result = mysqli_fetch_assoc($query);
        $JumlahPkFalse=$result['jumlah'];
        //echo "= $JumlahPkFalse";

        //Perhitungan Kelompok Usia
        //echo "Tua=Yes ";
        $sql = "SELECT count(*)AS jumlah FROM datalatih where KUsia='$KUsiaa' && KKredit='$nilaiA'";
        $query = mysqli_query($success, $sql);
        $result = mysqli_fetch_assoc($query);
        $JumlahKUTrue=$result['jumlah'];
        //echo "= $JumlahKUTrue";
        //echo "<br>";

        //echo "Tua=No ";
        $sql = "SELECT count(*)AS jumlah FROM datalatih where KUsia='$KUsiaa' && KKredit='$nilaiB'";
        $query = mysqli_query($success, $sql);
        $result = mysqli_fetch_assoc($query);
        $JumlahKUFalse=$result['jumlah'];
        //echo "= $JumlahKUFalse";

        //Perhitungan Naive Bayes
        $PYa = ($KKTrue/$JumlahKK)*($JumlahJKTrue/$KKTrue)*($JumlahPTrue/$KKTrue)*($JumlahPkTrue/$KKTrue)*($JumlahKUTrue/$KKTrue);
        $PTi = ($KKFalse/$JumlahKK)*($JumlahJKFalse/$KKFalse)*($JumlahPFalse/$KKFalse)*($JumlahPkFalse/$KKFalse)*($JumlahKUFalse/$KKFalse);

        $PYa = number_format($PYa,5);
        $PTi = number_format($PTi,5);

        echo "Hasil Perhitungan :";
        echo "<br> P(True) = $PYa";
        echo "<br> P(False) = $PTi";

        //Perhitungan Presentase
        $presentase = ($PTi/($PYa + $PTi))*100;
        $presentase = number_format($presentase,2);

        if ($presentase < 50) {
            echo "<br>Presentasi sebesar $presentase % maka Anda Tidak Boleh Menerima Kartu Kredit";
        
        } else {
            echo "<br>Presentasi sebesar $presentase % maka Anda Boleh Menerima Kartu Kredit";
        }
    ?>
    </body>
</html>