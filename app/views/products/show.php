<?php require APPROOT . "/views/default/header.php"; ?>

<div class="d-flex flex-wrap flex-md-nowrap  pt-3 pb-2 mb-3 border-bottom">
    <div class="row">
        <a href="<?= URLROOT ?>/" class="btn btn-sm btn-dark mr-4">BACK</a>
        <h1 class="h2">Show</h1>
    </div>
</div>

<?php flash("comment_error") ?>
<?php flash("comment_destroy_success") ?>

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
            <div class="mt-3 text-center">説明</div>
            <p><?= $data["product"]->description ?></p>
            <p class="mt-3">Price : ￥ <?= number_format($data["product"]->price, -2) ?></p>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION["user_id"])) : ?>
                <a href="<?= URLROOT ?>/wishlists/addToList/<?= $data['product']->id ?>" class="btn btn-outline-success btn-lg">Add to WishList</a>
            <?php endif ?>
            <button type="submit" name="add_to_cart" class="btn btn-lg btn-success" <?= $data["product"]->stock > 0 ? "" : "disabled" ?>><?= $data["product"]->stock > 0 ? "かごに入れる" : "SOLD OUT" ?></button>
        </div>
    </form>
    <small class="text-left pl-3">Review <?= count($data["comment"]) ?></small>
</div>

<?php if (isLoggedIn()) : ?>
    <div class="card mt-3" style="width: 50rem; margin: auto;">
        <form class="row" action="<?= URLROOT ?>/products/createComment/<?= $data['product']->id ?>" method="post">
            <div class="col-10" style="padding-right: 0;">
                <textarea class="form-control" name="reply" placeholder="comment.." required></textarea>
            </div>
            <div class="col-2" style="margin: 0; padding-left: 0;">
                <input type="submit" class="btn btn-lg btn-dark form-control" value="Submit" style=" height: 60px" />
            </div>
        </form>
    </div>
<?php endif ?>

<?php if (isset($data["comment"]) && !empty($data["comment"])) : ?>
    <div class="container mt-4 mb-5" style="width: 50rem; margin: auto;">
        <?php foreach ($data["comment"] as $comment) : ?>
            <div class="row justify-content-between">
                <div class="col-9 row">
                    <div>
                        <span class="row">
                            <h5 class="ml-3"><?= $comment->user->name ?></h5>
                            <small class="ml-4" style="line-height: 2.7; color: darkgray;"><?= $comment->created_at ?></small>
                        </span>
                        <p class="mt-3"><?= $comment->reply ?></p>
                    </div>
                </div>
                <?php if (isset($_SESSION["user_id"]) && $comment->user_id == $_SESSION["user_id"]) : ?>
                    <div class="col-3 text-right" style="line-height: 5">
                        <form action="<?= URLROOT ?>/products/destroyComment/<?= $comment->id ?>/<?= $data['product']->id ?>" method="post">
                            <button type="submit" class="btn btn-outline-danger">Delete</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
            <hr>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <div class="container mt-4 mb-5" style="width: 50rem; margin: auto;">
        <p>Nothing...</p>
    </div>
<?php endif; ?>

<?php require APPROOT . "/views/default/footer.php"; ?>
