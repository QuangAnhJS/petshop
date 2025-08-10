<?php
require_once('./sytem/header.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /');
    exit;
}

if (!isset($_SESSION['User'])) {
    die("Bạn chưa đăng nhập.");
}

if (!isset($_POST['total']) || !isset($_POST['payment'])) {
    die("Thiếu dữ liệu đặt hàng.");
}

$user_id = $_SESSION['User']['id'];
$total_amount = $_POST['total'] ?? 0;
$payment_method = $_POST['payment'] ?? 'cod';
$product_ids = $_POST['product_id'] ?? [];
$quantities = $_POST['quantity'] ?? [];

// Gán trạng thái đơn hàng
$status = ($payment_method === 'cod') ? 'cod' : 'pending';
$check = $conn->query("SELECT id FROM tb_orders 
    WHERE user_id = '$user_id' 
    AND status = 'pending' 
    AND created_at > (NOW() - INTERVAL 5 MINUTE)");

if ($check->num_rows > 0) {
    die("Bạn đang có đơn hàng chưa thanh toán. Vui lòng hoàn tất trước khi tạo đơn mới.");
}
$sql = "INSERT INTO tb_orders (user_id, total, payment_method, payment_status)
        VALUES ('$user_id', '$total_amount', '$payment_method', '$status')";

if ($conn->query($sql) === TRUE) {
    $order_id = $conn->insert_id;

    for ($i = 0; $i < count($product_ids); $i++) {
        $productId = (int)$product_ids[$i];
        $quantity = (int)$quantities[$i];

        mysqli_query($conn, "UPDATE product SET StockQuantity = StockQuantity - $quantity WHERE id = $productId");
        mysqli_query($conn, "INSERT INTO orderdetail (order_id, product_id, quantity)
                             VALUES ('$order_id', '$productId', '$quantity')");
    }

    mysqli_query($conn, "DELETE FROM cart WHERE UserID = '$user_id'");

    if ($payment_method === 'online') {
        $result = $conn->query("SELECT * FROM tb_orders WHERE id = $order_id");
        $order_details = $result->fetch_object();

        $formatted_amount = number_format($order_details->total_amount, 0, ',', '.');
        $order_code = "DH" . $order_id;
        $order_note = "DH" . $order_details->id;
        $amount = $order_details->total_amount;

        echo <<<HTML
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <div class="card shadow p-4">
            <h3 class="text-center text-success">🎉 Đặt hàng thành công!</h3>
            <p class="text-center">Mã đơn hàng: <strong>#{$order_code}</strong></p>
            <hr>
            <div class="row">
                <div class="col-md-6 text-center">
                    <h5>🔍 Quét mã QR bằng App ngân hàng</h5>
                    <img 
                        src="https://qr.sepay.vn/img?acc=0866598542&bank=VPBank&amount={$amount}&des={$order_code}"
                        class="img-fluid" 
                        style="max-width:300px"
                        alt="QR thanh toán"
                    >
                    <p class="mt-2 text-muted">
                        Trạng thái: <span id="pay_status_text">⏳ Chờ thanh toán...</span>
                    </p>
                </div>
                <div class="col-md-6">
                    <h5>🏦 Thông tin chuyển khoản</h5>
                    <table class="table">
                        <tr><td>Ngân hàng:</td><td><strong>VPBank</strong></td></tr>
                        <tr><td>Chủ tài khoản:</td><td><strong>Tạ Quang Anh</strong></td></tr>
                        <tr><td>Số tài khoản:</td><td><strong>0866598542</strong></td></tr>
                        <tr><td>Số tiền:</td><td><strong>{$formatted_amount} vnđ</strong></td>
                        <tr><td>Nội dung CK:</td><td><strong>{$order_note}</strong></td></tr>
                    </table>
                    <div class="alert alert-warning small">
                        ⚠️ <strong>Lưu ý:</strong> Ghi đúng nội dung chuyển khoản để hệ thống tự động xác nhận.
                    </div>
                </div>
            </div>
            <div class="text-center mt-4" id="success_box" style="display:none">
                <div class="alert alert-success">
                    ✅ Thanh toán thành công! Đơn hàng sẽ được xử lý sớm nhất.
                </div>
                <a href="/" class="btn btn-success">Quay về trang chủ</a>
            </div>
        </div>
    </div>

    <!-- Script kiểm tra trạng thái thanh toán -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var pay_status = 'Unpaid';
        function check_payment_status() {
            if (pay_status === 'Unpaid') {
                $.ajax({
                    type: "POST",
                    url: "api/user.php?action=check_payment_status",
                    data: { order_id: {$order_id} },
                    dataType: "json",
                    success: function(res) {
                        if (res.payment_status === "Paid") {
                            $("#pay_status_text").html("✅ Đã thanh toán");
                            $("#success_box").show();
                            pay_status = 'Paid';
                        }
                    }
                });
            }
        }
        setInterval(check_payment_status, 2000);
    </script>
</body>
</html>
HTML;
        exit;
    }
} else {
    echo "❌ Lỗi khi thêm đơn hàng: " . $conn->error;
}
