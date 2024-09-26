<?php
$sql = "SELECT max(customerId) as maxCode FROM customers";
$query = mysqli_query($connection, $sql); // Perbaikan di sini, mengganti my_sqli_query dengan mysqli_query

$data = mysqli_fetch_array($query); // Perbaikan di sini, mengganti my_sqli_fetch_array dengan mysqli_fetch_array
$customerId = $data['maxCode'];


$serialNumber = (int) substr($customerId, -3); // Mengubah parameter substr agar sesuai dengan serial number
$serialNumber++;

$char = "PLG";
$customerCode = $char . sprintf("%03s", $serialNumber);
echo $customerCode;
?>

<div class="row">
    <center>
        <h2>Pesanan</h2>
    </center>
    <div class="col-lg-5">
        <div class="panel panel-primary">
            <div class="panel-heading">Form Pesanan</div>
            <div class="panel-body">

                <form action="" method="post">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">ID Pelanggan</label>
                            <input type="text" name="customerId" class="form-control" readonly="readonly" value="<?= $customerCode ?>">
                        </div>

                        <div class="form-group">
                            <label for="ID Pelanggan">Nama Pelanggan</label>
                            <input type="text" name="customerName" class="form-control" value="">
                        </div>

                        <div class="form-group">
                            <label for="ID Pelanggan">Jenis Kelamin</label>
                            <select name="gender" id="" class="form-control">
                                <option value="" disabled selected> ~ Jenis Kelamin ~ </option>
                                <option value="Male">Laki-laki</option>
                                <option value="Female">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">No. Telepon</label>
                            <input type="number" name="phoneNumber" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Alamat</label>
                            <textarea name="address" id="" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Barang</label>
                            <select name="productId" id="" class="form-control">
                                <option value="" disabled selected> ~ Pilih Barang ~ </option>
                                <?php
                                $sqlProducts = "SELECT * FROM products";
                                $queryProducts = mysqli_query($connection, $sqlProducts); // Perbaikan di sini
                                while ($product = mysqli_fetch_array($queryProducts)) : // Perbaikan di sini
                                    ?>
                                    <option value="<?= $product['productId'] ?>"><?= $product['productName'] ?></option>
                                    <?php
                                endwhile;
                                ?>
                            </select>
                        </div>    

                        <div class="form-group">
                            <label for="">Jumlah</label>
                            <input type="number" name="total" class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="save" class="btn btn-md btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>

                <?php if (isset($_POST['save'])) : ?>
                    <?php 
                        $customerId = $_POST['customerId']; 
                        $customerName = $_POST['customerName'];
                        $gender = $_POST['gender'];
                        $phoneNumber = $_POST['phoneNumber'];
                        $address = $_POST['address'];
                        $productId = $_POST['productId'];
                        $total = $_POST['total'];
                        $userId = 1; // Sesuaikan dengan ID user yang sedang login

                        $sqlCustomers = "INSERT INTO customers (customerId, customerName, gender, phoneNumber, address) VALUES ('$customerId', '$customerName', '$gender', '$phoneNumber', '$address')";
                        $queryInput = mysqli_query($connection, $sqlCustomers);
                        if ($queryInput) { 
                            $sqlOrder = "INSERT INTO orders (productId, customerId, total, userId, status) VALUES ('$productId', '$customerId', '$total', '$userId', '0')";
                            $queryOrder = mysqli_query($connection, $sqlOrder);
                            if ($queryOrder) {
                                ?>
                                <div class="alert alert-success">Berhasil Menyimpan</div>
                                <?php
                            } else {
                                ?>
                                <div class="alert alert-danger">Gagal Menyimpan</div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="alert alert-danger">Gagal Menyimpan</div>
                            <?php
                        }
                    ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                Daftar Pesanan Hari Ini
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Pelanggan</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <!-- Tambahkan daftar pesanan di sini -->
                </table>
            </div>
        </div>
    </div>
</div>
