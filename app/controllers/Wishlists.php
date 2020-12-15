<?php

class Wishlists extends Controller
{
    public function __construct()
    {
        $this->wishlistModel = $this->model("Wishlist");
    }

    public  function index()
    {
        $user_id = $_SESSION["user_id"];
        $wishlist = $this->wishlistModel->getWishlist($user_id);

        $data = ["wishlist" => $wishlist];
        $this->view("wishlists/index", $data);
    }

    public function addToList($id)
    {
        $user_id = $_SESSION["user_id"];
        $product_id = $id;

        if ($this->wishlistModel->findById($user_id)) {
            $this->wishlistModel->create($user_id, $product_id);
        }

        $wishlist = $this->wishlistModel->getWishlist($user_id);

        $data = ["wishlist" => $wishlist];
        $this->view("wishlists/index", $data);
    }

    public function destroy($id)
    {
        $this->wishlistModel->removeWishList($id);
        $this->index();
    }
}
