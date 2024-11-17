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
        window.location.href = "?p=transactions";
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
                        <input type="text" name="" class="form-control" value="<?= isset($data['customerName']) ? $data['customerName'] : '' ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Barang</label>
                        <input type="text" name="" class="form-control" value="<?= isset($data['productName']) ? $data['productName'] : '' ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Total Bayar</label>
                        <input type="text" name="total" class="form-control" value="<?= isset($data['quantity']) && isset($data['price']) ? number_format($data['quantity'] * $data['price'], 0, ',', '.') : '0' ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Jumlah</label>
                        <input type="number" name="" class="form-control" value="<?= isset($data['quantity']) ? $data['quantity'] : '' ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Total Bayar</label>
                        <input type="text" name="total" class="form-control" value="<?= isset($data['quantity']) && isset($data['price']) ? number_format($data['quantity'] * $data['price'], 0, ',', '.') : '0' ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Uang Pelanggan</label>
                        <input type="text" id="payment" <?= (isset($data['status']) && $data['status'] == '2' ? 'readonly' : '') ?> name="payment" class="form-control" value="<?= isset($data['payment']) ? number_format($data['payment'], 0, ',', '.') : '0' ?>" oninput="formatRupiah(this)">
                    </div>

                    <button type="submit" <?= (isset($data['status']) && $data['status'] == '2' ? 'disabled="disabled"' : '') ?> name="save" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
            </div>
            <br>

            <div class="row">
            <?php
            if (isset($_POST['save'])) {
                $total = $_POST['total'];
                $payment = str_replace('.', '', $_POST['payment']);
                $code = $_POST['transactionCode'];
                
                if ($payment < $total) {
                    ?>
                        <script>
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Nominal uang kurang.',
                                icon: 'error',
                                confirmButtonText: 'Coba Lagi'
                            });
                        </script>
                    <?php
                } else {
                    $cashback = $payment - $total;
                    $cashbackFormatted = "Rp " . number_format($cashback, 0, ',', '.');

                    $sqlInsert = "INSERT INTO transactions SET transactionId = '$code',
                                  orderId = '$orderId', total = '$total', payment = '$payment', cashback = '$cashback'";
                                  
                    $queryInsert = mysqli_query($connection, $sqlInsert);

                    if ($queryInsert) {
                        $sqlUpdate = "UPDATE orders SET status = '2' WHERE orderId = '$orderId'";
                        $queryUpdate = mysqli_query($connection, $sqlUpdate);

                        if ($queryUpdate) {
                            ?>
                            <script>
                                Swal.fire({
                                    title: 'Pembayaran Berhasil!',
                                    text: 'Transaksi telah disimpan. Uang kembalian: <?= $cashbackFormatted ?>',
                                    icon: 'success',
                                    confirmButtonText: 'Cetak Struk'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "page/print_receipt.php?transactionId=<?= $code ?>";
                                    }
                                });
                            </script>
                            <?php
                        } else {
                            ?>
                            <script>
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Gagal menyimpan transaksi.',
                                    icon: 'error',
                                    confirmButtonText: 'Coba Lagi'
                                });
                            </script>
                            <?php
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