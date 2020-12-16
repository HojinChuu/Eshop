<?php require APPROOT . "/views/default/header.php"; ?>

    <div class="row">
        <div class="col-md-6 mx-auto">
            <a href="<?= URLROOT ?>/" class="btn btn-lg btn-dark">BACK</a>
            <div class="card card-body mt-5">

                <?php flash("access_error") ?>　
                <?php flash("register_success") ?>

                <h2>Login</h2>
                <form action="<?= URLROOT; ?>/users/login" method="post">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control form-control-lg <?= (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?= $data['email']; ?>">
                        <span class="invalid-feedback"><?= $data["email_err"] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg <?= (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?= $data['password']; ?>">
                        <span class="invalid-feedback"><?= $data["password_err"] ?></span>
                    </div>

                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Login" class="btn btn-secondary btn-block">
                        </div>
                        <div class="col">
                            <a href="<?= URLROOT; ?>/users/register" class="btn btn-light btn-block">No account?</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

<?php require APPROOT . '/views/default/footer.php'; ?>