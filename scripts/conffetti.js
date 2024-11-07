document.getElementById('confettiButton').addEventListener('mouseover', function() {
    let container = document.getElementById('confettiContainer');
    let button = this;
    let buttonRect = button.getBoundingClientRect();
    let numberOfConfetti = 50;

    
    for (let i = 0; i < numberOfConfetti; i++) {
        let confetti = document.createElement('div');
        confetti.classList.add('confetti');

        // Randomize confetti's size and color
        confetti.style.backgroundColor = getRandomColor();
        confetti.style.width = `${Math.random() * 10 + 5}px`;
        confetti.style.height = confetti.style.width;

        // Position confetti randomly around the button
        confetti.style.left = `${Math.random() * buttonRect.width + buttonRect.left}px`;
        confetti.style.top = `${Math.random() * buttonRect.height + buttonRect.top}px`;

        // Random direction for confetti movement
        let xDirection = (Math.random() - 0.5) * 700; 
        let yDirection = (Math.random() - 0.5) * 700;
        confetti.style.setProperty('--x', `${xDirection}px`);
        confetti.style.setProperty('--y', `${yDirection}px`);

        container.appendChild(confetti);

        // Remove confetti after animation ends
        setTimeout(() => {
            confetti.remove();
        }, 1000);
    }
});

// Function to generate random color
function getRandomColor() {
    const colors = ['#f39c12', '#e74c3c', '#8e44ad', '#2ecc71', '#3498db'];
    return colors[Math.floor(Math.random() * colors.length)];
}