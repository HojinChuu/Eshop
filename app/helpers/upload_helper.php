<?php

function upload($POST, $FILES, $updateProduct = null)
{
    $image_url = "";
    if (isset($FILES["image"]) && !empty($FILES["image"])) {
        $errors = array();
        $file_name = $FILES["image"]["name"];
        $file_size = $FILES["image"]["size"];
        $file_tmp = $FILES["image"]["tmp_name"];
        $file_ext = strtolower((explode(".", $FILES["image"]["name"])[1]));
        $extensions = array("jpeg", "jpg", "png");

        if (in_array($file_ext, $extensions) === false) {
            $errors[] = "extension not allowed, JPEG or PNG";
        }

        if ($file_size > 2097152) {
            $errors[] = "File size おおすぎ";
        }

        if (empty($errors) == true) {
            move_uploaded_file($file_tmp, "upload/" . $file_name);
            if (!empty($updateProduct)) {
                unlink($updateProduct->image_path);
            }
        } else {
            print_r($errors);
        }

        if ($file_name) {
            $image_url = "upload/" . $file_name;
        } else {
            $image_url = "img/no_image.png";
        }
    }

    $price = (int)$POST["price"];
    $stock = (int)$POST["stock"];

    $resultData = [
        "name" => htmlspecialchars(trim($POST["name"])),
        "description" => htmlspecialchars(trim($POST["description"])),
        "image" => $image_url,
        "price" => $price,
        "stock" => $stock,
    ];

    return $resultData;
}
