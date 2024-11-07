<?php 

$transactionId = $_GET['transactionId'];
include("../config/connection.php");

$sql = "SELECT * FROM transactions LEFT JOIN orders 
        ON orders.orderId = transactions.orderId
        LEFT JOIN customers ON orders.customerId = customers.customerId
        LEFT JOIN products ON orders.productId = products.productId
        WHERE transactionId = '$transactionId";

$query = mysqli_query($connection,$sql);
$check = mysqli_num_rows($query);

if($check > 0) {
    $data = mysqli_fetch_array($query);
} else {
    ?>
    <script type="text/javascript">
        window.location.href = "index.php?p=transactions";
    </script>
    <?php
}
// print_r($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Struk</title>
    <style>
        body {
            font-family: monospace;
            /* font-size: 12px; */
        }
        .cetak {
            width: 40%;
            height: auto;
            border: 1px solid #000;
            padding: 20px;
        }
        .bb {
            border-bottom: 1px solid #999;
        }
    </style>
</head>
<body style="margin: 0 auto">

<center>
    <div class="cetak">
        <h2 style="margin: 0;">Iqii Second Gok</h2>
        <span><?= date('d-m-Y') . ", " . date('H:i:s') ?></span>
        <br/>
        <table style="float: none;" width="100%" border="0" cellpadding="10" cellspacing="0">
            <tr>
                <td colspan="4">Nama: <?= $data['customerName'] ?></td>
            </tr>
            <tr>
                <td class="bb"><?= $data['productName'] ?></td>
                <td class="bb"><?= $data['price'] ?></td>
                <td class="bb"><?= $data['quantity'] ?></td>
                <td class="bb"><?= $data['total'] ?></td>
            </tr>
            <tr>
                <td colspan="3">Uang bayar</td>
                <td><?= $data['payment'] ?></td>
            </tr>
            <tr>
                <td colspan="3">Kembalian</td>
                <td><?= $data['cashback']?></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:center ;">
                    Terima kasih atas kunjungan anda, silahkan tunggu sebentar.
                    <br/>
                    <br/>
                    <br/>
                    (<?= $data['customerName']?>)
                </td>
            </tr>
        </table>
    </div>
</center>
<script type="text/javascript">
    window.print();
    setTimeout(function(){
        window.location.href = "index.php?p=transactions";
    }, 2000); 
</script>

</body>
</html>