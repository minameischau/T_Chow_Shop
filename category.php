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

    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Sản phẩm theo loại</span></h2>
        </div>
        
        <div class="row px-xl-5 pb-3" >

        <?php
            $category_name = $_GET['category'];
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE category = ?");
            $select_products->execute([$category_name]);
            if($select_products->rowCount() > 0){
                while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
        ?> 

            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">

                <form class="card product-item border-0 mb-4" method="POST">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0 border rounded-top border-bottom-0 text-center">
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
            echo '<p class="empty">Hiện tại chưa có sản phẩm!</p>';
        }
        ?>            
        </div>

    </div>
    <!-- Products End -->

    <!-- Vendor Start -->
    <div class="container-fluid py-5">
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