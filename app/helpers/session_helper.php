<?php

session_start();

/**
 * @param string $name
 * @param string $message
 * @param string $class
 */
function flash($name = "", $message = "", $class = "alert alert-success")
{
    if (!empty($name)) {

        if (!empty($message) && empty($_SESSION[$name])) {

            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }

            if (!empty($_SESSION[$name . "_class"])) {
                unset($_SESSION[$name . "_class"]);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name . "_class"] = $class;
        } else if (empty($message) && !empty($_SESSION[$name])) {

            $class = !empty($_SESSION[$name . "_class"]) ? $_SESSION[$name . "_class"] : "";
            echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name . "_class"]);
        }
    }
}

/**
 * @return bool
 */
function isLoggedIn()
{
    return isset($_SESSION["user_id"]) ? true : false;
}

/**
 * @return bool
 */
function isAdminUser()
{
    return isset($_SESSION["user_isAdmin"]) ? true : false;
}