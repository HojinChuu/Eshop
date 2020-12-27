<?php

require_once "config/config.php";
require_once "helpers/session_helper.php";
require_once "helpers/redirect_helper.php";
require_once "helpers/mail_helper.php";

spl_autoload_register(function ($className) {
    require_once "libraries/" . $className . ".php";
});

require_once "controllers/Logs.php";

$log = new Logs();
if ($log->inputData()) {
    $log->mailBtn();
}
