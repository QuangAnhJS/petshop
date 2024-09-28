<?php
ob_start();
session_start();
$servername = "127.0.0.1";
$username = "petshop";
$password = "6uveIQcPLvkXUqoWmo20";
$databaseName = "petshop";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $databaseName);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_SESSION['User'])) {
    $login = $_SESSION['User'];
    $get_users = mysqli_query($conn, "SELECT * from `user` where `Username`='$login' ");
    $get_row = mysqli_fetch_assoc($get_users);
    $get_id = $get_row['id'];
    $_SESSION['id'] = $get_id;
    $id = $_SESSION['id'];
    switch ($get_row) {
        case $get_row['Role'] == 1:
            $chucvu = 'khách hàng';
            $code = 1;
            break;
        case $get_row['Role'] == 2:
            $chucvu = 'nhân viên';
            $code = 2;
            break;
        case $get_row['Role'] == 3:
            $chucvu = 'admin';
            $code = 3;
            if (!isset($_SESSION['quanli'])) {
                header('location: /page/datatable.php');
                $_SESSION['quanli'] = true; // Đánh dấu rằng đã chuyển hướng
                exit;
            }
            break;
        default:
            die(" Connection failed: ");
            break;
    }
}
