<?php

class Comment
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
        $sql = "INSERT INTO comments (user_id, product_id, reply)
                    VALUES (:user_id, :product_id, :reply)";
        $this->db->query($sql);
        $this->db->bind(":user_id", $data["user_id"]);
        $this->db->bind(":product_id", $data["product_id"]);
        $this->db->bind(":reply", $data["reply"]);

        return $this->db->execute() ? true : false;
    }

    /**
     * @param $product_id
     * @return mixed
     */
    public function show($product_id)
    {
        $sql = "SELECT * FROM comments 
                    WHERE product_id = :product_id
                    ORDER BY id DESC";
        $this->db->query($sql);
        $this->db->bind(":product_id", $product_id);
        $this->db->execute();

        return $this->db->resultSet();
    }

    /**
     * @param $id
     * @return bool
     */
    public function destroy($id)
    {
        $sql = "DELETE FROM comments WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);

        return $this->db->execute() ? true : false;
    }

    /**
     * @param $user_id
     * @param $product_id
     * @return bool
     */
    public function commentProtectDuplicate($user_id, $product_id)
    {
        $sql = "SELECT * FROM comments 
                    WHERE user_id = :user_id 
                    AND product_id = :product_id";
        $this->db->query($sql);
        $this->db->bind(":user_id", $user_id);
        $this->db->bind(":product_id", $product_id);
        $this->db->execute();

        return $this->db->rowCount() < 1 ? true : false;
    }
}