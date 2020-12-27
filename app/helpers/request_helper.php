<?php

/**
 * @param $path
 * @param string $method
 * @param null $body
 * @param bool $manager
 * @return array
 */
function shopserveRequest($path, $method = "GET", $body = null, $manager = true)
{
    $requestPath = SPAPI_ROOT . $path;
    $curl = curl_init($requestPath);

    $manager ?
        curl_setopt($curl, CURLOPT_USERPWD, SPAPI_USERNAME . ":" . SPAPI_MANAGER_PASSWORD) :
        curl_setopt($curl, CURLOPT_USERPWD, SPAPI_USERNAME . ":" . SPAPI_OPEN_PASSWORD);
    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
            break;
        case "DELETE":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
            break;
    }

    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $data = curl_exec($curl);
    $info = curl_getinfo($curl);
    curl_close($curl);

    return $data = ["data" => json_decode($data), "info" => $info];
}