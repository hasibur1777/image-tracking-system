<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";


$conn = new mysqli($servername,
$username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$servername_qc = "";
$username_qc = "";
$password_qc = "";
$dbname_qc = "";


$conn_qc = new mysqli($servername_qc,
$username_qc, $password_qc, $dbname_qc);

if ($conn_qc->connect_error) {
    die("Connection failed: " . $conn_qc->connect_error);
}
