<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

include 'connection.php';

// Handle replying to bookings requests and updating progress
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
        error_log("MySQL error: " . mysqli_error($conn)); 
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
        }

        .sidebar h2 {
            color: #ecf0f1;
            font-size: 18px;
            margin: 20px 0 10px;
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
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        .sidebar a:hover {
            background-color: #9990cc;
            color: #ecf0f1;
            box-shadow: inset 5px 0 0 #9990cc;
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

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
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

        /* Responsive Styling */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                flex-direction: row;
                justify-content: space-around;
                padding: 10px;
            }

            .content {
                margin-left: 0;
                padding: 15px;
            }

            table, th, td {
                font-size: 14px;
            }

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            td input[type="text"],
            td input[type="date"],
            td input[type="number"] {
                width: 100%;
            }

            .sidebar a {
                padding: 10px 5px;
                font-size: 14px;
            }

            .sidebar h2 {
                font-size: 16px;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            th, td {
                padding: 8px;
                font-size: 12px;
            }

            td button {
                padding: 5px 8px;
                font-size: 12px;
            }

            .sidebar h2 {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

<div class="sidebar">
    <h2>Admin Dashboard</h2>
    <a href="#">
        <img src="icons/req.png" alt="req Icon" style="width:20px; height:20px; margin-right:10px;"> Requests
    </a>
    <div class="spacer" style='height:23px'></div>
    <a href="admin.php">
        <img src="icons/ive.png" alt="Manage Products Icon" style="width:20px; height:20px; margin-right:10px;"> Manage Products
    </a>
    <div class="spacer" style='height:23px'></div>
    <a href="admin_reply_requests.php">
        <img src="icons/book.png" alt="Book Requests Icon" style="width:20px; height:20px; margin-right:10px;"> Book Requests
    </a>
    <div class="spacer" style='height:23px'></div>
    <a href="logout.php" onclick="return confirm('Are you sure you want to Logout?')">
        <img src="icons/logout.png" alt="Logout Icon" style="width:20px; height:20px; margin-right:10px;"> Logout
    </a>
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
                                    <input type='text' name='reply_message' placeholder='Tell customer something' required>
                                   <label>Finish day:</label> <input type='date' name='finish_day' required>
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