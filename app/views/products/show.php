<?php require APPROOT . "/views/default/header.php"; ?>

<div class="d-flex flex-wrap flex-md-nowrap  pt-3 pb-2 mb-3 border-bottom">
    <div class="row">
        <a href="<?= URLROOT ?>/" class="btn btn-sm btn-dark mr-4">BACK</a>
        <h1 class="h2">Show</h1>
    </div>
</div>

<div class="card text-center" style="width: 50rem; margin: auto;">
    <div class="card-body">
        <img src="<?= URLROOT ?>/<?= $data['product']->image_path ?>" width="75%" height="500" />
    </div>
    <form action="<?= URLROOT ?>/products/addToCart/<?= $data['product']->id ?>" method="post">
        <div class="card-title">
            <input type="number" name="quantity" min="1" value="1" class="form-control" style="width: 200px; margin: auto;" required />
            <input type="hidden" name="hidden_price" value="<?= $data['product']->price ?>" />
            <input type="hidden" name="hidden_name" value="<?= $data['product']->name ?>" />
            <input type="hidden" name="hidden_image" value="<?= $data['product']->image_path ?>" />
            <p class="mt-3">Price : ￥ <?= number_format($data["product"]->price, -2) ?></p>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION["user_id"])) : ?>
                <a href="<?= URLROOT ?>/wishlists/addToList/<?= $data['product']->id ?>" class="btn btn-outline-success btn-lg">Add to WishList</a>
            <?php endif ?>
            <button type="submit" name="add_to_cart" class="btn btn-lg btn-success" <?= $data["product"]->stock > 0 ? "" : "disabled" ?>><?= $data["product"]->stock > 0 ? "かごに入れる" : "SOLD OUT" ?></button>
        </div>
    </form>
</div>

<?php require APPROOT . "/views/default/footer.php"; ?>