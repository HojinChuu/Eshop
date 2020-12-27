<?php require APPROOT . "/views/default/header.php"; ?>

    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body mt-5">
                <h2>Edit Product</h2>
                <div class="col">
                </div>
                <form action="<?= URLROOT ?>/products/updateShopServeProduct/<?= $data["product"]->item_code ?>" method="post">
                    <input type="hidden" name="basic" />
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control form-control-lg" value="<?= $data["product"]->basic->item_name ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Price</label>
                        <input type="number" name="price" class="form-control form-control-lg" value="<?= $data["product"]->basic->item_price ?>" required />
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Update" class="btn btn-light btn-block">
                        </div>
                    </div>
                </form>

                <form action="<?= URLROOT ?>/products/updateShopServeProduct/<?= $data["product"]->item_code ?>" method="post" class="mt-3">
                    <input type="hidden" name="stock" />
                    <div class="form-group">
                        <label for="description">Stock</label>
                        <input type="number" name="stock" class="form-control form-control-lg" value="<?= $data["stock"] ?>" require />
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Update" class="btn btn-light btn-block">
                        </div>
                    </div>
                </form>

<!--
                <form action="<?= URLROOT ?>/products/updateShopServeProduct/<?= $data["product"]->item_code ?>" method="post" class="mt-3" enctype="multipart/form-data">
                    <input type="hidden" name="image" />
                    <div class="form-group">
                        <label for="description">Image</label>
                        <input type="file" name="image" class="form-control form-control-sm" required />
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Update" class="btn btn-light btn-block">
                        </div>
                    </div>
                </form>
-->
            </div>
            <a href="<?= URLROOT ?>/products/adminProductPage" class="btn btn-secondary btn-block mt-4">Back</a>
        </div>
    </div>

<?php require APPROOT . "/views/default/footer.php"; ?>