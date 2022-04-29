<?php

@include 'config.php';

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Trang chủ</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="T Chow" name="keywords">
    <meta content="T Chow" name="description">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/icon" href="./images/favicon.ico"/>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="./lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="./css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">T</span>Chow</h1>
                </a>
            </div>
            <nav class="col-lg-6 col-6 navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">T</span>Chow</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="home.php" class="nav-item nav-link active">Trang chủ</a>
                        <a href="shop.php" class="nav-item nav-link">Sản phẩm</a>
                        <a href="order.php" class="nav-item nav-link">Đơn hàng</a>
                        <a href="about.php" class="nav-item nav-link">Về chúng tôi</a>
                        <a href="contact.php" class="nav-item nav-link">Liên hệ</a>
                    </div>
                </div>
                <a href="search_page.php"><i class="fas fa-search"></i> </a>
            </nav>
            <div class="col-lg-3 col-6 text-right">
                <a href="register.php" class="font-weight-bolder btn border text-primary mr-1">
                    Đăng ký
                </a>
                <a href="login.php" class="font-weight-bolder btn border text-primary">
                    Đăng nhập
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row px-xl-5">


            <div class="col-lg-2 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100 border" data-toggle="collapse" href="#navbar-vertical" style="height: 50px; padding: 0 30px;">
                    <h6 class="m-0">Danh mục</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0" id="navbar-vertical">
                    <div class="navbar-nav w-100 overflow-hidden">
                        <a href="category.php?category=banhquy" class="nav-item nav-link">Bánh Quy</a>
                        <a href="category.php?category=keo" class="nav-item nav-link">Kẹo</a>
                        <a href="category.php?category=snack" class="nav-item nav-link">Snack</a>
                        <a href="category.php?category=saykho" class="nav-item nav-link">Đồ Sấy Khô</a>
                    </div>
                </nav>
            </div>

            <!-- Start Navbar -->
            <?php include 'nav.php'; ?>
            <!-- End Navbar -->

        </div>
    </div>
    <!-- Navbar End -->

    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Sản phẩm an toàn</h5>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px 15px;">
                    <h1 class="fa fa-book-open text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Chất lượng cam kết</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-star text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0"> Dịch vụ vượt trội</h5>
                </div>
            </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Giao hàng nhanh</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->

    <!-- Categories Start -->
        <section class="container-fluid pt-5">
            <div class="row px-xl-5 pb-3">
                <div class="col-lg-3 col-md-6 pb-1">
                    <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                        <a href="category.php?category=banhquy" class="cat-img position-relative overflow-hidden mb-3 text-center">
                            <img class="img-fluid" src="./images/Bánh Quy/Bánh cracker dinh dưỡng AFC vị lúa mì hộp 200g.jpg" alt="">
                        </a>
                        <h5 class="font-weight-semi-bold m-0">Bánh Quy</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 pb-1">
                    <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                        <a href="category.php?category=keo" class="cat-img position-relative overflow-hidden mb-3 text-center">
                            <img class="img-fluid" src="./images/Kẹo/Sô cô la KitKat Chunky gói 38g.jpg" alt="">
                        </a>
                        <h5 class="font-weight-semi-bold m-0">Kẹo</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 pb-1">
                    <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                        <a href="category.php?category=snack" class="cat-img position-relative overflow-hidden mb-3 text-center">
                            <img class="img-fluid" src="./images/Snack/Bánh lát khoai tây vị phô mai Slide hộp 160g.jpg" alt="">
                        </a>
                        <h5 class="font-weight-semi-bold m-0">Bánh Snack</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 pb-1">
                    <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                        <a href="category.php?category=saykho" class="cat-img position-relative overflow-hidden mb-3 text-center">
                            <img class="img-fluid" src="./images/Đồ Sấy Khô/Hạt hướng dương nguyên vị 130g.jpg" alt="">
                        </a>
                        <h5 class="font-weight-semi-bold m-0">Đồ sấy khô</h5>
                    </div>
                </div>
            </div>
        </section>
    <!-- Categories End -->

    <?php include 'product_cate.php'; ?>

    <!-- Vendor Start -->
    <div class="container-fluid py-5 border-top">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    <div class="vendor-item border p-4">
                        <img src="./images/vendor-1 lays.png" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="./images/vendor-2 oishi.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="./images/vendor-3 chupachups.png" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="./images/vendor-4 poca.png" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="./images/vendor-5 oneone.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="./images/vendor-6 jacknjill.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="./images/vendor-7 kinhdo.png" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="./images/vendor-8 chacheer.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End -->

    <!-- Footer Start -->
    <?php include 'footer.php'; ?>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="./lib/easing/easing.min.js"></script>
    <script src="./lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="./mail/jqBootstrapValidation.min.js"></script>
    <script src="./mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="./js/main.js"></script>
</body>

</html>