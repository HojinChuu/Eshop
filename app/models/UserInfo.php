<?php

class UserInfo
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getUserInfo($user_id)
    {
        $sql = "SELECT * FROM user_info WHERE user_id = $user_id";
        $this->db->query($sql);
        $this->db->bind(":user_id", $user_id);
        $this->db->execute();

        return $this->db->single();
    }

    public function getOrderUserInfo($user_id, $order_id)
    {
        $sql = "SELECT * FROM user_info WHERE user_id = :user_id AND order_id = :order_id";
        $this->db->query($sql);
        $this->db->bind(":user_id", $user_id);
        $this->db->bind(":order_id", $order_id);
        $this->db->execute();

        return $this->db->single();
    }

    public function userInfoCount($user_id)
    {
        $sql = "SELECT * FROM user_info WHERE user_id = $user_id";
        $this->db->query($sql);
        $this->db->bind(":user_id", $user_id);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function create($user_id, $postData, $order_id)
    {
        $sql = "INSERT INTO user_info (country, firstname, lastname, address1, address2, state, company, phone, city, zip, user_id, order_id)
                VALUES (:country, :firstname, :lastname, :address1, :address2, :state, :company, :phone, :city, :zip, :user_id, :order_id)";
        $this->db->query($sql);
        $this->db->bind(":country", $postData["country"]);
        $this->db->bind(":firstname", $postData["fname"]);
        $this->db->bind(":lastname", $postData["lname"]);
        $this->db->bind(":address1", $postData["address1"]);
        $this->db->bind(":address2", $postData["address2"]);
        $this->db->bind(":state", $postData["state"]);
        $this->db->bind(":company", $postData["company"]);
        $this->db->bind(":phone", $postData["phone"]);
        $this->db->bind(":city", $postData["city"]);
        $this->db->bind(":zip", $postData["zip"]);
        $this->db->bind(":user_id", $user_id);
        $this->db->bind(":order_id", $order_id);

        return $this->db->execute() ? true : false;
    }

    public function update($user_id, $postData, $order_id)
    {
        $sql = "UPDATE user_info 
                SET country = :country, firstname = :firstname,
                    lastname = :lastname, address1 = :address1, 
                    state = :state, company = :company, phone = :phone,
                    address2 = :address2, city = :city, zip = :zip
                WHERE user_id = :user_id AND order_id = :order_id";
        $this->db->query($sql);
        $this->db->bind(":country", $postData["country"]);
        $this->db->bind(":firstname", $postData["fname"]);
        $this->db->bind(":lastname", $postData["lname"]);
        $this->db->bind(":address1", $postData["address1"]);
        $this->db->bind(":address2", $postData["address2"]);
        $this->db->bind(":state", $postData["state"]);
        $this->db->bind(":company", $postData["company"]);
        $this->db->bind(":phone", $postData["phone"]);
        $this->db->bind(":city", $postData["city"]);
        $this->db->bind(":zip", $postData["zip"]);
        $this->db->bind(":user_id", (int)$user_id);
        $this->db->bind(":order_id", (int)$order_id);

        return $this->db->execute() ? true : false;
    }
}
