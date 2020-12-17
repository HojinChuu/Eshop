<?php

class Products extends Controller
{
    public function __construct()
    {
        $this->productModel = $this->model("Product");
    }

    // Product page
    public function index()
    {
        $products = $this->productModel->getProducts();
        $data = ["products" => $products];
        $this->view("products/index", $data);
    }

    // Product Detail
    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        $data = ["product" => $product];
        $this->view("products/show", $data);
    }

    // Add To Cart
    public function addToCart($id)
    {
        $_SESSION["cart"][$id] = ["quantity" => $_POST["quantity"]];
        $cart_session = $_SESSION["cart"];

        foreach ($cart_session as $cart_id => $value) {
            $cart[] = $this->productModel->findCartProductsById($cart_id);
            $quantity[] = $value;
        }

        $data = [
            "cart" => $cart,
            "quantity" => $quantity
        ];

        $this->view("orders/index", $data);
    }

    // ADMIN product management
    public function adminProductPage()
    {
        $products = $this->productModel->getProducts();

        $data = ["products" => $products];

        isAdminUser() ?
            $this->view("admin/productList", $data) :
            redirect("products/index");
    }

    // ADMIN create product
    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_POST = filter_input_array(INPUT_POST);
            $resultData = upload($_POST, $_FILES);

            $data = [
                "name" => $resultData["name"],
                "description" => $resultData["description"],
                "image" => $resultData["image"],
                "price" => $resultData["price"],
                "stock" => $resultData["stock"],
            ];

            if ($this->productModel->createProduct($data)) {
                flash("create_success", "create success");
                redirect("admin/adminProductPage");
            }
        } else {
            $this->view("admin/productCreateForm");
        }
    }

    // ADMIN update product
    public function update($id)
    {
        $product = $this->productModel->getProductById($id);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_POST = filter_input_array(INPUT_POST);
            $resultData = upload($_POST, $_FILES, $product);

            $data = [
                "id" => $id,
                "name" => $resultData["name"],
                "description" => $resultData["description"],
                "image" => $resultData["image"],
                "price" => $resultData["price"],
                "stock" => $resultData["stock"],
            ];

            if ($this->productModel->updateProduct($data)) {
                flash("update_success", "update success");
                redirect("admin/adminProductPage");
            }
        } else {
            $data = [
                "id" => $product->id,
                "name" => $product->name,
                "description" => $product->description,
                "image" => $product->image_path,
                "price" => $product->price,
                "stock" => $product->stock,
            ];

            $this->view("admin/productUpdateForm", $data);
        }
    }

    // ADMIN remove product
    public function destroy($id)
    {
        $product = $this->productModel->getProductById($id);

        $image_text_array = explode("/", $product->image_path);
        if ($image_text_array[0] == "upload") {
            unlink($product->image_path);
        }

        $this->productModel->destroyProduct($id);
        $products = $this->productModel->getProducts();

        $data = ["products" => $products];
        $this->view("admin/productList", $data);
    }
}