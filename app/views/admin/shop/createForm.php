<?php require APPROOT . "/views/default/header.php"; ?>

    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body mt-5">
                <h2>Shop Serve Create Product</h2>
                <form action="<?= URLROOT ?>/products/createShopServeProduct" method="post">
                    <div class="form-group">
                        <label for="name">Code Number</label>
                        <input type="text" name="code" class="form-control form-control-lg ">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control form-control-lg ">
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="<?= URLROOT ?>/products/adminProductPage" class="btn btn-light btn-block">Back</a>
                        </div>
                        <div class="col">
                            <input type="submit" value="Create" class="btn btn-secondary btn-block">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php require APPROOT . "/views/default/footer.php"; ?>