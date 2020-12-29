<?php

class Products extends Controller
{
    public function __construct()
    {
        $this->productModel = $this->model("Product");
        $this->userModel = $this->model("User");
        $this->commentModel = $this->model("Comment");
        $this->orderModel = $this->model("Order");
    }

    public function index()
    {
        $products = $this->productModel->getProducts();
        $data = ["products" => $products];
        $this->view("products/index", $data);
    }

    /**
     * @param $id
     */
    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        $comments = $this->commentModel->show($id);

        foreach ($comments as $key => $comment) {
            $comment->user = $this->userModel->getUserById($comment->user_id);
        }

        $data = [
            "product" => $product,
            "comment" => $comments
        ];

        $this->view("products/show", $data);
    }

    /**
     * @param $id
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
     * @param $id
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
     * @param $id
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
     * @param $code
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
     * @param $code
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

    /**
     * @param $product_id
     */
    public function createComment($product_id)
    {
        $user_id = $_SESSION["user_id"];
        $reply = htmlspecialchars($_POST["reply"]);

        $data = [
            "user_id" => $user_id,
            "product_id" => $product_id,
            "reply" => $reply
        ];

        if ($this->orderModel->commentProductHistory($user_id, $product_id)) {
            if ($this->commentModel->commentProtectDuplicate($user_id, $product_id)) {
                $this->commentModel->create($data);
            } else {
                flash("comment_error", "もうレビューを書きました", "alert alert-danger");
            }
        } else {
            flash("comment_error", "購入しなかった商品はレビューが書けません", "alert alert-danger");
        }

        $this->show($product_id);
    }

    /**
     * @param mixed ...$id
     */
    public function destroyComment(...$id)
    {
        $comment_id = $id[0];
        $product_id = $id[1];

        $this->commentModel->destroy($comment_id);
        flash("comment_destroy_success", "レビューを削除しました");

        $this->show($product_id);
    }
}