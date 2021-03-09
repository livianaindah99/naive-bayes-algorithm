<?php

include('koneksi.php');

$id = $_POST['id'];
$outlook = $_POST['Outlook'];
$temperature = $_POST['Temperature'];
$humidity = $_POST['Humidity'];
$wind = $_POST['Wind'];
$play = $_POST['Play'];

$hasil = mysqli_query($success, "INSERT INTO dt_latih VALUES('$id','$outlook','$temperature','$humidity', '$wind', '$play')") or die(mysqli_error($success));;

if ($hasil) {
    echo('<br>Data Berhasil Ditambahkan!');
        header("location:index.php");
} else {
    echo('<br>Data Gagal Ditambahkan!');
}

?>