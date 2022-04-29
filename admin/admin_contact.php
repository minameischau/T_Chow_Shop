<?php

@include '../config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `message` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:admin_contact.php');

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

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Danh sách tin nhắn</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên người dùng</th>
                                            <th>SĐT</th>
                                            <th>Email</th>
                                            <th>Tin nhắn</th>
                                            <th>Tùy chọn</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                        $select_message = $conn->prepare("SELECT * FROM `message`");
                                        $select_message->execute();
                                        if($select_message->rowCount() > 0){
                                            while($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                        <tr>
                                            <td><?= $fetch_message['user_id']; ?></td>
                                            <td><?= $fetch_message['name']; ?></td>
                                            <td><?= $fetch_message['number']; ?></td>
                                            <td><?= $fetch_message['email']; ?></td>
                                            <td><?= $fetch_message['message']; ?></td>
                                            <td class="flex-btn">
                                                <a href="admin_contact.php?delete=<?= $fetch_message['id']; ?>" onclick="return confirm('Bạn chắc chắn muốn xóa tin nhắn này?');" class="delete-btn"
                                                style=" font-weight:700;
                                                        border-radius: 20px;
                                                        color: #e74a3b;
                                                        text-decoration:none;"
                                                >Xóa</a>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                    }else{
                                        echo '<p class="empty">Chưa có tin nhắn</p>';
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