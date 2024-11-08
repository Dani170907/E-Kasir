<?php
$sqlCode = "SELECT max(transactionId) as maxKode FROM transactions";
$queryCode = mysqli_query($connection, $sqlCode);

$data = mysqli_fetch_array($queryCode);
$transactionId = isset($data['maxKode']) ? $data['maxKode'] : null;

if ($transactionId) {
    $serialNumber = (int) substr($transactionId, 3, 3);
} else {
    $serialNumber = 0;
}

$serialNumber++;

$char = "TRX";
$transactionCode = $char . sprintf("%03s", $serialNumber);

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
            <div class="row">
            <form action="" method="post">
                <input type="hidden" name="transactionCode" value="<?= $transactionCode ?>">
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
                        <input type="number" name="total" class="form-control" value="<?= $data['quantity'] * $data['price'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Uang Pelanggan</label>
                        <input type="number" <?= ($data['status'] == '2' ? 'readonly' : '') ?> name="payment" class="form-control">
                    </div>
                    <button type="submit" <?= ($data['status'] == '2' ? 'disabled="disabled"' : '') ?> name="save" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
            </div>
            <br>

            <div class="row">
            <?php 
            // echo $transactionCode;
            ?><a href="?p=transactions">test</a><?php
            if (isset($_POST['save'])) {
                $total = $_POST['total'];
                $payment = $_POST['payment'];
                $code = $_POST['transactionCode'];
                
                if ($payment < $total) {
                    ?>
                        <div class="alert alert-danger">
                            Nominal uang kurang
                        </div>
                        <?php
                } else {
                    $cashback = $payment - $total;

                    $sqlInsert = "INSERT INTO transactions SET transactionId = '$code',
                                  orderId = '$orderId', total = '$total', payment = '$payment', cashback = '$cashback'";
                                  
                    $queryInsert = mysqli_query($connection, $sqlInsert);

                    if ($queryInsert) {
                        $sqlUpdate = "UPDATE orders SET status = '2' WHERE orderId = '$orderId'";
                        $queryUpdate = mysqli_query($connection, $sqlUpdate);

                        if ($queryUpdate) {
                            ?>
                            <div class="col-lg-12">
                            <span style="float: right;">
                                <a target="_blank"></a>
                                <a href="page/print_receipt.php?transactionId=<?= $code ?>">
                                     Cetak Struk
                                     <span class="glyphicon glyphicon-print"></span>
                                     </a>
                                </a>
                            </span>
                            <p>Uang kembalian: <?=$cashback ?></p>
                            </div>

                            <?php
                        } else {
                            echo "Gagal menyimpan transaksi";
                        }
                    }
                }
            }
            ?>
            <a href="?p=transactions" class="btn btn-default">Kembali</a>
            </div>
        </div>
    </div>
</div>