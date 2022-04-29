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
      $message[] = 'Đã tồn tại trong danh sách yêu thích!';
   }elseif($check_cart_numbers->rowCount() > 0){
      $message[] = 'Đã tồn tại trong giỏ hàng!';
   }else{
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
      $message[] = 'Đã tồn tại trong danh sách yêu thích!';
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
      $message[] = 'Đã tồn tại trong giỏ hàng!';
   }else{

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$p_name, $user_id]);

      if($check_wishlist_numbers->rowCount() > 0){
         $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
         $delete_wishlist->execute([$p_name, $user_id]);
      }

      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
      $message[] = 'Đã thêm vào giỏ hàng';
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Tìm kiếm</title>
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
            </nav>

            <?php
                $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $count_cart_items->execute([$user_id]);
                $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
                $count_wishlist_items->execute([$user_id]);
            ?>

            <div class="col-lg-3 col-6 text-right">
                <a href="wishlist.php" class="btn border">
                    <i class="fas fa-heart text-primary"></i>
                    <span class="badge"><?= $count_wishlist_items->rowCount(); ?></span>
                </a>
                <a href="cart.php" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge"><?= $count_cart_items->rowCount(); ?></span>
                </a>
                <a class="btn border" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                    <i class="fas fa-user text-primary"></i>
                </a>
                <div class="row">

                <?php
                    $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                    $select_profile->execute([$user_id]);
                    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                ?>

                    <div class="col">
                        <div class="collapse multi-collapse" id="multiCollapseExample1">
                            <div class="card card-body rounded" style="position: fixed; z-index: 2; top: 4rem; right: 3rem;">

                                <img src="./admin/uploaded_img/<?= $fetch_profile['image']; ?>" class="rounded-circle" style="width: 10rem;" alt="">
                                <p class="text-center mt-1 mb-0 font-weight-bold"><?= $fetch_profile['name']; ?></p>
                                <a href="user_profile_update.php" class="btn font-weight-bold bg-light">Cập nhật hồ sơ</a>
                                <a href="logout.php" class="delete-btn font-weight-bold">Đăng xuất</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Search button -->
    <div class="container-fluid">
        <div class="row align-items-center text-center py-3 px-xl-5">
            <div class="col-lg-6 col-6 text-left m-auto">
                <form action="" method="POST">
                    <div class="input-group">
                        <input type="text" name="search_box" class="form-control border" placeholder="Nhập sản phẩm cần tìm...">
                        <div class="input-group-append">
                            <button class="input-group-text bg-transparent text-primary border" name="search_btn" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Search button-->

    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Kết quả tìm kiếm</span></h2>
        </div>
        
        <div class="row px-xl-5 pb-3" >

        <?php
            if(isset($_POST['search_btn'])){
            $search_box = $_POST['search_box'];
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE '%{$search_box}%' OR category LIKE '%{$search_box}%'");
            $select_products->execute();
            if($select_products->rowCount() > 0){
                while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
        ?>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    
                <form class="card product-item border-0 mb-4" method="POST">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0  border rounded-top border-bottom-0 text-center">
                        <img class="img-fluid w-100" src="./admin/uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h5 class="text-truncate mb-3 font-weight-semi-bold"><?= $fetch_products['name']; ?></h5>
                        <div class="d-flex justify-content-center">
                            <h6><span><?= number_format($fetch_products['price'], 0, ',', '.') ; ?>đ</h6>
                        </div>
                    </div>
                    <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                    <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
                    <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">   
                    <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
                    <input type="hidden" min="1" value="1" name="p_qty" class="qty" style="text-align:center;">
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <input type="submit" value="️❤️ Yêu thích" class="option-btn font-weight-medium border" name="add_to_wishlist">
                        <input type="submit" value="️🛒 Giỏ hàng" class="option-btn font-weight-medium border" name="add_to_cart">
                    </div>
                    
                </form>
            </div>
        <?php
                }
            }else{
                echo '<p class="empty">Không tìm thấy sản phẩm!</p>';
            }
        };
        ?>            
        </div>
    </div>
    <!-- Products End -->

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