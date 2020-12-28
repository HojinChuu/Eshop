<?php require APPROOT . "/views/default/header.php"; ?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body mt-5">
            <h2>Edit User</h2>
            <form action="<?= URLROOT; ?>/users/update/<?= $data['id'] ?>" method="post">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control form-control-lg <?= (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?= $data['name']; ?>">
                    <span class="invalid-feedback"><?= isset($data["name_err"]) ? $data["name_err"] : "" ?></span>
                </div>
                <div class="for m-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg <?= (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" />
                    <span class="invalid-feedback"><?= isset($data["password_err"]) ? $data["password_err"] : "" ?></span>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control form-control-lg <?= (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" />
                    <span class="invalid-feedback"><?= isset($data["confirm_password_err"]) ? $data["confirm_password_err"] : "" ?></span>
                </div>
                <div class="row">
                    <div class="col">
                        <a href="<?= URLROOT; ?>/users/mypage" class="btn btn-light btn-block">Back</a>
                    </div>
                    <div class="col">
                        <input type="submit" value="UPDATE" class="btn btn-secondary btn-block">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require APPROOT . "/views/default/footer.php"; ?>
