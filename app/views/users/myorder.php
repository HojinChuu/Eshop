<?php require APPROOT . "/views/default/header.php"; ?>

    <div class="row">
        <main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-12">
            <a href="<?= URLROOT ?>/users/mypage" class="btn btn-dark mr-4">BACK</a>
            <h2 class="mt-5">Code No.<?= $data["order"][0]->order_id ?></h2>

            <!-- MY INFO -->
            <div class="card text-center" style="width: 40rem; margin: auto;">
                <div class="card-body">
                    <h3 class="card-title">Order Destination</h3>
                </div>
                <table class="table">
                    <tbody class="text-left">
                    <tr>
                        <th scope="row" class="pl-5">Name : </th>
                        <td><?= $data["userinfo"]->firstname . " " . $data["userinfo"]->lastname ?></td>
                    </tr>
                    <tr>
                        <th scope="row" class="pl-5">Address : </th>
                        <td><?= $data["userinfo"]->country . ", " . $data["userinfo"]->city . ", " . $data["userinfo"]->state . ", " . $data["userinfo"]->address1 . ", " . $data["userinfo"]->address2 ?></td>
                    </tr>
                    <tr>
                        <th scope="row" class="pl-5">Postal Number : </th>
                        <td colspan="2"><?= $data["userinfo"]->zip ?></td>
                    </tr>
                    <tr>
                        <th scope="row" class="pl-5">Company : </th>
                        <td colspan="2"><?= $data["userinfo"]->company ?></td>
                    </tr>
                    <tr>
                        <th scope="row" class="pl-5">Phone Number : </th>
                        <td colspan="2"><?= $data["userinfo"]->phone ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="table table-responsive mt-5">
                <table class="table table-striped table-sm">
                    <thead class="text-center">
                    <tr>
                        <th>Image</th>
                        <th>name</th>
                        <th>description</th>
                        <th>quantity</th>
                        <th>price</th>
                        <th>total price</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    <?php foreach ($data["order"] as $order) : ?>
                        <tr>
                            <td>
                                <img src="<?= URLROOT ?>/<?= $order->image_path ?>" height="80px" />
                            </td>
                            <td><?= $order->name ?></td>
                            <td><?= $order->description ?></td>
                            <td><?= $order->product_qty ?></td>
                            <td>￥ <?= number_format($order->price, -2) ?></td>
                            <td>￥ <?= number_format($order->price * $order->product_qty, -2) ?></td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

<?php require APPROOT . "/views/default/footer.php"; ?>