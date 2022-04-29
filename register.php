<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $email = $_POST['email'];
   $pass = md5($_POST['pass']);
   $cpass = md5($_POST['cpass']);

   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = './admin/uploaded_img/'.$image;

   $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select->execute([$email]);

   if($select->rowCount() > 0){
      echo '<script type="text/javascript">alert(`Email đã tồn tại`)</script>';
   }else{
      if($pass != $cpass){
         $message[] = 'Mật khẩu nhập lại không đúng!';
      }else{
         $insert = $conn->prepare("INSERT INTO `users`(name, email, password, image) VALUES(?,?,?,?)");
         $insert->execute([$name, $email, $pass, $image]);

         if($insert){
            if($image_size > 2000000){
               $message[] = 'Ảnh có kích thước quá lớn!';
            }else{
               move_uploaded_file($image_tmp_name, $image_folder);
               $message[] = 'Đăng ký thành công!';
               header('location:login.php');
            }
         }

      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Đăng ký</title>

    <!-- Custom fonts for this template-->
    <link href="./admin/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="./admin/assets/css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-5">Tạo tài khoản</h1>
                            </div>
                            <form id="signupForm" class="user" action="" enctype="multipart/form-data" method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Họ tên" name="name">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Email" name="email">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            id="pass" placeholder="Nhập mật khẩu" name="pass">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="Nhập lại mật khẩu" name="cpass">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="file" class="form-control form-control-user" style="padding:0.5rem 1rem; height:43px;" required accept="image/jpg, image/jpeg, image/png"
                                        placeholder="Chọn ảnh đại diện" name="image">
                                </div>
                                
                                <button type="submit" name="submit" class="btn btn-primary btn-user btn-block btn-login" style="width:50%; margin: auto; ">
                                    Đăng ký
                                </button>
                                <hr>
                                <a href="index.html" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Đăng nhập bằng Google
                                </a>
                                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Đăng nhập bằng Facebook
                                </a>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="medium" href="./login.php">Đã có tài khoản? Đăng nhập</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="./admin/assets/vendor/jquery/jquery.min.js"></script>
    <script src="./admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="./admin/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="./js/jquery.validate.js"></script>
    <script type="text/javascript">
		$(document).ready(function(){
			$("#signupForm").validate({
				rules: {
					name: "required",
                    email: {required: true, email: true},
					pass: {required: true, minlength: 3},
					cpass: {required: true, minlength: 3, equalTo: "#pass"}
				},
				messages: {
                    name: "Bạn chưa nhập vào tên của bạn",
					email: "Hộp thư điện tử không hợp lệ",
					pass: {
						required: "Bạn chưa nhập mật khẩu",
						minlength: "Mật khẩu phải có ít nhất 3 ký tự"
					},
					cpass: {
						required: "Bạn chưa nhập mật khẩu",
						minlength: "Mật khẩu phải có ít nhất 3 ký tự",
						equalTo: "Mật khẩu không khớp"
					},
                    image: {
                        required: "Chưa chọn ảnh đại diện"
                    }
				},
				errorElement: "div",
				errorPlacement: function(error, element) {
					error.addClass("invalid-feedback");
					error.insertBefore(element);
				},
				highlight: function(element, errorClass, validClass) {
					$(element).addClass("is-invalid").removeClass("is-valid");
				},
				unhighlight: function(element, errorClass, validClass) {
					$(element).addClass("is-valid").removeClass("is-invalid");
				}
			});
		});
	</script>

</body>

</html>