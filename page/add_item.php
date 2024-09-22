<div class="row">
<h2>Tambah Barang</h2>
    <div class="col-lg-4">
        <form action="" method="post" class="form">
            <div class="form-group">
                <label for="">Nama Barang</label>
                <input type="text" name="productName" class="form-control" placeholder="Masukkan Nama Barang">
            </div>
            
            <div class="form-group">
                <label for="category">Kategori</label>
                <select name="category" id="category" class="form-control">
                    <option value="" disabled selected>Pilih Kategori Barang</option>
                    <option value="celana">Celana</option>
                    <option value="hoodie">Hoodie</option>
                    <option value="jaket">Jaket</option>
                    <option value="tas">Tas</option>
                </select>
            </div>

            <div class="form-group">
                <label for="price">Harga</label>
                <input type="number" name="price" id="price" class="form-control" placeholder="Masukkan Harga">
            </div>

            <div class="form-group">
                <button type="submit" name="save" class="btn btn-sm-md btn-primary">Simpan</button>
                <a href="?p=list_item" class="btn btn-md btn-default">Kembali</a>
            </div>
        </form>
    </div>
        <?php
        if (isset($_POST['save'])) :
            $productName = $_POST['productName'];
            $category = $_POST['category'];
            $price = $_POST['price'];

            // Escape input data untuk menghindari SQL injection
            $productName = mysqli_real_escape_string($connection, $productName);
            $price = mysqli_real_escape_string($connection, $price);

            $sql = "INSERT INTO products (productName, category, price) VALUES ('$productName', '$category', '$price')";

            $query = mysqli_query($connection, $sql);

            if ($query) : ?>
                <div class="alert alert-success">
                    Barang berhasil ditambahkan
                </div>
            <?php else : ?>
                <div class="alert alert-danger">
                    Gagal
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>