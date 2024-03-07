<?php
require_once '../sytem/config.php';
switch ($_GET['action']) {
    case 'createProduct':

        $json = [];
        $ProductName = mysqli_real_escape_string($conn, $_POST['ProductNme']);
        $category =  mysqli_real_escape_string($conn, $_POST['danhmuc']);
        $Price = mysqli_real_escape_string($conn, $_POST['Price']);
        $StockQuantity = mysqli_real_escape_string($conn, $_POST['StockQuantity']);
        // $IMG = mysqli_real_escape_string($conn, $_POST['IMG']);

        $Describe = mysqli_real_escape_string($conn, $_POST['Describe']);
        $Type = mysqli_real_escape_string($conn, $_POST['Type']);
        $target_dir = "../uploads/";


        if (empty($ProductName) || empty($category) || empty($Price) || empty($StockQuantity) || empty($Describe)  || empty($_FILES['IMG']['size']) || empty($Type)) {
            $json = ['status' => 404, 'msg' => 'vui lòng nhập đầy đủ thông tin'];
        } else {
            $target_file = $target_dir . basename($_FILES["IMG"]["name"]);

            if (move_uploaded_file($_FILES["IMG"]["tmp_name"], $target_file)) {
                $create = mysqli_query($conn, "INSERT INTO `product`( `ProductName`,`Category`, `Price`, `StockQuantity`, `img`, `Describe`,`type`) VALUES ('$ProductName',' $category','$Price','$StockQuantity','$target_file','$Describe','$Type')");
                if ($create) {
                    $json = ['status' => 200, 'msg' => 'chúc mừng! thành công'];
                } else {
                    $json = ['status' => 500, 'msg' => 'không thành công'];
                }
            }
        }
        echo json_encode($json);
        break;

    case 'delete':
        $json = [];
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        if (empty($id)) {
            $json = ['status' => 404, 'msg' => 'lỗi không lấy được id'];
        } else {
            $delete = mysqli_query($conn, "DELETE FROM `product` WHERE `id`='$id'");
            if ($delete) {
                $json = ['status' => 200, 'msg' => 'thành công'];
            }
        }
        echo json_encode($json);
        break;


    default:
        $json = ['status' => '500', 'msg' => 'không hợp lệ'];
        echo json_encode($json);
        break;
}
