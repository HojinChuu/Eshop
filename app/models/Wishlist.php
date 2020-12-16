<?php

class Wishlist
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function create($user_id, $product_id)
    {
        $sql = "INSERT INTO wishList (user_id, product_id)
                    VALUES (:user_id, :product_id)";
        $this->db->query($sql);
        $this->db->bind(":user_id", $user_id);
        $this->db->bind(":product_id", $product_id);

        return $this->db->execute() ? true : false;
    }

    public function getWishlist($id)
    {
        $sql = "SELECT wishList.id, wishList.product_id, wishList.user_id, 
                        products.name, products.image_path, products.price 
                FROM wishList LEFT JOIN products
                ON wishList.product_id = products.id
                WHERE wishList.user_id = :user_id";
        $this->db->query($sql);
        $this->db->bind(":user_id", $id);
        $this->db->execute();

        return $this->db->resultSet();
    }

    public function findById($user_id)
    {
        $sql = "SELECT * FROM wishList WHERE user_id = :user_id";
        $this->db->query($sql);
        $this->db->bind(":user_id", $user_id);
        $this->db->execute();

        return $this->db->rowCount() > 0 ? false : true;
    }

    public function removeWishList($id)
    {
        $sql = "DELETE FROM wishList WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);

        return $this->db->execute() ? true : false;
    }
}