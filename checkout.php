<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $number = $_POST['number'];
   $email = $_POST['email'];
   $method = $_POST['method'];
   $address = 'Duong ' . $_POST['duong'] .' '. $_POST['phuong'] .' '. $_POST['quan'] .' '. $_POST['tinh'];
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $cart_query->execute([$user_id]);
   if($cart_query->rowCount() > 0){
      while($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)){
         $cart_products[] = $cart_item['name'].' ( '.$cart_item['quantity'].' )';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      };
   };

   $total_products = implode(', ', $cart_products);

   $order_query = $conn->prepare("SELECT * FROM `orders` WHERE name = ? AND number = ? AND email = ? AND method = ? AND address = ? AND total_products = ? AND total_price = ?");
   $order_query->execute([$name, $number, $email, $method, $address, $total_products, $cart_total]);

   if($cart_total == 0){
   }elseif($order_query->rowCount() > 0){
      $message[] = 'order placed already!';
   }else{
      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES(?,?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $cart_total, $placed_on]);
      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);
    echo '
    <div class="d-flex align-items-center border border-success mb-4 " style="padding: 15px;">
        <h3 class="fa-solid fa-check text-success mr-3"></h3>
        <h5 class="font-weight-semi-bold m-0">Đặt hàng thành công</h5>
        <i class="fas fa-times ml-auto " style="font-size: 1.5rem;" onclick="this.parentElement.remove();"></i>
    </div>';
   }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Thanh toán</title>
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
            <h1 class="font-weight-semi-bold text-uppercase mt-3">Thanh toán</h1>
            <div class="d-inline-flex mb-3">
                <p class="m-0"><a href="home.php">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Thanh toán</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Checkout Start -->
    <div class="container-fluid pt-5">

    <?php
      $cart_grand_total = 0;
      $select_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart_items->execute([$user_id]);
      
    ?>

        <div class="row px-xl-5">
            
            <div class="col-lg-5">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Thông tin đơn hàng</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Sản phẩm</h5>

                        <?php
                            if($select_cart_items->rowCount() > 0){
                                while($fetch_cart_items = $select_cart_items->fetch(PDO::FETCH_ASSOC)){
                                   $cart_total_price = ($fetch_cart_items['price'] * $fetch_cart_items['quantity']);
                                   $cart_grand_total += $cart_total_price;
                        ?>    

                        <div class="d-flex justify-content-between">
                            <p><b><?= $fetch_cart_items['name']; ?></b></p>
                            <p><?=number_format( $fetch_cart_items['price'], 0, ',', '.'). 'đ x ' . $fetch_cart_items['quantity']; ?> </p>
                        </div>
                                    
                        <?php
                            }
                        }else{
                            echo '<p class="font-weight-medium text-danger">Giỏ hàng rỗng</p>';
                        }
                        ?>

                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Tổng tiền</h5>
                            <h5 class="font-weight-bold"><?= number_format($cart_grand_total, 0, ',', '.'); ?> đ</h5>
                        </div>
                    </div>
                </div>
            </div>

            <form class="col-lg-7" method="POST">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Thông tin giao hàng</h4>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Họ và tên</label>
                            <input name="name" class="form-control" type="text" placeholder="Nguyễn Văn A">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số điện thoại</label>
                            <input name="number" class="form-control" type="number" placeholder="0123456789">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input name="email" class="form-control" type="email" placeholder="ct275@gmail.com">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Phương thức thanh toán</label>
                            <select name="method" class="form-control" required>
                               <option value="cod">Thanh toán khi nhận hàng</option>
                               <option value="tindung">Thẻ tín dụng</option>
                               <option value="momo">Momo</option>
                            </select>
                         </div>
                        <div class="col-md-12 form-group">
                            <label>Địa chỉ</label>
                            <input name="duong" class="form-control" type="text" placeholder="Đường 3/2">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Phường/Xã</label>
                            <input name="phuong" class="form-control" type="text" placeholder="Xuân Khánh">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Quận/Huyện</label>
                            <input name="quan" class="form-control" type="text" placeholder="Ninh Kiều">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Tỉnh/Thành phố</label>
                            <input name="tinh" class="form-control" type="text" placeholder="Tp Cần Thơ">
                        </div>
                        <div class="col-md-12">
                            <button name="order" class="btn btn-block btn-primary my-3 py-3 border <?= ($cart_grand_total > 1)?'':'disabled'; ?>" type="submit">Đặt hàng</button>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
    <!-- Checkout End -->

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