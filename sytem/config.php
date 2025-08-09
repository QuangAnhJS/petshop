<?php
ob_start();
session_start();

$servername = "localhost";
$username = "root";
$password = "12345";
$databaseName = "petshop";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $databaseName);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_SESSION['User']) && is_array($_SESSION['User']) && isset($_SESSION['User']['username'])) {
    $login = $_SESSION['User']['username'];

    $get_users = mysqli_query($conn, "SELECT * FROM `user` WHERE `Username` = '$login' ");
    $get_row = mysqli_fetch_assoc($get_users);

    if (!$get_row) {
        die("Không tìm thấy người dùng.");
    }

    // Cập nhật session là mảng chứa thông tin người dùng
    $_SESSION['User'] = [
        'id' => $get_row['id'],
        'username' => $get_row['Username'],
        'role' => $get_row['Role']
    ];

    $id = $_SESSION['User']['id'];

    switch ($get_row['Role']) {
        case 1:
            $chucvu = 'khách hàng';
            $code = 1;
            break;
        case 2:
            $chucvu = 'nhân viên';
            $code = 2;
            break;
        case 3:
            $chucvu = 'admin';
            $code = 3;
            if (!isset($_SESSION['quanli'])) {
                $_SESSION['quanli'] = true;
                header('location: /page/datatable.php');
                exit;
            }
            break;
        default:
            die("Phân quyền không hợp lệ.");
    }
}
