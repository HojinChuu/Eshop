<?php

/**
 * @param string $page
 */
function redirect($page)
{
    header("location: " . URLROOT . "/" . $page);
}