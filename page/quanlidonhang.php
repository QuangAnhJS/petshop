<?php
require_once('head.php');

?><div class="col-11">
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Tài khoản</th>
                <th>Tên đơn hàng</th>
                <th>Số lượng</th>
                <th>Giá tiền</th>
                <th>Trạng thái</th>
                <th>Tên người nhận</th>
                <th>Địa chỉ</th>
                <th>SĐT</th>

                <th>action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($conn, "SELECT * from `order`");
            $stt = 0;
            while ($row = mysqli_fetch_assoc($query)) {
                $stt++;
                $rowid = $row['id'];
                $rowUserID = $row['UserID'];
                $get_user = mysqli_query($conn, "SELECT * from `user` where `id`='$rowUserID'");
                $rowUser = mysqli_fetch_assoc($get_user);
                $rowState = $row['State'];
                $rowStatus = $row['status'];
                $queryOderDetail = mysqli_query($conn, "SELECT * from `orderdetail` where `OrderID`='$rowid'");
                $rowqueryOderDetail = mysqli_fetch_assoc($queryOderDetail);
                if ($rowState == 1) {
                    $text = 'Đã thanh toán';
                } else {
                    $text = 'Thanh toán khi nhận hàng';
                }
                if ($rowStatus == 1) {
                    $Status = '<button type="button" class="btn btn-primary validate" data-id="' . $rowid . '">Xác nhận đơn hàng</button>';
                    $delete = '<button type="button" class="btn btn-primary CancelOrder" data-id="' . $rowid . '">Hủy đơn hàng</button>';
                } elseif ($rowStatus == 2) {
                    $Status = '<button type="button" class="btn btn-secondary" disabled> Xác nhận thành công</button>';
                    $delete = '';
                } elseif ($rowStatus == 3) {
                    $Status = '<button type="button" class="btn btn-secondary" disabled>Đơn hàng đã bị hủy</button>';
                    $delete = '';
                }

            ?>
            <tr>
                <td><?= $rowUser['Username']; ?></td>
                <td><?= $rowqueryOderDetail['ProductName']; ?></td>
                <td><?= $rowqueryOderDetail['StockQuantity']; ?></td>
                <td><?= $row['Price']; ?></td>
                <td><?= $text; ?></td>
                <td>
                    <?= $rowqueryOderDetail['name']; ?>
                </td>
                <td>
                    <?= $rowqueryOderDetail['diachi']; ?>
                </td>
                <td>
                    <?= $rowqueryOderDetail['sdt']; ?>
                </td>
                <td>
                    <?= $Status; ?>
                    <?= $delete; ?>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<?php
require_once('end.php');
?>