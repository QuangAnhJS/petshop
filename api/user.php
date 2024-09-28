<?php
require_once("../sytem/config.php");
switch ($_GET['action']) {
    case 'login':
        $json = [];
        $userName = mysqli_real_escape_string($conn, $_POST['userName']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        if (empty(($userName) && ($password))) {
            $json = ['status' => '404', 'msg' => 'vui lòng nhập userName và password'];
        } else {
            $hashpassword = md5($password);
            $user = mysqli_query($conn, "SELECT * from`user` where `UserName`='$userName' and `password`='$hashpassword'");
            if (mysqli_num_rows($user) == 1) {
                $_SESSION['User'] = $userName;
                $json = ['status' => '200', 'msg' => 'thành công'];
            } else {
                $json = ['status' => '500', 'msg' => 'vui lòng kiểm tra lại UserName và password'];
            }
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        break;
    case 'register':
        $json = [];
        $id =  mysqli_real_escape_string($conn, $_POST['id']);
        $name =  mysqli_real_escape_string($conn, $_POST['name']);
        $sdt =  mysqli_real_escape_string($conn, $_POST['sdt']);
        $taikhoan =  mysqli_real_escape_string($conn, $_POST['taikhoan']);
        $pass =  mysqli_real_escape_string($conn, $_POST['pass']);
        $test =  mysqli_real_escape_string($conn, $_POST['test']);
        if (empty(($id) && ($name) && ($sdt) && ($taikhoan) && ($pass) && ($test))) {
            $json = ['status' => '404', 'msg' => 'vui lòng điền đầy đủ thông tin'];
        } else {
            if ($pass !== $test) {
                $json = ['status' => '500', 'msg' => 'nhập lại mật khẩu không đúng'];
            } else {
                $hashpassword = md5($pass);
                $createUser = mysqli_query($conn, "INSERT INTO `user`( `Username`, `Password`, `Role`) VALUES ('$taikhoan','$hashpassword','$id')");
                if ($createUser) {

                    $client = mysqli_query($conn, "INSERT INTO `client`( `name`, `sdt`) VALUES ('$name','$sdt')");
                    if ($client) {
                        $Cart = mysqli_insert_id($conn);

                        $createCart = mysqli_query($conn, "INSERT INTO `cart`( `UserID`) VALUES ('$Cart') ");
                        if ($createCart) {
                            $json = ['status' => '200', 'msg' => 'Tạo thành công'];
                        } else {
                            $json = ['status' => '500', 'msg' => 'Thất bại'];
                        }
                    }
                }
            }
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        break;
    case 'addCart':
        $json = [];
        $id =  mysqli_real_escape_string($conn, $_POST['id']);
        if (isset($_SESSION['User'])) {
            if (empty($id)) {
                $json = ['status' => '404', 'msg' => 'không chọn được sản phẩm'];
            } else {
                $user = $_SESSION['User'];
                $query = mysqli_query($conn, "SELECT `id` FROM `user` WHERE `Username`='$user' ");
                if ($query) {
                    $row = mysqli_fetch_assoc($query);
                    $rowid = $row['id'];

                    $checkProduct = mysqli_query($conn, "SELECT * FROM `cart` WHERE `id`='$id' and `UserID`='$rowid'");
                    if (mysqli_num_rows($checkProduct) > 0) {
                        $json = ['status' => 200, 'msg' => 'đã có sản phẩm này trong giỏ hàng'];
                    } else {
                        $addCart = mysqli_query($conn, "INSERT INTO `cart`(`id`,`UserID`) VALUES ('$id','$rowid')");
                        $json = ['status' => 200, 'msg' => 'thêm vào giỏ hàng thành công'];
                    }
                } else {
                    $json = ['status' => '500', 'msg' => 'lỗi không thành công'];
                }
            }
        } else {
            $json = ['status' => '500', 'msg' => 'vui lòng đăng nhập để đặt hàng'];
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        break;
    case 'GetCart':
        $json = [];
        if (isset($_SESSION['User'])) {
            $user = $_SESSION['User'];
            $query = mysqli_query($conn, "SELECT `id` FROM `user` WHERE `Username`='$user' ");
            if ($query) {
                $row = mysqli_fetch_assoc($query);
                $rowid = $row['id'];
                $queryCart = mysqli_query($conn, "SELECT * FROM `cart` WHERE `UserID`='$rowid'");
                if ($queryCart) {
                    $cartData = [];
                    while ($arr = mysqli_fetch_assoc($queryCart)) {
                        $productCart = $arr['id'];
                        $queryProduct = mysqli_query($conn, "SELECT id, ProductName, Price, img FROM `product` WHERE `id` = '$productCart'");
                        if ($queryProduct) {
                            while ($rowCart = mysqli_fetch_assoc($queryProduct)) {
                                $cartData[] = $rowCart;
                            }
                        } else {
                            $json = ['status' => '404', 'msg' => 'không có sản phẩm'];
                            break;
                        }
                    }
                    if (!empty($cartData)) {
                        $json = ['status' => '200', 'msg' => $cartData];
                    } else {
                        $json = ['status' => '404', 'msg' => 'không có sản phẩm'];
                    }
                }
            }
        } else {
            $json = ['status' => '500', 'msg' => 'vui lòng đăng nhập để xem giỏ hàng'];
        }

        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        break;
    case 'DeleteCart':
        $json = [];
        $ProductID = mysqli_real_escape_string($conn, $_POST['id']);
        if (!isset($_SESSION['User'])) {
            $json = ['status' => '200', 'msg' => 'vui lòng đăng nhập'];
        } else {
            if (empty($ProductID)) {
                $json = ['status' => '404', 'msg' => 'lỗi không tìm thấy sản phẩm'];
            } else {
                $delete = mysqli_query($conn, "DELETE FROM `cart` WHERE `id`='$ProductID'");
                $json = ['status' => '200', 'msg' => 'xóa thành công'];
            }
        }

        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        break;
    case 'checkOut':
        $json = [];
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $ProductName = mysqli_real_escape_string($conn, $_POST['ProductName']);
        $StockQuantity = mysqli_real_escape_string($conn, $_POST['StockQuantity']);
        $id = mysqli_real_escape_string($conn, $_POST['ProductID']);
        $Price = mysqli_real_escape_string($conn, $_POST['Price']);
        $state = mysqli_real_escape_string($conn, $_POST['state']);
        if (isset($_SESSION['User'])) {
            $user = $_SESSION['User'];
            $query = mysqli_query($conn, "SELECT `id` FROM `user` WHERE `Username`='$user' ");
            if ($query) {
                $row = mysqli_fetch_assoc($query);
                $rowid = $row['id'];
                if (empty($name) || empty($address) || empty($phone)) {
                    $json = ['status' => 404, 'msg' => 'vui lòng nhập đầy đủ thông tin giao hàng'];
                } elseif (empty($id) || empty($ProductName) || empty($StockQuantity) || empty($Price)) {
                    $json = ['status' => 500, 'msg' => 'lỗi bất định'];
                } else {
                    $creteOder = mysqli_query($conn, "INSERT INTO `order`(`Price`, `ProductId`, `UserID`,`state`,`status`) VALUES ('$Price','$id','$rowid','$state',1)");
                    $id = mysqli_insert_id($conn);
                    if ($creteOder) {
                        $createOderdetali = mysqli_query($conn, "INSERT INTO `orderdetail`(`OrderID`, `StockQuantity`, `name`, `sdt`, `diachi`, `ProductName`) VALUES ('$id','$StockQuantity','$name','$phone','$address','$ProductName')");
                        $json = ['status' => 200, 'msg' => 'thành công'];
                    } else {
                        $json = ['status' => 500, 'msg' => 'lỗi'];
                    }
                }
            } else {
                $json = ['status' => 404, 'msg' => 'không tồn tại '];
            }
        } else {
            $json = ['status' => 500, 'msg' => 'vui lòng đăng nhập'];
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        break;
    case 'SearchProduct':
        $json = [];
        $data = mysqli_real_escape_string($conn, $_GET['data']);
        $query = mysqli_query($conn, "SELECT * FROM product WHERE ProductName LIKE '%$data%' ");
        if ($query) {
            $results = [];
            while ($row = mysqli_fetch_assoc($query)) {
                $results[] = $row;
            }
            $json = ['status' => 200, 'msg' => $results];
        } else {
            $json = ['status' => 500, 'msg' => 'Lỗi trong quá trình tìm kiếm'];
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        break;
}
