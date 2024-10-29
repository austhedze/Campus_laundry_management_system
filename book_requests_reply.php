<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

include 'connection.php';

// Handle replying to appointment requests and updating progress
if (isset($_POST['reply'])) {
    $request_id = $_POST['request_id'];
    $reply_message = mysqli_real_escape_string($conn, $_POST['reply_message']);
    $finish_day = mysqli_real_escape_string($conn, $_POST['finish_day']);
    $progress = mysqli_real_escape_string($conn, $_POST['progress']);

    $sql = "UPDATE book_service SET reply_message='$reply_message', finish_day='$finish_day', progress='$progress', status='replied' WHERE id='$request_id'";
    
    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Progress updated successfully!");</script>';
    } else {
        echo '<script>alert("Failed to update reply and progress: ' . mysqli_error($conn) . '");</script>';
        error_log("MySQL error: " . mysqli_error($conn)); // Log the error for server-side debugging
    }
}


// Handle delete request
if (isset($_POST['delete'])) {
    $deleteID = $_POST['deleteID'];

    // Delete query without prepared statements
    $sql = "DELETE FROM book_service WHERE id='$deleteID'";
    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("book request deleted successfully!");</script>';
    } else {
        echo '<script>alert("Failed to delete book request: ' . mysqli_error($conn) . '");</script>';
    }
}

// Fetch book requests from the database
$sql = "SELECT * FROM book_service";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Requests</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        background-color: #f4f4f4;
        display: flex;
    }

    .sidebar {
        width: 220px;
        background-color: grey;
        color: white;
        padding: 20px;
        height: 100vh;
        position: fixed;
    }

    .sidebar h2 {
        color: #ffffff;
    }

    .sidebar a {
        color: #ffffff;
        text-decoration: none;
        display: block;
        margin: 10px 0;
        padding: 10px;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .sidebar a:hover {
        background-color: #9990cc;
    }

    .content {
        margin-left: 260px;
        padding: 20px;
        flex-grow: 1;
    }

    h2 {
        margin-top: 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table,
    th,
    td {
        border: 1px solid #000;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #9990cc;
        color: white;
    }

    td input[type="text"],
    td input[type="date"],
    td input[type="number"] {
        padding: 5px;
        margin: 5px 0;
        width: calc(100% - 10px);
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    td button {
        background-color: #5cb85c;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 4px;
    }

    td button:hover {
        background-color: #4cae4c;
    }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="customer.php">Home</a>
        <a href="admin.php">Manage Products</a>
        <a href="admin_reply_requests.php">Book Requests</a>
        <a href="logout.php" onclick="return confirm('Are you sure you want to Logout?')">Logout</a>
    </div>

    <div class="content">
        <h2>Book Requests</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Book Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['book_date']}</td>
                            <td>{$row['status']}</td>
                            <td>
                                <form method='POST' style='display:inline;' action=''>
                                    <input type='hidden' name='request_id' value='{$row['id']}'>
                                    <input type='text' name='reply_message' placeholder='Your reply' required>
                                    <input type='date' name='finish_day' required>
                                    <input type='number' name='progress' placeholder='Progress (%)' min='0' max='100' required>
                                    <button type='submit' name='reply'>Update</button>
                                </form>

                                <form method='POST' style='display:inline;' action=''>
                                    <input type='hidden' name='deleteID' value='{$row['id']}'>
                                    <button type='submit' name='delete' style='background:red; color:white;'>Delete</button>
                                </form>
                            </td>
                          </tr>";
                }
            }
            ?>
        </table>
    </div>

</body>

</html>