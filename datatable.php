<?php
require_once('./sytem/config.php');

if (!isset($_SESSION['quanli'])) {
    header("location:/login.php ");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.css">
    <link href="node_modules/froala-editor/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.js"></script>

    <title>Quan lí </title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <div class="card p-3 m-3">
                    <p class="h5"><a href=""></a>Menu</p>
                    <hr>

                    <div class="row">
                        <div class="col-10">
                            <p class="h6"><a href="datatable.php">danh sách sản phẩm </a>
                        </div>
                        <div class="col-2"><span class="d-inline-block ml-auto">(0)</span></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-10">
                            <p class="h6" id="capnhatsanpham"><a href="#capnhatsanpham.php">cập nhật sản phẩm </a>
                        </div>
                        <div class="col-2"><span class="d-inline-block ml-auto">(0)</span></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-10">
                            <p class="h6"><a href="">Quản lí tài khoản </a>
                        </div>
                        <div class="col-2"><span class="d-inline-block ml-auto">(0)</span></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-10">
                            <p class="h6"><a href="">Chó ngáo </a>
                        </div>
                        <div class="col-2"><span class="d-inline-block ml-auto">(0)</span></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-10">
                            <p class="h6"><a href="logout.php">Đăng xuất </a>
                        </div>
                        <div class="col-2"><span class="d-inline-block ml-auto">(0)</span></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-10">
                            <p class="h6"><a href="">Mèo đuôi chuột </a>
                        </div>
                        <div class="col-2"><span class="d-inline-block ml-auto">(0)</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-7">
                <div id="main">
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
                                    <td>
                                        <button class="delete-btn" data-id="<?= $row['id']; ?>">xóa</button>
                                    </td>
                                </tr>
                            </tbody>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>


    </div>


    <script>
        $(document).ready(function() {
            $(".delete-btn").click(function() {
                var idCart = $(this).data("id");
                $.ajax({
                    type: 'POST',
                    url: "/api/quanli.php?action=delete",
                    data: {
                        id: idCart
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.status == 200) {
                            alert(result.msg);
                            location.reload();
                        } else if (result.status == 404) {
                            alert(result.msg);
                        } else if (result.status == 500) {
                            alert(result.msg);
                        }
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#capnhatsanpham").click(function(event) {
                // Ngăn chặn hành động mặc định của biểu mẫu (tránh trang web tải lại)
                event.preventDefault();
                $('#main').load('/capnhatsanpham.php');
            });
        })
    </script>


</body>

</html>