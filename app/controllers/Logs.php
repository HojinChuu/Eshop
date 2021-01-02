<?php

class Logs extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model("User");
        $this->orderModel = $this->model("Order");
        $this->productModel = $this->model("Product");
        $this->logModel = $this->model("AccessLog");
    }

    public function adminLogPage()
    {
        $data = $this->getData();

        if (isset($data["product_ranking"][0]) && !empty($data["product_ranking"][0])) {
            foreach ($data["product_ranking"] as $product) {
                $data["products_info"][] = $this->productModel->getProductByName($product);
            }
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
    }

    public function inputData()
    {
        $uu = $this->getAccessIp();
        $pv = $this->getAccessPage()["access_all_page"];
        $access_page_count = $this->getAccessPage()["access_page_count"];
        $product_ranking = $this->getOrderRank();
        $access_date = $this->getAccessDate();
        $order_count = $this->getOrderCount();

        $data = [
            "uu" => $uu,
            "pv" => $pv,
            "access_page_count" => $access_page_count,
            "product_ranking" => $product_ranking,
            "date" => $access_date,
            "order_count" => $order_count,
        ];

        if ($this->logModel->create($data)) {
            $allData = $this->getData();
            sendToMail($allData);
        }
    }

    /**
     * @return int
     */
    private function getAccessIp()
    {
        $user_ip = [];
        exec(ACCESS_ROOT . IP . RULE, $user_ip);

        foreach ($user_ip as $key => $ip) {
            $ip_result[] = explode(" ", trim($ip));
        }

        foreach ($ip_result as $key => $ip) {
            if (strpos($ip[1], "::")) {
                unset($ip_result[$key]);
            }
        }
        $access_user_count = count($ip_result);

        return $access_user_count;
    }

    /**
     * @return array
     */
    private function getAccessPage()
    {
        $access_page = [];
        exec(ACCESS_ROOT . PAGE . RULE, $access_page);

        $admin_page_count = 0;
        $products_page_count = 0;
        $users_page_count = 0;
        $wishlists_page_count = 0;
        $orders_page_count = 0;

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

        $pageAndPv = [
            "access_page_count" => [
                "admin_page" => $admin_page_count,
                "products_page" => $products_page_count,
                "users_page" => $users_page_count,
                "wishlists_page" => $wishlists_page_count,
                "orders_page" => $orders_page_count,
            ],
            "access_all_page" => $count
        ];

        return $pageAndPv;
    }

    /**
     * @return string
     */
    private function getOrderRank()
    {
        $order_items = $this->orderModel->getOrderItemsRanking();

        $popular_product_ranking = [];
        foreach ($order_items as $key => $value) {
            if ($key < 5) {
                $popular_product_ranking[] = $value->name;
            }
        }
        $product_ranking = implode(",", $popular_product_ranking);

        return $product_ranking;
    }

    /**
     * @return false|string
     */
    private function getAccessDate()
    {
        $access_time = [];
        exec(ACCESS_ROOT . TIME . RULE, $access_time);

        $time_result = explode(" ", trim($access_time[0]));
        $date_result = substr($time_result[1], 1, 11);
        $date_result = strtr($date_result, '/', '-');
        $date_result = strtotime($date_result);
        $access_date = date('Y-m-d', $date_result);

        return $access_date;
    }

    /**
     * @return int
     */
    private function getOrderCount()
    {
        $order_count = 0;
        $orders = $this->orderModel->getAllOrders();

        foreach ($orders as $order) {
            $created_at = substr($order->created_at, 0, 10);
            if ($created_at == $this->getAccessDate()) {
                $order_count++;
            }
        }

        return $order_count;
    }

    /**
     * @return array
     */
    private function getData()
    {
        $lastLog = $this->logModel->getLastColumnId();
        $logs = $this->logModel->getLogs();
        $log = $this->logModel->getLog($lastLog->id);

        if ($log) {
            $ranking = explode(",", $log->product_rank);

            $data = [
                "all_uu" => $logs->all_uu,
                "all_pv" => $logs->all_pv,
                "all_page" => [
                    "admin_page" => $logs->all_admin_page_count,
                    "products_page" => $logs->all_product_page_count,
                    "users_page" => $logs->all_user_page_count,
                    "wishlists_page" => $logs->all_wishlist_page_count,
                    "orders_page" => $logs->all_order_page_count,
                ],
                "all_order_count" => $logs->all_order_count,
                "uu" => $log->uu,
                "pv" => $log->pv,
                "page" => [
                    "admin_page" => $log->admin_page_count,
                    "products_page" => $log->product_page_count,
                    "users_page" => $log->user_page_count,
                    "wishlists_page" => $log->wishlist_page_count,
                    "orders_page" => $log->order_page_count,
                ],
                "order_count" => $log->order_count,
                "product_ranking" => $ranking,
                "date" => $log->date,
            ];

            return $data;
        }
    }
}