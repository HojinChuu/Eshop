<?php require APPROOT . "/views/default/header.php"; ?>

    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Products</h1>
        </div>
    </div>

<?php flash("login_success") ?>
<?php flash("logout_success") ?>

    <div class="row mb-4">
        <?php foreach ($data["products"] as $product) : ?>
            <div class="col-md-4 zoom">
                <div class="card card-body">
                    <img class="card-img-top" src="<?= URLROOT ?>/<?= $product->image_path ?>" alt="Card image cap" width="100%" height="250">
                    <h5 class="card-title mt-3"><?= $product->name; ?></h5>
                    <p class="card-text text-muted">残り <?= $product->stock ?> </p>
                    <div class="card-footer text-muted row align-item-center">
                        <div class="col">
                            <a href="<?= URLROOT ?>/products/show/<?= $product->id ?>" class="btn btn-info btn-lg">MORE</a>
                        </div>
                        <div class="col align-self-center">
                            <h5 class="card-text text-center">￥ <?= number_format($product->price, -2) ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php require APPROOT . "/views/default/footer.php"; ?>