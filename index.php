<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry Management System -index</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body, html {
            height: 100%;
            font-family: Arial, sans-serif;
            color: #fff;
            overflow: hidden;
        }

        .background {
            background: url('images/back.jpg') no-repeat center center/cover;
            height: 100%;
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            text-align: center;
            padding: 60px;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
        
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.5);
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            font-weight: bold;
            
        }

        .button-group {
            margin-top: 20px;
            display: flex;
            gap: 20px;
            justify-content: center;
            
        }

        .button {
            padding: 10px 20px;
            font-size: 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-weight: bold;
        }

        .button-login {
            background-color: #9990cc;
            color: #fff;
        }

        .button-signup {
            background-color: orangered;
            color: #fff;
        }

        .button-login:hover {
            background-color: violet;
        }

        .button-signup:hover {
            background-color: grey;
            color:white;
        }

    
        .bubble {
            position: absolute;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            opacity: 0.8;
            top: -10px;
            animation: bubble-float linear infinite;
        }

        
        @keyframes bubble-float {
            0% {
                transform: translateY(0) translateX(0) scale(1);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) translateX(20px) scale(1.2);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <div class="background">
        <div class="overlay">
            <div class="container">
                <h1>Laundry Management System</h1>
                <div class="button-group">
                    <button class="button button-login" onclick="location.href='login.php'">Login</button>
                    <button class="button button-signup" onclick="location.href='register.php'">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Generate a random color gradient for soap bubbles
        function getRandomBubbleColor() {
            const colors = [
                "radial-gradient(circle at 20% 20%, rgba(255,255,255,0.9), rgba(173,216,230,0.3))",
                "radial-gradient(circle at 20% 20%, rgba(255,182,193,0.9), rgba(255,228,225,0.3))",
                "radial-gradient(circle at 20% 20%, rgba(147,112,219,0.9), rgba(216,191,216,0.3))",
                "radial-gradient(circle at 20% 20%, rgba(255,255,224,0.9), rgba(255,250,205,0.3))"
            ];
            return colors[Math.floor(Math.random() * colors.length)];
        }

        // JavaScript to create floating soap bubbles
        function createBubble() {
            const bubble = document.createElement('div');
            bubble.classList.add('bubble');

            // Randomize bubble size, horizontal position, and animation duration
            const size = Math.random() * 20 + 10 + 'px';
            bubble.style.width = size;
            bubble.style.height = size;
            bubble.style.left = Math.random() * 100 + 'vw';
            bubble.style.animationDuration = (Math.random() * 2 + 3) + 's';

            // Apply random bubble color
            bubble.style.background = getRandomBubbleColor();

            document.body.appendChild(bubble);

            // Remove bubble after it floats out of view
            setTimeout(() => {
                bubble.remove();
            }, 5000);
        }

        // Generate multiple bubbles at intervals
        setInterval(createBubble, 200);
    </script>
</body>
</html>
