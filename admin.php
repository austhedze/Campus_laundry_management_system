<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}
?>
<?php
include 'connection.php';

// Handle product addition
if (isset($_POST['add_product'])) {
    $file_name = $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name'];
    $folder = 'Images/' . $file_name;
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category']; 

    $sql = "INSERT INTO products (file, name, description, price, category) VALUES ('$file_name', '$name', '$description', '$price', '$category')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        move_uploaded_file($tempname, $folder);
        echo '<script>
        alert("product added sucessfully!");
        </script>';
    } else {
        echo "Failed to add product: " . mysqli_error($conn);
    }
}

// Handle product deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM products WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo '<script>
            alert("product deleted successfully");
            window.location.href="admin.php";
            </script>';
    } else {
        echo "Failed to delete product: " . mysqli_error($conn);
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            width: 20%;
            background-color:grey;
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
            background-color:  #9990cc;
        }

      
        .content {
            width: 80%;
            padding: 30px;
            background-color: #ecf0f1;
            overflow-y: auto;
        }

        .content h2 {
            font-size: 32px;
            margin-bottom: 30px;
            color: #34495e;
        }

        /* Form Styling */
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
            background-color:  #9990cc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #16a085;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color:  #9990cc;
            color: white;
        }

        td img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
        }

        td a {
            color: #e74c3c;
            text-decoration: none;
            margin-right: 10px;
            transition: color 0.3s ease;
        }

        td a:hover {
            color: #c0392b;
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

            table, form {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="#">Manage Products</a>
        <a href="book_requests_reply.php">Book Requests</a>
        <a href="#">Settings</a>
        <a href="logout.php" onclick="return confirm('Are You Sure You Want To Logout?')">Logout</a>
    </div>
    <div class="content">
        <h2>Manage Products</h2>
        
        <!-- Add Product Form -->
        <form method="POST" enctype="multipart/form-data">
            <label for="name">Product Name:</label><br>
            <input type="text" name="name" required><br>
            <label for="description">Description:</label><br>
            <textarea name="description" required></textarea><br>
            <label for="price">Price:</label><br>
            <input type="text" name="price" required><br>
            <label for="category">Category:</label><br>
            <select name="category" required>
                <option value="Clothing">Clothing</option>
                <option value="Bedding">Bedding</option>
                <option value="Miscellaneous">Miscellaneous</option>
            </select><br><br>
            <label for="image">Image:</label><br>
            <input type="file" name="image" required><br><br>
            <button type="submit" name="add_product">Add Product</button>
        </form>

        <!-- Product List -->
        <h3>Products</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Category</th> 
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php
            $sql = "SELECT * FROM products";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['description']}</td>
                            <td>{$row['price']}</td>
                            <td>{$row['category']}</td> <!-- Display category in table -->
                            <td><img src='Images/{$row['file']}' alt='Product Image' width='50'></td>
                            <td>
                                <a href='admin.php?delete={$row['id']}'>Delete</a> |
                                <a href='update_product.php?id={$row['id']}'>Update</a>
                            </td>
                          </tr>";
                }
            }
            ?>
        </table>
    </div>
</div>

</body>
</html>
