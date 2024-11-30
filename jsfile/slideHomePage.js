let currentIndex = 0;
const slides = document.querySelectorAll('.box_img img');
const dots = document.querySelectorAll('.change div');

// chạy slide
function updateSlider() {
    const offset = -currentIndex * 100;
    slides.forEach(slide => {
        slide.style.transform = `translateX(${offset}%)`;
    });

    // chuyển nút
    dots.forEach((dot, index) => {
        dot.style.backgroundColor = index === currentIndex ? 'white' : 'rgba(128, 128, 128, 0.5)';
    });
}

// chuyển slide
function autoSlide() {
    currentIndex = (currentIndex + 1) % slides.length; // quay lại slide đầu tiên
    updateSlider();
}

updateSlider();
setInterval(autoSlide, 3000);