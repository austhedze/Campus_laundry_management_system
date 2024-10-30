<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username']; 
    $book_date = $_POST['book_date'];
    $product_id = $_POST['product_id'];

    // Prepare the SQL query
    $sql = "INSERT INTO book_service  (name, username, book_date, product_id) VALUES ('$name', '$username', '$book_date', '$product_id')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo '<script>
        alert("Book request submitted successfully!");
        window.location.href="customer.php"; // Redirect to customer page
        </script>';
    } else {
        echo "Failed to submit book request: " . mysqli_error($conn);
    }
}

// Fetch product details for thebookings request (assuming product_id is passed via GET)
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch product details
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request a Book</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        display: flex;
        flex-direction: column;
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
        transition: width 0.3s;
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
        box-shadow: inset 5px 0 0 #9990cc;
    }

    .content {
        margin-left: 250px;
        flex-grow: 1;
        padding: 20px;
    }

    .container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        margin: 20px auto;
    }

    .container h2 {
        margin-bottom: 20px;
    }

    input,
    textarea {
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

    .active {
        background-color: grey;
    }

    
    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: static;
            box-shadow: none;
            display: flex;
            flex-direction: row;
            overflow-x: auto;
            justify-content: space-around;
        }

        .sidebar h2 {
            display: none;
           
        }

        .sidebar a {
            width: auto;
            padding: 10px;
            font-size: 14px;
        }

        .content {
            margin-left: 0;
            padding: 10px;
        }

        .container {
            width: 100%;
            margin: 10px auto;
            padding: 15px;
        }
    }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>Menu</h2>
        <a href="customer.php">
            <img src="icons/home.png" alt="Home Icon"> Home
        </a>
        <div class="spacer" style='height:40px'></div>
        <a href="booking.php" class="active">
            <img src="icons/book.png" alt="Bookings Icon"> Book request
        </a>
        <div class="spacer" style='height:40px'></div>
        <a href="customer.php">
            <img src="icons/product.png" alt="Products Icon"> Products
        </a>
        <div class="spacer" style='height:40px'></div>
        <a href="logout.php" onclick="return confirm('Are You Sure You Want To Logout?')">
            <img src="icons/logout.png" alt="Logout Icon"> Logout
        </a>
    </div>



    <div class="content">
        <div class="container">
            <?php if (isset($product)): ?>
            <h2>Request a Book for <span style='color:indigo'><?php echo htmlspecialchars($product['name']); ?></span>
            </h2>
            <p>Price:<span style='color:green'> MWK<?php echo htmlspecialchars($product['price']); ?></p></span>

            <form method="POST">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                <label for="name">Your Name:</label>
                <input type="text" name="name" required>

                <label for="username">Your Email:</label>
                <input type="email" name="username" required>

                <label for="book_date">Book Date:</label>
                <input type="date" name="book_date" required>

                <button type="submit" name="submit">Request a book</button>
            </form>
            <?php else: ?>
            <h2>Product not found!</h2>
            <p>Please select a valid product to request a book.</p>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>