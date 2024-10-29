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

        margin: 15px;
    }

    .sidebar a:hover {
        background-color: #9990cc;
        transition: all 1.5s;
    }

    .sidebar h2 {
        text-align: center;
        margin-bottom: 30px;
    }


    .main-content {
        margin-left: 260px;
        padding: 20px;


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
        border: 3px solid #4caf50;
        display: block;
        float: right;
        right: 0;
        position:fixed;
        
    }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Categories</h2>
        <a href="?category=clothing">Clothing</a>
        <a href="?category=bedding">Bedding</a>
        <a href="?category=miscellaneous">Miscellaneous</a>
        <a href="response.php">Book Updates</a>
        <a href="customer_profile.php">my Profile</a>
        <a href="logout.php" onclick="return confirm('Are you sure you want to logout?')">sign out</a>
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
                                <button onclick=\"window.location.href='booking.php?product_id={$row['id']}'\">Book Now</button>
                            </div>
                          </div>";
                }
            } else {
                echo "No products found.";
            }
            ?>
        </div>
    </div>
</body>

</html>