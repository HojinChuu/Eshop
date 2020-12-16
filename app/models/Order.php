<?php

class Order
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function create($user_id, $orderData)
    {
        $sql = "INSERT INTO orders (user_id, total_price, order_status, payment_mode)
                VALUES (:user_id, :total_price, :order_status, :payment_mode)";
        $this->db->query($sql);
        $this->db->bind(":user_id", $user_id);
        $this->db->bind(":total_price", $orderData["total_price"]);
        $this->db->bind(":order_status", $orderData["order_status"]);
        $this->db->bind(":payment_mode", $orderData["payment_mode"]);
        $this->db->execute();

        return $this->db->lastInsertId();
    }

    public function orderItemCreate($orderItemData)
    {
        $sql = "INSERT INTO order_items (product_id, order_id, product_price, product_qty) 
                VALUES (:product_id, :order_id, :product_price, :product_qty)";
        $this->db->query($sql);
        $this->db->bind(":product_id", $orderItemData["product_id"]);
        $this->db->bind(":order_id", $orderItemData["order_id"]);
        $this->db->bind(":product_price", $orderItemData["product_price"]);
        $this->db->bind(":product_qty", $orderItemData["product_qty"]);

        return $this->db->execute() ? true : false;
    }

    public function getOrders($id)
    {
        $sql = "SELECT * FROM orders WHERE user_id = :user_id";
        $this->db->query($sql);
        $this->db->bind(":user_id", $id);
        $this->db->execute();

        return $this->db->resultSet();
    }

    public function getOrderItem($id)
    {
        $sql = "SELECT * FROM order_items 
                LEFT JOIN products
                ON order_items.product_id = products.id
                WHERE order_id = :order_id";
        $this->db->query($sql);
        $this->db->bind(":order_id", $id);
        $this->db->execute();

        return $this->db->resultSet();
    }

    public function destroyOrder($id)
    {
        $sql = "DELETE FROM orders WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        $this->db->execute();
    }

    // ADMIN
    public function getOrder($id)
    {
        $sql = "SELECT * FROM orders WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        $this->db->execute();

        return $this->db->single();
    }

    // ADMIN
    public function getAllOrders()
    {
        $sql = "SELECT orders.id, orders.total_price, orders.order_status, user_info.phone,
                        orders.payment_mode, orders.created_at, user_info.user_id, 
                        user_info.country, user_info.firstname, user_info.lastname
                FROM orders JOIN user_info 
                WHERE orders.id = user_info.order_id
                ORDER BY orders.id desc";
        $this->db->query($sql);
        $this->db->execute();

        return $this->db->resultSet();
    }

    // ADMIN
    public function updateOrderStatus($id, $status)
    {
        $sql = "UPDATE orders SET order_status = :order_status WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":order_status", $status);
        $this->db->bind(":id", $id);

        return $this->db->execute() ? true : false;
    }
}