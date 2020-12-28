<?php

class Controller
{
    /**
     * @param $model
     * @return mixed
     */
    public function model($model)
    {
        require_once APPROOT . "/models/" . $model . ".php";
        return new $model();
    }

    /**
     * @param $view
     * @param array $data
     */
    public function view($view, $data = [])
    {
        if (file_exists(APPROOT . "/views/" . $view . ".php")) {
            require_once APPROOT . "/views/" . $view . ".php";
        } else {
            die("View does not exist");
        }
    }

    /**
     * @param $validate
     * @return mixed
     */
    public function validate($validate)
    {
        require_once APPROOT . "/validation/" . $validate . ".php";
        return new $validate();
    }
}