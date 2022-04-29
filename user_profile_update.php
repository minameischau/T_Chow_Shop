<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['update_profile'])){

   $name = $_POST['name'];
   $email = $_POST['email'];

   $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
   $update_profile->execute([$name, $email, $user_id]);

   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = './admin/uploaded_img/'.$image;
   $old_image = $_POST['old_image'];

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'Ảnh có kích thước quá lớn!';
      }else{
         $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $user_id]);
         if($update_image){
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('./admin/uploaded_img/'.$old_image);
            echo '
                <div class="d-flex align-items-center border border-success mb-4 " style="padding: 15px;">
                    <h3 class="fa-solid fa-check text-success mr-3"></h3>
                    <h5 class="font-weight-semi-bold m-0">Cập nhật ảnh đại diện thành công</h5>
                    <i class="fas fa-times ml-auto " style="font-size: 1.5rem;" onclick="this.parentElement.remove();"></i>
                </div>';
         };
      };
   };

   $old_pass = $_POST['old_pass'];
   $update_pass = md5($_POST['update_pass']);
   $new_pass = md5($_POST['new_pass']);
   $confirm_pass = md5($_POST['confirm_pass']);

   if(!empty($update_pass) AND !empty($new_pass) AND !empty($confirm_pass)){
      if($update_pass != $old_pass){
        echo '
            <div class="d-flex align-items-center border border-warning mb-4 " style="padding: 15px;">
                <h3 class="fa-solid fa-triangle-exclamation text-warning mr-3"></h3>
                <h5 class="font-weight-semi-bold m-0">Mật khẩu cũ không chính xác!</h5>
                <i class="fas fa-times ml-auto text-danger " style="font-size: 1.5rem;" onclick="this.parentElement.remove();"></i>
            </div>';
      }elseif($new_pass != $confirm_pass){
        echo '
        <div class="d-flex align-items-center border border-warning mb-4 " style="padding: 15px;">
            <h3 class="fa-solid fa-triangle-exclamation text-warning mr-3"></h3>
            <h5 class="font-weight-semi-bold m-0">Xác nhận mật khẩu không đúng!</h5>
            <i class="fas fa-times ml-auto text-danger " style="font-size: 1.5rem;" onclick="this.parentElement.remove();"></i>
        </div>';
      }else{
         $update_pass_query = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
         $update_pass_query->execute([$confirm_pass, $user_id]);
        echo '
            <div class="d-flex align-items-center border border-success mb-4 " style="padding: 15px;">
                <h3 class="fa-solid fa-check text-success mr-3"></h3>
                <h5 class="font-weight-semi-bold m-0">Cập nhật mật khấu thành công</h5>
                <i class="fas fa-times ml-auto " style="font-size: 1.5rem;" onclick="this.parentElement.remove();"></i>
            </div>';
      }
   }

}

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
    <?php include 'header.php'; ?>
    <!-- Topbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 120px">
            <!-- <img src="img/avt20.png" style="height: 14rem; margin-top: 1rem;"  alt=""> -->
            <h1 class="font-weight-semi-bold text-uppercase mt-3">Cập nhật thông tin</h1>
            <div class="d-inline-flex mb-3">
                <p class="m-0"><a href="home.php">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Cập nhật thông tin</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Update Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-2 table-responsive"></div>
            <div class="col-lg-8 table-responsive">
                <div class="">
                    <form class="row px-xl-4 border" method="POST" enctype="multipart/form-data">
                        <div class="col-md-12 form-group update">
                           <img class="" src="./admin/uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Họ và tên</label>
                            <input class="form-control" name="name" type="text" placeholder="Cập nhật tên" value="<?= $fetch_profile['name']; ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <input type="hidden" name="old_pass" value="<?= $fetch_profile['password']; ?>">
                            <label>Mật khẩu cũ</label>
                            <input class="form-control" name="update_pass" type="password" placeholder="Nhập mật khẩu cũ">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input class="form-control" name="email" type="email" placeholder="Cập nhật email" value="<?= $fetch_profile['email']; ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mật khẩu mới</label>
                            <input class="form-control" name="new_pass" type="password" placeholder="Nhập mật khẩu mới">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Ảnh đại diện</label>
                            <input class="form-control" name="image" accept="image/jpg, image/jpeg, image/png" type="file" placeholder="Chọn ảnh đại diện">
                            <input type="hidden" name="old_image" value="<?= $fetch_profile['image']; ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Xác nhận mật khẩu mới</label>
                            <input class="form-control" name="confirm_pass" type="password" placeholder="Nhập lại mật khẩu mới">
                        </div>
                        <div class="col-md-6 form-group">
                            <input type="submit" class="btn btn-block btn-warning my-3 border" value="Cập nhật" name="update_profile">
                        </div>
                        <div class="col-md-6 form-group">
                            <a href="home.php" type="button" class="btn btn-block btn-secondary my-3 border">Quay lại</a>
                        </div>
                    </form>
                </div>
                <div class="row px-xl-5">
                </div>
            </div>
            <div class="col-lg-2 table-responsive mb-5"></div>
        </div>
    </div>
    <!-- Update End -->

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
    <!-- <script src="./js/main.js"></script> -->
</body>

</html>