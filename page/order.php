<?php
$sql = "SELECT max(customerId) as maxKode FROM customers";
$query = mysqli_query($connection, $sql);

$data = mysqli_fetch_array($query);
$customerId = isset($data['maxKode']) ? $data['maxKode'] : null;

if ($customerId) {
    $serialNumber = (int) substr($customerId, 3, 3);
} else {
    $serialNumber = 0;
}

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
                            <label for="Nama Pelanggan">Nama Pelanggan</label>
                            <input type="text" name="customerName" class="form-control" value="">
                        </div>

                        <div class="form-group">
                            <label for="Jenis Kelamin">Jenis Kelamin</label>
                            <select name="gender" class="form-control">
                                <option value="" disabled selected> ~ Jenis Kelamin ~ </option>
                                <option value="Male">Laki-laki</option>
                                <option value="Female">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="No. Telepon">No. Telepon</label>
                            <input type="number" name="phoneNumber" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="Alamat">Alamat</label>
                            <textarea name="address" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Barang">Barang</label>
                            <select name="productId" class="form-control">
                                <option value="" disabled selected> ~ Pilih Barang ~ </option>
                                <?php
                                $sqlProducts = "SELECT * FROM products";
                                $queryProducts = mysqli_query($connection, $sqlProducts);

                                while ($product = mysqli_fetch_array($queryProducts)) {
                                    ?>
                                    <option value="<?= $product['productId'] ?>">
                                        <?= $product['productName'] ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="Jumlah">Jumlah</label>
                            <input type="number" name="quantity" class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="save" class="btn btn-md btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>

                <?php if (isset($_POST['save'])) : ?>
                    <?php 
                        // Mendapatkan data dari form
                        $customerId = $_POST['customerId'];
                        $customerName = $_POST['customerName'];
                        $gender = $_POST['gender'];
                        $phoneNumber = $_POST['phoneNumber'];
                        $address = $_POST['address'];
                        $productId = $_POST['productId'];
                        $quantity = $_POST['quantity'];

                        // Insert data ke tabel customers
                        $sqlCustomers = "INSERT INTO customers (customerId, customerName, gender, phoneNumber, address) 
                                         VALUES ('$customerId', '$customerName', '$gender', '$phoneNumber', '$address')";
                        $queryInput = mysqli_query($connection, $sqlCustomers);

                        if ($queryInput) {
                            // Insert data ke tabel orders
                            $userId = 1; // Misalnya userId dari session user login
                            $sqlOrder = "INSERT INTO orders (productId, customerId, quantity, userId, status) 
                                         VALUES ('$productId', '$customerId', '$quantity', '$userId', '0')";
                            $queryOrder = mysqli_query($connection, $sqlOrder);

                            if ($queryOrder) {
                                ?>
                                <script>
                                    alert('Berhasil Menyimpan Pesanan');
                                    window.location.href = "?p=order";  // Refresh halaman setelah alert tampil
                                </script>
                                <?php
                            } else {
                                echo '<div class="alert alert-danger">Gagal Menyimpan Pesanan</div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger">Gagal Menyimpan Pelanggan</div>';
                        }
                    ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="panel panel-default">
            <div class="panel-heading">
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
                    <tbody>
                        <?php
                        $listOrder = "SELECT orders.orderId, customers.customerName, products.productName, orders.quantity, orders.status 
                                      FROM orders 
                                      LEFT JOIN customers ON customers.customerId = orders.customerId
                                      LEFT JOIN products ON products.productId = orders.productId";

                        $queryList = mysqli_query($connection, $listOrder);

                        $check = mysqli_num_rows($queryList);
                        if ( $check > 0 ) {
                            $num = 1;
                            while ($dataList = mysqli_fetch_array($queryList))  {
                                ?>
                                    <tr>
                                        <td><?= $num++ ?></td>
                                        <td><?= $dataList['customerName'] ?></td>
                                        <td><?= $dataList['productName'] ?></td>
                                        <td><?= $dataList['quantity'] ?></td>
                                        <td>
                                            <?php 
                                            if ($dataList['status'] == '0') {
                                                echo "<label class='label label-primary'>Belum</label>";
                                            } else if ($dataList['status'] == '1') {
                                                echo "<label class='label label-success'>Sudah</label>";
                                            } else {
                                                echo "<label class='label label-info'>Lunas</label>";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a onclick="return confirm('Yakin?')" href="page/mark.php?orderId=<?= $dataList['orderId'] ?>" class="btn btn-sm btn-primary">Tandai</a>
                                        </td>
                                    </tr>
                                <?php
                            }
                            ?> <?php
                        } else {
                            ?>
                            <tr>
                                <td colspan="6">Tidak Ada Data</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
