<?php

class Wishlist
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * @param $user_id
     * @param $product_id
     * @return bool
     */
    public function create($user_id, $product_id)
    {
        $sql = "INSERT INTO wishList (user_id, product_id)
                VALUES (:user_id, :product_id)";
        $this->db->query($sql);
        $this->db->bind(":user_id", $user_id);
        $this->db->bind(":product_id", $product_id);

        return $this->db->execute() ? true : false;
    }

    /**
     * @param $id
     * @return mixed
     */
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

    /**
     * @param $product_id
     * @return bool
     */
    public function findById($product_id)
    {
        $sql = "SELECT * FROM wishList WHERE product_id = :product_id";
        $this->db->query($sql);
        $this->db->bind(":product_id", $product_id);
        $this->db->execute();

        return $this->db->rowCount() > 0 ? false : true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function removeWishList($id)
    {
        $sql = "DELETE FROM wishList WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);

        return $this->db->execute() ? true : false;
    }
}