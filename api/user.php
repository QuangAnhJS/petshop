<?php
require_once("../sytem/config.php");
header('Content-Type: application/json; charset=utf-8');
switch ($_GET['action']) {
    case 'login':
        $json = [];

        // Bắt lỗi PHP
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $userName = mysqli_real_escape_string($conn, $_POST['userName']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        if (empty($userName) || empty($password)) {
            $json = ['status' => '404', 'msg' => 'vui lòng nhập userName và password'];
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            exit;
        }

        $hashpassword = md5($password);

        $user = mysqli_query($conn, "SELECT * FROM `user` WHERE `UserName`='$userName' AND `password`='$hashpassword'");

        if (!$user) {
            // Nếu truy vấn lỗi
            $json = ['status' => '500', 'msg' => 'Lỗi truy vấn SQL', 'debug' => mysqli_error($conn)];
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            exit;
        }

        if (mysqli_num_rows($user) == 1) {
            $userData = mysqli_fetch_assoc($user);

            $_SESSION['User'] = [
                'id' => $userData['id'],
                'username' => $userData['Username'],
                'role' => $userData['Role']
            ];

            $json = ['status' => '200', 'msg' => 'Thành công', 'debug' => 'login_ok'];
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            exit;
        } else {
            $json = ['status' => '500', 'msg' => 'Sai username hoặc password'];
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            exit;
        }
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
        $productId = isset($_POST['id']) ? intval($_POST['id']) : 0;

        if (!isset($_SESSION['User']) || !is_array($_SESSION['User']) || !isset($_SESSION['User']['username'])) {
            $json = ['status' => 401, 'msg' => 'Vui lòng đăng nhập để thêm vào giỏ hàng (session không hợp lệ)'];
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            break;
        }


        if ($productId <= 0) {
            $json = ['status' => 404, 'msg' => 'Không chọn được sản phẩm'];
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            break;
        }
        $user = $_SESSION['User']['username'];

        $query = mysqli_query($conn, "SELECT `id` FROM `user` WHERE `Username` = '$user' LIMIT 1");

        if (!$query || mysqli_num_rows($query) == 0) {
            $json = ['status' => 500, 'msg' => 'Không tìm thấy người dùng'];
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            break;
        }

        $userId = mysqli_fetch_assoc($query)['id'];

        // Lấy tồn kho sản phẩm
        $queryProduct = mysqli_query($conn, "SELECT StockQuantity FROM product WHERE id = '$productId'");
        if (!$queryProduct) {
            $json = ['status' => 500, 'msg' => 'Lỗi truy vấn tồn kho'];
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            break;
        }

        $rowQuantity = mysqli_fetch_assoc($queryProduct);
        $stock = intval($rowQuantity['StockQuantity']);

        $checkProduct = mysqli_query($conn, "SELECT Quantity FROM cart WHERE ProductID = '$productId' AND UserID = '$userId'");
        $hasProduct = mysqli_num_rows($checkProduct) > 0;
        $currentQuantity = 0;

        if ($hasProduct) {
            $rowCart = mysqli_fetch_assoc($checkProduct);
            $currentQuantity = intval($rowCart['Quantity']);
        }

        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
        if ($quantity <= 0) $quantity = 1;

        $totalQuantity = $currentQuantity + $quantity;

        if ($totalQuantity > $stock) {
            $json = ['status' => 404, 'msg' => 'Số lượng vượt quá số lượng còn lại trong kho'];
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            break;
        }

        if ($hasProduct) {
            mysqli_query($conn, "UPDATE cart SET Quantity = $totalQuantity WHERE ProductID = '$productId' AND UserID = '$userId'");
            $json = ['status' => 200, 'msg' => 'Đã cập nhật số lượng sản phẩm trong giỏ hàng'];
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            break;
        } else {
            $insertResult = mysqli_query($conn, "INSERT INTO cart (UserID, ProductID, Quantity) VALUES ('$userId', '$productId', $quantity)");
            if ($insertResult) {
                $json = ['status' => 200, 'msg' => 'Thêm vào giỏ hàng thành công'];
                echo json_encode($json, JSON_UNESCAPED_UNICODE);
            } else {
                $json = ['status' => 500, 'msg' => 'Lỗi khi thêm sản phẩm vào giỏ hàng'];
            }
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            break;
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        break;

    case 'GetCart':
        $json = [];

        if (!isset($_SESSION['User'])) {
            $json = ['status' => 500, 'msg' => 'Vui lòng đăng nhập để xem giỏ hàng'];
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            break;
        }

        $user = $_SESSION['User']['username'];
        $query = mysqli_query($conn, "SELECT `id` FROM `user` WHERE `Username`='$user' LIMIT 1");

        if (!$query || mysqli_num_rows($query) == 0) {
            $json = ['status' => 500, 'msg' => 'Người dùng không tồn tại'];
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            break;
        }

        $userId = mysqli_fetch_assoc($query)['id'];

        $queryCart = mysqli_query($conn, "SELECT * FROM `cart` WHERE `UserID` = '$userId'");
        $cartData = [];

        while ($cartItem = mysqli_fetch_assoc($queryCart)) {
            $productId = $cartItem['ProductID'];
            $quantity = $cartItem['Quantity'];
            $cartId = $cartItem['id'];
            $queryProduct = mysqli_query($conn, "SELECT id, ProductName, Price, img FROM `product` WHERE `id` = '$productId'");

            if ($queryProduct && mysqli_num_rows($queryProduct) > 0) {
                $product = mysqli_fetch_assoc($queryProduct);
                $product['Quantity'] = $quantity; // thêm số lượng trong giỏ
                $product['CartID'] = $cartId; // thêm ID giỏ hàng
                $cartData[] = $product;
            }
        }

        if (!empty($cartData)) {
            $json = ['status' => 200, 'msg' => $cartData];
        } else {
            $json = ['status' => 404, 'msg' => 'Giỏ hàng trống'];
            break;
            // echo json_encode($json, JSON_UNESCAPED_UNICODE);
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
                if (!$delete) {
                    $json = ['status' => '500', 'msg' => 'lỗi không xóa được sản phẩm'];
                } else {
                    $json = ['status' => '200', 'msg' => 'xóa thành công'];
                }
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
    case 'check_payment_status':
        $json = [];
 
        if (!isset($_POST['order_id'])) {
            echo json_encode(['payment_status' => 'MissingOrderId']);
            exit;
        }

        $order_id = intval($_POST['order_id']);

        // 3. Truy vấn DB để lấy trạng thái đơn hàng
        $sql = "SELECT status FROM tb_orders WHERE id = $order_id LIMIT 1";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($row['status'] === 'paid') {
                echo json_encode(['payment_status' => 'Paid']);
            } else {
                echo json_encode(['payment_status' => 'Unpaid']);
            }
        } else {
            echo json_encode(['payment_status' => 'NotFound']);
        }
}
