<?php
require_once('./sytem/header.php');
if (!isset($_SESSION['User'])) {
    header("location:/login.php");
}

?>
<div class="container mt-5">
    <h2 class="mb-4">🛒 Giỏ hàng của bạn</h2>

    <form id="cart-form" action="checkout.php" method="post">
        <div class="table-responsive">
          
                <div class="table-responsive">
                    <table class="table table-bordered cart-table">
                        <thead class="table-light">
                            <tr>
                                <th><input type="checkbox" id="check-all"></th>
                                <th>Ảnh</th>
                                <th>Sản phẩm</th>
                                <th>Giá (đ)</th>
                                <th>Số lượng</th>
                                <th>Thành tiền (đ)</th>
                                <th>Xoá</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Lấy ID đã chọn từ URL
                            $selected = isset($_GET['selected']) ? (int)$_GET['selected'] : null;

                            // Lấy sản phẩm trong giỏ hàng của người dùng
                            $query = mysqli_query($conn, "SELECT * FROM `cart` WHERE `UserID` = '{$_SESSION['User']['id']}'");

                            while ($row = mysqli_fetch_assoc($query)) {
                                if (!$row) {
                                    echo "<div style='padding:20px;color:red;'>Không có sản phẩm trong giỏ hàng</div>";
                                    require_once('./sytem/end.php');
                                    exit;
                                }

                                $rowid = $row['id'];
                                $rowProductCart = $row['ProductID'];
                                $rowQuantity = $row['Quantity'];

                                // Xác định checkbox có được tích hay không
                                $isChecked = ($selected == $rowProductCart) ? 'checked' : '';

                                // Lấy thông tin sản phẩm
                                $queryProduct = mysqli_query($conn, "SELECT * FROM `product` WHERE `id` = '$rowProductCart'");
                                $rowProduct = mysqli_fetch_assoc($queryProduct);
                                if (!$rowProduct) {
                                    echo "<div style='padding:20px;color:red;'>Không tìm thấy sản phẩm có ID = $rowProduct</div>";
                                    require_once('./sytem/end.php');
                                    exit;
                                }

                                $Price = $rowProduct['Price'];
                                $ProductName = $rowProduct['ProductName'];
                                $img = $rowProduct['img'];
                                $totalPrice = $Price * $rowQuantity;

                                // Debug (tuỳ chọn) — để xem PHP có tạo ra checked không
                                // echo "<!-- rowid=$rowid, selected=$selected, isChecked=$isChecked -->";
                            ?>
                                <tr data-price="<?= $Price ?>">
                                    <td>
                                        <input type="checkbox"
                                            name="items[]"
                                            value="<?= $rowid ?>"
                                            class="item-check"
                                            <?= $isChecked ?>

                                        >
                                    </td>
                                    <td hidden>
                                        <input type="text"
                                            name="ProductId[<?= $rowid ?>]"
                                            class="handleinput"
                                            value="<?= $rowProductCart ?>"
                                            readonly>
                                    </td>
                                    <td>
                                        <img style="width: 80px; height: 80px; object-fit: cover;"
                                            src="<?= $img ?>"
                                            class="cart-img"
                                            alt="<?= $ProductName ?>">
                                    </td>
                                    <td>
                                        <input type="text"
                                            name="ProductName[<?= $rowid ?>]"
                                            class="handleinput"
                                            value="<?= $ProductName ?>"
                                            readonly>
                                    </td>
                                    <td>
                                        <input type="text"
                                            name="Price"
                                            class="handleinput"
                                            value="<?= $Price ?>"
                                            readonly>
                                    </td>
                                    <td>
                                        <input type="number"
                                            name="qty[<?= $rowid ?>]"
                                            value="<?= $rowQuantity ?>"
                                            min="1"
                                            class="form-control quantity-input w-75"
                                            readonly>
                                    </td>
                                    <td class="line-total">
                                        <input type="text"
                                            class="display-line-total handleinput"
                                            value="<?= number_format($totalPrice) ?> đ"
                                            readonly>
                                        <input type="hidden"
                                            class="hidden-line-total"
                                            name="totalPrice[<?= $rowid ?>]"
                                            value="<?= $totalPrice ?>">
                                    </td>
                                    <td>
                                        <button type="button"
                                            class="btn btn-sm btn-danger"
                                            onclick="deleteCart(<?= $rowid ?>)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
          

        </div>

        <!-- Tổng tiền hiển thị -->
        <div class="total-price-box text-end">
            Tổng tiền sản phẩm đã chọn: <span id="total-price">0</span> đ
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="index.php" class="btn btn-secondary">← Tiếp tục mua sắm</a>
            <button type="submit" class="boc btn btn-primary">Mua hàng</button>
        </div>
    </form>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    function deleteCart(id) {
        $.ajax({
            url: '/api/user.php?action=DeleteCart',
            type: 'POST',
            dataType: 'json',
            data: {
                id
            },
            success: function(data) {
                if (data.status == 200) {
                    alert(data.msg);
                    location.reload();
                } else {
                    alert(data.msg);
                    location.reload();
                }
            }
        });
    }
</script>
<script>
    function formatCurrency(number) {
        return new Intl.NumberFormat('vi-VN').format(number);
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('tbody tr').forEach(row => {
            const checkbox = row.querySelector('.item-check');
            const qtyInput = row.querySelector('.quantity-input');
            const price = parseInt(row.dataset.price);

            const hiddenTotalInput = row.querySelector('.hidden-line-total');
            const displayTotalInput = row.querySelector('.display-line-total');

            const qty = parseInt(qtyInput.value);

            const lineTotal = price * qty;

            if (checkbox.checked) {
                total += lineTotal;
            }

            // Cập nhật hiển thị và giá trị gửi lên form
            displayTotalInput.value = formatCurrency(lineTotal) + ' đ';
            hiddenTotalInput.value = lineTotal;
        });

        document.getElementById('total-price').innerText = formatCurrency(total);
    }


    // Chọn tất cả
    document.getElementById("check-all").addEventListener("change", function() {
        document.querySelectorAll('.item-check').forEach(cb => {
            cb.checked = this.checked;
        });
        updateTotal();
    });

    // Khi thay đổi checkbox hoặc số lượng
    document.querySelectorAll('.item-check, .quantity-input').forEach(el => {
        el.addEventListener('change', updateTotal);
    });

    // Khởi tạo tổng lần đầu
    updateTotal();
</script>
<script>
    document.getElementById('cart-form').addEventListener('submit', function(e) {
        const checked = document.querySelectorAll('.item-check:checked');
        if (checked.length === 0) {
            e.preventDefault(); // chặn submit
            alert('Vui lòng chọn sản phẩm trước khi thanh toán!');
        }
    });
</script>
<?php
require_once('./sytem/end.php');
?>