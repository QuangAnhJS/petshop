<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>petShop</title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    //
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="/assets/css/styles.min.css?h=4a10e52155003076b9b1b8608127ba11">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="node_modules/froala-editor/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.css">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
    .nav-center {
        margin: auto;
    }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <a class="navbar-brand text-center ms-5" href="#"><img src="/assets/img/perfume shop.png" alt=""
                    style="width: 130px;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <br> <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 nav-center">
                    <li class="nav-item px-3">
                        <a class="nav-link active btn btn-primary" aria-current="page" href="#">TRANG CHỦ</a>
                    </li>

                    <li class="nav-item dropdown px-3">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            THÚ CƯNG
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">PHỤ KIỆN</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link " href="#">PHỤ KIỆN</a>
                    </li>
                    <li class="nav-item dropdown px-3">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            DỊCH VỤ
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">PHỤ KIỆN</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link " href="#">LIÊN HỆ</a>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link " href="#">GIỚI THIỆU</a>
                    </li>
                    <li class="nav-item px-3">
                        <div class="row">
                            <div class="col-3">
                                <div class=""
                                    style="background: url(/assets/img/pexels-photo-20116318.jpeg?h=c867642ec54510f360b18be82cf6000e) center / cover no-repeat;">
                                </div>
                            </div>
                            <div class="col-9"> <a class="nav-link " href="#"><span class=""><i
                                            class="fa-solid fa-cart-shopping"></i></span>Đăng
                                    nhập</a></div>
                        </div>


                    </li>


                </ul>

            </div>
        </div>
    </nav>
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-3">
                    <div class="card p-3 m-3">
                        <p class="h5"><a href=""></a>Menu</p>
                        <hr>

                        <div class="row">
                            <div class="col-10">
                                <p class="h6"><a href="#" id="themsanpham">danh sách sản phẩm </a>
                            </div>
                            <div class="col-2"><span class="d-inline-block ml-auto">(0)</span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-10">
                                <p class="h6"><a href="">cập nhật sản phẩm </a>
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
                                <p class="h6"><a href="">Mèo đuôi chuột </a>
                            </div>
                            <div class="col-2"><span class="d-inline-block ml-auto">(0)</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6" id="main">
                    <div>
                        <form">
                            <div class="mb-3 mt-3">
                                <label for="email" class="form-label">Nhập tên sản phẩm</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter email"
                                    name="email">
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="email" class="form-label">Nhập tên danh mục</label>
                                <input type="text" class="form-control" id="category" placeholder="Enter email"
                                    name="text">
                            </div>
                            <div class="mb-3">
                                <label for="pwd" class="form-label">Giá tiền</label>
                                <input type="text" class="form-control" id="Price" placeholder="VNĐ" name="pswd">
                            </div>
                            <div class="mb-3">
                                <label for="pwd" class="form-label">Nhập số lượng</label>
                                <input type="text" class="form-control" id="StockQuantity" placeholder="Enter password"
                                    name="pswd">
                            </div>


                            <div class="input-group mb-3">
                                <input type="file" class="form-control" id="inputGroupFile02">

                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                            </div>
                            <div class="input-group mb-3">
                                <textarea id="froala-editor"></textarea>
                            </div>
                            <button id="submit" class="btn btn-primary">Submit</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
    $(document).ready(function() {
        $("#submit").click(function(event) {
            event.preventDefault();
            var formData = new FormData();
            formData.append('ProductNme', $("#name").val());
            formData.append('category', $("#category").val());
            formData.append('Price', $("#Price").val());
            formData.append('StockQuantity', $("#StockQuantity").val());
            formData.append('IMG', $("#inputGroupFile02").prop('files')[
                0]); // Truyền toàn bộ đối tượng file vào
            formData.append('Describe', $("#froala-editor").val());

            $.ajax({
                type: 'POST',
                url: "/api/quanli.php?action=createProduct",
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(result) {
                    switch (result.status) {
                        case 200:
                            alert("Thành công: " + result.msg);
                            break;
                        case 404:
                            alert("Không tìm thấy: " + result.msg);
                            break;
                        case 500:
                            alert("Lỗi không thành công: " + result.msg);
                            break;
                        default:
                            alert("Trạng thái không xác định: " + result.status);
                    }
                    location.reload();
                },
            });
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $("#themsanpham").click(function(event) {
            // Ngăn chặn hành động mặc định của biểu mẫu (tránh trang web tải lại)
            event.preventDefault();
            $('#main').load('/viewquanli/Viewproduct.php');
        });
    })
    $(document).ready(function() {
        $("#capnhatsanpham").click(function(event) {
            // Ngăn chặn hành động mặc định của biểu mẫu (tránh trang web tải lại)
            event.preventDefault();
            $('#main').load('/viewquanli/createproduct.php');
        });
    })
    </script>
    <!-- End: Bold BS4 Image Caption Hover Effect 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="/assets/js/script.min.js?h=0135ccae25d5a5ba675cd74038ecc611"></script>
    <script type="text/javascript" src="node_modules/froala-editor/js/froala_editor.pkgd.min.js"></script>

    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


    <script>
    new FroalaEditor('textarea#froala-editor')
    </script>
</body>

</html>