<?php

@include 'config.php';

session_start(); //bat dau phien

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   header('location:cart.php');
}

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $p_qty = $_POST['p_qty'];
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$p_qty, $cart_id]);
   echo '<script type="text/javascript">alert(`Đã cập nhật thành công!`)</script>';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Giỏ hàng</title>
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
            <h1 class="font-weight-semi-bold text-uppercase mt-3">Giỏ hàng</h1>
            <div class="d-inline-flex mb-3">
                <p class="m-0"><a href="home.php">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Giỏ hàng</p>
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
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                            <th>Hiệu chỉnh</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">

                        <?php
                            $grand_total = 0;
                            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                            $select_cart->execute([$user_id]);
                            if($select_cart->rowCount() > 0){
                                while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){ 
                        ?>   

                        <tr>
                            <td class="align-middle"><img src="./admin/uploaded_img/<?= $fetch_cart['image']; ?>" alt="" style="width: 50px;"> <b> <?= $fetch_cart['name']; ?></b></td>
                            <td class="align-middle">
                                <?= number_format($fetch_cart['price'], 0, ',', '.') ; ?> đ
                                <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                            </td>
                            <td class="align-middle">
                                <div class="flex-btn">
                                    <input type="number" min="1" value="<?= $fetch_cart['quantity']; ?>" class="qty" name="p_qty">
                                </div>
                            </td>
                            <?php
                                $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']);
                            ?>
                            <td class="align-middle"><?= number_format($sub_total, 0, ',', '.');  ?> đ</td>
                            <td class="align-middle"><input type="submit" value="Cập nhật" name="update_qty" class="option-btn btn-warning border"></td>
                        </tr>

                        <?php
                                $grand_total += $sub_total;
                            }
                        }else{
                            echo '
                            <div class="d-flex align-items-center border border-danger mb-4" style="padding: 15px;">
                                <h5 class="font-weight-semi-bold">Giỏ hàng trống</h5>
                            </div>';
                        }
                        ?>

                    </tbody>
                </table>
            </form>

            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0"> 
                        <h4 class="font-weight-semi-bold m-0">Tổng tiền: <?= number_format($grand_total, 0, ',', '.'); ?> đ</h4>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <a href="shop.php" type="button" class="btn btn-block btn-success my-3 py-3 border">Tiếp tục mua sắm</a>
                        <a href="cart.php?delete_all" type="button" class="btn btn-block btn-danger my-3 py-3 border <?= ($grand_total > 1)?'':'disabled'; ?>">Xóa tất cả</a>
                        <a href="checkout.php" type="button" class="btn btn-block btn-primary my-3 py-3 border <?= ($grand_total > 1)?'':'disabled'; ?>">Tiến hành thanh toán</a>
                    </div>
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