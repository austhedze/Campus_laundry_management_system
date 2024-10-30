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

// Handle profile update
if (isset($_POST['update'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $profile_picture = $_FILES['profile_picture'];

    // Upload profile picture
    if ($profile_picture['name']) {
        $target_dir = "Images/";
        $target_file = $target_dir . basename($profile_picture["name"]);
        move_uploaded_file($profile_picture["tmp_name"], $target_file);
    } else {
        $target_file = $user['profile_picture']; // Keep existing picture if not updated
    }

    // Update user information
    $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname', profile_picture='$target_file' WHERE username='$username'";
    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Profile updated successfully!");</script>';
        header('Location: customer_profile.php'); // Refresh to show updated profile
        exit;
    } else {
        echo '<script>alert("Error updating profile: ' . mysqli_error($conn) . '");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f6fa;
        }

        .container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
        }

        .content {
            margin-left: 270px;
            padding: 40px;
            background-color: #ecf0f1;
            flex: 1;
            overflow-y: auto;
        }

        .form-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        .avatar-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .avatar {
            width: 240px;
            height: 240px;
            border-radius: 50%;
            border: 3px solid #4caf50;
        }

        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #9990cc;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            width: 100%;
            border-radius: 4px;
        }

        button:hover {
            background-color: grey;
        }

        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                box-shadow: none;
                padding: 20px;
                margin-bottom: 20px;
            }

            .sidebar h2, .sidebar a {
                font-size: 16px;
                padding: 10px;
            }

            .content {
                margin: 0;
                padding: 20px;
            }

            .avatar {
                width: 200px;
                height: 200px;
            }
        }
    </style>
</head>
<body>

<div class="container">
   
<div class="sidebar">
    <h2>User Dashboard</h2>
    <a href="customer.php">
        <img src="icons/home.png" alt="Home Icon"> Home
    </a>
    <div style='height:23px'></div>
    <a href="customer_profile.php">
        <img src="icons/account.png" alt="Profile Icon"> View Profile
    </a>
    <div style='height:23px'></div>
    <a href="book_requests_reply.php">
        <img src="icons/book.png" alt="Book Requests Icon"> Book Requests
    </a>
    <div style='height:23px'></div>
    <a href="logout.php" onclick="return confirm('Are You Sure You Want To Logout?')">
        <img src="icons/logout.png" alt="Logout Icon"> Logout
    </a>
</div>


    
    <div class="content">
    <div class="avatar-container">
        
            <img src="<?php echo $user['profile_picture'] ? htmlspecialchars($user['profile_picture']) : 'images/prof.png'; ?>" class="avatar" alt="Avatar">
        </div>
        <div class="form-section">
            <h2>Update Profile</h2>
            <form method="POST" enctype="multipart/form-data">
                <label for="firstname">First Name:</label>
                <input type="text" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>

                <label for="lastname">Last Name:</label>
                <input type="text" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>

                <label for="profile_picture">Profile Picture:</label>
                <input type="file" name="profile_picture">

                <button type="submit" name="update">Update Profile</button>
            </form>
        </div>
       
    </div>
</div>

</body>
</html>
