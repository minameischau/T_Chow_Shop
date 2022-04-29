<?php

@include '../config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_order'])){

    $order_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    $update_orders = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $update_orders->execute([$update_payment, $order_id]);
    echo '<script>alert("Trạng thái đã được cập nhật!");</script>';

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_orders->execute([$delete_id]);
   header('location:admin_order.php');

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
                            <h6 class="m-0 font-weight-bold text-primary">Danh sách đơn hàng</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID người dùng</th>
                                            <th>Thời gian</th>
                                            <th>Tên KH</th>
                                            <th>Email</th>
                                            <th>SĐT</th>
                                            <th>Địa chỉ</th>
                                            <th>Đơn hàng</th>
                                            <th>Tổng</th>
                                            <th>Phương thức</th>
                                            <th>Trạng thái</th>
                                            <th>Hiệu chỉnh</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                        $select_orders = $conn->prepare("SELECT * FROM `orders`");
                                        $select_orders->execute();
                                        if($select_orders->rowCount() > 0){
                                            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                        <tr>
                                            <td><?= $fetch_orders['user_id']; ?></td>
                                            <td><?= $fetch_orders['placed_on']; ?></td>
                                            <td><?= $fetch_orders['name']; ?></td>
                                            <td><?= $fetch_orders['email']; ?></td>
                                            <td><?= $fetch_orders['number']; ?></td>
                                            <td><?= $fetch_orders['address']; ?></td>
                                            <td><?= $fetch_orders['total_products']; ?></td>
                                            <td><?= $fetch_orders['total_price']; ?></td>
                                            <td><?= $fetch_orders['method']; ?></td>
                                            <td>
                                            <form action="" method="POST">
                                                <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                                                <select name="update_payment" class="drop-down">
                                                    <option value="pending" selected disabled><?= $fetch_orders['payment_status']; ?></option>
                                                    <option value="completed">completed</option>
                                                </select>
                                            
                                            </td>
                                            <td>
                                                <div class="flex-btn">
                                                <input type="submit" name="update_order" class="option-btn" value="Cập nhật"
                                                style=" border: none;
                                                        background: #fff;
                                                        font-weight: 700;
                                                        color: #27ae60;
                                                        text-decoration:none;">
                                                <a href="admin_order.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Bạn chắc chắn muốn xóa đơn hàng này?');"
                                                    style=" margin-left: 7px;
                                                        font-weight: 700;
                                                        color: #e74a3b;
                                                        text-decoration:none;
                                                        line-height: 40px;">Xóa</a>
                                                </div>
                                            </td>
                                            </form>
                                        </tr>
                                    <?php
                                        }
                                    }else{
                                        echo '<p class="empty">Chưa có đơn hàng!</p>';
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