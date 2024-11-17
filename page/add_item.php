<div class="row">
    <h2>Tambah Barang</h2>
    <div class="col-lg-4">
        <form action="" method="post" class="form">
            <div class="form-group">
                <label for="">Nama Barang</label>
                <input type="text" name="productName" class="form-control" placeholder="Masukkan Nama Barang" required>
            </div>

            <div class="form-group">
                <label for="category">Kategori</label>
                <select name="category" id="category" class="form-control" required>
                    <option value="" disabled selected>Pilih Kategori Barang</option>
                    <option value="celana">Celana</option>
                    <option value="hoodie">Hoodie</option>
                    <option value="jaket">Jaket</option>
                    <option value="tas">Tas</option>
                </select>
            </div>

            <div class="form-group">
                <label for="price">Harga</label>
                <input type="text" name="price" id="price" class="form-control" placeholder="Masukkan Harga" required oninput="formatRupiah(this)">
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" placeholder="Masukkan Stock" required>
            </div>

            <div class="form-group">
                <button type="submit" name="save" class="btn btn-sm-md btn-primary">Simpan</button>
                <a href="?p=list_item" class="btn btn-md btn-default">Kembali</a>
            </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST['save'])) {
    $productName = $_POST['productName'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Menghapus simbol 'Rp', titik (pempisah ribuan) dan koma (pemisan desimal)
    $price = str_replace(['Rp', '.', ','], '', $price);

    // Escape input data untuk menghindari SQL injection
    $productName = mysqli_real_escape_string($connection, $productName);
    $category = mysqli_real_escape_string($connection, $category);
    $price = mysqli_real_escape_string($connection, $price);
    $stock = mysqli_real_escape_string($connection, $stock);

    // Insert data ke database
    $sql = "INSERT INTO products (productName, category, price, stock) VALUES ('$productName', '$category', '$price', '$stock')";
    $query = mysqli_query($connection, $sql);

    if ($query) {
        ?>
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Barang Berhasil Ditambahkan!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '?p=list_items';
            });
        </script>
        <?php
    } else {
        ?>
        <script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Gagal menambahkan barang, silakan coba lagi.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
        <?php
    }
}