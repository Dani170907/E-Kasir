<?php
    @$productId = $_GET['productId'];
    if (empty($productId)) {
        ?>
        <script type="text/javascript">
            window.location.href="?p=list_items";
        </script>
        <?php
    }

    // Ambil data produk berdasarkan ID
    $sql = "SELECT * FROM products WHERE productId = '$productId'";
    $query = mysqli_query($connection, $sql);
    $check = mysqli_num_rows($query);
    if ($check > 0) {
        $data = mysqli_fetch_array($query);
    } else {
        $data = NULL;
    }
?>

<div class="row">
    <h2>Edit Barang</h2>
    <div class="col-lg-4">
        <form action="" class="form" method="post">
            <div class="form-group">
                <label for="">Nama Barang</label>
                <input type="text" name="productName" value="<?= $data['productName'] ?>" class="form-control" placeholder="Masukkan Nama Barang">
            </div>

            <div class="form-group">
                <label for="category">Kategori</label>
                <select name="category" id="category" class="form-control" required>
                    <option value="<?= $data['category'] ?>" selected>Kategori saat ini: <?= $data['category'] ?></option>
                    <option value="celana">Celana</option>
                    <option value="hoodie">Hoodie</option>
                    <option value="jaket">Jaket</option>
                    <option value="tas">Tas</option>
                </select>
            </div>

            
            <div class="form-group">
                <label for="">Harga</label>
                <input type="number" name="price" value="<?= $data['price'] ?>" id="" class="form-control">
            </div>

            <div class="form-group">
                <button type="submit" name="save" class="btn btn-md btn-primary">Simpan</button>
                <a href="?p=list_item" class="btn btn-md btn-default">Kembali</a>
            </div>
        </form>

        <?php
            if (isset($_POST['save'])) :
                $productName = $_POST['productName'];
                $price = $_POST['price'];
                
                // Cek apakah kategori ada di POST
                if (isset($_POST['category']) && !empty($_POST['category'])) {
                    $category = $_POST['category'];
                } else {
                    $category = $data['category']; // Jika kategori tidak dipilih, gunakan kategori lama
            }

            // query update
            $sqlUpdate = "UPDATE products SET productName = '$productName', category = '$category', price = '$price' WHERE productId = '$productId'";

            $queryUpdate = mysqli_query($connection, $sqlUpdate);
            if ($queryUpdate) : ?>
                <script type="text/javascript">
                    window.location.href="?p=list_items";
                </script>
            <?php else : ?>
                <div class="alert alert-danger">
                    Gagal menyimpan!
                </div>    
        <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
