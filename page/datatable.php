<?php
require_once('head.php');
?>
<div class="col-11">
    <div id="page">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm </th>
                    <th>Số lượng</th>
                    <th>Giá tiền</th>
                    <th>Tên danh mục </th>
                    <th>Mô tả</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php
            $query = mysqli_query($conn, "SELECT * from `product`");
            $stt = 0;
            while ($row = mysqli_fetch_assoc($query)) {
                $stt++;
            ?>

                <tbody>
                    <tr>
                        <td>
                            <?= $stt; ?>
                        </td>
                        <td>
                            <?= $row['ProductName']; ?>
                        </td>
                        <td>
                            <?= $row['Price']; ?>
                        </td>
                        <td>
                            <?= $row['StockQuantity']; ?>
                        </td>
                        <td>
                            <img src="<?= $row['img']; ?>" alt="" style="width:56px;">
                        </td>
                        <td>
                            <?= $row['Category']; ?>
                        </td>
                        <td class="p-5">
                            <div class="row">
                                <div class="col-6 "><button class="delete-btn btn btn-danger m-3" data-id="<?= $row['id']; ?>">xóa</button>
                                </div>
                                <div class="col-6"><a class="edit-btn btn btn-warning m-3" href="editProduct.php?id=<?= $row['id']; ?>">Sửa</a>
                                </div>
                            </div>
    </div>
    </td>
    </tr>
    </tbody>

    <!-- Scrollable modal -->


<?php
            }
?>
</table>
</div>
</div>
</div>


</div>


<?php
require_once('end.php');
?>