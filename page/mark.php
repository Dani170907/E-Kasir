<?php

include "../config/connection.php";

// Pastikan $orderId dari URL
$orderId = isset($_GET['orderId']) ? $_GET['orderId'] : '';
if (empty($orderId)) {
    // Perbaiki penulisan header
    header('Location: ../index.php?p=order');
    exit;
}

// Jalankan query untuk update status
$sql = "UPDATE orders SET status = '1' WHERE orderId = '$orderId'";
$query = mysqli_query($connection, $sql);

// Cek apakah query berhasil atau tidak
if ($query) {
    ?>
    <script type="text/javascript">
        window.location.href = "../index.php?p=order";
    </script>
    <?php
} else {
    // Tampilkan pesan error jika query gagal
    ?>
    <script type="text/javascript">
        alert('Gagal mengubah status: <?= mysqli_error($connection) ?>');
        window.location.href = "../index.php?p=order";
    </script>
    <?php
}
?>
