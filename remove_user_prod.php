<?php
require "db_conn.php";

$id = $_GET['id'];

$sqlquery = "UPDATE user_prod SET is_active = 0 WHERE id='$id'";

if (mysqli_query($conn, $sqlquery) === TRUE) {
    header("location: user.php");
} else {
    echo "Error: " . $sqlquery . "<br>" . $conn->error;
}

?>