<?php
include "../config/connection.php";

// Periksa apakah productId ada di URL
if (isset($_GET['productId'])) {
    $productId = $_GET['productId'];
    
    // Escape productId untuk mencegah SQL injection
    $productId = mysqli_real_escape_string($connection, $productId);
    
    // Query SQL yang benar
    $sql = "DELETE FROM products WHERE productId = '$productId'";
    
    $query = mysqli_query($connection, $sql);
    
    if ($query) : ?>
        <script type="text/javascript">
            window.location.href="../index.php?p=list_items";
        </script>
    <?php else : ?>
        <script type="text/javascript">
            alert('Terjadi Kesalahan!');
            window.location.href="../index.php?p=list_items";
        </script>
    <?php endif;
} else {
    // Jika productId tidak ada di URL, kembali ke halaman list_items
    ?>
    <script type="text/javascript">
        alert('Data tidak ditemukan!');
        window.location.href="../index.php?p=list_items";
    </script>
<?php
}
?>
