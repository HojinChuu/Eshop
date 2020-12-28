<?php require APPROOT . "/views/default/header.php"; ?>

<a href="<?= URLROOT ?>/orders/index" class="btn btn btn-dark ml-5">BACK</a>
<div class="content-blog">
    <div class="page_header text-center m-5">
        <h1>CHECK OUT</h1>
    </div>

    <div class="container">
        <form action="<?= URLROOT ?>/orders/payment" method="post">
            <div class="row justify-content-around">
                <div class="col-md-5">
                    <h3 class="mb-5 text-center">Billing Details</h3>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>First Name </label>
                                <input name="fname" class="form-control" placeholder="First Name" type="text" required>
                            </div>
                            <div class="col-md-6">
                                <label>Last Name </label>
                                <input name="lname" class="form-control" placeholder="Last Name" type="text" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Company Name</label>
                        <input name="company" class="form-control" placeholder="Company" type="text" required>
                    </div>

                    <div class="form-group">
                        <label>Country</label>
                        <select name="country" class="form-control">
                            <option disabled>Select Country</option>
                            <option value="UnitedStates">United States</option>
                            <option value="UnitedKingdom">United kingdom</option>
                            <option value="China">China</option>
                            <option value="Japan">Japan</option>
                            <option value="Germany">Germany</option>
                            <option value="Singapore">Singapore</option>
                            <option value="Vietnam">Vietnam</option>
                            <option value="Australia">Australia</option>
                            <option value="Brazil">Brazil</option>
                            <option value="Korea">Korea</option>
                            <option value="Cuba">Cuba</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Town / City </label>
                                <input name="city" class="form-control" placeholder="City" type="text" required>
                            </div>
                            <div class="col-md-4">
                                <label>State</label>
                                <input name="state" class="form-control" placeholder="State" type="text" required>
                            </div>

                            <div class="col-md-4">
                                <label>Postcode</label>
                                <input name="zipcode" class="form-control" placeholder="Postcode" type="text" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Address </label>
                        <input name="address1" class="form-control" placeholder="Street address" type="text" required>
                        <input name="address2" class="form-control" placeholder="Apartment" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Phone </label>
                        <input name="phone" class="form-control" placeholder="07012345678" type="text" required>
                    </div>
                </div>

                <div class="col-md-5">
                    <h3 class="mb-5 text-center">Your order</h3>

                    <table class="table table-bordered">
                        <?php
                        $delivery = $data["total_price"] > 2000 ? 0 : 500;
                        $tax = $data["total_price"] * 0.15;
                        $orderTotal = $data["total_price"] + $delivery + $tax;
                        ?>
                        <tbody>
                        <tr>
                            <th>Order Subtotal</th>
                            <td><span>￥ <?= number_format($data["total_price"], -2) ?></span></td>
                        </tr>
                        <tr>
                            <th>Delivery (2,000円以上は無料！)</th>
                            <td>￥ <?= $delivery ?></td>
                        </tr>
                        <tr>
                            <th>Tax</th>
                            <td>￥ <?= number_format($tax, -2) ?></td>
                        </tr>
                        <tr>
                            <th>Order Total</th>
                            <td><strong><span>￥ <?= number_format($orderTotal, -2) ?></span></strong></td>
                        </tr>
                        </tbody>
                    </table>

                    <h4 class="mt-5 mb-5 text-center">Payment Method</h4>

                    <div class="row">
                        <div class="col-md-4 text-center">
                            <input name="payment" value="Cash" id="radio1" type="radio" class="form-control" checked><span>Cash</span>
                        </div>
                        <div class="col-md-4 text-center">
                            <input name="payment" value="Card" id="radio2" type="radio" class="form-control"><span>Card</span>
                        </div>
                        <div class="col-md-4 text-center">
                            <input name="payment" value="Paypal" id="radio3" type="radio" class="form-control"><span>Paypal</span>
                        </div>
                    </div>

                    <div class="form-group mt-5">
                        <input type="checkbox" name="agree" id="agree" value="true" required>
                        <label for="agree">
                            <h5>Agree</h5>
                        </label>
                    </div>

                    <div class="mb-5 pb-5">
                        <input type="hidden" name="orderTotal" value="<?= $orderTotal ?>" />
                        <input type="submit" class="btn btn-block btn-lg btn-success" value="PAY NOW" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require APPROOT . "/views/default/footer.php"; ?>
