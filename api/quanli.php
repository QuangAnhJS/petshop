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

        if (0 < $Type || $Type < 4) {
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
        } else {
            $json = ['status' => 500, 'msg' => 'vui lòng chọn lại thể loại'];
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
    case 'editProduct':
        $json = [];
        $ProductNme = mysqli_real_escape_string($conn, $_POST['ProductNme']);
        $Price = mysqli_real_escape_string($conn, $_POST['Price']);
        $StockQuantity = mysqli_real_escape_string($conn, $_POST['StockQuantity']);
        $Describe = mysqli_real_escape_string($conn, $_POST['Describe']);
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename(isset($_FILES["IMG"]["name"]));
        $Type = mysqli_real_escape_string($conn, $_POST['Type']);
        $danhmuc = mysqli_real_escape_string($conn, $_POST['danhmuc']);
        $id = mysqli_real_escape_string($conn, $_POST['id']);

        if (empty($_FILES["IMG"]["name"])) {
            // Có file được tải lên
            // Lưu file vào thư mục đích
            if ($Type > 0 && $Type < 4) {
                $update = mysqli_query($conn, "UPDATE `product` SET `ProductName`='$ProductNme',`Price`='$Price',`StockQuantity`='$StockQuantity',`Describe`='$Describe',`Category`='$danhmuc',`Type`='$Type' WHERE id= '$id'");
                if ($update) {
                    $json = ['status' => '200', 'msg' => 'Thành công'];
                } else {
                    $json = ['status' => '500', 'msg' => 'không hợp lệ'];
                }
            } else {
                $json = ['status' => '500', 'msg' => 'vui lòng chọn lại thể loại'];
            }
        } else {
            // Có lỗi xảy ra khi tải file
            // Hiển thị thông báo lỗi cho người dùng

            if ($Type > 0 && $Type < 4) {
                if (move_uploaded_file($_FILES["IMG"]["tmp_name"], $target_file)) {
                    $update = mysqli_query($conn, "UPDATE `product` SET `ProductName`='$ProductNme',`Price`='$Price',`StockQuantity`='$StockQuantity'`Describe`='$Describe',`Category`='$danhmuc',`Type`='$Type' WHERE id= '$id'");
                    if ($update) {
                        $json = ['status' => '200', 'msg' => 'Thành công'];
                    } else {
                        $json = ['status' => '500', 'msg' => 'không hợp lệ'];
                    }
                }
            } else {
                $json = ['status' => '500', 'msg' => 'vui lòng chọn lại thể loại'];
            }
        }
    case 'OrderConfirmation':
        $json = [];
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        if ($id) {
            $OrderConfirmation = mysqli_query($conn, "UPDATE `order` SET `status`='2' WHERE `id`='$id'");
            if ($OrderConfirmation) {
                $json = ['status' => '200', 'msg' => 'Xác nhận'];
            } else {
                $json = ['status' => '500', 'msg' => 'Lỗi không xác nhận được'];
            }
        } else {
            $json = ['status' => '500', 'msg' => 'lỗi '];
        }

        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        break;
    case 'CancelOrder':
        $json = [];
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        if ($id) {
            $OrderConfirmation = mysqli_query($conn, "UPDATE `order` SET `status`='3' WHERE `id`='$id'");
            if ($OrderConfirmation) {
                $json = ['status' => '200', 'msg' => 'Hủy đơn hàng thành Công'];
            } else {
                $json = ['status' => '500', 'msg' => 'Lỗi không hủy được'];
            }
        } else {
            $json = ['status' => '500', 'msg' => 'lỗi '];
        }

        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        break;
    default:
        $json = ['status' => '500', 'msg' => 'không hợp lệ'];
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        break;
}
