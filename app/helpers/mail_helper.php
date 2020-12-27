<?php

/**
 * @param array $data
 */
function sendToMail($data)
{
    $recipient = 'chu@estore.co.jp';
    $sender = 'chu@estore.co.jp';
    $subject = "Log Management";

    $message = "<h2>" . $data["date"] . "</h2>";
    $message .= "<h5>UU : " . $data['uu'] . "</h5>";
    $message .= "<h5>PV : " . $data['pv'] . "</h5>";
    $message .= "<h5>Order Count : " . $data['page']['wishlists_page'] . " 回</h5>";
    $message .= "<h5>Conversion Rate : " . round($data['order_count'] / $data['pv'], 6) . " %</h5>";
    $message .= "<h5>Admin Page : " . $data['page']['admin_page'] . " 回</h5>";
    $message .= "<h5>Product Page : " . $data['page']['products_page'] . " 回</h5>";
    $message .= "<h5>User Page : " . $data['page']['users_page'] . " 回</h5>";
    $message .= "<h5>Order Page : " . $data['page']['orders_page'] . " 回</h5>";
    $message .= "<h5>WishList Page : " . $data['page']['wishlists_page'] . " 回</h5>";
    $message .= "<small><strong># Product Ranking</strong></small><br>";
    $message .= "<small>1. " . $data['product_ranking'][0] . "</small><br>";
    $message .= "<small>2. " . $data['product_ranking'][1] . "</small><br>";
    $message .= "<small>3. " . $data['product_ranking'][2] . "</small><br>";
    $message .= "<small>4. " . $data['product_ranking'][3] . "</small><br>";
    $message .= "<small>5. " . $data['product_ranking'][4] . "</small>";

    $headers = 'From:' . $sender;
    $headers .= "\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8";

    mail($recipient, $subject, $message, $headers);
}

