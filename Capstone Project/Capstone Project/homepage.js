document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.button');

    buttons.forEach(button => {
        button.addEventListener('mouseover', () => {
            button.style.transform = 'translateY(-5px) scale(1.05)';
        });

        button.addEventListener('mouseout', () => {
            button.style.transform = 'translateY(0) scale(1)';
        });

        button.addEventListener('click', (e) => {
            e.preventDefault();
            button.style.transform = 'translateY(2px) scale(0.95)';
            setTimeout(() => {
                window.location.href = button.getAttribute('href');
            }, 200);
        });
    });
});