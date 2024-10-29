<?php
session_start();
include 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
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
    <title>View Profile</title>
    <style>

    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f6fa;
    }

    .container {
        display: flex;
        height: 100vh;
    }

   
    .sidebar {
        width: 20%;
        background-color: grey;
        padding: 30px 20px;
        color: #fff;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    .sidebar h2 {
        text-align: center;
        font-size: 24px;
        margin-bottom: 40px;
        border-bottom: 2px solid #f5f6fa;
        padding-bottom: 15px;
    }

    .sidebar a {
        color: #ecf0f1;
        text-decoration: none;
        font-size: 18px;
        padding: 15px 20px;
        display: block;
        border-radius: 8px;
        margin-bottom: 15px;
        transition: background-color 0.3s ease;

    }

    .sidebar a:hover {
        background: #9990cc;
    }


    .content {
        width: 80%;
        padding: 30px;

        overflow-y: auto;
    }

    .profile-container {
        display: flex;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        margin: 20px auto;
    }

    .form-section {
        flex: 1;
        margin-right: 20px;
    }

    .avatar {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        border: 3px solid #4caf50;
        display: block;
        margin-left: auto;
    }

    p {
        margin: 10px 0;
        font-size: 16px;
    }

    .update-btn {
        display: block;
        margin: 20px 0;
        padding: 10px 20px;
        background-color: #9990cc;
        color: white;
        text-align: center;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
    }

    .update-btn:hover {
        background-color: grey;
    }

    @media (max-width: 768px) {
        .container {
            flex-direction: column;
        }

        .sidebar {
            width: 100%;
            height: auto;
            padding: 20px;
        }

        .content {
            width: 100%;
        }
    }
    </style>
</head>

<body>

    <div class="container">
   
        <div class="sidebar">
            <h2>User Dashboard</h2>
            <a href="customer.php">Home</a>
            <a href="customer_profile.php">View Profile</a>
            <a href="response.php">Book Updates</a>
            <!-- <a href="settings.php">Settings</a> -->
            <a href="logout.php" onclick="return confirm('Are You Sure You Want To Logout?')">Logout</a>
        </div>

       
        <div class="content">
            <div class="profile-container">
                <div class="form-section">
                    <h2>Your Profile Information</h2>
                    <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
                    <p><strong>First Name:</strong> <?php echo $user['firstname']; ?></p>
                    <p><strong>Last Name:</strong> <?php echo $user['lastname']; ?></p>
                    <a href="update_profile.php" class="update-btn">Edit Profile</a>
                </div>
                <div>
                    <img src="<?php echo $user['profile_picture'] && file_exists($user['profile_picture']) ? $user['profile_picture'] : 'images/prof.png'; ?>"
                        class="avatar" alt="Avatar">
                </div>
            </div>
        </div>
    </div>

</body>

</html>