<?php

require_once "config/config.php";
require_once "helpers/session_helper.php";
require_once "helpers/redirect_helper.php";
require_once "helpers/mail_helper.php";
require_once "libraries/Controller.php";
require_once "libraries/Core.php";
require_once "libraries/Database.php";
require_once "controllers/Logs.php";
$log = new Logs();
$log->inputData();
