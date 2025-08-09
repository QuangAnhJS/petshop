<?php
require_once('./sytem/header.php');
if (!isset($_SESSION['User'])) {
    header("location:/login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (!empty($_POST['items']) || !empty($_POST['ProductName'])) {
    $orderItems = [];

    foreach ($_POST['items'] as $cartId) {
        $orderItems[] = [
            'productName' => $_POST['ProductName'][$cartId] ?? 'Không rõ',
            'quantity' => $_POST['qty'][$cartId] ?? 1,
            'price' => $_POST['Price'][$cartId] ?? 0,
            'totalPrice' => $_POST['totalPrice'][$cartId] ?? 0,
            'productId' => $_POST['ProductId'][$cartId] ?? 0
        ];
    }
} else {
    echo "Bạn chưa chọn sản phẩm nào!";
    require_once('./sytem/end.php');
    exit;
}
if (isset($_GET["id"]) && is_numeric($_GET["id"]))
    $order_id = $_GET["id"];
else
    $order_id = '';
}else {
    header("location: /");
    exit;
}
// Nếu method là POST thì tạo đơn hàng


?>
<!-- /HEADER -->

<!-- NAVIGATION -->

<!-- /NAVIGATION -->

<!-- BREADCRUMB -->

<!-- /BREADCRUMB -->

<!-- SECTION -->
<div class="section" id="main">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">

            <form method="POST" action="handleCheckOut.php">
                <div class="col-md-7">
                    <!-- Billing Details -->
                    <div class="billing-details">
                        <div class="section-title">
                            <h3 class="title">Thông tin nhận hàng</h3>
                            <input type="text" id="Product" value="<?= $rowid; ?>" hidden>
                        </div>
                        <div class="form-group">
                            <input class="input" type="text" name="first-name" placeholder="Họ tên" id="name">
                        </div>


                        <div class="form-group">
                            <input class="input" type="text" name="address" placeholder="dia chỉ" id="address">
                            <p>Lưu ý ghi chính xác địa chỉ </p>
                        </div>


                        <div class="form-group">
                            <input class="input" type="tel" name="tel" placeholder="Telephone" id="phone">
                        </div>
                        <div class="form-group">
                            <div class="input-checkbox">
                                <input type="checkbox" id="create-account">
                                <label for="create-account">

                                </label>

                            </div>
                        </div>
                    </div>
                    <!-- /Billing Details -->

                    <!-- Shiping Details -->

                    <!-- /Order notes -->
                </div>

                <!-- Order Details -->
                <div class="col-md-5 order-details">
                    <div class="section-title text-center">
                        <h3 class="title">Your Order</h3>
                    </div>
                    <div class="order-summary">
                        <div class="order-col">
                            <div><strong>Sản phẩm</strong></div>
                            <div><strong>tổng</strong></div>
                        </div>
                        <div class="order-products">
                            <?php foreach ($orderItems as $item): ?>
                                <div class="order-col">
                                    <div><?= htmlspecialchars($item['productName']) ?></div>
                                    <input type="hidden" name="product_id[]" value="<?= (int)$item['productId'] ?>">
                                    <input type="text" name="quantity[]" value="<?= (int)$item['quantity'] ?>" hidden>
                                    <div><strong><?= (int)$item['quantity'] ?> </strong></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php
                        $totalAmount = array_sum(array_column($orderItems, 'totalPrice'));
                        ?>
                        <div class="order-col">
                            <div><strong>Số tiền</strong></div>
                            <input type="text" name="total" value="<?= $totalAmount ?>" hidden>
                            <div><strong class="order-total"><?= number_format($totalAmount) ?></strong> VND</div>
                        </div>
                        <div class="payment-method">

                            <div class="input-radio1">
                                <input type="radio" name="payment" id="payment-2" value="cod" required>
                                <label for="payment-2">Thanh toán khi nhận hàng</label>



                            </div>
                            <div class="input-radio2">
                                <input type="radio" name="payment" id="payment-3" value="online">
                                <label for="payment-3">Thanh toán online</label>
                            </div>
                        </div>

                        <button class="primary-btn order-submit" id="muahang" type="submit">Đặt hàng </button>
                    </div>
                    <!-- /Order Details -->
                </div>

            </form>




        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>


    <?php
    // Nếu đang ở giao diện checkout
    if (isset($order_id)) { ?>
        <script>
            var pay_status = 'Unpaid';

            // Hàm kiểm tra trạng thái đơn hàng
            // Sử dụng Ajax để lấy trạng thái đơn hàng. Nếu thanh toán thành công thì hiển thị Box đã thanh toán thành công, ẩn box checkout
            function check_payment_status() {
                if (pay_status == 'Unpaid') {
                    $.ajax({
                        type: "POST",
                        data: {
                            order_id: <?= $order_id; ?>
                        },
                        url: "https://payment-gateway-demo.sepay.dev/check_payment_status.php",
                        dataType: "json",
                        success: function(data) {
                            if (data.payment_status == "Paid") {
                                $("#checkout_box").hide();
                                $("#success_pay_box").show();
                                pay_status = 'Paid';
                            }
                        }
                    });
                }
            }
            //Kiểm tra trạng thái đơn hàng 1 giây một lần
            setInterval(check_payment_status, 1000);
        </script>
    <?php } ?>
    <!-- /row -->
</div>
<!-- /container -->
</div>
<!-- /SECTION -->

<!-- NEWSLETTER -->

<!-- /NEWSLETTER -->



<?php
require_once('./sytem/end.php');
?>