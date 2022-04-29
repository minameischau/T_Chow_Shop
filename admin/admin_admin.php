<?php

@include '../config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_admin'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = md5($_POST['pass']);
 
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/'.$image;
 
    $select_admins = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_admins->execute([$email]);
 
    if($select_admins->rowCount() > 0){
        echo '<script type="text/javascript">alert(`Email đã tồn tại`)</script>';
    }else{
       $insert_admins = $conn->prepare("INSERT INTO `users`(name, email, password, user_type , image) VALUES(?,?,?,'admin',?)");
       $insert_admins->execute([$name, $email, $pass, $image]);
 
       if($insert_admins){
          if($image_size > 2000000){
             $message[] = 'Kích thước ảnh quá lớn!';
          }else{
             move_uploaded_file($image_tmp_name, $image_folder);
             header('location:admin_admin.php');
          }
 
       }
 
    }
 
 };


if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
    $delete_users->execute([$delete_id]);
    header('location:admin_admin.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="./assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="./assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body id="page-top">
    <div id="wrapper">

        <?php include 'admin_sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'admin_nav.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#staticBackdrop">
                        Thêm admin
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title font-weight-bold text-dark" id="staticBackdropLabel">Thêm admin</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            
                                <form  method="POST" enctype="multipart/form-data">
                                    <div class="form-row mb-3">
                                        <label class="ml-3  font-weight-bold" for="inputText4">Họ tên </label>
                                        <input type="text" name="name" class="form-control" id="inputText4" placeholder="Nhập họ tên">
                                    </div>
                                    <div class="form-row mb-3">
                                        <label class="ml-3  font-weight-bold" for="inputText4">Email</label>
                                        <input type="email" name="email" class="form-control" id="inputText4" placeholder="Nhập email admin">
                                    </div>
                                    <div class="form-row mb-3">
                                        <label class="ml-3  font-weight-bold" for="inputAddress">Password</label>
                                        <input type="password" name="pass" class="form-control" id="inputText4" placeholder="Nhập mật khẩu">
                                    </div>
                                    <div class="form-row mb-3">
                                        <label class="ml-3  font-weight-bold" for="inputNumber4">Ảnh đại diện</label> 
                                        <input type="file" name="image" class="form-control border-0" id="inputNumber4" accept="image/jpg, image/jpeg, image/png">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Đóng</button>
                                        <input type="submit" class="btn btn-primary rounded-pill" value="Thêm" name="add_admin">
                                    </div>

                                </form>

                            </div>

                            </div>
                        </div>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Danh sách tài khoản admin</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Ảnh đại diện</th>
                                            <th>Tên người dùng</th>
                                            <th>Email</th>
                                            <th>Hiệu chỉnh</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                        $select_users = $conn->prepare("SELECT * FROM `users`");
                                        $select_users->execute();
                                        while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                        <tr style="<?php if($fetch_users['user_type'] != 'admin'){ echo 'display:none'; }; ?>">
                                            <td><?= $fetch_users['id']; ?></td>
                                            <td><img style="width: 6rem;" src="uploaded_img/<?= $fetch_users['image']; ?>" alt=""></td>
                                            <td><?= $fetch_users['name']; ?></td>
                                            <td><?= $fetch_users['email']; ?></td>
                                            <td class="flex-btn">
                                            <a href="admin_admin.php?delete=<?= $fetch_users['id']; ?>" onclick="return confirm('Bạn chắc chắn muốn xóa admin này?');" class="delete-btn"
                                                style=" font-weight:700;
                                                        border-radius: 20px;
                                                        color: #e74a3b;
                                                        text-decoration:none;"
                                                >Xóa</a>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        ?>    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include 'admin_footer.php'; ?>
            <!-- End of Footer -->

        </div>
    </div>
    
    <?php include 'admin_logoutModal.php'; ?>

    <!-- Bootstrap core JavaScript-->
    <script src="./assets/vendor/jquery/jquery.min.js"></script>
    <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="./assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="./assets/js/sb-admin-2.min.js"></script>
</body>
</html>