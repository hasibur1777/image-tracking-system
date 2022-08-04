<?php
require "db_conn.php";

$uid = $_GET["id"];
$result = mysqli_query($conn, "SELECT * FROM user_prod WHERE user_id='$uid' and is_active='1'");
$user_details = array();
while ($row = mysqli_fetch_array($result)) {
    $user_details[$row['short_code']] = $row['product'];
}

//var_dump($user_details);
//$res = implode(",, ", $user_details);
$res = json_encode($user_details);


echo $res;
