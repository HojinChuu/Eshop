<?php

/**
 * @param $data
 */
function sendToMail($data)
{
    // $recipient = 'cnghwls12@naver.com, chu@estore.co.jp';
    $recipient = 'kubo@estore.co.jp, takawashi@estore.co.jp, tak-sasaki@estore.co.jp, f-maeda@estore.co.jp, kanayama@estore.co.jp, kumamimi@estore.co.jp, mi-kim@estore.co.jp, y-saito@estore.co.jp';
    $sender = 'chu@estore.co.jp';
    $subject = "Log Management";
    $rank1 = ($data["product_ranking"][0] != "") ? $data["product_ranking"][0] : "Nothing";
    $rank2 = isset($data["product_ranking"][1]) ? $data["product_ranking"][1] : "Nothing";
    $rank3 = isset($data["product_ranking"][2]) ? $data["product_ranking"][2] : "Nothing";
    $rank4 = isset($data["product_ranking"][3]) ? $data["product_ranking"][3] : "Nothing";
    $rank5 = isset($data["product_ranking"][4]) ? $data["product_ranking"][4] : "Nothing";

    $message = "<p>お疲れ様です。チュホジンです。</p>";
    $message .= "<p>ショップの集計です。</p>";
    $message .= "<h2>" . $data["date"] . "</h2>";
    $message .= "<h5>UU : " . $data['uu'] . "</h5>";
    $message .= "<h5>PV : " . $data['pv'] . "</h5>";
    $message .= "<h5>Order Count : " . $data['order_count'] . " 回</h5>";
    $message .= "<h5>Conversion Rate : " . round(($data['order_count'] / $data['pv']) * 100, 6) . " %</h5>";
    $message .= "<h5>Admin Page : " . $data['page']['admin_page'] . " 回</h5>";
    $message .= "<h5>Product Page : " . $data['page']['products_page'] . " 回</h5>";
    $message .= "<h5>User Page : " . $data['page']['users_page'] . " 回</h5>";
    $message .= "<h5>Order Page : " . $data['page']['orders_page'] . " 回</h5>";
    $message .= "<h5>WishList Page : " . $data['page']['wishlists_page'] . " 回</h5>";
    $message .= "<small><strong># Product Ranking</strong></small><br>";
    $message .= "<small>1. " . $rank1 . "</small><br>";
    $message .= "<small>2. " . $rank2 . "</small><br>";
    $message .= "<small>3. " . $rank3 . "</small><br>";
    $message .= "<small>4. " . $rank4 . "</small><br>";
    $message .= "<small>5. " . $rank5 . "</small>";

    $headers = 'From:' . $sender;
    $headers .= "\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8";

    mail($recipient, $subject, $message, $headers);
}