<?php

// Tải thư viện autoload từ Composer
require(__DIR__ . '/../vendor/autoload.php');
use Com\Tecnick\Barcode\Barcode;

// Thông tin cấu hình VNPAY
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = "http://yourwebsite.com/vnpay_return.php";
$vnp_TmnCode = "DNQYTRZN";
$vnp_HashSecret = "J10AUM3BPTXUBHS5R62IHWIREGEUV43K";

// Lấy số tiền từ URL
$amount = isset($_GET['amount']) ? intval($_GET['amount']) : 0;

// Kiểm tra số tiền hợp lệ
if ($amount <= 0) {
    die("Invalid amount");
}

$vnp_TxnRef = uniqid();
$vnp_OrderInfo = 'Thanh toán gói dịch vụ';
$vnp_Amount = $amount * 100; // Số tiền tính bằng VND
$vnp_Locale = 'vn';
$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

$inputData = array(
    "vnp_Version" => "2.1.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $vnp_Amount,
    "vnp_CurrCode" => "VND",
    "vnp_Command" => "pay",
    "vnp_CreateDate" => date('YmdHis'),
    "vnp_IpAddr" => $vnp_IpAddr,
    "vnp_Locale" => $vnp_Locale,
    "vnp_OrderInfo" => $vnp_OrderInfo,
    "vnp_OrderType" => 'billpayment',
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef" => $vnp_TxnRef
);

ksort($inputData);

$hashdata = "";
$i = 0;
foreach ($inputData as $key => $value) {
    $hashdata .= ($i == 1 ? '&' : '') . urlencode($key) . "=" . urlencode($value);
    $i = 1;
}

$query = "";
foreach ($inputData as $key => $value) {
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
}

if (isset($vnp_HashSecret)) {
    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
    $query .= 'vnp_SecureHash=' . $vnpSecureHash;
}

$vnp_Url = $vnp_Url . "?" . $query;

$barcode = new Barcode();
$bobj = $barcode->getBarcodeObj(
    'QRCODE,H',
    $vnp_Url,
    200, 200, 'black',
    [-2, -2, -2, -2]
)->setBackgroundColor('#ffffff');

?>
<!DOCTYPE html>
<html>
<head>
    <title>QR Code VNPAY</title>
    <meta charset="utf-8">
</head>
<body>
    <h1>QR Code cho Thanh toán VNPAY</h1>
    <p>Quét mã QR để thực hiện thanh toán:</p>
    <img alt="QR Code" src="data:image/png;base64,<?= base64_encode($bobj->getPngData()) ?>" />
    <p><a href="<?= $vnp_Url ?>" target="_blank">Hoặc nhấn vào đây để thanh toán</a></p>
</body>
</html>
