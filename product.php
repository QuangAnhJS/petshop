<?php
require_once('./sytem/header.php');
$id = isset($_GET['id']) ? $_GET['id'] : '';
$query = mysqli_query($conn, "SELECT * FROM `product` WHERE  `id`='$id'");
$row = mysqli_fetch_assoc($query);
?>

<!-- /HEADER -->

<!-- NAVIGATION -->

<!-- /NAVIGATION -->

<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb-tree">
                    <li><a href="#">Home</a></li>

                    <li class="active">Product name goes here</li>
                </ul>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /BREADCRUMB -->

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->

        <div class="row">

            <!-- Product main img -->
            <div class="col-md-5 col-md-push-2">
                <div id="product-main-img">
                    <div class="product-preview">
                        <img src="<?= $row['img']; ?>" alt="">
                    </div>


                </div>
            </div>
            <!-- /Product main img -->

            <!-- Product thumb imgs -->
            <div class="col-md-2  col-md-pull-5">
                <div id="product-imgs">
                    <div class="product-preview">
                        <img src="<?= $row['img']; ?>" alt="">
                    </div>


                </div>
            </div>
            <!-- /Product thumb imgs -->

            <!-- Product details -->
            <div class="col-md-5">
                <div class="product-details">
                    <h2 class="product-name"><?=isset($row['ProductName'])? $row['ProductName']:null; ?></h2>
                    <div>
                        <div class="product-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                        </div>
                        <a class="review-link" href="#">10 Review(s) | Add your review</a>
                    </div>
                    <div>
                        <h3 class="product-price"><?=isset( $row['Price'])? $row['Price']:null; ?><del class="product-old-price">$990.00</del>
                        </h3>
                        <span class="product-available">In Stock</span>
                    </div>
                    <p><?=isset( $row['Category'])? $row['Category']:null; ?></p>



                    <div class="add-to-cart">
                        <p> Số lượng sản phẩm còn lại <Span><?=isset( $row['StockQuantity'])? $row['StockQuantity']:null; ?></Span></p>

                        <div class="qty-label">
                            Qty

                            <div class="input-number">
                                <input type="number" id="my-input" value="1">
                                <span class="qty-up">+</span>
                                <span class="qty-down">-</span>
                            </div>
                        </div>

                        <a class="add-to-cart-btn" style="padding: 12px 20px;"><i class="fa fa-shopping-cart"></i>Mua
                            hàng</a>
                    </div>



                </div>
            </div>
            <!-- /Product details -->

            <!-- Product tab -->

            <!-- /product tab -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->

<!-- Section -->

<!-- /Section -->


<!-- /NEWSLETTER -->
<script>
    $(document).ready(function() {
        $('.add-to-cart-btn').on('click', function(e) {
            const quantity = $('#my-input').val(); // Lấy giá trị từ input
            if (quantity <= 0) {
                alert("Vui lòng nhập số lượng hợp lệ");
                e.preventDefault(); // Ngăn không cho chuyển trang nếu số lượng không hợp lệ
            } else if (quantity > <?= $row['StockQuantity']; ?>) {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Số lượng không hợp lệ",
                    timer: 1500
                });
                $('#my-input').val(''); // Xóa giá trị không hợp lệ
                e.preventDefault(); // Ngăn hành động chuyển trang
            } else {
                $(this).attr('href', `checkout.php?id=${<?= $id; ?>}&soluong=${quantity}`); // Cập nhật href
            }
        });
    });
</script>
<!-- FOOTER -->
<?php
require_once('./sytem/end.php');
?>