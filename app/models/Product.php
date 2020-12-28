<?php

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        $sql = "SELECT * FROM products";
        $this->db->query($sql);
        $this->db->execute();

        return $this->db->resultSet();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getProductById($id)
    {
        $sql = "SELECT * FROM products WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        $this->db->execute();

        return $this->db->single();
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getProductByName($name)
    {
        $sql = "SELECT * FROM products WHERE name = :name";
        $this->db->query($sql);
        $this->db->bind(":name", $name);
        $this->db->execute();

        return $this->db->single();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findCartProductsById($id)
    {
        $sql = "SELECT * FROM products WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        $this->db->execute();

        return $this->db->single();
    }

    /**
     * @param $id
     * @param $stock
     * @return bool
     */
    public function updateStock($id, $stock)
    {
        $sql = "UPDATE products SET stock = :stock WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        $this->db->bind(":stock", $stock);

        return $this->db->execute() ? true : false;
    }

    /**
     * @param $data
     * @return bool
     */
    public function createProduct($data)
    {
        $sql = "INSERT INTO products (name, description, image_path, price, stock) 
                VALUES (:name, :description, :image_path, :price, :stock)";
        $this->db->query($sql);
        $this->db->bind(":name", $data["name"]);
        $this->db->bind(":description", $data["description"]);
        $this->db->bind(":image_path", $data["image"]);
        $this->db->bind(":price", $data["price"]);
        $this->db->bind(":stock", $data["stock"]);

        return $this->db->execute() ? true : false;
    }

    /**
     * @param $data
     * @return bool
     */
    public function updateProduct($data)
    {
        $sql = "UPDATE products 
                SET name = :name, description = :description, 
                image_path = :image_path, price = :price, stock = :stock 
                WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $data["id"]);
        $this->db->bind(":name", $data["name"]);
        $this->db->bind(":description", $data["description"]);
        $this->db->bind(":image_path", $data["image"]);
        $this->db->bind(":price", $data["price"]);
        $this->db->bind(":stock", $data["stock"]);

        return $this->db->execute() ? true : false;
    }

    /**
     * @param $id
     * @return bool
     */
    public function destroyProduct($id)
    {
        $sql = "DELETE FROM products WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);

        return $this->db->execute() ? true : false;
    }
}