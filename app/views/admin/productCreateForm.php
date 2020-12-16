<?php require APPROOT . "/views/default/header.php"; ?>

    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body mt-5">
                <h2>Create Product</h2>
                <form action="<?= URLROOT ?>/products/create" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control form-control-lg ">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control form-control-lg" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="description">Image</label>
                        <input type="file" name="image" class="form-control form-control-sm">
                    </div>
                    <div class="form-group">
                        <label for="description">Price</label>
                        <input type="number" name="price" class="form-control form-control-lg ">
                    </div>
                    <div class="form-group">
                        <label for="description">Stock</label>
                        <input type="number" name="stock" class="form-control form-control-lg ">
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