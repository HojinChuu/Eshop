<?php

class Wishlists extends Controller
{
    public function __construct()
    {
        $this->wishlistModel = $this->model("Wishlist");
        $this->productModel = $this->model("Product");
    }

    /**
     * @return array $data[wishlist]
     * @todo Show my wishlist
     */
    public function index()
    {
        $user_id = $_SESSION["user_id"];
        $wishlist = $this->wishlistModel->getWishlist($user_id);

        $data = ["wishlist" => $wishlist];
        $this->view("wishlists/index", $data);
    }

    /**
     * @param int $id ( product_id )
     * @return array $data[wishlist]
     */
    public function addToList($id)
    {
        $user_id = $_SESSION["user_id"];
        $product_id = $id;

        if ($this->wishlistModel->findById($product_id)) {
            if ($this->productModel->getProductById($product_id)) {
                $this->wishlistModel->create($user_id, $product_id);
            }
        }

        $wishlist = $this->wishlistModel->getWishlist($user_id);

        $data = ["wishlist" => $wishlist];
        $this->view("wishlists/index", $data);
    }

    /**
     * @param int $id ( wishlist_id )
     */
    public function destroy($id)
    {
        $this->wishlistModel->removeWishList($id);
        $this->index();
    }
}