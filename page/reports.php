<?php
$today = date("Y-m-d");

?>

<div class="col-lg-8">
    <div class="panel panel-default">
        <div class="panel-heading">Data Transaksi</div>
        <div class="panel-body">
            <form action="" method="get" class="form-inline">
                <input type="hidden" name="p" value="reports">
                <div class="form-group">
                    <label for="">Tanggal Awal</label><br>
                    <input type="date" name="dateFrom" class="form-control"
                        value="<?= !empty($_GET['dateFrom']) ? $_GET['dateFrom'] : $today ?>">
                </div>
                <div class="form-group">
                    <label for="">Tanggal Sampai</label><br>
                    <input type="date" name="dateTo" class="form-control"
                        value="<?= !empty($_GET['dateTo']) ? $_GET['dateTo'] : $today ?>">
                </div>
                <div class="form-group">
                    <input type="submit" name="search" class="btn btn-sm btn-primary" value="Filter">
                    <a href="" class="btn btn-sm btn-success">Cetak</a>
                </div>
            </form>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $search = '';
                    $dateFrom = isset($_GET['dateFrom']) ? $_GET['dateFrom'] : '';
                    $dateTo = isset($_GET['dateTo']) ? $_GET['dateTo'] : '';

                    if (!empty($dateFrom) && !empty($dateTo)) {
                        $search .= " AND DATE(transactions.transactionDate) BETWEEN '$dateFrom' AND '$dateTo'";
                    } elseif (!empty($dateFrom)) {
                        $search .= " AND DATE(transactions.transactionDate) >= '$dateFrom'";
                    } elseif (!empty($dateTo)) {
                        $search .= " AND DATE(transactions.transactionDate) <= '$dateTo'";
                    } else {
                        $search .= " AND DATE(transactions.transactionDate) = '$today'";
                    }

                    $sql = "SELECT *, transactions.transactionDate as tgl 
                            FROM transactions
                            LEFT JOIN orders ON orders.orderId = transactions.orderId
                            LEFT JOIN customers ON orders.customerId = customers.customerId
                            LEFT JOIN products ON orders.productId = products.productId
                            WHERE 1=1 $search";

                    $query = mysqli_query($connection, $sql);
                    $check = mysqli_num_rows($query);
                    if ($check > 0) {
                        $no = 1;
                        while ($data = mysqli_fetch_array($query)) {
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data['customerName'] ?></td>
                                <td><?= $data['productName'] ?></td>
                                <td><?= $data['quantity'] ?></td>
                                <td><?= $data['tgl'] ?></td>
                                <td><?= $data['total'] ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                            <tr>
                                <td colspan="6" class="text-center">Data Tidak Ditemukan</td>
                            </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-lg-4">
    <div class="panel panel-success">
        <div class="panel-heading">Total hari ini</div>
        <div class="panel-body">
            <h2>
                <?php 
                    $income = "SELECT SUM(total) as amount FROM transactions 
                    WHERE date(transactionDate) = '" . $today . "'";

                    $queryIncome = mysqli_query($connection, $income);
                    $dataIncome = mysqli_fetch_array($queryIncome);

                    echo "Rp. ". number_format($dataIncome['amount'], 2, ',', '.');
                ?>
            </h2>
        </div>
    </div>

    <div class="panel panel-success">
        <div class="panel-heading">Total 28 hari terakhir</div>
        <div class="panel-body">
            <h2>
            <?php 
                $incomeFrom = date('Y-m-d', strtotime('-28 days'));

                $income = "SELECT SUM(total) as amount FROM transactions
                           WHERE date(transactionDate) BETWEEN '$incomeFrom' AND '$today'";

                $queryIncome = mysqli_query($connection, $income);
                $dataIncome = mysqli_fetch_array($queryIncome);
                
                echo "Rp. " . number_format($dataIncome['amount'], 2, ',', '.');                
            ?>
            </h2>
        </div>
    </div>

    <div class="panel panel-success">
        <div class="panel-heading">Selama ini</div>
        <div class="panel-body">
            <h2>
                <?php 
                    $income = "SELECT SUM(total) as amount FROM transactions";
                    $queryIncome = mysqli_query($connection, $income);
                    $dataIncome = mysqli_fetch_array($queryIncome);

                    echo "Rp. ". number_format($dataIncome['amount'], 2, ',', '.');
                ?>
            </h2>
        </div>
    </div>
</div>