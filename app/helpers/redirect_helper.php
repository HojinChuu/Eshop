<?php

/**
 * @param $page
 */
function redirect($page)
{
    header("location: " . URLROOT . "/" . $page);
}