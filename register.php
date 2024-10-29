<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $default_role = 'customer'; 

    // Compare passwords before hashing
    if($password !== $confirmPassword){
        echo '
        <script>
        alert("Password does not Match!");
        window.location.href="register.php";
        </script>
        ';
        exit;
    }

    // Hash the password after confirmation
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if user already exists
    $check_user_query = "SELECT * FROM users WHERE username = '$username'";
    
    $check_user_result = mysqli_query($conn, $check_user_query);

    if (mysqli_num_rows($check_user_result) > 0) {
        echo '<script>
        alert("User Already Exists");
        window.location.href="register.php";
        </script>';
        exit;
    }

    // Add new user to database
    $sql = "INSERT INTO users (firstname, lastname, username, password, role)
     VALUES ('$firstname', '$lastname', '$username', '$hashedPassword', '$default_role')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo '<script>
        alert("You are Successfully Registered!");
        window.location.href= "customer.php";
        </script>';
        exit;
    } else {
        echo '<script>
        alert("Registration Failed. Please try again.");
        window.location.href= "register.php";
        </script>';
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Laundry management Register Page</title>
    <link rel="stylesheet" href="custom/styles.css">
    <style>
        .container {
    display: flex;
    width: 900px;
    height: 610px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    border-radius: 8px;
    overflow: hidden;
}
        </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Campus Laundry Management</h2>
            <form method="POST">

            <label for="username">Firstname</label>
                <input type="text" id="username" name="firstname" required>

                <label for="username">Lastname</label>
                <input type="text" id="username" name="lastname" required>

                <label for="username">Username</label>
                <input type="email" id="username" name="username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
  
                
                <label for="password">ConfirmPassword</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>

                <button type="submit" name="submit">Register</button>
                <p>Already have an account? <a href="login.php">Sign in</a></p>
            </form>
        </div>
        <div class="image-container">
            <img src="images/l2.jpg" alt="Luandry image">
        </div>
    </div>
</body>
</html>
