<?php
session_start();

if ($_SESSION['role'] != 'customer') {
    header('Location: login.php');
    exit;
}

include 'connection.php';

$username = $_SESSION['username'];
    
// Fetch user details from the database
 $sql = "SELECT * FROM users WHERE username = '$username'";
 $result = mysqli_query($conn, $sql);
 $customer = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obtain answers to FAQs</title>
    <style>
    body { 
        font-family: Arial, sans-serif; 
        background-color: #2c2c3e;
        display: flex; 
        justify-content: center; 
        align-items: center; 
        height: 100vh; 
        margin: 0; 
    }


    #chat-container { 
        width: 100%; 
        max-width: 600px; 
        background: rgba(0, 0, 0, 0.5);
        border-radius:  20px; 
        backdrop-filter: blur(10px); 
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3); 
        overflow: hidden; 
        display: flex;
        flex-direction: column;
        height: 80vh;
    }

    #chatbox { 
        padding: 15px; 
        background: rgba(0, 0, 0, 0.1);
        flex-grow: 1;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .message { 
        padding: 10px 10px; 
        border-radius: 20px 0px 20px 0px; 
        max-width: 75%; 
        word-wrap: break-word; 
        display: flex;
        align-items: center;
        color: white; 
    }

    .user { 
        background-color: rgba(0, 123, 255, 0.7); 
        color: white; 
        align-self: flex-end;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); 
    }

    .bot { 
        background-color: rgba(32, 201, 151, 0.7); 
        color: white; 
        align-self: flex-start;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    #userInputContainer { 
        display: flex; 
        padding: 10px; 
        background: rgba(255, 255, 255, 0.6);
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    #userInput { 
        flex: 1; 
        padding: 10px; 
        border: none;
        border-radius: 20px; 
        font-size: 14px; 
        outline: none;
        color: white;
        background-color: rgba(255, 255, 255, 0.2);
    }

    #sendButton { 
        padding: 10px 20px; 
        border: none; 
        background-color: rgba(0, 123, 255, 0.8);
        color: white; 
        border-radius: 20px; 
        cursor: pointer; 
        margin-left: 10px; 
        transition: background-color 0.3s; 
    }

    #sendButton:hover { 
        background-color: rgba(0, 123, 255, 1); 
    }

    .bot-avatar {
        width: 30px; 
        height: 30px;
        border-radius: 50%; 
        margin-left: 10px;
        align-self: flex-end; 
    }

    
    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: static;
            box-shadow: none;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar img {
            width: 60px;
            height: 60px;
            margin-bottom: 10px;
        }

        .sidebar a {
            font-size: 14px;
            padding: 8px;
            margin-bottom: 10px;
            display: inline-flex;
            align-items: center;
        }

        #chat-container {
            width: 100%;
            max-width: 100%;
            height: calc(100vh - 140px);
        }

        #userInputContainer {
            padding: 5px;
        }

        #userInput {
            font-size: 12px;
            padding: 8px;
        }

        #sendButton {
            padding: 8px 16px;
            font-size: 12px;
        }
    }
    .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: none;
        display: block;
        float: right;
        right: 0;
        top:20px;
        position: absolute;
        margin-right:30px;

    }
 
.sidebar {
    width: 250px;
    background-color: #2c3e50;
    color: white;
    height: 100vh;
    padding-top: 20px;
    position: fixed;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    left:0;
}

.sidebar h2 {
    color: #ecf0f1;
    font-size: 18px;
    margin: 20px 0 10px;
    padding-left: 15px;
    width: 90%; 
    border-bottom: 1px solid #34495e;
    text-align: left;
    box-sizing: border-box; 
}

.sidebar a {
    display: flex;
    align-items: center;
    color: #bdc3c7;
    padding: 12px 20px;
    margin: 5px 0;
    width: 85%; 
    border-radius: 8px;
    font-size: 15px;
    text-decoration: none;
    transition: background 0.3s, color 0.3s;
}

.sidebar a img {
    width: 31px;
    height: 31px;
    margin-right: 10px;
}

.sidebar a:hover {
    background-color: #9990cc;
    color: #ecf0f1;
    box-shadow: inset 5px 0 0 #9990cc;
}

.main-content {
    margin-left: 260px; 
    padding: 20px;
    flex-grow: 1; 
}

.container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
    padding: 20px;
}
</style>

</head>
<body>
 
<div class="sidebar">
    <h2>Categories</h2>
    <div class="spacer" style="height:30"></div>
    <a href="customer.php?category=clothing">
        <img src="icons/apparel.png" alt="Clothing Icon"> Clothing
    </a>
    
    <a href="customer.php?category=bedding">
        <img src="icons/bed.png" alt="Bedding Icon"> Bedding
    </a>
    <a href="customer.php?category=miscellaneous">
        <img src="icons/random.png" alt="Miscellaneous Icon"> Miscellaneous
    </a>
    <div class="spacer" style="height:50px"></div>
    
    <h2>Account</h2>
    
    <a href="response.php">
        <img src="icons/update.png" alt="Updates Icon"> Book Updates
    </a>
    <a href="customer_profile.php">
        <img src="icons/account.png" alt="Profile Icon"> My Profile
    </a>
    
    <a href="logout.php" onclick="return confirm('Are you sure you want to logout?')">
        <img src="icons/logout.png" alt="Logout Icon"> Sign Out
    </a>
</div>
<a href="user_profile.php">

