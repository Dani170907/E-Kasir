<?php
include "../config/connection.php";

$start_date = isset($_GET["start_date"]) ? $_GET["start_date"] : date("Y-m-d");
$end_date = isset($_GET["end_date"]) ? $_GET["end_date"] : date("Y-m-d");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../dist/css/bootstrap.min.css">
    <title>Cetak</title>
</head>

<body>
    <div class="row">
        <div class="col-lg-6" style="margin: 0 auto; float: none;">
            <center>
                <h3>Iqii Scnd GOK</h3>
                <h2>Laporan Penjualan</h2>
                Periode: <?= date('d-m-Y', strtotime($start_date)) ?> s/d <?= date('d-m-Y', strtotime($end_date)) ?>
            </center>
            <br>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $search = '';

                    if (!empty($start_date) && !empty($end_date)) {
                        $search .= " AND DATE(transactions.transactionDate) BETWEEN '$start_date' AND '$end_date'";
                    } elseif (!empty($start_date)) {
                        $search .= " AND DATE(transactions.transactionDate) >= '$start_date'";
                    } elseif (!empty($end_date)) {
                        $search .= " AND DATE(transactions.transactionDate) <= '$end_date'";
                    }

                    $sql = "SELECT products.productName, SUM(orders.quantity) as quantity, SUM(transactions.total) as total
                            FROM transactions
                            LEFT JOIN orders ON orders.orderId = transactions.orderId
                            LEFT JOIN products ON orders.productId = products.productId
                            WHERE 1=1 $search
                            GROUP BY orders.productId";

                    $query = mysqli_query($connection, $sql);
                    $check = mysqli_num_rows($query);
                    if ($check > 0) {
                        $no = 1;
                        while ($data = mysqli_fetch_array($query)) {
                    ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data['productName'] ?></td>
                                <td><?= $data['quantity'] ?></td>
                                <td><?= "Rp. " . number_format($data['total'], 0, '', '.') ?></td>
                            </tr>
                    <?php
                        }
                    } else {
                    ?>
                        <tr>
                            <td colspan="4" class="text-center">Data Tidak Ditemukan</td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td>
                            <?php 
                            $sqlTotal = "SELECT SUM(total) as totalAmount 
                                         FROM transactions
                                         WHERE DATE(transactionDate) BETWEEN '$start_date' AND '$end_date'";
                                    
                            $queryTotal = mysqli_query($connection, $sqlTotal);
                            $dataTotal = mysqli_fetch_array($queryTotal);
                            echo "Rp. " . number_format($dataTotal['totalAmount'] ?? 0, 0, '', '.');  // Tampilkan total hari ini
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<script type="text/Javascript">
    window.print();
    setTimeout(function(){
        window.location.href = "../index.php?p=reports";
    }, 2000);  // Tutup halaman setelah 2 detik
</script>
