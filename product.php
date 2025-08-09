<?php
require_once('./sytem/header.php');
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Kiểm tra ID
if ($id <= 0) {
    echo "<div style='padding:20px;color:red;'> Không có sản phẩm</div>";
    require_once('./sytem/end.php');
    exit; // Dừng xử lý tiếp
}

$query = mysqli_query($conn, "SELECT * FROM `product` WHERE  `id`='$id'");
$row = mysqli_fetch_assoc($query);

// Kiểm tra không tìm thấy sản phẩm
if (!$row) {
    echo "<div style='padding:20px;color:red;'>Không tìm thấy sản phẩm có ID = $id</div>";
    require_once('./sytem/end.php');
    exit;
}
?>



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
                    <h2 class="product-name"><?= isset($row['ProductName']) ? $row['ProductName'] : null; ?></h2>
                    <!-- <div>
                        <div class="product-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                        </div>
                        <a class="review-link" href="#">10 Review(s) | Add your review</a>
                    </div> -->
                    <div>
                        <h3 class="product-price"><?= isset($row['Price']) ? $row['Price'] : null; ?>
                        </h3>
                        <span class="product-available">In Stock</span>
                    </div>
                    <p><?= isset($row['Category']) ? $row['Category'] : null; ?></p>



                    <div class="add-to-cart">
                        <p> Số lượng sản phẩm còn lại <Span><?= isset($row['StockQuantity']) ? $row['StockQuantity'] : null; ?></Span></p>

                        <div class="qty-label">
                            Qty

                            <div class="input-number">
                                <input type="number" style="outline: none;" id="my-input" value="1" min="1" max="<?= $stockQuantity ?>">
                                <span class="qty-up">+</span>
                                <span class="qty-down">-</span>
                            </div>
                        </div>

                        <button type="button"
                            class="add-to-cart-btn1"
                            data-id="<?= $_GET['id'] ?>"
                            style="padding: 12px 20px;">
                            <i class="fa fa-shopping-cart"></i> Mua hàng
                        </button>
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
<script>
    const stockQuantity = <?= isset($row['StockQuantity']) ? $row['StockQuantity'] : 0 ?>;
</script>

<!-- <script>
    $(document).ready(function() {
        $('.add-to-cart-btn').on('click', function(e) {
            const quantity = $('#my-input').val();
            if (quantity <= 0) {
                alert("Vui lòng nhập số lượng hợp lệ");
                e.preventDefault();
            } else if (quantity > <?= $row['StockQuantity']; ?>) {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Số lượng không hợp lệ",
                    timer: 1500
                });
                $('#my-input').val('');
                e.preventDefault();
            } else {
                $(this).attr('href', `checkout.php?id=<?= $id; ?>&soluong=${quantity}`);
            }
        });
    });
</script> -->

<?php require_once('./sytem/end.php'); ?>