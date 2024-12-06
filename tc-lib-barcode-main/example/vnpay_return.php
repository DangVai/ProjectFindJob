<?php
// Thông tin cấu hình VNPAY
$vnp_HashSecret = "J0INYMME2I4P4LZ90M7Y3XR7Q8CGVG2I"; // Chuỗi bí mật

// Lấy các tham số trả về từ VNPAY
$vnp_TxnRef = $_GET['vnp_TxnRef'];
$vnp_Amount = $_GET['vnp_Amount'];
$vnp_SecureHash = $_GET['vnp_SecureHash'];
$inputData = $_GET;
unset($inputData['vnp_SecureHash']); // Xóa mã bảo mật khỏi tham số đầu vào

// Tạo chuỗi hash từ các tham số trả về
ksort($inputData); // Sắp xếp theo thứ tự key
$hashdata = "";
$i = 0;
foreach ($inputData as $key => $value) {
    $hashdata .= ($i == 1 ? '&' : '') . urlencode($key) . "=" . urlencode($value);
    $i = 1;
}

// Tạo mã bảo mật HMAC
$checkSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

// So sánh mã bảo mật trả về và mã bảo mật tính lại
if ($checkSecureHash == $vnp_SecureHash) {
    // Nếu mã bảo mật đúng, xử lý thanh toán thành công
    if ($_GET['vnp_ResponseCode'] == '00') {
        echo "Thanh toán thành công!";
        // Thực hiện các hành động sau thanh toán thành công (cập nhật đơn hàng, lưu trữ thông tin, ...).
    } else {
        echo "Thanh toán thất bại!";
    }
} else {
    echo "Mã bảo mật không hợp lệ!";
}
?>
