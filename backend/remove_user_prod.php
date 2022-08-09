<?php
require "db_conn.php";

$id = $_GET['id'];

$admin_id = $_SESSION['login_user'];

$my_query = "SELECT user_id FROM user_prod WHERE id='$id' AND is_active='1'";

$result = mysqli_query($conn, $my_query) or die("Query Failed");
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        if ($row['user_id'] == $admin_id) {
            session_start();
            $_SESSION['double_create_error'] = "Self Remove Can't Possible!";
            header("location: user.php");
        } else {

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
        }
    }
}
