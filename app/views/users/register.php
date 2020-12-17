<?php require APPROOT . "/views/default/header.php"; ?>

    <div class="row">
        <div class="col-md-6 mx-auto">
            <a href="<?= URLROOT ?>/" class="btn btn-lg btn-dark">BACK</a>
            <div class="card card-body mt-5">
                <h2>Create An Account</h2>

                <form action="<?= URLROOT; ?>/users/register" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control form-control-lg <?= (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?= isset($data['name']) ? $data['name'] : ""; ?>">
                        <span class="invalid-feedback"><?= isset($data["name_err"]) ? $data["name_err"] : "" ?></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control form-control-lg <?= (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?= isset($data['email']) ? $data['email'] : ""; ?>">
                        <span class="invalid-feedback"><?= isset($data["email_err"]) ? $data["email_err"] : "" ?></span>
                    </div>
                    <div class="for m-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg <?= (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?= isset($data['password']) ? $data['password'] : ""; ?>">
                        <span class="invalid-feedback"><?= isset($data["password_err"]) ? $data["password_err"] : "" ?></span>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control form-control-lg <?= (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?= isset($data['confirm_password']) ? $data['confirm_password'] : ""; ?>">
                        <span class="invalid-feedback"><?= isset($data["confirm_password_err"]) ? $data["confirm_password_err"] : "" ?></span>
                    </div>

                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Register" class="btn btn-secondary btn-block">
                        </div>
                        <div class="col">
                            <a href="<?= URLROOT; ?>/users/login" class="btn btn-light btn-block">Have an account?</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

<?php require APPROOT . "/views/default/footer.php"; ?>