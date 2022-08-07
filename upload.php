<?php
require "backend/db_conn.php";

session_start();
$user_id = $_SESSION["login_user"];
$product = $_SESSION["product"];
$line = $_SESSION["line"];
$point = $_SESSION["point"];
$time = date("Y/m/d h:i:sa");
$time2 = date("Y_m_d_h_i_sa");


$barcode = $_GET['barcode'];
$filename = $barcode . '-' . $time2 . '.jpeg';

$url = '';
if (move_uploaded_file($_FILES['webcam']['tmp_name'], 'upload/' . $filename)) {
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/upload/' . $filename;
}

echo $user_id . $product . $line . $point . $url;

$_SESSION["last_img"] = $url;
$_SESSION["barcode"] = $barcode;

//$sqlquery = "INSERT INTO test (barcode, path) VALUES ('$barcode', '$url')";
$sqlquery = "INSERT INTO track (user_id, product, line, point, barcode, img_path, created_at) 
    VALUES ('$user_id', '$product','$line', '$point', '$barcode', '$url', '$time')";

if (mysqli_query($conn, $sqlquery) === TRUE) {
    echo "record inserted successfully";
} else {
    echo "Error: " . $sqlquery . "<br>" . $conn->error;
}
