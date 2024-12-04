// Khi người dùng bấm vào nút "Viết đánh giá"
document.getElementById('writeReviewBtn').addEventListener('click', function() {
    document.getElementById('reviewForm').style.display = 'flex'; // Hiển thị form đánh giá
});

// Khi người dùng bấm vào nút "X" để đóng form
document.getElementById('closeReviewForm').addEventListener('click', function() {
    document.getElementById('reviewForm').style.display = 'none'; // Ẩn form đánh giá
});

// Đảm bảo form không đóng khi người dùng bấm vào nó
document.querySelector('.review-form').addEventListener('click', function(e) {
    e.stopPropagation();
});