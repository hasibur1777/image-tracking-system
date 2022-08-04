<?php
require "db_conn.php";

$id = $_GET['id'];

$sqlquery = "UPDATE user_prod SET is_active=0 WHERE user_id='$id'";

if (mysqli_query($conn, $sqlquery) === TRUE) {
    //header("location: user.php");
} else {
    echo "Error: " . $sqlquery . "<br>" . $conn->error;
}

$sqlquery2 = "UPDATE user_role SET is_active=0 WHERE user_id='$id'";

if (mysqli_query($conn, $sqlquery2) === TRUE) {
    //header("location: user.php");
} else {
    echo "Error: " . $sqlquery2 . "<br>" . $conn->error;
}
