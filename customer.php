<?php
include 'connection.php';
session_start();

// Check if the user is logged 
if ($_SESSION['role'] !== 'customer') {
    echo "Welcome to user Dashboard, " . $_SESSION['username'];
    header("Location: login.php");
    exit();
}

       $username = $_SESSION['username'];
    
        // Fetch user details from the database
         $sql = "SELECT * FROM users WHERE username = '$username'";
         $result = mysqli_query($conn, $sql);
         $user = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry Products</title>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
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

.card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s;
}

.card:hover {
    transform: scale(1.05);
}

.card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.card-content {
    padding: 15px;
}

.card h2 {
    margin: 0;
    font-size: 18px;
    color: #333;
}

.card p {
    color: #777;
    font-size: 14px;
}

.card button {
    background-color: #9990cc;
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
    width: 100%;
    border-radius: 4px;
}

.card button:hover {
    background-color: grey;
}

.avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border:none;
    display: block;
    float: right;
    right: 0;
    position: fixed;
}

@media (max-width: 768px) {
    .sidebar {
        width: 100%; 
        height: auto ;
        position: absolute; 
        display: block; 

       
    }

    .main-content {
        margin-left: 0;
        padding: 10px;
    }

    .container {
        grid-template-columns: 1fr; 
        padding: 0; 
    }

    .card {
        margin: 10px 0; 
    }
}

@media (max-width: 480px) {
    .sidebar {
        
    }
    .sidebar h2 {
        font-size: 16px; 
    }

    .sidebar a {
        font-size: 14px; 
    }

    .card h2 {
        font-size: 16px; 
    }
}


.notification {
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            display: none;
            z-index: 1000;
            width: 300px;
        }

        .notification.success {
            background-color: #9b59b6;
        }

        .notification.error {
            background-color: #e74c3c;
        }

        /* Custom Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
        }

        .modal-content button {
            background-color: #e74c3c;
            color: white;
            padding: 10px 20px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .modal-content button.cancel {
            background-color: #bdc3c7;
        }
 /* Confetti container */
.confetti-container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1000;
    display: none; /* Initially hidden */
}

/* Confetti style */
.confetti {
    position: absolute;
    width: 10px;
    height: 10px;
    opacity: 0;
    border-radius: 50%;
    animation: confetti-animation 3s forwards;
}

/* Confetti animation */
@keyframes confetti-animation {
    0% {
        transform: scale(0.5);
        opacity: 1;
    }
    100% {
        transform: translate(var(--x), var(--y)) rotate(720deg);
        opacity: 0;
    }
}



</style>
</head>

<body>
    
    <div class="sidebar">
    <h2>Categories</h2>
    <a href="?category=clothing">
        <img src="icons/apparel.png" alt="Clothing Icon"> Clothing
    </a>
    
    <a href="?category=bedding">
        <img src="icons/bed.png" alt="Bedding Icon"> Bedding
    </a>
    <a href="?category=miscellaneous">
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
    <a href="bot.php">
        <img src="icons/enquiries.png" alt="Profile Icon"> Enquiries
    </a>
    <a href="logout.php" id="logoutLink">
        <img src="icons/logout.png" alt="Logout Icon"> Sign Out
    </a>
</div>


    <!-- Main Content Area -->
    <div class="main-content">

        <!-------add avator to the right----------->


        <a href="customer_profile.php">
            <div>
                <img src="<?php echo $user['profile_picture'] && file_exists($user['profile_picture']) ? $user['profile_picture'] : 'images/prof.png'; ?>"
                    class="avatar" alt="Avatar">
            </div>
        </a>

        <h1 style="text-align: center;">Available Laundry Services</h1>

        <div class="container">
            <?php
            // Get the category from URL,  if any
            $category = isset($_GET['category']) ? $_GET['category'] : '';

            // Modify the SQL query based on category selection
            if ($category) {
                $sql = "SELECT * FROM products WHERE category = '$category'";
            } else {
                // Show all products if no category selected
                $sql = "SELECT * FROM products";  
            }
            $result = mysqli_query($conn, $sql);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='card'>
                            <img src='Images/{$row['file']}' alt='Product Image'>
                            <div class='card-content'>
                                <h2>{$row['name']}</h2>
                                <p>{$row['description']}</p>
                                <p><strong>Price: </strong>K{$row['price']}</p>
                              
                                <button id='confettiButton' onclick=\"window.location.href='booking.php?product_id={$row['id']}'\">Book Now</button>
                            <div class='confetti-container' id='confettiContainer'></div>
                                </div>
                          </div>";
                }
            } else {
                echo "No products found.";
            }
            ?>
        </div>
    </div>
     <!-- Custom Modal for Logout Confirmation -->
     <div id="logoutModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to logout?</p>
            <button id="confirmLogout">Yes, Logout</button>
            <button class="cancel" id="cancelLogout">Cancel</button>
        </div>
    </div>

    <script>
        // Function to show notification
        function showNotification(message, type) {
            var notification = document.getElementById('notification');
            notification.textContent = message;
            notification.classList.add(type); // success or error
            notification.style.display = 'block';

            // Hide after 3 seconds
            setTimeout(function () {
                notification.style.display = 'none';
                notification.classList.remove(type);
            }, 3000);
        }

        // Get modal and buttons
        var logoutModal = document.getElementById('logoutModal');
        var logoutLink = document.getElementById('logoutLink');
        var cancelLogout = document.getElementById('cancelLogout');
        var confirmLogout = document.getElementById('confirmLogout');

        // Show the modal when the logout link is clicked
        logoutLink.onclick = function (event) {
            event.preventDefault();  // Prevent the default logout action
            logoutModal.style.display = 'flex';
        };

        // Close the modal when 'Cancel' is clicked
        cancelLogout.onclick = function () {
            logoutModal.style.display = 'none';
        };

        // Confirm logout action
        confirmLogout.onclick = function () {
            // You can add the actual logout code here
            window.location.href = "logout.php";  // For example, redirect to the logout page
        };

        // Close modal if clicked outside of the modal content
        window.onclick = function (event) {
            if (event.target == logoutModal) {
                logoutModal.style.display = 'none';
            }
        };
    </script>

<script src="scripts/splash.js"></script>


</body>

</html>