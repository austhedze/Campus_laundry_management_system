<?php
include 'connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to get the user's hashed password and role from the database
    $query = "SELECT id, password, role FROM users WHERE username = '$username'";
    
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'];

            // Redirect based on user role
            if ($row['role'] == 'admin') {
                header('Location: admin.php');
            } else {
                header('Location: customer.php');
            }
            
            exit;



        } else {
            echo '<script>
            alert("Invalid Password");
            </script>';
        }
    } else {
        echo '<script>
        alert("User not found with such Credentials!");
        </script>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Laundry management Login Page</title>
    <link rel="stylesheet" href="custom/styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Campus Laundry Management</h2>
            <form method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Login</button>
                <p>Don't have an account? <a href="register.php">Sign up</a></p>
            </form>
        </div>
        <div class="image-container">
            <img src="images/l2.jpg" alt="Login Image">
        </div>
    </div>
</body>
</html>
