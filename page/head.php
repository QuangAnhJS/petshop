<?php
require_once('../sytem/config.php');

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
    <link href="../node_modules/froala-editor/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <!-- link boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Roboto+Slab:wght@500&display=swap"
        rel="stylesheet">


    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.js"></script>

    <title>Quan lí </title>
</head>

<body id="main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-1">
                <div class="">
                    <div class="navbar" id="navbar">
                        <div class="nav">
                            <div>
                                <a href="" class="logo">
                                    <img src="image/bird-colorful-logo-gradient-vector_343694-1365.webp" alt=""
                                        class="icon">
                                    <span>Quan lí</span>
                                </a>
                                <div class="nav_toggle" id="nav_toggle">
                                    <i class='bx bxs-chevron-left-circle'></i>
                                </div>
                                <ul class="nav_list">
                                    <div class="hover">
                                        <a href="datatable.php" class="nav_link">
                                            <i class='bx bx-grid-alt'></i>
                                            <span>Danh sách sản phẩm</span>
                                        </a>
                                    </div>
                                    <div class="hover">
                                        <a href="" class="nav_link" id="capnhatsanpham">
                                            <i class='bx bx-grid-alt'></i>
                                            <span>Thêm sản phẩm</span>
                                        </a>
                                    </div>
                                    <div class="hover">
                                        <a href="quanlidonhang.php" class="nav_link">
                                            <i class='bx bx-grid-alt'></i>
                                            <span>Quản lí đơn hàng</span>
                                        </a>
                                    </div>
                                    <div class="hover">
                                        <a href="" class="nav_link">
                                            <i class='bx bx-grid-alt'></i>
                                            <span>home</span>
                                        </a>
                                    </div>
                                    <div class="hover">
                                        <a href="" class="nav_link">
                                            <i class='bx bx-grid-alt'></i>
                                            <span>home</span>
                                        </a>
                                    </div>
                                    <div class="hover">
                                        <a href="" class="nav_link">
                                            <i class='bx bx-grid-alt'></i>
                                            <span>home</span>
                                        </a>
                                    </div>
                                </ul>
                            </div>
                            <a href="../logout.php" class="nav_link">
                                <i class='bx bx-exit'></i>
                                <span>Đăng xuất</span>
                            </a>
                        </div>
                    </div>
                    <!-- <p class="h5"><a href=""></a>Menu</p>
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
                            <p class="h6"><a href="">Quản lí đơn hàng </a>
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
                            <p class="h6"><a href="../logout.php">Đăng xuất </a>
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
                    </div> -->
                </div>
            </div>