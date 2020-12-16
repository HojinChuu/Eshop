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

        if (isAdminUser()) {
            $this->view("admin/productList", $data);
        } else {
            redirect("products/index");
        }
    }

    // ADMIN create product
    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_POST = filter_input_array(INPUT_POST);

            $image_url = "";
            if (isset($_FILES["image"]) && !empty($_FILES["image"])) {
                $errors = array();
                $file_name = $_FILES["image"]["name"];
                $file_size = $_FILES["image"]["size"];
                $file_tmp = $_FILES["image"]["tmp_name"];
                $file_ext = strtolower((explode(".", $_FILES["image"]["name"])[1]));
                $extensions = array("jpeg", "jpg", "png");

                if (in_array($file_ext, $extensions) === false) {
                    $errors[] = "extension not allowed, JPEG or PNG";
                }

                if ($file_size > 2097152) {
                    $errors[] = "File size おおすぎ";
                }

                if (empty($errors) == true) {
                    move_uploaded_file($file_tmp, "upload/" . $file_name);
                } else {
                    print_r($errors);
                }

                if ($file_name) {
                    $image_url = "upload/" . $file_name;
                } else {
                    $image_url = "img/no_image.png";
                }
            }

            $price = (int)$_POST["price"];
            $stock = (int)$_POST["stock"];

            $data = [
                "name" => htmlspecialchars(trim($_POST["name"])),
                "description" => htmlspecialchars(trim($_POST["description"])),
                "image" => $image_url,
                "price" => $price,
                "stock" => $stock,
            ];

            if ($this->productModel->createProduct($data)) {
                flash("create_success", "create success");
                redirect("admin/adminProductPage");
            } else {
                die("Something wrong");
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

            $image_url = "";
            if (isset($_FILES["image"]) && !empty($_FILES["image"])) {
                $errors = array();
                $file_name = $_FILES["image"]["name"];
                $file_size = $_FILES["image"]["size"];
                $file_tmp = $_FILES["image"]["tmp_name"];
                $file_ext = strtolower((explode('.', $_FILES["image"]["name"])[1]));
                $extensions = array("jpeg", "jpg", "png");

                if (in_array($file_ext, $extensions) === false) {
                    $errors[] = "extension not allowed, JPEG or PNG";
                }

                if ($file_size > 2097152) {
                    $errors[] = "File size おおすぎ";
                }

                if (empty($errors) == true) {
                    move_uploaded_file($file_tmp, "upload/" . $file_name);
                    unlink($product->image_path);
                } else {
                    print_r($errors);
                }

                if ($file_name) {
                    $image_url = "upload/" . $file_name;
                } else {
                    $image_url = "img/no_image.png";
                }
            }

            $price = (int)$_POST["price"];
            $stock = (int)$_POST["stock"];

            $data = [
                "id" => $id,
                "name" => htmlspecialchars(trim($_POST["name"])),
                "description" => htmlspecialchars(trim($_POST["description"])),
                "image" => $image_url,
                "price" => $price,
                "stock" => $stock,
            ];

            if ($this->productModel->updateProduct($data)) {
                flash("update_success", "update success");
                redirect("admin/adminProductPage");
            } else {
                die("Something went wrong");
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