<!-- Topbar Start -->
<div class="container-fluid">
    <div class="row align-items-center py-3 px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a href="" class="text-decoration-none">
                <h1 class="m-0 display-5 font-weight-bolder"><span class="text-primary font-weight-bold border px-3 mr-1">T</span>Chow</h1>
            </a>
        </div>
        <nav class="col-lg-6 col-6 navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
            <a href="" class="text-decoration-none d-block d-lg-none">
                <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">T</span>Chow</h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav mr-auto py-0">
                    <a href="home.php" class="nav-item nav-link active">Trang chủ</a>
                    <a href="shop.php" class="nav-item nav-link">Sản phẩm</a>
                    <a href="order.php" class="nav-item nav-link">Đơn hàng</a>
                    <a href="about.php" class="nav-item nav-link">Về chúng tôi</a>
                    <a href="contact.php" class="nav-item nav-link">Liên hệ</a>
                </div>
            </div>
            <a href="search_page.php"><i class="fas fa-search"></i> </a>
        </nav>

        <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_items->execute([$user_id]);
        ?>

        <div class="col-lg-3 col-6 text-right">
            <a href="wishlist.php" class="btn border">
                <i class="fas fa-heart text-primary"></i>
                <span class="badge"><?= $count_wishlist_items->rowCount(); ?></span>
            </a>
            <a href="cart.php" class="btn border">
                <i class="fas fa-shopping-cart text-primary"></i>
                <span class="badge"><?= $count_cart_items->rowCount(); ?></span>
            </a>
            <a class="btn border" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                <i class="fas fa-user text-primary"></i>
            </a>
            <div class="row">

            <?php
                $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                $select_profile->execute([$user_id]);
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>

                <div class="col">
                    <div class="collapse multi-collapse" id="multiCollapseExample1">
                        <div class="card card-body rounded" style="position: fixed; z-index: 2; top: 4rem; right: 3rem;">

                            <img src="./admin/uploaded_img/<?= $fetch_profile['image']; ?>" class="rounded-circle" style="width: 10rem;" alt="">
                            <p class="text-center mt-1 mb-0 font-weight-bold"><?= $fetch_profile['name']; ?></p>
                            <a href="user_profile_update.php" class="btn font-weight-bold bg-light">Cập nhật hồ sơ</a>
                            <a href="logout.php" class="delete-btn font-weight-bold">Đăng xuất</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->