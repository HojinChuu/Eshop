<?php require APPROOT . "/views/default/header.php"; ?>

<div class="row">
    <main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-12">
        <div class="d-flex flex-wrap flex-md-nowrap  pt-3 pb-2 mb-3 border-bottom">
            <div class="row">
                <a href="<?= URLROOT ?>/" class="btn btn-sm btn-dark mr-4">BACK</a>
                <h1 class="h2">MyPage</h1>
            </div>
        </div>

        <div class="mt-4">
            <?php flash("money_success") ?>
            <?php flash("refund_success") ?>
            <?php flash("money_error1") ?>
            <?php flash("money_error2") ?>
        </div>

        <!-- MY INFO -->
        <?php $date = new DateTime($data["user"]->created_at) ?>
        <div class="card text-center" style="width: 30rem; margin: auto;">
            <div class="card-body">
                <h3 class="card-title"><?= strtoupper($data["user"]->name) ?> 様</h3>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><?= $data["user"]->email ?></li>
                <li class="list-group-item"><strong>￥ <?= number_format($data["user"]->money, -2) ?></strong></li>
                <li class="list-group-item"><?= date_format($date, "Y年 m月 d日") ?></li>
            </ul>
            <div class="card-body">
                <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#chargeModal">CHARGE</button>
                <a href="<?= URLROOT ?>/users/update/<?= $data['user']->id ?>" class="btn btn-outline-dark">EDIT</a>
            </div>
        </div>

        <!-- ORDER LIST -->
        <?php if ($data["orders"]) : ?>
            <h2 class="mt-5">Order list</h2>
            <div class="table table-responsive">
                <table class="table table-striped table-sm">
                    <thead class="text-center">
                    <tr>
                        <th>Order code</th>
                        <th>Date</th>
                        <th>Payment method</th>
                        <th>Total price</th>
                        <th>Status</th>
                        <th>VIEW</th>
                        <th>CANCEL</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    <?php foreach ($data["orders"] as $order) : ?>
                        <?php $date = new DateTime($order->created_at) ?>
                        <tr>
                            <td><?= $order->id ?></td>
                            <td><?= date_format($date, "Y/m/d") ?></td>
                            <td><?= $order->payment_mode ?></td>
                            <td>￥ <?= number_format($order->total_price, -2) ?></td>
                            <td><?= $order->order_status ?></td>
                            <td>
                                <a class="btn btn-sm btn-outline-success" href="<?= URLROOT ?>/orders/orderShow/<?= $order->id ?>">View</a>
                            </td>
                            <td>
                                <?php if ($order->order_status == "Order Placed") : ?>
                                    <a class="btn btn-sm btn-outline-danger" href="<?= URLROOT ?>/orders/orderCancel/<?= $order->id ?>/<?= $order->total_price ?>">Cancel</a>
                                <?php else : ?>
                                    <button disabled class="btn btn-sm btn-primary"><?= $order->order_status ?></button>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        <?php endif ?>
    </main>
</div>

<?php require APPROOT . "/views/users/chargeModal.php"; ?>
<?php require APPROOT . "/views/default/footer.php"; ?>
