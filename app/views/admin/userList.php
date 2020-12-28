<?php require APPROOT . "/views/default/header.php"; ?>

<?php if (isset($data) && count($data["users"]) > 0) : ?>
    <h4 class="text-center mt-5">
        <strong>User Total: </strong><?= count($data["users"]) ?>
    </h4>

    <div class="table-responsive mt-5">
        <table class="table table-striped" style="overflow: hidden;">

            <thead class="thead-light text-center">
            <th>Name</th>
            <th>Email</th>
            <th>Money</th>
            <th>Admin</th>
            <th>Action</th>
            </thead>

            <tbody>
            <?php foreach ($data["users"] as $user) : ?>
                <tr class="text-center">
                    <td> <?= $user->name ?> </td>
                    <td> <?= $user->email ?> </td>
                    <td>￥ <?= $user->money ?> </td>
                    <td><?= $user->isAdmin == 1 ? "<i class='fas fa-check fa-2x' style='color: Dodgerblue;'></i>" : "<i class='far fa-times-circle fa-2x' style='color: Tomato;'></i>" ?> </td>
                    <td class="row justify-content-center">
                        <form action="<?= URLROOT ?>/users/destroy/<?= $user->id ?>" method="post">
                            <input type="submit" value="Delete" class="btn btn-outline-danger ml-3" />
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>

        </table>
    </div>

<?php else : ?>
    <h3 class="mt-4">Nothing...</h3>
<?php endif ?>

<?php require APPROOT . "/views/default/footer.php"; ?>
