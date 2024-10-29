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

// Fetch product details for the appointment request (assuming product_id is passed via GET)
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
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            padding: 20px;
            height: 100vh;
        }
        .sidebar h2 {
            color: #ffffff;
        }
        .sidebar a {
            color: #ffffff;
            text-decoration: none;
            display: block;
            margin: 10px 0;
            padding:10px;
            margin:17px;
          
        }
        .sidebar a:hover {
        background-color: #9990cc;;
        }
        .content {
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
        input, textarea {
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
            background-color:grey;
        }
       
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Menu</h2>
    <a href="customer.php">Home</a>
    <a href="book_requests.php" class="active">Your Bookings</a>
    <a href="customer.php">Products</a>
    <a  href="logout.php" onclick="return confirm('Are You Sure You Want To Logout?')">Logout</a>
</div>


<div class="content">
    <div class="container">
        <?php if (isset($product)): ?>
            <h2>Request a Book for <span style='color:indigo'><?php echo htmlspecialchars($product['name']); ?></span></h2>
            <p >Price:<span style='color:green'> MWK<?php echo htmlspecialchars($product['price']); ?></p></span>

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
