<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $email = $_POST['email'];
   $number = $_POST['number'];
   $msg = $_POST['msg'];

   $select_message = $conn->prepare("SELECT * FROM `message` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
    echo '
    <div class="d-flex align-items-center border border-warning mb-4 " style="padding: 15px;">
        <h3 class="fa-solid fa-triangle-exclamation text-warning mr-3"></h3>
        <h5 class="font-weight-semi-bold m-0">Tin nhắn đã tồn tại</h5>
        <i class="fas fa-times ml-auto text-danger " style="font-size: 1.5rem;" onclick="this.parentElement.remove();"></i>
    </div>';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `message`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);
    echo '
    <div class="d-flex align-items-center border border-success mb-4 " style="padding: 15px;">
        <h3 class="fa-solid fa-check text-success mr-3"></h3>
        <h5 class="font-weight-semi-bold m-0">Tin nhắn được gửi thành công</h5>
        <i class="fas fa-times ml-auto " style="font-size: 1.5rem;" onclick="this.parentElement.remove();"></i>
    </div>';

   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Liên hệ</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="T Chow" name="keywords">
    <meta content="T Chow" name="description">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/icon" href="./img/favicon.ico"/>

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
            <h1 class="font-weight-semi-bold text-uppercase mt-3">Liên hệ</h1>
            <div class="d-inline-flex mb-3">
                <p class="m-0"><a href="home.php">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Liên hệ</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Contact Start -->
    <div class="container-fluid pt-4">
        <div class="text-center mb-5">
            <h2 class="section-title px-5"><span class="px-2">Liên hệ với chúng tôi</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-7 mb-5">
                <div class="contact-form">
                    <form  id="contactForm" novalidate="novalidate" action="" method="POST">
                        <div class="control-group">
                            <input name="name" type="text" class="form-control" placeholder="Tên của bạn"/>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input name="email" type="email" class="form-control" placeholder="Email"/>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input name="number" type="number" min="0" class="form-control" placeholder="Số điện thoại"/>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <textarea name="msg" class="form-control" rows="6" placeholder="Nội dung"></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div>
                            <button name="send" class="btn btn-primary py-2 px-4 border" type="submit" id="sendMessageButton">Gửi tin nhắn</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5 mb-5">
                <h5 class="font-weight-bold mb-3">Liên hệ với chúng tôi</h5>
                <p>Chúng tôi rất vui lòng khi nhận được phản hồi từ bạn.</p>
                <div class="d-flex flex-column mb-3">
                    <h5 class="font-weight-bold mb-3">Cửa hàng 1</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Vị Thanh, Hậu Giang</p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>chaub1910192@student.ctu.edu.vn</p>
                    <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>012 345 67890</p>
                </div>
                <div class="d-flex flex-column">
                    <h5 class="font-weight-bold mb-3">Cửa hàng 2</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Lai Vung, Đồng Tháp</p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>truongb1910325@student.ctu.edu.vn</p>
                    <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>012 345 67890</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <!-- Footer Start -->
    <?php include 'footer.php'; ?>
    <!-- Footer End -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
    <script src="./mail/contact.js"></script>
    <script src="./js/main.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="./lib/easing/easing.min.js"></script>
    <script src="./lib/owlcarousel/owl.carousel.min.js"></script>
</body>
</html>