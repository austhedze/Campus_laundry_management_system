document.querySelectorAll('.card button').forEach(button => {
    button.addEventListener('mouseenter', function () {
        var confettiContainer = this.nextElementSibling; // Get the next sibling (confetti-container)
        confettiContainer.style.display = 'block';  // Show the confetti container

        // List of possible confetti colors
        const colors = ['#FF5733', '#33FF57', '#3357FF', '#FF33A1', '#FFBC33', '#A1FF33'];

        // Generate confetti pieces
        for (var i = 0; i < 100; i++) { // Create 100 pieces of confetti
            var confetti = document.createElement('div');
            confetti.classList.add('confetti');

            // Randomize confetti positions and movement
            var x = (Math.random() - 0.5) * 300 + 'px'; // Random horizontal movement
            var y = (Math.random() - 0.5) * 300 + 'px'; // Random vertical movement

            // Random color from the colors array
            var color = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.backgroundColor = color;

            confetti.style.setProperty('--x', x); // Set random x
            confetti.style.setProperty('--y', y); // Set random y

            // Append to the confetti container
            confettiContainer.appendChild(confetti);
        }

        // Remove confetti after animation ends (after 3 seconds)
        setTimeout(() => {
            confettiContainer.innerHTML = ''; // Clear confetti pieces
            confettiContainer.style.display = 'none'; // Hide confetti container
        }, 3000); // 3 seconds, based on animation duration
    });
});