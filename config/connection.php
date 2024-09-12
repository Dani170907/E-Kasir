<?php

$connection = mysqli_connect("localhost", "root", "", "kasir");

if (mysqli_connect_errno()) {
    echo "Koneksi error : " . mysqli_connect_error();   
} else {
    // echo "Koneksi Berhasil";
}

?>