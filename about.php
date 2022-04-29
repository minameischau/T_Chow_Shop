<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Về chúng tôi</title>
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
    <?php include 'header.php'; ?>
    <!-- Topbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 120px">
            <h1 class="font-weight-semi-bold text-uppercase mt-3">Về chúng tôi</h1>
            <div class="d-inline-flex mb-3">
                <p class="m-0"><a href="home.php">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Về chúng tôi</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

     <!-- About Start -->
     <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-6 col-md-7 pb-1">
                <img src="./images/about1.png" style="height: 30rem;" alt="">
            </div>
            <div class="col-lg-5 col-md-12 pb-1">
                <h2 class="about-title">Các sản phẩm kinh doanh?</h2>
                <p>Những sản phẩm của chúng tôi mang đến cho người tiêu dùng sự lựa chọn đa dạng về chất lượng hàng hóa và dịch vụ, đáp ứng đầy đủ nhu cầu trải nghiệm mua sắm từ bình dân đến cao cấp của mọi khách hàng.</p>
                <a href="shop.php" class="btn btn-block btn-primary font-weight-bold my-3 py-3 border">Xem thêm</a>
            </div>
        </div>
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Đánh giá</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                    <div class="box">
                        <img class="" src="./images/avt15.png" alt="">
                        <p class="mt-4">Sản phẩm chất lượng, có nguồn gốc rõ ràng đảm bảo an toàn thực phẩm của Bộ Y Tế. Khuyến khích các bạn sử dụng.</p>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <h5 class="font-weight-semi-bold">King of animals</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                    <div class="box">
                        <img class="" src="./images/avt14.png" alt="">
                        <p class="mt-4">Sản phẩm chất lượng, có nguồn gốc rõ ràng đảm bảo an toàn thực phẩm của Bộ Y Tế. Khuyến khích các bạn sử dụng.</p>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <h5 class="font-weight-semi-bold">Virus</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                    <div class="box">
                        <img class="" src="./images/avt13.png" alt="">
                        <p class="mt-4">Sản phẩm chất lượng, có nguồn gốc rõ ràng đảm bảo an toàn thực phẩm của Bộ Y Tế. Khuyến khích các bạn sử dụng.</p>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <h5 class="font-weight-semi-bold">Ghost</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->    

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