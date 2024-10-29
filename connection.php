<?php


$conn = new mysqli('localhost', 'root', '', 'LAUNDRY_MANAGEMENT_SYSTEM');

if(!$conn){
    
 die(mysqli_error($conn));
}

?>