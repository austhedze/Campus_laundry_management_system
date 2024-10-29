<?php
include 'connection.php';

if (isset($_POST['submit'])) {

    $file_name = $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name']; 
    $folder = 'Images/' . $file_name;

    $sql = "INSERT INTO `products` (file) VALUES ('$file_name')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (move_uploaded_file($tempname, $folder)) {
            echo '<h1>Product added successfully</h1>';
        } else {
            echo '<h1>Product not added</h1>';
        }
    } else {
        die(mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload files to DB</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="image" required/><br><br><br>
        <button type="submit" name="submit">Upload</button>
    </form>

    <?php
    $sql = "SELECT * FROM `products`";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Displaying the image
            echo '<img src="Images/' . $row['file'] . '" alt="Product Image" /><br>';
        }
    } else {
        die(mysqli_error($conn));
    }
    ?>
</body>
</html>
