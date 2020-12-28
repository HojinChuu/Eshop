<?php

class Validate
{
    /**
     * @param $postData
     * @param $userModel
     * @return array
     */
    public function userRegisterCheck($postData, $userModel)
    {
        $data = [
            "name" => trim($postData["name"]),
            "email" => trim($postData["email"]),
            "password" => trim($postData["password"]),
            "confirm_password" => trim($postData["confirm_password"]),
            "name_err" => "",
            "email_err" => "",
            "password_err" => "",
            "confirm_password_err" => ""
        ];

        if (empty($data["email"])) {
            $data["email_err"] = "メールをご記入ください";
        } else {
            if ($userModel->findUserByEmail($data["email"])) {
                $data["email_err"] = "もうメールアドレスが存在します";
            }
        }

        if (empty($data["name"])) {
            $data["name_err"] = "お名前をご記入ください";
        }

        if (empty($data["password"])) {
            $data["password_err"] = "パスワードをご記入ください";
        } else if (strlen($data["password"]) < 6) {
            $data["password_err"] = "パスワードは6字以上にしてください";
        }

        if (empty($data["confirm_password"])) {
            $data["confirm_password_err"] = "パスワード確認項目をご記入ください";
        } else {
            if ($data["password"] != $data["confirm_password"]) {
                $data["confirm_password_err"] = "パスワードが間違います";
            }
        }

        return $data;
    }

    /**
     * @param $postData
     * @param $userModel
     * @return array
     */
    public function userLoginCheck($postData, $userModel)
    {
        $data = [
            "email" => trim($postData["email"]),
            "password" => trim($postData["password"]),
            "email_err" => "",
            "password_err" => "",
        ];

        if (empty($data["email"])) {
            $data["email_err"] = "メールをご記入ください";
        } else if (!$userModel->findUserByEmail($data["email"])) {
            $data["email_err"] = "メールアドレスが存在しません";
        }

        if (empty($data["password"])) {
            $data["password_err"] = "パスワードをご記入ください";
        }

        return $data;
    }

    /**
     * @param $postData
     * @param $user
     * @return array
     */
    public function userUpdateCheck($postData, $user)
    {
        $data = [
            "id" => $user->id,
            "name" => trim($postData["name"]),
            "password" => trim($postData["password"]),
            "confirm_password" => trim($postData["confirm_password"]),
            "name_err" => "",
            "password_err" => "",
            "confirm_password_err" => ""
        ];

        if (empty($data["name"])) {
            $data["name_err"] = "お名前をご記入ください";
        }

        if (empty($data["password"])) {
            $data["password_err"] = "パスワードをご記入ください";
        } else if (strlen($data["password"]) < 6) {
            $data["password_err"] = "パスワードは6字以上にしてください";
        }

        if (empty($data["confirm_password"])) {
            $data["confirm_password_err"] = "パスワード確認項目をご記入ください";
        } else {
            if ($data["password"] != $data["confirm_password"]) {
                $data["confirm_password_err"] = "パスワードが間違います";
            }
        }

        return $data;
    }
}