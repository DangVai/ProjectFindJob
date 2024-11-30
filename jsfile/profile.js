document.addEventListener('DOMContentLoaded', () => {
    // **Modal đổi mật khẩu**
    const changePasswordModal = document.getElementById('changePasswordModal');
    const changePasswordLink = document.querySelector('.change-password-link'); // Nút "Đổi mật khẩu"
    const changePasswordCloseBtn = document.querySelector('#changePasswordModal .close-btn'); // Nút đóng trong modal
    const cancelChangeBtn = document.getElementById('cancelChangeBtn'); // Nút "Hủy"

    // Hiển thị modal đổi mật khẩu
    changePasswordLink.addEventListener('click', (event) => {
        event.preventDefault();
        changePasswordModal.style.display = 'flex';
    });

    // Đóng modal đổi mật khẩu khi click nút đóng
    changePasswordCloseBtn.addEventListener('click', () => {
        changePasswordModal.style.display = 'none';
    });

    // Đóng modal đổi mật khẩu khi click nút "Hủy"
    cancelChangeBtn.addEventListener('click', () => {
        changePasswordModal.style.display = 'none';
    });

    // **Modal xóa tài khoản**
    const deleteAccountModal = document.getElementById('deleteAccountModal');
    const deleteAccountLink = document.querySelector('.text-danger'); // Nút "Xóa tài khoản"
    const deleteAccountCloseBtn = document.querySelector('#deleteAccountModal .close-btn'); // Nút đóng trong modal
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn'); // Nút "Hủy"

    // Hiển thị modal xóa tài khoản
    deleteAccountLink.addEventListener('click', (event) => {
        event.preventDefault();
        deleteAccountModal.style.display = 'flex';
    });

    // Đóng modal xóa tài khoản khi click nút đóng
    deleteAccountCloseBtn.addEventListener('click', () => {
        deleteAccountModal.style.display = 'none';
    });

    // Đóng modal xóa tài khoản khi click nút "Hủy"
    cancelDeleteBtn.addEventListener('click', () => {
        deleteAccountModal.style.display = 'none';
    });

    // **Đóng modal khi click bên ngoài**
    window.addEventListener('click', (event) => {
        if (event.target === changePasswordModal) {
            changePasswordModal.style.display = 'none';
        } else if (event.target === deleteAccountModal) {
            deleteAccountModal.style.display = 'none';
        }
    });

    // **Tự động ẩn thông báo (nếu có)**
    setTimeout(() => {
        const alertBox = document.querySelector('.alert-success');
        if (alertBox) {
            alertBox.classList.add('fade-out');
            setTimeout(() => alertBox.remove(), 1000); // Xóa khỏi DOM sau khi ẩn
        }
    }, 3000);
});