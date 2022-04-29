<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_wishlist'])){

   $pid = $_POST['pid'];
   $p_name = $_POST['p_name'];
   $p_price = $_POST['p_price'];
   $p_image = $_POST['p_image'];

   $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
   $check_wishlist_numbers->execute([$p_name, $user_id]);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_wishlist_numbers->rowCount() > 0){
    echo '
    <div class="d-flex align-items-center border border-warning mb-4 " style="padding: 15px;">
        <h3 class="fa-solid fa-triangle-exclamation text-warning mr-3"></h3>
        <h5 class="font-weight-semi-bold m-0">Đã tồn tại trong danh sách yêu thích!</h5>
        <i class="fas fa-times ml-auto text-danger " style="font-size: 1.5rem;" onclick="this.parentElement.remove();"></i>
    </div>';
   }elseif($check_cart_numbers->rowCount() > 0){
    echo '
    <div class="d-flex align-items-center border border-warning mb-4 " style="padding: 15px;">
        <h3 class="fa-solid fa-triangle-exclamation text-warning mr-3"></h3>
        <h5 class="font-weight-semi-bold m-0">Đã tồn tại trong giỏ hàng!</h5>
        <i class="fas fa-times ml-auto text-danger " style="font-size: 1.5rem;" onclick="this.parentElement.remove();"></i>
    </div>';

   }else{
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
   }

}

if(isset($_POST['add_to_cart'])){

   $pid = $_POST['pid'];
   $p_name = $_POST['p_name'];
   $p_price = $_POST['p_price'];
   $p_image = $_POST['p_image'];
   $p_qty = $_POST['p_qty'];

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_cart_numbers->rowCount() > 0){
    echo '
    <div class="d-flex align-items-center border border-warning mb-4 " style="padding: 15px;">
        <h3 class="fa-solid fa-triangle-exclamation text-warning mr-3"></h3>
        <h5 class="font-weight-semi-bold m-0">Đã tồn tại trong giỏ hàng!</h5>
        <i class="fas fa-times ml-auto text-danger " style="font-size: 1.5rem;" onclick="this.parentElement.remove();"></i>
    </div>';
   }else{

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$p_name, $user_id]);

      if($check_wishlist_numbers->rowCount() > 0){
         $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
         $delete_wishlist->execute([$p_name, $user_id]);
      }

      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sản phẩm</title>
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
                        <h5 class="font-weight-semi-bold m-0">Snack</h5>
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

    <!-- Products Start -->
    <?php include 'product_cate.php'; ?>
    <!-- Products End -->

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