<?php

include('koneksi.php');

$KKredit = $_POST['KKredit'];
$JenisKelamin = $_POST['JenisKelamin'];
$Pendidikan = $_POST['Pendidikan'];
$BPekerjaan = $_POST['BPekerjaan'];
$KUsia = $_POST['KUsia'];

$hasil = mysqli_query($success, "INSERT INTO datalatih VALUES('$JenisKelamin','$Pendidikan','$BPekerjaan','$KUsia','$KKredit')") or die(mysqli_error($success));;

if ($hasil) {
    echo('<br>Data Berhasil Ditambahkan!');
        header("location:index.php");
} else {
    echo('<br>Data Gagal Ditambahkan!');
}

?>