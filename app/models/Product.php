<?php

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getProducts()
    {
        $sql = "SELECT * FROM products";
        $this->db->query($sql);
        $this->db->execute();

        return $this->db->resultSet();
    }

    public function getProductById($id)
    {
        $sql = "SELECT * FROM products WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        $this->db->execute();

        return $this->db->single();
    }

    public function findCartProductsById($id)
    {
        $sql = "SELECT * FROM products WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        $this->db->execute();

        return $this->db->single();
    }

    public function updateStock($id, $stock)
    {
        $sql = "UPDATE products SET stock = :stock WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        $this->db->bind(":stock", $stock);

        return $this->db->execute() ? true : false;
    }

    // ADMIN
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

    // ADMIN
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

    // ADMIN
    public function destroyProduct($id)
    {
        $sql = "DELETE FROM products WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);

        return $this->db->execute() ? true : false;
    }
}