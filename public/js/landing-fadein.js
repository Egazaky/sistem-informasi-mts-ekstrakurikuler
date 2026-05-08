document.addEventListener('DOMContentLoaded', () => {
    const heroSection = document.querySelector('.hero');
    if (heroSection) {
        heroSection.classList.add('fade-in-right-to-left');
    }

    const fadeInLeftContainer = document.querySelector('.fade-in-left');
    if (fadeInLeftContainer) {
        const fadeInLeftElements = fadeInLeftContainer.querySelectorAll('.berita-item');
        fadeInLeftElements.forEach((el, index) => {
            el.style.animation = `fadeInLeft 1s cubic-bezier(0.4,0,0.2,1) forwards`;
            el.style.animationDelay = `${index * 0.3}s`;
            el.style.opacity = 0;
            el.classList.add('fade-in-left-anim');
        });
    }

    const fadeInRightElements = document.querySelectorAll('.fade-in-right');
    fadeInRightElements.forEach(el => {
        el.classList.add('fade-in-right-anim');
    });
});
