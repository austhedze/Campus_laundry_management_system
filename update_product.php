<?php
include('connection.php');

// Handle product update
if (isset($_POST['update_product'])) {
    $id = $_GET['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    // Check if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $file_name = $_FILES['image']['name'];
        $tempname = $_FILES['image']['tmp_name'];
        $folder = 'Images/' . $file_name;

        // Update product with new image
        $sql = "UPDATE products SET name='$name', description='$description', price='$price', category='$category', file='$file_name' WHERE id=$id";
        move_uploaded_file($tempname, $folder);
    } else {
        // Update product without changing image
        $sql = "UPDATE products SET name='$name', description='$description', price='$price', category='$category' WHERE id=$id";
    }

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo '<script>
        alert("Product Updated successfully!");
        window.location.href="admin.php";
        </script>';
    } else {
        echo "Failed to update product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
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
    width: 90%;  /* Reduced width to prevent overflow */
    border-bottom: 1px solid #34495e;
    text-align: left;
    box-sizing: border-box;  /* Ensures padding is included in width */
}

.sidebar a {
    display: flex;
    align-items: center;
    color: #bdc3c7;
    padding: 12px 20px;
    margin: 5px 0;
    width: 85%;  /* Ensures links align with the headings */
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
    background-color:  #9990cc;
    color: #ecf0f1;
    box-shadow: inset 5px 0 0 #9990cc;
}

        .content {
            width: 50%;
            padding: 30px;
            background-color: #ecf0f1;
            overflow-y: auto;
            right: 100px;
            position: fixed;
        }

        .content h2 {
            font-size: 32px;
            margin-bottom: 30px;
            color: #34495e;
        }

  
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        form label {
            font-size: 16px;
            color: #34495e;
            margin-top: 10px;
            display: block;
        }

        form input, form select, form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 20px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
        }

        form button {
            background-color: #9990cc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: grey;
        }

        /* Responsiveness */
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

            form {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
    <h2>Admin Dashboard</h2>
    <a href="admin.php">
        <img src="icons/manage_products.png" alt="Manage Products Icon"> Manage Products
    </a>
    <a href="book_requests_reply.php">
        <img src="icons/requests.png" alt="Book Requests Icon"> Book Requests
    </a>
    <a href="#">
        <img src="icons/settings.png" alt="Settings Icon"> Settings
    </a>
    <a href="logout.php" onclick="return confirm('Are You Sure You Want To Logout?')">
        <img src="icons/logout.png" alt="Logout Icon"> Logout
    </a>
</div>

    <!-- Main Content -->
    <div class="content">
        <h2>Update Product</h2>

        <!-- Update Product Form -->
        <form method="POST" enctype="multipart/form-data">
            <label for="name">Product Name:</label>
            <input type="text" name="name" required>

            <label for="description">Description:</label>
            <textarea name="description" required></textarea>

            <label for="price">Price:</label>
            <input type="text" name="price" required>

            <label for="category">Category:</label>
            <select name="category" required>
                <option value="Clothing">Clothing</option>
                <option value="Bedding">Bedding</option>
                <option value="Miscellaneous">Miscellaneous</option>
            </select>

            <label for="image">Image (optional):</label>
            <input type="file" name="image">

            <button type="submit" name="update_product">Update Product</button>
        </form>
    </div>
</div>

</body>

</html>
