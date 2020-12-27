<?php

/**
 * Product Class with function of Product, Admin Product, Shopping Serve Product
 */
class Products extends Controller
{
    public function __construct()
    {
        $this->productModel = $this->model("Product");
    }

    /**
     * @return array $data[products]
     * @todo Show Main Page (Product)
     */
    public function index()
    {
        $products = $this->productModel->getProducts();
        $data = ["products" => $products];
        $this->view("products/index", $data);
    }

    /**
     * @param int $id ( product_id )
     * @return array $data[product]
     * @todo Show product detail
     */
    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        $data = ["product" => $product];
        $this->view("products/show", $data);
    }

    /**
     * @param int $id ( product_id )
     * @return array $data[cart, quantity]
     * @todo Create product in Cart and go to Cart Page
     */
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

    /**
     * @access Admin
     * @return array $data[products, shop_products]
     * @todo Show products and shopping serve products
     */
    public function adminProductPage()
    {
        $products = $this->productModel->getProducts();

        $shop_products = shopserveRequest("/items/_search", "POST");

        $data = [
            "products" => $products,
            "shop_products" => $shop_products["data"]->contents
        ];

        isAdminUser() ?
            $this->view("admin/productList", $data) :
            redirect("products/index");
    }

    /**
     * @access Admin
     * @todo Create a product
     */
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

    /**
     * @access Admin
     * @param int $id ( product_id )
     * @todo Update a product
     */
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

    /**
     * @access Admin
     * @param int $id ( product_id )
     * @todo Remove a product
     */
    public function destroy($id)
    {
        $product = $this->productModel->getProductById($id);

        $image_text_array = explode("/", $product->image_path);
        if ($image_text_array[0] == "upload") {
            unlink($product->image_path);
        }

        $this->productModel->destroyProduct($id);
        $this->adminProductPage();
    }

    /**
     * @access Admin
     * @todo Create a shopping serve product
     */
    public function createShopServeProduct()
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            $this->view("admin/shop/createForm");
        } else {
            $_POST = filter_input_array(INPUT_POST);

            $formData = [
                "item_code" => $_POST["code"],
                "item_name" => $_POST["name"],
            ];

            $body = json_encode($formData);
            $result = shopserveRequest("/items", "PUT", $body);

            if ($result["info"]["http_code"] === 201) {
                sleep(5);
                flash("shop_create_success", "shop product create success");
            } else if ($result["info"]["http_code"] === 409) {
                sleep(5);
                flash("shop_create_fail", "Already exists", "alert alert-danger");
            }

            redirect("admin/adminProductPage");
        }
    }

    /**
     * @access Admin
     * @param int $code ( shopping serve product code )
     */
    public function deleteShopServeProduct($code)
    {
        $result = shopserveRequest("/items/" . $code, "DELETE");

        if ($result["info"]["http_code"] === 200) {
            sleep(5);
            flash("shop_delete_success", "shop product delete success");
            redirect("admin/adminProductPage");
        }
    }

    /**
     * @access Admin
     * @param int $code ( shopping serve product code )
     */
    public function updateShopServeProduct($code)
    {
        if (isset($_POST["basic"])) {
            $postData = [
                "item_name" => $_POST["name"],
                "item_price" => $_POST["price"],
            ];
            $body = json_encode($postData);
            shopserveRequest("/items/$code/basic", "PUT", $body);
        } else if (isset($_POST["stock"])) {
            $postData = [
                "quantity" => $_POST["stock"],
                "unlimited" => "No",
                "alert_threshold" => 20
            ];
            $body = json_encode($postData);
            shopserveRequest("/items/$code/stock", "PUT", $body);
        }

        $product = shopserveRequest("/items/$code/basic");
        $stock = shopserveRequest("/items/$code/stock");

        $data = [
            "product" => $product["data"],
            "stock" => $stock["data"]->stock->management_item->quantity
        ];

        $this->view("admin/shop/updateForm", $data);
    }
}