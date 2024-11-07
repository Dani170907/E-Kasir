<?php
$orderId = $_GET['orderId'];
if (empty($orderId)) {
    ?>
        <script type="text/javascript">
            window.location.href="?p=transactions";
        </script>
    <?php
}

$listOrder = "SELECT orders.orderId, customers.customerName, products.productName, products.price, orders.quantity, orders.status 
              FROM orders 
              LEFT JOIN customers ON customers.customerId = orders.customerId
              LEFT JOIN products ON products.productId = orders.productId
              WHERE orderId='$orderId'";


$queryList = mysqli_query($connection, $listOrder);
$data = mysqli_fetch_array($queryList);
// print_r($data);

?>

<div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading">Input Pembayaran</div>
        <div class="panel-body">
            <form action="">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Nama Pelanggan</label>
                        <input type="text" name="" class="form-control" value="<?= $data['customerName'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Barang</label>
                        <input type="text" name="" class="form-control" value="<?= $data['productName'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Harga Satuan</label>
                        <input type="text" name="" class="form-control" value="<?= $data['price'] ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Jumlah</label>
                        <input type="number" name="" class="form-control" value="<?= $data['quantity'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Total Bayar</label>
                        <input type="number" name="" class="form-control" value="<?= $data['quantity'] * $data['price'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Uang Pelanggan</label>
                        <input type="number" name="" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>