<?php

class Log
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function create($data)
    {
        $sql = "INSERT INTO logs (uu, pv, admin_page, products_page, users_page, wishlists_page, orders_page, order_count, product_ranking, date) 
                VALUES (:uu, :pv, :admin_page, :products_page, :users_page, :wishlists_page, :orders_page, :order_count, :product_ranking, :date)";
        $this->db->query($sql);
        $this->db->bind(":uu", $data["access_user_count"]);
        $this->db->bind(":pv", $data["access_all_page"]);
        $this->db->bind(":admin_page", $data["access_page_count"]["admin_page"]);
        $this->db->bind(":products_page", $data["access_page_count"]["products_page"]);
        $this->db->bind(":users_page", $data["access_page_count"]["users_page"]);
        $this->db->bind(":wishlists_page", $data["access_page_count"]["wishlists_page"]);
        $this->db->bind(":orders_page", $data["access_page_count"]["orders_page"]);
        $this->db->bind(":order_count", $data["order_count"]);
        $this->db->bind(":product_ranking", $data["product_ranking"]);
        $this->db->bind(":date", $data["date"]);

        return $this->db->execute() ? true : false;
    }

    public function getLogs()
    {
        $sql = "SELECT SUM(uu) as all_uu, SUM(pv) as all_pv, 
                   SUM(admin_page) as all_admin_page,
                   SUM(products_page) as all_products_page,
                   SUM(users_page) as all_users_page,
                   SUM(wishlists_page) as all_wishlists_page,
                   SUM(orders_page) as all_orders_page,
                   SUM(order_count) as all_order_count
                 FROM logs";
        $this->db->query($sql);
        $this->db->execute();

        return $this->db->single();
    }

    public function getLog($yesterday)
    {
        $sql = "SELECT * FROM logs WHERE date = :date";
        $this->db->query($sql);
        $this->db->bind(":date", $yesterday);
        $this->db->execute();

        return $this->db->single();
    }
}
