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

    form input,
    form select,
    form textarea {
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
        background-color: #16a085;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    th,
    td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #9990cc;
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
            position: static;
        }

        .content {
            margin-left: 0;
            width: 100%;
        }

        form,
        table {
            font-size: 14px;
        }

        th,
        td {
            padding: 10px;
        }
    }
    </style>
</head>

<body>

    <div class="container">
        <div class="sidebar">
            <h2>Admin Dashboard</h2>
            <div class="spacer" style='height:50px'></div>
            <a href="#">
                <img src="icons/ive.png" alt="Manage Products Icon"> Manage Products
            </a>
            <div class="spacer" style='height:23px'></div>
            <a href="book_requests_reply.php">
                <img src="icons/not.png" alt="Book Requests Icon"> Book Requests
            </a>
            <div class="spacer" style='height:23px'></div>
            <a href="assign_role.php">
                <img src="icons/roles.png" alt="Settings Icon"> Assign Roles
            </a>
            <div class="spacer" style='height:23px'></div>
            <a href="logout.php" onclick="return confirm('Are You Sure You Want To Logout?')">
                <img src="icons/logout.png" alt="Logout Icon"> Logout
            </a>
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
                                <a style='color:green' href='update_product.php?id={$row['id']}'>Update</a>
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