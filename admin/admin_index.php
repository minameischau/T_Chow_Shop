<?php

@include '../config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Thống kê</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Doanh thu Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                        <?php
                            $total_completed = 0;
                            $select_completed = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                            $select_completed->execute(['completed']);
                            while($fetch_completed = $select_completed->fetch(PDO::FETCH_ASSOC)){
                                $total_completed += $fetch_completed['total_price'];
                            };
                        ?>
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Doanh thu</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_completed; ?> đồng</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Đơn đã đặt Example -->
                        <div class="col-xl-3 col-md-6 mb-4">

                        <?php
                            $select_orders = $conn->prepare("SELECT * FROM `orders`");
                            $select_orders->execute();
                            $number_of_orders = $select_orders->rowCount();
                        ?>
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Tổng đơn đã đặt
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $number_of_orders; ?></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Chờ xử lý Example -->
                        <div class="col-xl-3 col-md-6 mb-4">

                        <?php
                            $total_pendings = 0;
                            $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                            $select_pendings->execute(['pending']);
                            while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                                $total_pendings += 1;
                            };
                        ?>
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Tổng đơn chờ xử lý</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_pendings; ?> đơn</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tổng tin nhắn Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">

                        <?php
                            $select_messages = $conn->prepare("SELECT * FROM `message`");
                            $select_messages->execute();
                            $number_of_messages = $select_messages->rowCount();
                        ?>
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Tổng số tin nhắn</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?= $number_of_messages; ?> 
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tống tài người dùng Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                        <?php
                            $select_users = $conn->prepare("SELECT * FROM `users` WHERE user_type = ?");
                            $select_users->execute(['user']);
                            $number_of_users = $select_users->rowCount();
                        ?>
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Tổng số người dùng</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $number_of_users; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tống tài admin Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                        <?php
                            $select_users = $conn->prepare("SELECT * FROM `users` WHERE user_type = ?");
                            $select_users->execute(['admin']);
                            $number_of_users = $select_users->rowCount();
                        ?>
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Tổng số admin</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $number_of_users; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tống sản phẩm đã thêm Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                        <?php
                            $select_products = $conn->prepare("SELECT * FROM `products`");
                            $select_products->execute();
                            $number_of_products = $select_products->rowCount();
                        ?>
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Tổng sản phẩm đã thêm</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $number_of_products; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-cart-plus fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
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