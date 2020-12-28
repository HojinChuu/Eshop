<?php require APPROOT . "/views/default/header.php"; ?>

<div class="row mt-5">
    <a href="<?= URLROOT ?>/" class="btn btn btn-dark mb-4 mr-4">BACK</a>
    <h1>Wish List</h1>
</div>

<?php if (isset($data["wishlist"]) && count($data["wishlist"]) !== 0) : ?>

    <div class="table-responsive mt-5" style="overflow: hidden;">
        <table class="table table-hover table-bordered">

            <thead class="thead-light text-center">
            <th>Product</th>
            <th>Price</th>
            <th>Action</th>
            </thead>

            <tbody>
            <?php if (isset($data["wishlist"])) : ?>
                <?php foreach ($data["wishlist"] as $key => $wishlist) : ?>

                    <tr class="text-center" onclick="window.location='<?= URLROOT ?>/products/show/<?= $wishlist->product_id ?>'" style="cursor: pointer;">
                        <td>
                            <img src="<?= URLROOT ?>/<?= $wishlist->image_path ?>" width="100px" height="80px" class="mr-4">
                            <strong><?= $wishlist->name ?></strong>
                        </td>
                        <td>￥ <?= number_format($wishlist->price, -2) ?></td>
                        <td>
                            <form action="<?= URLROOT ?>/wishlists/destroy/<?= $wishlist->id ?>" method="post">
                                <input type="submit" value="Delete" class="btn btn-outline-danger btn-block" />
                            </form>
                        </td>
                    </tr>

                <?php endforeach ?>
            <?php endif ?>
            </tbody>
        </table>
    </div>

<?php else : ?>
    <div class="row justify-content-center">
        <h3 style="margin-top: 200px;">Nothing Wish List Item...</h3>
    </div>
<?php endif ?>

<?php require APPROOT . "/views/default/footer.php"; ?>
