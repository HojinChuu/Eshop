<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <div class="container">
        <a class="navbar-brand" href="<?= URLROOT ?>/"><?= SITENAME ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">

            <!-- NAV LEFT -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= URLROOT; ?>/orders/index">CART
                        ( <?= isset($_SESSION["cart"]) ? count($_SESSION["cart"]) : "0" ?> )</a>
                </li>

                <?php if (isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URLROOT; ?>/wishlists/index">WISH LIST</a>
                    </li>
                <?php endif ?>

                <?php if (isset($_SESSION["user_isAdmin"]) && $_SESSION["user_isAdmin"] == 1) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URLROOT; ?>/users/admin">ADMIN</a>
                    </li>
                <?php endif ?>
            </ul>

            <!-- NAV RIGHT -->
            <ul class="navbar-nav ml-auto">

                <?php if (isset($_SESSION["user_id"])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URLROOT; ?>/users/mypage"><strong>MY PAGE</strong></a>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link btn btn-sm" data-toggle="modal" data-target="#exampleModal">
                            SIGN OUT
                        </button>
                    </li>

                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URLROOT; ?>/users/login">LOGIN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URLROOT; ?>/users/register">SIGN UP</a>
                    </li>
                <?php endif ?>

            </ul>
        </div>
    </div>
</nav>
<?php require APPROOT . "/views/users/logoutModal.php"; ?>
