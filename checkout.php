<?php
require_once('./sytem/header.php');
$id = isset($_GET['id']) ? $_GET['id'] : "";
$query = mysqli_query($conn, "SELECT * from `product` where `id`='$id'");
$row = mysqli_fetch_assoc($query);
$rowid = $row['id'];
// $queryProduct = mysqli_query($conn, "SELECT * from `product` where `id`='$rowid'");
// $rowProduct = mysqli_fetch_assoc($queryProduct);
$Price = $row['Price'];
$StockQuantity = isset($_GET['soluong']) ? $_GET['soluong'] : "";
$NumPrice = $StockQuantity * $Price;
if (!isset($_SESSION['User'])) {
    header("location:/login.php");
}
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
            <form action="">
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
                            <div><strong>PRODUCT</strong></div>
                            <div><strong>TOTAL</strong></div>
                        </div>
                        <div class="order-products">
                            <div class="order-col">
                                <div>
                                    <span id="StockQuantity"><?= $StockQuantity; ?></span>x <span id="ProductName">
                                        <?= $row['ProductName']; ?></span>
                                </div>
                                <div id="Price"><?= $Price; ?></div>
                            </div>

                        </div>
                        <div class="order-col">
                            <div>Shiping</div>
                            <div><strong>FREE</strong></div>
                        </div>
                        <div class="order-col">
                            <div><strong>TOTAL</strong></div>
                            <div><strong class="order-total" id="Pice"><?= $NumPrice; ?></strong>VND</div>
                        </div>
                    </div>
                    <div class="payment-method">

                        <div class="input-radio1">
                            <input type="radio" name="payment" id="payment-2">
                            <label for="payment-2">
                                <span></span>
                                Thanh toán thi nhận hàng
                            </label>

                        </div>
                        <div class="input-radio2">
                            <input type="radio" name="payment" id="payment-3">
                            <label for="payment-3">
                                <span></span>
                                Thanh toán online
                            </label>

                        </div>
                    </div>

                    <button class="primary-btn order-submit" id="muahang"></button>
                </div>
                <!-- /Order Details -->
        </div>
        </form>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->

<!-- NEWSLETTER -->

<!-- /NEWSLETTER -->

<script>
$(document).ready(function() {
    $('#muahang').prop('disabled', true);
    $('#muahang')['html']('vui lòng chọn hình thức thanh toán...');
    $('.input-radio2 input[type="radio"]').change(function() {
        $('#muahang').prop('disabled', !$(this).is(':checked'));
        $('#muahang')['html']('Mua ngay');
        $('#muahang').click(function(event) {
            event.preventDefault();
            var formData = {
                sotien: $('#Pice').html(),
                comment: $('#ProductName').html(),
                return_url: 'http://localhost/checkout.php?id=<?= $id; ?>&soluong=<?= $StockQuantity; ?>',
                shop: '8jq2l7sha3gu89nleoo02qsj7b2w8ofn',
            }

            async function createBill() {
                const response = await $.ajax({
                    type: 'POST',
                    url: "https://hoadon.qdevs.tech/api/user/create-bill",
                    headers: {
                        Authorization: "Bearer 2|aFDzou7YnXC2hipGUSSxn45QsNfcIUAkadU1K4V0",
                    },
                    data: formData,
                    dataType: "json",
                });

                if (response.status === 'success') {

                    const data = response.data
                    const idHoaDon = data.id_hoadon;
                    console.log('check id hóa don', idHoaDon)
                    window.location = response.link
                    await checkBill(idHoaDon);
                } else {
                    alert(response.status)
                }
            }

            async function checkBill(idHoaDon) {
                const response = await $.ajax({
                    type: 'POST',
                    url: "https://hoadon.qdevs.tech/api/check-bill",
                    data: {
                        id_hoadon: idHoaDon
                    },
                    dataType: "json",
                });
                if (response.status === 'success') {
                    await checkOut();
                } else if (response.status === 'error') {
                    alert(response.status);
                }
            }
            async function checkOut() {
                var formData = {
                    ProductID: $('#Product').val(),
                    name: $('#name').val(),
                    address: $('#address').val(),
                    phone: $('#phone').val(),
                    StockQuantity: $('#StockQuantity').html(),
                    ProductName: $('#ProductName').html(),
                    Price: $('#Price').html(),
                    state: 1
                }
                console.log('api kiem tra', formData)
                const response = await $.ajax({
                    type: 'POST',
                    url: "/api/user.php?action=checkOut",
                    data: formData,
                    dataType: "json",
                });
                if (response.status === 'success') {
                    alert(response.status)
                    $('#main').load('/register.php');
                } else if (response.status === 'error') {
                    alert(response.status)
                }
            }

            createBill();
        })
    })
    $('.input-radio1 input[type="radio"]').change(function() {
        $('#muahang').prop('disabled', !$(this).is(':checked'));
        $('#muahang')['html']('Mua ngay');
        $('#muahang').click(function(event) {
            event.preventDefault();
            console.log('sukien')
            var formData = {
                ProductID: $('#Product').val(),
                name: $('#name').val(),
                address: $('#address').val(),
                phone: $('#phone').val(),
                StockQuantity: $('#StockQuantity').html(),
                ProductName: $('#ProductName').html(),
                Price: $('#Price').html(),
                state: 0
            }
            console.log(formData)
            $.ajax({
                type: 'POST',
                url: "/api/user.php?action=checkOut",

                data: formData,
                dataType: "json",
                success: function(result) {
                    if (result.status == "200") {
                        alert(result.msg)
                        window.location.href = 'blank.php'
                    } else if (result.status == 404) {
                        alert(result.msg)
                    } else if (result.status == 500) {

                    }
                }
            })
        })
    })
})
</script>

<?php
require_once('./sytem/end.php');
?>