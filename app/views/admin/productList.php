<?php require APPROOT . "/views/default/header.php"; ?>

<?php if (isset($data) && count($data["products"]) > 0) : ?>

    <?php flash("create_success") ?>
    <?php flash("update_success") ?>

    <h4 class="text-center mt-5">
        <strong>Products Total: </strong><?= count($data["products"]) ?>
    </h4>

    <div class="text-right mb-3">
        <a href="<?= URLROOT ?>/products/create">
            <input type="submit" value="CREATE" class="btn btn btn-outline-success" />
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped" style="overflow: hidden;">

            <thead class="thead-light text-center">
            <th>Image</th>
            <th>name</th>
            <th>Description</th>
            <th>price</th>
            <th>stock</th>
            <th>Action</th>
            </thead>

            <tbody>
            <?php foreach ($data["products"] as $product) : ?>
                <tr class="text-center">
                    <td><img src="<?= URLROOT . "/" . $product->image_path ?>" width="100" height="100" style="border-radius: 20px;" /></td>
                    <td> <?= $product->name ?> </td>
                    <td><?= $product->description ?> </td>
                    <td>￥ <?= number_format($product->price, -2) ?> </td>
                    <td><?= $product->stock ?> </td>
                    <td class="row justify-content-center">
                        <form action="<?= URLROOT ?>/products/update/<?= $product->id ?>" method="get">
                            <input type="submit" value="Edit" class="btn btn-sm btn-outline-dark ml-3" />
                        </form>
                        <form action="<?= URLROOT ?>/products/destroy/<?= $product->id ?>" method="post">
                            <input type="submit" value="Delete" class="btn btn-sm btn-outline-danger ml-3" />
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>

        </table>
    </div>

<?php else : ?>
    <h3 class="mt-4">Nothing...</h3>
    <div class="text-right mb-3">
        <a href="<?= URLROOT ?>/products/create">
            <input type="submit" value="CREATE" class="btn btn btn-outline-success" />
        </a>
    </div>
<?php endif ?>

<?php require APPROOT . "/views/default/footer.php"; ?>