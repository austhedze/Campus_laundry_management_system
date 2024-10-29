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
            height: 100vh;
        }

        .sidebar {
            width: 20%;
            background:grey;
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
            background-color:#9990cc;
        }

     
        .content {
            width: 80%;
            padding: 30px;
            background-color: #ecf0f1;
            overflow-y: auto;
        }

        .form-section {
            flex: 1;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 20px auto;
        }

        .avatar-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-left: 30px;
        }

        .avatar {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 3px solid #4caf50;
            margin-top: 10px;
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
            background-color:grey;
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
        <a href="book_requests_reply.php">Book Requests</a>
       
        <a href="logout.php" onclick="return confirm('Are You Sure You Want To Logout?')">Logout</a>
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
