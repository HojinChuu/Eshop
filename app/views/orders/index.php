<?php require APPROOT . "/views/default/header.php"; ?>

<div class="row mt-5">
    <a href="<?= URLROOT ?>/" class="btn btn btn-dark mb-4 mr-4">BACK</a>
    <h1>Cart</h1>
</div>

<?php if (isset($data["cart"]) && count($data["cart"]) !== 0) : ?>

    <div class="text-center mt-4 row justify-content-center">
        <a href="<?= URLROOT ?>/orders/checkout" class="btn btn-success btn-lg btn-block" style="width: 300px">Check Out</a>
    </div>

    <div class="mt-4">
        <?php flash("money_error") ?>
        <?php flash("stock_error") ?>
    </div>

    <div class="table-responsive mt-5" style="overflow: hidden;">
        <table class="table table-hover table-bordered">

            <thead class="thead-light text-center">
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Action</th>
            </thead>

            <tbody>
                <?php $total = 0 ?>
                <?php if (isset($data["cart"])) : ?>
                    <?php foreach ($data["cart"] as $key => $cartItem) : ?>
                        <?php $quantity = $data["quantity"][$key]["quantity"] ?>
                        <tr class="text-center">
                            <td>
                                <img src="<?= URLROOT ?>/<?= $cartItem->image_path ?>" width="100px" height="80px" class="mr-4">
                                <strong><?= $cartItem->name ?></strong>
                            </td>
                            <td>
                                <form action="<?= URLROOT ?>/orders/update/<?= $cartItem->id ?>" method="post">
                                    <input type="number" name="quantity" class="pb-1" min="1" value="<?= $quantity ?>" style="width:50px;" />
                                    <input type="submit" class="btn btn-sm btn-dark" value="Update" />
                                </form>
                            </td>
                            <td>￥ <?= number_format($cartItem->price, -2) ?></td>
                            <td>￥ <?= number_format($quantity * $cartItem->price, -2) ?></td>
                            <td>
                                <form action="<?= URLROOT ?>/orders/destroy/<?= $cartItem->id ?>" method="post">
                                    <input type="submit" value="Delete" class="btn btn-outline-danger btn-block" />
                                </form>
                            </td>
                        </tr>
                        <?php $total = $total + ($quantity * $cartItem->price) ?>
                    <?php endforeach ?>
                    <div class="row justify-content-around">
                        <h4 class="text-center">
                            Total Count :
                            <strong><?= isset($data["cart"]) ? count($data["cart"]) : "0" ?></strong>
                        </h4>
                        <h4 class="text-right mb-4">総額 : ￥ <strong><?= number_format($total, -2) ?></strong></h4>
                    </div>
                <?php endif ?>
            </tbody>

        </table>
    </div>

<?php else : ?>
    <div class="row justify-content-center">
        <h3 style="margin-top: 200px;">Nothing Cart Item...</h3>
    </div>
<?php endif ?>

<?php require APPROOT . "/views/default/footer.php"; ?>