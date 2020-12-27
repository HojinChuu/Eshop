<?php

class Logs extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model("User");
        $this->orderModel = $this->model("Order");
        $this->productModel = $this->model("Product");
        $this->logModel = $this->model("Log");
    }

    public function adminLogPage()
    {
        $data = $this->getData();

        foreach ($data["product_ranking"] as $product) {
            $data["products_info"][] = $this->productModel->getProductByName($product);
        }

        isAdminUser() ?
            $this->view("admin/logInfo", $data) :
            redirect("products/index");
    }

    public function mailBtn()
    {
        $data = $this->getData();
        sendToMail($data);
        $this->adminLogPage();
        exit();
    }

    public function inputData()
    {
        $user_ip = [];
        $access_page = [];
        $url = [];
        $access_time = [];

        exec(ACCESS_ROOT . IP . RULE, $user_ip);
        exec(ACCESS_ROOT . PAGE . RULE, $access_page);
        exec(ACCESS_ROOT . URL . RULE, $url);
        exec(ACCESS_ROOT . TIME . RULE, $access_time);

        foreach ($user_ip as $ip) {
            $ip_result[] = explode(" ", trim($ip));
        }

        // init page count
        $admin_page_count = 0;
        $products_page_count = 0;
        $users_page_count = 0;
        $wishlists_page_count = 0;
        $orders_page_count = 0;

        // page access
        $count = 0;
        foreach ($access_page as $key => $page) {
            $page_result[] = explode(" ", trim($page));
            if (strpos($page_result[$key][1], "/") == 0) {
                $divided = explode("/", $page_result[$key][1]);
                if (isset($divided[1]) && !empty($divided[1])) {
                    if ($divided[1] == "favicon.ico" || $divided[1] == "img" || $divided[1] == "upload" || $divided[1] == "js" || $divided[1] == "css" || $divided[0] == "*") {
                        unset($page_result[$key]);
                    } else {
                        $count += $page_result[$key][0];
                        if ($divided[1] == "admin") $admin_page_count += $page_result[$key][0];
                        elseif ($divided[1] == "users") $users_page_count += $page_result[$key][0];
                        elseif ($divided[1] == "wishlists") $wishlists_page_count += $page_result[$key][0];
                        elseif ($divided[1] == "orders") $orders_page_count += $page_result[$key][0];
                        else  $products_page_count += $page_result[$key][0];
                    }
                }
            }
        }

        // 1. 오늘 사이트에 들어온 총인원수 (UU)
        $access_user_count = count($ip_result);

        // 2. 페이지를 새로고친 총수 (PV)
        $access_all_page = $count;

        // 4. 페이지별 접속수
        $access_page_count = [
            "admin_page" => $admin_page_count,
            "products_page" => $products_page_count,
            "users_page" => $users_page_count,
            "wishlists_page" => $wishlists_page_count,
            "orders_page" => $orders_page_count,
        ];

        // 6. 상품 랭킹 top 5
        $order_items = $this->orderModel->getOrderItemsRanking();

        $popular_product_ranking = [];
        foreach ($order_items as $key => $value) {
            if ($key < 5) {
                $popular_product_ranking[] = $value->name;
            }
        }
        $product_ranking = implode(",", $popular_product_ranking);

        // 3. 날짜
        $time_result = explode(" ", trim($access_time[0]));
        $date_result = substr($time_result[1], 1, 11);
        $date_result = strtr($date_result, '/', '-');
        $date_result = strtotime($date_result);
        $access_date = date('Y-m-d', $date_result);

        // 7. 오늘 주문수
        $order_count = 0;
        $orders = $this->orderModel->getAllOrders();
        foreach ($orders as $order) {
            $created_at = substr($order->created_at, 0, 10);
            if ($created_at == $access_date) {
                $order_count++;
            }
        }

        $data = [
            "access_user_count" => $access_user_count,
            "access_all_page" => $access_all_page,
            "access_page_count" => $access_page_count,
            "product_ranking" => $product_ranking,
            "date" => $access_date,
            "order_count" => $order_count,
        ];

        return $this->logModel->create($data) ? true : false;
    }

    private function getData()
    {
        $yesterday = date('Y-m-d', $_SERVER['REQUEST_TIME']);
        // $yesterday = date('Y-m-d', $_SERVER['REQUEST_TIME']-86400);

        $logs = $this->logModel->getLogs();
        $log = $this->logModel->getLog($yesterday);

        $ranking = explode(",", $log->product_ranking);

        $data = [
            "all_uu" => $logs->all_uu,
            "all_pv" => $logs->all_pv,
            "all_page" => [
                "admin_page" => $logs->all_admin_page,
                "products_page" => $logs->all_products_page,
                "users_page" => $logs->all_users_page,
                "wishlists_page" => $logs->all_wishlists_page,
                "orders_page" => $logs->all_orders_page,
            ],
            "all_order_count" => $logs->all_order_count,
            "uu" => $log->uu,
            "pv" => $log->pv,
            "page" => [
                "admin_page" => $log->admin_page,
                "products_page" => $log->products_page,
                "users_page" => $log->users_page,
                "wishlists_page" => $log->wishlists_page,
                "orders_page" => $log->orders_page,
            ],
            "order_count" => $log->order_count,
            "product_ranking" => $ranking,
            "date" => $log->date,
        ];

        return $data;
    }
}