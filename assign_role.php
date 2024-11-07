<?php
include "connection.php";
session_start();

if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

// Fetch user details from the database
$sql = "SELECT * FROM users WHERE username = '$username' AND role='admin'";
$result = mysqli_query($conn, $sql);
$admin = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $role = $_POST["role"];

    // Check if the user exists
    $checkUserQuery = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($checkUserQuery);

    if ($result->num_rows > 0) {
        // Update the role
        $updateRoleQuery = "UPDATE users SET role = '$role' WHERE username = '$username'";
        
        if ($conn->query($updateRoleQuery) === TRUE) {
            echo "<script>
            alert('Role for $username updated successfully.');
            window.location.href='assign_role.php';
            </script>";
        } else {
            echo "Error updating role: " . $conn->error;
        }
    } else {
        echo "<script>
        alert('Oops! No user with such username was found');
        </script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Roles</title>
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

        .content {
            margin-left: 250px;
            padding: 30px;
            width: calc(100% - 250px);
            background-color: #ecf0f1;
            overflow-y: auto;
        }

        .content h2 {
            font-size: 32px;
            margin-bottom: 30px;
            color: #34495e;
        }

        .form-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
            position: relative;
        }

        .form-section label {
            font-size: 16px;
            color: #34495e;
            margin-top: 10px;
            display: block;
        }

        .form-section input,
        .form-section select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 20px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
        }

        .form-section button {
            background-color: #9990cc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .form-section button:hover {
            background-color: #16a085;
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
            transition:all 2s;
        
        }

        .notification.success {
            background-color: #9b59b6;
        }

        .notification.error {
            background-color: #e74c3c; 
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="sidebar">
            <h2>Admin Dashboard</h2>
            <a href="#">
                <img src="icons/manage_products.png" alt="Manage Products Icon"> Manage Products
            </a>
            <div class="spacer" style='height:23px'></div>
            <a href="book_requests_reply.php">
                <img src="icons/book_requests.png" alt="Book Requests Icon"> Book Requests
            </a>
            <div class="spacer" style='height:23px'></div>
            <a href="#">
                <img src="icons/enquiries.png" alt="Settings Icon"> Enquiries
            </a>
            <div class="spacer" style='height:23px'></div>
            <a href="logout.php" onclick="return confirm('Are You Sure You Want To Logout?')">
                <img src="icons/logout.png" alt="Logout Icon"> Logout
            </a>
        </div>

        <div class="content">
          <CENTER>  <h2>Assign Roles</h2></CENTER>

            <div class="form-section">
                <form method="POST" id="roleForm">
                    <label for="username">Username:</label>
                    <input type="text" name="username" placeholder="Enter Username" required>

                    <label for="role">Role:</label>
                    <select name="role" required>
                        <option value="customer">Customer</option>
                        <option value="admin">Admin</option>
                    </select>

                    <button type="submit" name="assign_role">Assign Role</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Custom Notification -->
    <div id="notification" class="notification"></div>
</body>

</html>
