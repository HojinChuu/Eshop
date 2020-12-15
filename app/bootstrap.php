<?php
ini_set("display_errors", 1);
ini_set("error_reporting", E_ALL);

require_once "config/config.php";
require_once "helpers/session_helper.php";
require_once "helpers/debug_helper.php";
require_once "helpers/redirect_helper.php";

// Autoload lib
spl_autoload_register(function ($className) {
    require_once "libraries/" . $className . ".php";
});
