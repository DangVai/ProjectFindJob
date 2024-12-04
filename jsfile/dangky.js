
    // Kiểm tra xem có tham số 'success=otp_sent' trong URL không
    window.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('success') && urlParams.get('success') === 'otp_sent') {
            // Hiển thị modal OTP
            document.getElementById('otpModal').style.display = 'block';
        }
        if (urlParams.get('error') === 'account_verification_failed') {
            // Hiển thị modal OTP
            alert('OTP verification failed. Please try again.');
        }
        if (urlParams.get('error') === 'expired') {
            // Hiển thị modal OTP
            alert('OTP expired. Please request a new one.');
            document.getElementById('otpModal').style.display = 'block';
        }
        if (urlParams.get('error') === 'Invalids') {
            document.getElementById('otpModal').style.display = 'block';
            alert('Invalid OTP. Please try again.');
        }
        if (urlParams.get('error') === 'No_pending') {
            // Hiển thị modal OTP
            alert('No pending account found for this email.');
            document.getElementById('otpModal').style.display = 'block';

        }

    });
    // Đóng modal
    document.getElementById('closeModal').addEventListener('click', function () {
        document.getElementById('otpModal').style.display = 'none';
    });

    // Ẩn modal khi nhấp bên ngoài
    window.addEventListener('click', function (e) {
        const modal = document.getElementById('otpModal');
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