<div>
    <img src="<?php echo $customer['profile_picture'] && file_exists($customer['profile_picture']) ? $customer['profile_picture'] : 'icons/account.png'; ?>"
        class="avatar" alt="Avatar">
</div>
</a>


    <div id="chat-container">
    <div id="chatbox">
        <div class="message bot">
            <span>Hello <span style="color:orange"> <?php echo ucfirst(explode('@', $_SESSION['username'])[0]); ?>! </span>How can I help you with Campus Laundry Management System?</span>
            <img src="images/logo.jpg" alt="Bot Avatar" class="bot-avatar" />
        </div>
    </div>

    <div id="userInputContainer">
        <input type="text" id="userInput" placeholder="Type your question here..." />
        <button id="sendButton" onclick="sendMessage()">Send</button>
    </div>
</div>

<script>
 const faqs = [
    { keywords: ["who", "your name"], answer: "I am the Campus Laundry Management System chatbot here to assist you with laundry-related questions." },
    { keywords: ["hi", "hello", "hey", "hey bro", "whatsap", "good morning", "hel", "hell", "ell"], answer: "Hello! How can I help you with your laundry needs today?" },
    { keywords: ["yes"], answer: "Great! Feel free to ask more questions about our laundry services." },
    { keywords: ["okay"], answer: "Thank you! Let me know if there's anything else you need." },
    { keywords: ["how", "does", "system", "work"], answer: "Our campus laundry system allows you to book washing machines and dryers, check machine availability, and view your laundry status in real-time." },
    { keywords: ["who", "created", "made"], answer: "This system was developed by Group 3 as part of a university project for laundry management on campus." },
    { keywords: ["how", "to", "book", "machine"], answer: "You can book a laundry machine by logging into the system, selecting a machine, and choosing an available time slot." },
    { keywords: ["contact", "support", "help"], answer: "You can contact campus laundry support at the facility or through our support page in the system." },
    { keywords: ["visit", "laundry", "hours"], answer: "Laundry facilities are open daily from 6 AM to 10 PM." },
    { keywords: ["how many", "accounts"], answer: "Each student can have only one account in this system." },
    { keywords: ["hello", "hi", "hey"], answer: "Hi there! How can I assist with your laundry today?" },
    { keywords: ["okay", "thanks", "thank you"], answer: "You're very welcome! Let me know if there's anything else." },
    { keywords: ["what", "policy", "rules", "regulations"], answer: "Our laundry facility requires that machines are used responsibly, machines are left clean, and no personal items are left unattended." },
    { keywords: ["why", "how", "does"], answer: "I'm here to assist with frequently asked questions. For specific queries, please contact laundry support." },
    { keywords: ["forgot", "password", "reset"], answer: "If you've forgotten your password, you can reset it from the login page or contact support for assistance." },
    { keywords: ["how", "check", "availability", "machine"], answer: "You can check machine availability through the system dashboard, where real-time updates are provided." },
    { keywords: ["how", "cancel", "booking"], answer: "To cancel a booking, go to your account dashboard, select the booking, and choose the 'Cancel' option." },
    { keywords: ["bring", "items", "laundry"], answer: "Please bring your laundry detergent and any other laundry products you need. Washing and drying machines are provided." },
    { keywords: ["how", "pay", "fees"], answer: "Laundry fees can be paid through your campus account, which allows credit , but especially direct paying or mobile money" },
    { keywords: ["can", "schedule", "laundry", "appointment"], answer: "Yes, you can schedule a laundry appointment by selecting an available time slot in the system." },
    { keywords: ["where", "is", "laundry", "located"], answer: "The campus laundry facility is located in the Student Center, near the east entrance." },
    { keywords: ["who", "manages", "laundry"], answer: "Our laundry facility is managed by campus staff to ensure it remains clean and well-maintained." },
    { keywords: ["rules", "for", "laundry"], answer: "Please make sure to remove your clothes promptly, clean up any spills, and follow all posted guidelines." },
    { keywords: ["how much","price", "cost", ], answer: "Ahh!, I see you are reffering to the charge or fee for the service, well note that our prices are two dynamic and they can change over time, however you can get nore discount for more use of our services" }
];

function findAnswer(userQuestion) {
            const lowerUserQuestion = userQuestion.toLowerCase();
            for (const faq of faqs) {
                if (faq.keywords.some(keyword => lowerUserQuestion.includes(keyword))) {
                    return faq.answer;
                }
            }
            return "Sorry, I couldn't find an answer to that question.";
        }

        function typeText(element, text, delay = 45) {
            element.innerHTML = ""; // Clear previous content
            let index = 0;

            function typing() {
                if (index < text.length) {
                    element.innerHTML += text.charAt(index);
                    index++;
                    setTimeout(typing, delay);
                }
            }
            typing();
        }

        function sendMessage() {
            const userInput = document.getElementById("userInput");
            const chatbox = document.getElementById("chatbox");

            if (userInput.value.trim() === "") return;

            const userMessage = document.createElement("div");
            userMessage.className = "message user";
            userMessage.textContent = userInput.value;
            chatbox.appendChild(userMessage);

            // Get bot's response
            const botResponse = findAnswer(userInput.value);
            const botMessage = document.createElement("div");
            botMessage.className = "message bot";
            chatbox.appendChild(botMessage);

            // Type the bot's response
            typeText(botMessage, botResponse);

            userInput.value = ""; 
            chatbox.scrollTop = chatbox.scrollHeight;
        }
    </script>

</body>
</html>
