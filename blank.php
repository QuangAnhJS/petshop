<?php
require_once('./sytem/header.php');
$user = $_SESSION['User']["username"];

if (!isset($_SESSION['User'])) {
	header('location: /login.php');
}
$query = mysqli_query($conn, "SELECT `id` FROM `user` WHERE `Username`='$user'");
$rowQuery = mysqli_fetch_assoc($query);
$rowID = $rowQuery['id'];
$queryOrder = mysqli_query($conn, "SELECT * FROM `order` WHERE `UserID`='$rowID'");
while ($rowOrder = mysqli_fetch_assoc($queryOrder)) {
	$rowProductID = $rowOrder['ProductId'];
	$statusOrder = $rowOrder['status'];
	$queryProduct = mysqli_query($conn, "SELECT * FROM `product` WHERE `id`='$rowProductID'");
	$rowProduct = mysqli_fetch_assoc($queryProduct);
	$rowID = $rowOrder['id'];
	if ($statusOrder == 1) {
		$status = 'đơn hàng đang xác nhận';
		$ok = '<button type="button" class="CancelOrder" data-id="' . $rowID . '">Hủy đơn hàng</button>';
	} elseif ($statusOrder == 2) {
		$status = 'Đơn hàng đang vận chuyển ';
		$ok = '';
	} elseif ($statusOrder == 3) {
		$status = 'đơn hàng đã được hủy';
		$ok = '';
	}
?>

	<div class="product-widget">
		<div class="product-img">
			<img src="<?= $rowProduct['img']; ?>" alt="">
		</div>
		<div class="product-body">
			<h3 class="product-name"><a href="#"><?= $rowProduct['ProductName']; ?></a></h3>
			<h4 class="product-price">$<?= $rowProduct['Price']; ?> <del class="product-old-price">$<?= $rowProduct['Price']; ?></del></h4>
			<button type="button"><?= $status; ?></button>
			<?= $ok; ?>
		</div>
	</div>
  <div class="card mb-4 order-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5>Đơn hàng #</h5>
                        <p class="mb-1 text-muted">Ngày đặt: ''</p>
                        <p class="mb-1 text-muted">Trạng thái: <strong></strong></p>
                    </div>
                    <div class="text-end">
                        <p class="mb-1"><strong>Tổng tiền:</strong></p>
                        <h5 class="text-primary"> đ</h5>
                    </div>
                </div>
                <hr>
                <h6>Chi tiết sản phẩm:</h6>
                <ul class="list-group list-group-flush">
                   
                </ul>
                <div class="mt-3 text-end">
                    <a href="order_detail.php?id=" class="btn btn-outline-primary btn-sm">
                        Xem chi tiết
                    </a>
                </div>
            </div>
        </div>
<?php
}
require_once('./sytem/end.php');
?>