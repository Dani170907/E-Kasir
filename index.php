<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Pastikan path connection.php benar
include "config/connection.php";

if (isset($_SESSION['username'])) {
  $user = $_SESSION['username'] ?? '';
  $level = $_SESSION['level'] ?? '';
  $userId = $_SESSION['userId'] ?? '';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Meta Tags -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../../favicon.ico">

  <title>E-Kasir</title>

  <!-- Bootstrap core CSS -->
  <link href="dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="dist/css/navbar-fixed-top.css" rel="stylesheet">

  <script src="assets/js/sweetalert2.all.min.js"></script>

  <!-- Debugging Scripts -->
  <script src="assets/js/ie-emulation-modes-warning.js"></script>

  <!-- HTML5 shim for IE8 -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="?p=home">E-Kasir</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <?php if (isset($level) && $level == "admin") : ?>
          <li><a href="?p=list_items">List Barang</a></li>
          <li><a href="?p=order">Pesan</a></li>
          <li><a href="?p=transactions">Transaksi</a></li>
          <li><a href="?p=reports">Laporan</a></li>
        <?php elseif (isset($level) && $level == "pemilik") : ?>
          <li><a href="?p=reports">Laporan</a></li>
        <?php elseif (isset($level) && $level == "kasir") : ?>
          <li><a href="?p=order">Pesan</a></li>
          <li><a href="?p=transactions">Transaksi</a></li>
          <li><a href="?p=reports">Laporan</a></li>
        <?php endif; ?>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <?php if (isset($user)) : ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <?= htmlspecialchars($user) ?> (<?= htmlspecialchars($level) ?>) <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="page/logout.php">Keluar</a></li>
            </ul>
          </li>
        <?php endif; ?>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>

<!-- Main Content -->
<div class="container">
  <?php
  if (isset($_SESSION['username'])) {
    $p = isset($_GET['p']) ? $_GET['p'] : 'home';

    switch ($p) {
      case 'login':
        include "page/login.php";
        break;
      case 'list_items':
        include "page/list_items.php";
        break;
      case 'add_item':
        include "page/add_item.php";
        break;
      case 'edit_item':
        include "page/edit_item.php";
        break;
      case 'order':
        include "page/order.php";
        break;
      case 'transactions':
        include "page/transactions.php";
        break;
      case 'transaction_details':
        include "page/transaction_details.php";
        break;
      case 'reports':
        include "page/reports.php";
        break;
      case 'receipt':
        include "page/receipt.php";
        break;
      case 'home':
        include "page/home.php";
        break;
      default:
        include "page/login.php";
        break;
    }
  } else {
    include "page/login.php";
  }
  ?>
</div> <!-- /container -->

<!-- JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="dist/js/bootstrap.min.js"></script>
<script src="assets/js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>
<script type="text/JavaScript">
  $(document).on('click', '#print', function(e) {
    e.preventDefault(); // Mencegah submit form
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    window.open('page/print_report.php?start_date=' + start_date + '&end_date=' + end_date, '_blank');
  });
</script>
