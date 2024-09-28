<?php
require_once("./sytem/header.php");
require_once("./sytem/config.php");
?>
<!-- /HEADER -->



<!-- SECTION -->

<!-- /SECTION -->

<div id="ok"></div>
<!-- SECTION -->
<div id="index">
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <!-- section title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">Sản phẩm</h3>

                    </div>
                </div>
                <!-- /section title -->

                <!-- Products tab & slick -->
                <div class="col-md-12">
                    <div class="row">
                        <div class="products-tabs">
                            <!-- tab -->
                            <div id="tab1" class="tab-pane active">
                                <div class="products-slick" data-nav="#slick-nav-1">
                                    <!-- product -->
                                    <?php
                                    $query = mysqli_query($conn, "SELECT * from `product` where `type`=1");
                                    while ($row = mysqli_fetch_assoc($query)) {

                                    ?>

                                        <div class="product">
                                            <div class="product-img" style="height: 256px;">
                                                <img src="<?= $row['img']; ?>" alt="">
                                                <div class="product-label">
                                                    <span class="sale">-30%</span>
                                                    <span class="new">NEW</span>
                                                </div>
                                            </div>
                                            <div class="product-body">
                                                <p class="product-category"><?= $row['Category']; ?></p>
                                                <h3 class="product-name"><a href="#"><?= $row['ProductName']; ?></a></h3>
                                                <h4 class="product-price"><?= $row['Price']; ?><del class="product-old-price">$990.00</del>
                                                </h4>
                                                <div class="product-rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <div class="product-btns">
                                                    <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
                                                    <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
                                                    <a class="quick-view" href="product.php?id=<?= $row['id']; ?>"><i class="fa fa-eye"></i><span class="tooltipp">quick
                                                            view</span></a>
                                                </div>
                                            </div>
                                            <div class="add-to-cart">
                                                <button class="add-to-cart-btn" data-id="<?= $row['id']; ?>"><i class="fa fa-shopping-cart"></i> add to
                                                    cart</button>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <!-- /product -->

                                    <!-- product -->


                                    <!-- product -->


                                    <!-- product -->


                                    <!-- product -->

                                </div>
                                <div id="slick-nav-1" class="products-slick-nav"></div>
                            </div>
                            <!-- /tab -->
                        </div>
                    </div>
                </div>
                <!-- Products tab & slick -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- HOT DEAL SECTION -->

    <!-- /HOT DEAL SECTION -->

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <!-- section title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">Phụ kiện</h3>

                    </div>
                </div>
                <!-- /section title -->

                <!-- Products tab & slick -->
                <div class="col-md-12">
                    <div class="row">
                        <div class="products-tabs">
                            <!-- tab -->
                            <div id="tab1" class="tab-pane active">
                                <div class="products-slick" data-nav="#slick-nav-1">
                                    <!-- product -->
                                    <?php
                                    $query = mysqli_query($conn, "SELECT * from `product` where `type`=2");
                                    while ($row = mysqli_fetch_assoc($query)) {

                                    ?>

                                        <div class="product">
                                            <div class="product-img" style="height: 256px;">
                                                <img src="<?= $row['img']; ?>" alt="">
                                                <div class="product-label">
                                                    <span class="sale">-30%</span>
                                                    <span class="new">NEW</span>
                                                </div>
                                            </div>
                                            <div class="product-body">
                                                <p class="product-category"><?= $row['Category']; ?></p>
                                                <h3 class="product-name"><a href="#"><?= $row['ProductName']; ?></a></h3>
                                                <h4 class="product-price"><?= $row['Price']; ?><del class="product-old-price">$990.00</del>
                                                </h4>
                                                <div class="product-rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <div class="product-btns">
                                                    <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
                                                    <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
                                                    <a class="quick-view" href="product.php?id=<?= $row['id']; ?>"><i class="fa fa-eye"></i><span class="tooltipp">quick
                                                            view</span></a>
                                                </div>
                                            </div>
                                            <div class="add-to-cart">
                                                <button class="add-to-cart-btn" data-id="<?= $row['id']; ?>"><i class="fa fa-shopping-cart"></i> add to
                                                    cart</button>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <!-- /product -->

                                    <!-- product -->


                                    <!-- product -->


                                    <!-- product -->


                                    <!-- product -->

                                </div>
                                <div id="slick-nav-1" class="products-slick-nav"></div>
                            </div>
                            <!-- /tab -->
                        </div>
                    </div>
                </div>
                <!-- /Products tab & slick -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- SECTION -->

    <!-- /SECTION -->

    <!-- NEWSLETTER -->
 
</div>
<script>
    $(document).ready(function() {
        $(".add-to-cart-btn").click(function(event) {
            event.preventDefault();
            var id = $(this).data("id");
            $.ajax({
                type: 'POST',
                url: "/api/user.php?action=addCart",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(result) {
                    if (result.status == 200) {
                        alert(result.msg);
                        location.reload();
                    } else if (result.status == 500) {
                        alert(result.msg);
                        window.location.href = "login.php";
                    } else if (result.status == 404) {
                        alert(result.msg);
                    }
                }
            });

        });
    })
</script>

<!-- /NEWSLETTER -->
<?php
require_once('./sytem/end.php');
?>