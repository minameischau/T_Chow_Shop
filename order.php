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
    <title>Đơn hàng</title>
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
</head>

<body>
    <!-- Topbar Start -->
    <?php include 'header.php'; ?>
    <!-- Topbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 120px">
            <!-- <img src="img/avt22.png" style="height: 14rem; margin-top: 1rem;" alt=""> -->
            <h1 class="font-weight-semi-bold text-uppercase mt-3">Đơn hàng</h1>
            <div class="d-inline-flex mb-3">
                <p class="m-0"><a href="shop.php">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Đơn hàng</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Contact Start -->
    <div class="container-fluid pt-4">

        <div class="row px-xl-5 pb-3">
            
                <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
                $select_orders->execute([$user_id]);
                if($select_orders->rowCount() > 0){
                    while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){ 
                ?>
                
            <div class="col-lg-4 col-md-6 pb-1 my-2">
                <div class="order border"> 
                    <p> Ngày : <span><?= $fetch_orders['placed_on']; ?></span> </p>
                    <p> Tên : <span><?= $fetch_orders['name']; ?></span> </p>
                    <p> Số điện thoại:  <span><?= $fetch_orders['number']; ?></span> </p>
                    <p> Email : <span><?= $fetch_orders['email']; ?></span> </p>
                    <p> Địa chỉ : <span><?= $fetch_orders['address']; ?></span> </p>
                    <p> Phương thức thanh toán : <span><?= $fetch_orders['method']; ?></span> </p>
                    <p> Sản phẩm : <span><?= $fetch_orders['total_products']; ?></span> </p>
                    <p> Tổng tiền : <span><?= $fetch_orders['total_price']; ?> đ</span> </p>
                    <p> Trạng thái thanh toán : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
                </div>
            </div>
                <?php
                    }
                }else{
                    echo '<p class="empty">Chưa có đơn hàng nào</p>';
                }
                ?>
        </div>
        
    </div>
    <!-- Contact End -->

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