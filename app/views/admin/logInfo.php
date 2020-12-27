<?php require APPROOT . "/views/default/header.php"; ?>

    <h1>Logs</h1>
    <form action="<?= URLROOT ?>/logs/mailBtn" method="get" class="text-right">
        <input type="submit" class="btn btn-dark btn-lg" value="Send Mail"/>
    </form>
    <div class="p-3">
        <table class="table table-bordered text-center">
            <h3>ALL</h3>
            <tr>
                <th>UU</th>
                <th>PV</th>
                <th>Order</th>
                <th>Conversion Rate</th>
            </tr>
            <tr>
                <td><?= $data["all_uu"] ?></td>
                <td><?= $data["all_pv"] ?></td>
                <td><?= $data["all_order_count"] ?></td>
                <td><?= round($data["all_order_count"] / $data["all_pv"], 6) ?> %</td>
            </tr>
        </table>

        <table class="table table-bordered text-center">
            <h3><?= $data["date"] ?></h3>
            <tr>
                <th>UU</th>
                <th>PV</th>
                <th>Order</th>
                <th>Conversion Rate</th>
            </tr>
            <tr>
                <td><?= $data["uu"] ?></td>
                <td><?= $data["pv"] ?></td>
                <td><?= $data["order_count"] ?></td>
                <td><?= round($data["order_count"] / $data["pv"], 6) ?> %</td>
            </tr>
        </table>
    </div>

    <div class="row">
        <div class="col">
            <canvas id="allPageChart"
                    data-admin="<?= $data["all_page"]["admin_page"] ?>"
                    data-user="<?= $data["all_page"]["users_page"] ?>"
                    data-product="<?= $data["all_page"]["products_page"] ?>"
                    data-order="<?= $data["all_page"]["orders_page"] ?>"
                    data-wishlist="<?= $data["all_page"]["wishlists_page"] ?>">
            </canvas>
        </div>
        <div class="col">
            <canvas id="pageChart"
                    data-admin="<?= $data["page"]["admin_page"] ?>"
                    data-user="<?= $data["page"]["users_page"] ?>"
                    data-product="<?= $data["page"]["products_page"] ?>"
                    data-order="<?= $data["page"]["orders_page"] ?>"
                    data-wishlist="<?= $data["page"]["wishlists_page"] ?>"
                    data-date="<?= $data["date"] ?>">
            </canvas>
        </div>
    </div>

    <div>
        <h3 class="mt-4">Ranking</h3>
        <div class="row justify-content-between no-gutters mt-4">
            <?php foreach ($data["products_info"] as $key => $product) : ?>
                <h2><?= $key + 1 ?></h2>
                <div class="col-2 card">
                    <img class="card-img-top" src="<?= URLROOT . "/" . $product->image_path ?>" width="100"
                         height="150"/>
                    <div class="card-body">
                        <p class="card-text"><?= $product->name ?></p>
                        <p class="card-text">￥ <?= number_format($product->price, -2) ?></p>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
<?php require APPROOT . "/views/default/footer.php"; ?>