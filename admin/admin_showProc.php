<?php

@include '../config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){

    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $details = $_POST['details'];
 
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/'.$image;
 
    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $select_products->execute([$name]);
 
    if($select_products->rowCount() > 0){
       echo '<script>alert("Sản phẩm đã tồn tại");</script>';
    }else{
 
       $insert_products = $conn->prepare("INSERT INTO `products`(name, category, details, price, image) VALUES(?,?,?,?,?)");
       $insert_products->execute([$name, $category, $details, $price, $image]);
 
       if($insert_products){
          if($image_size > 2000000){
             $message[] = 'Kích thước ảnh quá lớn!';
          }else{
             move_uploaded_file($image_tmp_name, $image_folder);
            //  $message[] = 'new product added!';
          }
 
       }
 
    }
 
 };

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete_image = $conn->prepare("SELECT image FROM `products` WHERE id = ?");
   $select_delete_image->execute([$delete_id]);
   $fetch_delete_image = $select_delete_image->fetch(PDO::FETCH_ASSOC);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   $delete_products = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_products->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
   $delete_wishlist->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   header('location:admin_showProc.php');


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

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#staticBackdrop">
                        Thêm sản phẩm
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    
                    
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Thêm sản phẩm</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                           
                            <form  method="POST" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputText4">Tên sản phẩm</label>
                                        <input type="text" name="name" class="form-control" id="inputText4" placeholder="Nhập tên sản phẩm">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputNumber4">Giá</label>
                                        <input type="number" min="0" name="price" class="form-control" id="inputNumber4">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputText4">Loại sản phẩm</label> <br>
                                        <select name="category" class="form-control box" required>
                                            <option value="" selected disabled>Chọn loại</option>
                                            <option value="banhquy">Bánh quy</option>
                                            <option value="keo">Kẹo</option>
                                            <option value="snack">Snack</option>
                                            <option value="saykho">Đồ sấy khô</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputNumber4">Ảnh sản phẩm</label> 
                                        <input type="file" name="image" class="form-control border-0" id="inputNumber4" accept="image/jpg, image/jpeg, image/png">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress">Mô tả</label>
                                    <textarea class="form-control" name="details" id="inputAddress" cols="10" rows="3"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    <input type="submit" class="btn btn-success" value="Thêm" name="add_product">
                                </div>
                            </form>

                        </div>

                        </div>
                    </div>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên SP</th>
                                            <th>Loại</th>
                                            <th>Mô tả</th>
                                            <th>Giá</th>
                                            <th>Hình ảnh</th>
                                            <th>Hiệu chỉnh</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                        $show_products = $conn->prepare("SELECT * FROM `products`");
                                        $show_products->execute();
                                        if($show_products->rowCount() > 0){
                                            while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
                                    ?>
                                        <tr>
                                            <td><?= $fetch_products['id']; ?></td>
                                            <td><?= $fetch_products['name']; ?></td>
                                            <td><?= $fetch_products['category']; ?></td>
                                            <td><?= $fetch_products['details']; ?></td>
                                            <td><?= $fetch_products['price']; ?></td>
                                            <td><img style="width: 6rem;" src="./uploaded_img/<?= $fetch_products['image']; ?>" alt=""></td>
                                            <td class="flex-btn">
                                                <a href="admin_update_product.php?update=<?= $fetch_products['id']; ?>" 
                                                    style=" margin-left: 7px;
                                                        font-weight: 700;
                                                        color: #27ae60;
                                                        text-decoration:none;">Cập nhật</a>  <br>
                                                <a href="admin_showProc.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?');" 
                                                    style=" margin-left: 7px;
                                                        font-weight: 700;
                                                        color: #e74a3b;
                                                        text-decoration:none;
                                                        line-height: 40px;">Xóa</a>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        }else{
                                            echo '<p class="empty">Chưa có sản phẩm!</p>';
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