<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

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
 
 };

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
   $delete_wishlist_item->execute([$delete_id]);
   header('location:wishlist.php');

};

if(isset($_GET['delete_all'])){

   $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
   $delete_wishlist_item->execute([$user_id]);
   header('location:wishlist.php');

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Yêu thích</title>
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
            <h1 class="font-weight-semi-bold text-uppercase mt-3">Danh sách yêu thích</h1>
            <div class="d-inline-flex mb-3">
                <p class="m-0"><a href="home.php">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Danh sách yêu thích</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Cart Start -->
    <div class="container-fluid pt-5">

        <div class="row px-xl-5">

            <form class="col-lg-8 table-responsive mb-5"  method="POST">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Hiệu chỉnh</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php
                            $grand_total = 0;
                            $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
                            $select_wishlist->execute([$user_id]);
                            if($select_wishlist->rowCount() > 0){
                                while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)){ 
                        ?>                       
                        <tr>
                            <td class="align-middle"><img src="./admin/uploaded_img/<?= $fetch_wishlist['image']; ?>" alt="" style="width: 50px;"> <b> <?= $fetch_wishlist['name']; ?> </b></td>
                            <td class="align-middle">
                            <?= number_format($fetch_wishlist['price'], 0, ',', '.') ; ?>đ
                                <input type="hidden" min="1" value="1" class="qty" name="p_qty">
                                <input type="hidden" name="cart_id" value="<?= $fetch_wishlist['id']; ?>">
                                <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
                                <input type="hidden" name="p_name" value="<?= $fetch_wishlist['name']; ?>">
                                <input type="hidden" name="p_price" value="<?= $fetch_wishlist['price']; ?>">
                                <input type="hidden" name="p_image" value="<?= $fetch_wishlist['image']; ?>">
                            </td>
                            <td class="align-middle"><input type="submit" class="btn btn-primary btn-block border bg-primary" value="Thêm vào giỏ hàng" name="add_to_cart"></td>
                        <?php
                                $grand_total += $fetch_wishlist['price'];
                            }
                        } else{
                            echo '
                                <div class="d-flex align-items-center border border-danger mb-4" style="padding: 15px;">
                                    <h5 class="font-weight-semi-bold">Danh sách yêu thích trống</h5>
                                </div>';
                        }
                        ?>    
                        </tr>
                    </tbody>    
                </table>
            </form>

            <div class="col-lg-4">
                <div class=" border-secondary bg-transparent">
                    <a href="shop.php" type="button" class="btn btn-block btn-success mb-3 py-3 border">Tiếp tục mua sắm</a>
                    <a href="wishlist.php?delete_all" type="button" style="" class="btn btn-block btn-danger my-3 py-3 border <?= ($grand_total > 1)?'':'disabled'; ?>">Xóa tất cả</a>
                </div>
                
            </div>
        </div>
    </div>
    <!-- Cart End -->

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