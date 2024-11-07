<div class="col-lg-8">
    <div class="panel panel-default">
        <div class="panel-heading">Data yang belum lunas</div>
        <div class="panel-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $listOrder = "SELECT orders.orderId, customers.customerName, products.productName, products.price, orders.quantity, orders.status 
                                      FROM orders 
                                      LEFT JOIN customers ON customers.customerId = orders.customerId
                                      LEFT JOIN products ON products.productId = orders.productId
                                      WHERE orders.status = '1'";

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
                            <a
                                href="?p=transaction_details&orderId=<?= $dataList['orderId'] ?>"
                                class="btn btn-sm btn-primary">Proses</a>
                        </td>
                    </tr>
                    <?php
                        }
                        ?> 
                        <?php
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