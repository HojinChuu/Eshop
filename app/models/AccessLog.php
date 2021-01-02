<?php

class AccessLog
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * @param $data
     * @return bool
     */
    public function create($data)
    {
        $sql = "INSERT INTO access_logs (uu, pv, order_count, admin_page_count, product_page_count, user_page_count, wishlist_page_count, order_page_count, product_rank, date) 
                VALUES (:uu, :pv, :order_count, :admin_page_count, :product_page_count, :user_page_count, :wishlist_page_count, :order_page_count, :product_rank, :date)";
        $this->db->query($sql);
        $this->db->bind(":uu", $data["uu"]);
        $this->db->bind(":pv", $data["pv"]);
        $this->db->bind(":order_count", $data["order_count"]);
        $this->db->bind(":admin_page_count", $data["access_page_count"]["admin_page"]);
        $this->db->bind(":product_page_count", $data["access_page_count"]["products_page"]);
        $this->db->bind(":user_page_count", $data["access_page_count"]["users_page"]);
        $this->db->bind(":wishlist_page_count", $data["access_page_count"]["wishlists_page"]);
        $this->db->bind(":order_page_count", $data["access_page_count"]["orders_page"]);
        $this->db->bind(":product_rank", $data["product_ranking"]);
        $this->db->bind(":date", $data["date"]);

        return $this->db->execute() ? true : false;
    }

    /**
     * @return mixed
     */
    public function getLogs()
    {
        $sql = "SELECT SUM(uu) as all_uu, SUM(pv) as all_pv,
                   SUM(order_count) as all_order_count,
                   SUM(admin_page_count) as all_admin_page_count,
                   SUM(product_page_count) as all_product_page_count,
                   SUM(user_page_count) as all_user_page_count,
                   SUM(wishlist_page_count) as all_wishlist_page_count,
                   SUM(order_page_count) as all_order_page_count
                 FROM access_logs";
        $this->db->query($sql);
        $this->db->execute();

        return $this->db->single();
    }

    /**
     * @param $yesterday
     * @return mixed
     */
    public function getLog($id)
    {
        $sql = "SELECT * FROM access_logs WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        $this->db->execute();

        return $this->db->single();
    }

    public function getLastColumnId()
    {
        $sql = "SELECT id FROM access_logs ORDER BY id DESC LIMIT 1";
        $this->db->query($sql);
        $this->db->execute();

        return $this->db->single();
    }
}