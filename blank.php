<?php
require_once('./sytem/header.php');
$user = $_SESSION['User'];

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


	if ($statusOrder == 1) {
		$status = 'đơn hàng đang xác nhận';
	} elseif ($statusOrder == 2) {
		$status = 'đơn hàng đang trên dường vận chuyển ';
	} elseif ($statusOrder == 3) {
		$status = 'đơn hàng đã giao thành công';
	}


?>

<div class="product-widget">
    <div class="product-img">
        <img src="<?= $rowProduct['img']; ?>" alt="">
    </div>
    <div class="product-body">
        <h3 class="product-name"><a href="#"><?=$rowProduct['ProductName'];?></a></h3>
        <h4 class="product-price">$<?= $rowProduct['Price']; ?> <del
                class="product-old-price">$<?= $rowProduct['Price']; ?></del></h4>
        <button type="button"><?= $status; ?></button>
    </div>
</div>

<?php
}
require_once('./sytem/end.php');
?>