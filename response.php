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


//$username = $_SESSION['username'];
$username = mysqli_real_escape_string($conn, $username);

//we need product name thus wjy we just joined the tables, i.e app & prod

$sql = "SELECT b.id, b.book_date, b.progress, b.reply_message, b.finish_day, p.name AS product_name 
        FROM book_service b
        JOIN products p ON b.product_id = p.id 
        WHERE b.username = '$username'";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Data query failed: " . mysqli_error($conn));
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Progress</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
        }

      
        .sidebar {
            width: 250px;
            background-color: #333;
            color: white;
            height: 100vh;
            padding-top: 20px;
            position: fixed;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 15px;
            text-decoration: none;
            text-align: left;
        }

        .sidebar a:hover {
            background:    #9990cc;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

 
        .main-content {
            margin-left: 260px;
            padding: 20px;
            flex-grow: 1;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 850px;
            margin: 20px auto;
           
          
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }

        .progress-bar {
            width: 100%;
            background-color: wheat;
            border-radius: 25px;
            overflow: hidden;
            margin-bottom: 20px;
            border:2px solid black;
        }

        .progress-bar-fill {
            height: 30px;
            background-color: #4caf50;
            width: 0;
            line-height: 30px;
            text-align: center;
            color: white;
            transition: width 0.5s;
        }
        
    .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 3px solid #4caf50;
        display: block;
        float: right;
    }
    </style>
</head>
<body>


    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Categories</h2>
        <a href="customer.php">home</a>
        <a href="?category=clothing">Clothing</a>
        <a href="?category=bedding">Bedding</a>
        <a href="?category=miscellaneous">Miscellaneous</a>
        <a href="response.php">Book Upadate</a>
        <a href="customer_profile.php">My Profile</a>
        <a href="logout.php" onclick="return confirm('Are you sure you want to logout?')">Sign Out</a>
    </div>

    


    <div class="main-content">
    <a href="customer_profile.php">
            <div>
                <img src="<?php echo $user['profile_picture'] && file_exists($user['profile_picture']) ? $user['profile_picture'] : 'images/prof.png'; ?>"
                    class="avatar" alt="Avatar">
            </div>
        </a>
        <div class="container">
            <h2>Your Booking Progress</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th> 
                    <th>Book Date</th>
                    <th>reply message</th>
                    <th>finish day</th>
                    <th>Progress</th>
                </tr>

                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // print_r($row);
                        // Calculate progress percentage
                        $progress = $row['progress'];

                       
                        echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['product_name']}</td> 
                        <td>{$row['book_date']}</td> <!-- Corrected this line -->
                        <td>{$row['reply_message']}</td> <!-- Corrected this line -->
                        <td>{$row['finish_day']}</td> <!-- Moved this line -->
                        <td>
                            <div class='progress-bar'>
                                <div class='progress-bar-fill' style='width: {$progress}%;'>
                                    {$progress}%
                                </div>
                            </div>
                        </td>
                      </tr>";                 }
                } else {
                    echo "<tr><td colspan='4'><h2 style='color:red'>No booking progress available.</h2></td></tr>"; 
                }
                ?>
            </table>
        </div>
    </div>

</body>
</html>