<?php

$connection = mysqli_connect("localhost", "root", "", "kasir");

// Pengecekan koneksi
if (!$connection) {
    die("Koneksi gagal: " . mysqli_connect_error());
} else {
    // echo "Koneksi Berhasil";
}

?>
