<?php require APPROOT . "/views/default/header.php"; ?>

    <h1 class="text-center mt-5">Admin</h1>
    <div class="row mb-12 align-items-center justify-content-around" style="height: 60vh;">

        <div class="col-md-3">
            <a href="<?= URLROOT ?>/products/adminProductPage">
                <div class="card border-0">
                    <img class="card-img-top" height="50%" src="<?= URLROOT ?>/img/product.png" />
                    <div class="card-body text-center">
                        <p class="card-text">PRODUCTS</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="<?= URLROOT ?>/orders/adminOrderPage">
                <div class="card border-0">
                    <img class="card-img-top" height="50%" src="<?= URLROOT ?>/img/order.png" />
                    <div class="card-body text-center">
                        <p class="card-text">ORDERS</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="<?= URLROOT ?>/users/adminUserPage">
                <div class="card border-0">
                    <img class="card-img-top" height="50%" src="<?= URLROOT ?>/img/user.png" />
                    <div class="card-body text-center">
                        <p class="card-text">USERS</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="<?= URLROOT ?>/logs/adminLogPage">
                <div class="card border-0">
                    <img class="card-img-top" height="50%" src="<?= URLROOT ?>/img/analyze.png" />
                    <div class="card-body text-center">
                        <p class="card-text">ANALYZE</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

<?php require APPROOT . "/views/default/footer.php"; ?>