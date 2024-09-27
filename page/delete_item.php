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
            // Redirect ke halaman list_items dengan pesan sukses menggunakan SweetAlert2
            window.location.href="../index.php?p=list_items&message=deleted";
        </script>
    <?php else : ?>
        <script type="text/javascript">
            // Redirect ke halaman list_items dengan pesan error menggunakan SweetAlert2
            window.location.href="../index.php?p=list_items&message=error";
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
