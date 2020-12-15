<?php

class Orders extends Controller
{
    public function __construct()
    {
        $this->productModel = $this->model("Product");
        $this->userinfoModel = $this->model("UserInfo");
        $this->orderModel = $this->model("Order");
        $this->userModel = $this->model("User");
    }

    // Cart List
    public function index()
    {
        if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
            $cart_session = $_SESSION["cart"];

            foreach ($cart_session as $key => $value) {
                $cart[] = $this->productModel->cartProduct($key);
                $quantity[] = $value;
            }

            $data = [
                "cart" => $cart,
                "quantity" => $quantity
            ];

            $this->view("orders/index", $data);
        }
        $this->view("orders/index");
    }

    // Cart Destroy
    public function destroy($id)
    {
        unset($_SESSION["cart"][$id]);
        unset($_SESSION["quantity"][$id]);
        $this->index();
    }

    // Cart Update
    public function update($id)
    {
        $_SESSION["cart"][$id]["quantity"] = $_POST["quantity"];
        $this->index();
    }

    // Order CheckOut
    public function checkout()
    {
        if (!isLoggedIn()) {
            flash("access_error", "ログインが必要です", "alert alert-danger");
            redirect("users/login");
        }

        // cart info
        $cart_session = $_SESSION["cart"];

        foreach ($cart_session as $key => $value) {
            $cart[] = $this->productModel->cartProduct($key);
            $quantity[] = $value;
        }

        $total = 0;
        foreach ($cart as $key => $cartItem) {
            $qty = $quantity[$key]["quantity"];
            $total = $total + ($qty * $cartItem->price);

            // Cart Stock Check 
            if ($cartItem->stock < $qty) {
                flash("stock_error", "[ $cartItem->name ] 希望する商品の数が残っている在庫の量より多いです。[ $cartItem->name ] の在庫 ( $cartItem->stock )", "alert alert-danger");
                redirect("orders/index");
            }
        }

        $data = ["total_price" => $total];
        $this->view("orders/checkout", $data);
    }

    // Order Payment
    public function payment()
    {
        if (!isLoggedIn()) {
            flash("access_error", "ログインが必要です", "alert alert-danger");
            redirect("users/login");
        }

        $uid = $_SESSION["user_id"];
        $user = $this->userModel->getUserById($uid);

        // Payment method Cash and No money
        if ($_POST["payment"] == "Cash") {
            if ($_POST["orderTotal"] > $user->money) {
                flash("money_error", "お金が足りない", "alert alert-danger");
                redirect("orders/index");
                exit();
            } else {
                $orderTotal = $_POST["orderTotal"];
                $result_money = $user->money - $orderTotal;
                $this->userModel->updateMoney($uid, $result_money);

                $result_orderTotal = number_format($orderTotal, -2);
                flash("money_success", "￥$result_orderTotal ポイントを払いました");
            }
        }

        // Cart Info
        $cart_session = $_SESSION["cart"];
        foreach ($cart_session as $key => $value) {
            $cart[] = $this->productModel->cartProduct($key);
            $quantity[] = $value;
        }

        // Product Stock Counting Logic
        foreach ($cart as $key => $cartItem) {
            $qty = $quantity[$key]["quantity"];

            // Cart Stock Check 
            if ($cartItem->stock < $qty) {
                flash("stock_error", "[ $cartItem->name ] 希望する商品の数が残っている在庫の量より多いです。[ $cartItem->name ] の在庫 ( $cartItem->stock )", "alert alert-danger");
                redirect("orders/index");
                exit();
            } else {
                $result_stock = $cart[$key]->stock - $quantity[$key]["quantity"];
                $this->productModel->updateStock($cart[$key]->id, $result_stock);
            }
        }

        // Payment Logic
        if (isset($_POST) && !empty($_POST)) {
            if ($_POST["agree"] == true) {
                $country = filter_var($_POST["country"], FILTER_SANITIZE_STRING);
                $fname = filter_var($_POST["fname"], FILTER_SANITIZE_STRING);
                $lname = filter_var($_POST["lname"], FILTER_SANITIZE_STRING);
                $company = filter_var($_POST["company"], FILTER_SANITIZE_STRING);
                $address1 = filter_var($_POST["address1"], FILTER_SANITIZE_STRING);
                $address2 = filter_var($_POST["address2"], FILTER_SANITIZE_STRING);
                $city = filter_var($_POST["city"], FILTER_SANITIZE_STRING);
                $state = filter_var($_POST["state"], FILTER_SANITIZE_STRING);
                $phone = filter_var($_POST["phone"], FILTER_SANITIZE_STRING);
                $zip = filter_var($_POST["zipcode"], FILTER_SANITIZE_STRING); // int
                $payment = filter_var($_POST["payment"], FILTER_SANITIZE_STRING);
                $postData = [
                    "country" => $country,
                    "fname" => $fname,
                    "lname" => $lname,
                    "company" => $company,
                    "address1" => $address1,
                    "address2" => $address2,
                    "city" => $city,
                    "state" => $state,
                    "phone" => $phone,
                    "zip" => $zip,
                    "payment" => $payment
                ];

                $orderData = [
                    "total_price" => $_POST["orderTotal"],
                    "order_status" => "Order Placed",
                    "payment_mode" => $payment
                ];

                // Order Create
                $order_id = $this->orderModel->create($uid, $orderData);

                // UserInfo Create
                $this->userinfoModel->create($uid, $postData, $order_id);

                // OrderItem Create
                if (!empty($order_id)) {
                    foreach ($cart as $key => $value) {
                        $cart[] = $this->productModel->cartProduct($key);
                        $quantity[] = $value;
                        $productqty = $quantity[$key]["quantity"];

                        $orderItemData = [
                            "product_id" => $cart[$key]->id,
                            "order_id" => $order_id,
                            "product_price" => $cart[$key]->price,
                            "product_qty" => $productqty
                        ];

                        if ($this->orderModel->orderItemCreate($orderItemData)) {
                            unset($_SESSION["cart"]);
                        }
                    }
                }
            }
            redirect("users/mypage");
        }

        $data = ["total_price" => $_POST["orderTotal"]];
        $this->view("orders/checkout", $data);
    }

    // Show My Order List
    public function orderShow($id)
    {
        $user_id = $_SESSION["user_id"];
        $order = $this->orderModel->getOrderItem($id);
        $userinfo = $this->userinfoModel->getOrderUserInfo($user_id, $id);

        $data = [
            "order" => $order,
            "userinfo" => $userinfo
        ];

        $this->view("users/myorder", $data);
    }

    // Cancel My Order
    public function orderCancel(...$data)
    {
        $order_id = $data[0];
        $price = $data[1];
        $user_id = $_SESSION["user_id"];

        $order = $this->orderModel->getOrder($order_id);

        $result = $order->payment_mode == "Cash" ? true : false;

        if ($result) {
            $this->userModel->refundMoney($user_id, $price);
            $price = number_format($price, -2);
            flash("refund_success", "￥ $price refund success");
        }

        $this->orderModel->destroyOrder($order_id);
        redirect("users/mypage");
    }

    // ADMIN OrderList
    public function adminOrderPage()
    {
        $orders = $this->orderModel->getAllOrders();
        $data = ["orders" => $orders];
        $this->view("admin/orderList", $data);
    }

    // ADMIN Remove Order
    public function orderDestroy($id)
    {
        $this->orderModel->destroyOrder($id);
        $this->adminOrderPage();
    }

    // ADMIN Update Order Status
    public function orderStatusUpdate($id)
    {
        $status = $_POST["status"];
        $this->orderModel->updateOrderStatus($id, $status);
        $this->adminOrderPage();
    }
}
