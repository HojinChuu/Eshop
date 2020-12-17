<?php

function shopserveGetRequest($path)
{
    $requestPath = SAPI_ROOT . $path;

    $curl = curl_init($requestPath);

    $headers = [
        "Content-Type: application/json",
        "Authorization: " . SAPI_AUTHORIZATION
    ];

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $data = curl_exec($curl);

    return json_decode($data, true);
}

function shopservePostRequest()
{

}