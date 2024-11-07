<?php 
include("../config/connection.php");

$sql = "SELECT * FROM transactions LEFT JOIN orders 
        ON orders.orderId = transactions.orderId
        LEFT JOIN customers ON orders.customerId = customers.customerId";

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
        .cetak {
            width: 40%;
            height: auto;
            border: 1px solid #000;
            padding: 20px;
        }
    </style>
</head>
<body style="margin: 0 auto">

<center>
    <div class="cetak">
        <h2 style="margin: 0;">Iqii Second Gok</h2>
        <span><?= date('d-m-Y') ?></span>
        <br/>
        <table style="float: none;" width="100%" border="1" cellpadding="10" cellspacing="0">
            <tr>
                <td>Nama: <?= $data['customerName'] ?></td>
            </tr>
            <tr>
                <td></td>
            </tr>
        </table>
    </div>
</center>

</body>
</html>