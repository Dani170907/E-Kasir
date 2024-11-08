<?php
require('../fpdf/fpdf.php');
include("../config/connection.php");

$transactionId = mysqli_real_escape_string($connection, $_GET['transactionId']);

$sql = "SELECT * FROM transactions 
        LEFT JOIN orders ON orders.orderId = transactions.orderId
        LEFT JOIN customers ON orders.customerId = customers.customerId
        LEFT JOIN products ON orders.productId = products.productId
        WHERE transactionId = '$transactionId'";

$query = mysqli_query($connection, $sql);
$data = mysqli_fetch_array($query);

$pdf = new FPDF();
$pdf->AddPage();

// Logo
$pdf->Image('../assets/img/logo.png', ($pdf->GetPageWidth() - 65) / 2, 0, 65); 
$pdf->Ln(50);

// Judul
$pdf->SetFont('Arial', 'B', 22);
$pdf->Cell(0, 10, 'Iqii Scnd Gok', 0, 2, 'C');

// Alamat
$pdf->SetFont('Arial', '', 18);
$pdf->Cell(0, 10, 'Pekalongan, Jawa Tengah, Indonesia', 0, 2, 'C');
$pdf->Cell(0, 10, 'No. Telp +6285972551095', 0, 2, 'C');

// Tanggal
$pdf->SetFont('Arial', '', 14);
$pdf->Cell(0, 10, 'Tanggal: ' . date('d-m-Y') . ', ' . date('H:i:s'), 0, 1, 'R');
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(5);

// Detail Transaksi
$pdf->SetFont('Arial', '', 18);
$pdf->Cell(40, 10, 'Nama:', 0, 0);
$pdf->Cell(0, 10, $data['customerName'], 0, 1, 'R');
$pdf->Ln(5); // Menambahkan jarak antar detail
$pdf->Cell(40, 10, 'Produk:', 0, 0);
$pdf->Cell(0, 10, $data['productName'], 0, 1, 'R');
$pdf->Ln(5); // Menambahkan jarak
$pdf->Cell(40, 10, 'Harga:', 0, 0);
$pdf->Cell(0, 10, "Rp " . number_format($data['price'], 2, ',', '.'), 0, 1, 'R');
$pdf->Ln(5); // Menambahkan jarak
$pdf->Cell(40, 10, 'Jumlah:', 0, 0);
$pdf->Cell(0, 10, $data['quantity'], 0, 1, 'R');
$pdf->Ln(5); // Menambahkan jarak
$pdf->Cell(40, 10, 'Total:', 0, 0);
$pdf->Cell(0, 10, "Rp " . number_format($data['total'], 2, ',', '.'), 0, 1, 'R');
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(10); // Menambahkan jarak sebelum bagian pembayaran

// Pembayaran dan Kembalian
$pdf->Cell(40, 10, 'Uang Bayar:', 0, 0);
$pdf->Cell(0, 10, "Rp " . number_format($data['payment'], 2, ',', '.'), 0, 1, 'R');
$pdf->Ln(5); // Menambahkan jarak
$pdf->Cell(40, 10, 'Kembalian:', 0, 0);
$pdf->Cell(0, 10, "Rp " . number_format($data['cashback'], 2, ',', '.'), 0, 1, 'R');
$pdf->Ln(10); // Menambahkan jarak

// Footer
$pdf->SetFont('Arial', '', 18);
$pdf->MultiCell(0, 10, 'Terima kasih ' . $data['customerName'] . " atas kunjungan Anda, semoga pengalaman Anda menyenangkan!", 0, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 16);
$pdf->Cell(0, 10, '(' . $data['customerName'] . ')', 0, 1, 'C');

// Output PDF
$pdf->Output('D', 'struk.pdf');

// Redirect setelah download selesai
echo "<script type='text/javascript'>
    window.location.href = 'transactions.php';
</script>";