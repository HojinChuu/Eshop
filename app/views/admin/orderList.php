<?php require APPROOT . "/views/default/header.php"; ?>

<?php if (isset($data) && count($data["orders"]) > 0) : ?>
    <h4 class="text-center mt-5">
        <strong>Order Total: </strong><?= count($data["orders"]) ?>
    </h4>

    <div class="table-responsive mt-5">
        <table class="table table-striped" style="overflow: hidden;">

            <thead class="thead-light text-center">
                <th>Order No</th>
                <th>Customer Name</th>
                <th>Total Price</th>
                <th>Order Status</th>
                <th>Payment Method</th>
                <th>Phone</th>
                <th>Order Date</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php foreach ($data["orders"] as $order) : ?>
                    <tr class="text-center">
                        <td> <?= $order->id ?> </td>
                        <td> <?= $order->firstname . " " . $order->lastname ?> </td>
                        <td>￥ <?= $order->total_price ?> </td>
                        <td>
                            <p><?= $order->order_status ?></p>
                            <form action="<?= URLROOT ?>/orders/orderStatusUpdate/<?= $order->id ?>" method="post">
                                <select name="status" style="width: 80px">
                                    <option disabled>Select Country</option>
                                    <option value="Order Placed">Order Placed</option>
                                    <option value="Shipping">Shipping</option>
                                    <option value="Delivery completed">Delivery completed
                                </select>
                                <input type="submit" value="Update" class="btn btn-outline-dark btn-sm" />
                            </form>
                        </td>
                        <td><?= $order->payment_mode ?> </td>
                        <td><?= $order->phone ?> </td>
                        <td><?= $order->created_at ?> </td>
                        <td class="row justify-content-center">
                            <form action="<?= URLROOT ?>/orders/orderDestroy/<?= $order->id ?>" method="post">
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