<?php

class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model("User");
        $this->orderModel = $this->model("Order");
    }

    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                "name" => trim($_POST["name"]),
                "email" => trim($_POST["email"]),
                "password" => trim($_POST["password"]),
                "confirm_password" => trim($_POST["confirm_password"]),
                "name_err" => "",
                "email_err" => "",
                "password_err" => "",
                "confirm_password_err" => ""
            ];

            if (empty($data["email"])) {
                $data["email_err"] = "メールをご記入ください";
            } else {
                if ($this->userModel->findUserByEmail($data["email"])) {
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

            if (empty($data["email_err"]) && empty($data["name_err"]) && empty($data["password_err"]) && empty($data["confirm_password_err"])) {

                $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);

                if ($this->userModel->register($data)) {
                    flash("register_success", "register success");
                    redirect("users/login");
                } else {
                    die("Something wrong");
                }
            } else {
                $this->view("users/register", $data);
            }
        } else {
            $data = [
                "name" => "",
                "email" => "",
                "password" => "",
                "confirm_password" => "",
                "name_err" => "",
                "email_err" => "",
                "password_err" => "",
                "confirm_password_err" => ""
            ];

            $this->view("users/register", $data);
        }
    }

    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                "email" => trim($_POST["email"]),
                "password" => trim($_POST["password"]),
                "email_err" => "",
                "password_err" => "",
            ];

            if (empty($data["email"])) {
                $data["email_err"] = "メールをご記入ください";
            } else if (!$this->userModel->findUserByEmail($data["email"])) {
                $data["email_err"] = "メールアドレスが存在しません";
            }

            if (empty($data["password"])) {
                $data["password_err"] = "パスワードをご記入ください";
            }

            if (empty($data["email_err"]) && empty($data["password_err"])) {

                $loggedInUser = $this->userModel->login($data["email"], $data["password"]);

                if ($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                    flash("login_success", "login success");
                    redirect("posts/index");
                } else {
                    $data["password_err"] = "パスワードが間違います";
                    $this->view("users/login", $data);
                }
            } else {
                $this->view("users/login", $data);
            }
        } else {
            $data = [
                "email" => "",
                "password" => "",
                "email_err" => "",
                "password_err" => ""
            ];

            $this->view("users/login", $data);
        }
    }

    public function createUserSession($user)
    {
        $_SESSION["user_id"] = $user->id;
        $_SESSION["user_email"] = $user->email;
        $_SESSION["user_name"] = $user->name;
        $_SESSION["user_isAdmin"] = $user->isAdmin;
    }

    public function logout()
    {
        unset($_SESSION["user_id"]);
        unset($_SESSION["user_email"]);
        unset($_SESSION["user_name"]);
        unset($_SESSION["user_isAdmin"]);

        session_destroy();
        session_start();

        flash("logout_success", "logout success");
        redirect("products/index");
    }

    public function myPage()
    {
        $user_id = $_SESSION["user_id"];

        if (isset($user_id)) {
            $user = $this->userModel->getUserById($_SESSION["user_id"]);
            $orders = $this->orderModel->getOrders($user_id);

            $data = [
                "user" => $user,
                "orders" => $orders
            ];
        }
        $this->view("users/mypage", $data);
    }

    public function moneyCharge($id)
    {
        $user_id = $_SESSION["user_id"];
        $money = (int)$_POST["money"];

        $user = $this->userModel->getUserById($user_id);

        if ($user->money >= 2147483647) {
            flash("money_error1", "持てるお金の範囲を外れました", "alert alert-danger");
            redirect("users/mypage");
            exit();
        }

        if ($money >=  2147483647) {
            flash("money_error2", "お金入れすぎ！", "alert alert-danger");
            redirect("users/mypage");
            exit();
        } else {
            $this->userModel->charge($id, $_POST["money"]);
        }

        $this->myPage();
    }

    // User Update
    public function update($id)
    {
        $user = $this->userModel->getUserById($id);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                "id" => $user->id,
                "name" => trim($_POST["name"]),
                "password" => trim($_POST["password"]),
                "confirm_password" => trim($_POST["confirm_password"]),
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

            if (empty($data["name_err"]) && empty($data["password_err"]) && empty($data["confirm_password_err"])) {

                $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);

                if ($this->userModel->update($data)) {
                    flash("update_success", "update success");
                    redirect("users/mypage");
                } else {
                    die("Something wrong");
                }
            } else {
                $this->view("users/edit", $data);
            }
        } else {
            $data = [
                "id" => $user->id,
                "name" => $user->name,
                "password" => "",
                "confirm_password" => "",
                "name_err" => "",
                "password_err" => "",
                "confirm_password_err" => ""
            ];

            $this->view("users/edit", $data);
        }
    }

    // ADMIN Page Redirect
    public function admin()
    {
        if (isAdminUser()) {
            $this->view("admin/index");
        } else {
            redirect("products/index");
        }
    }

    // ADMIN User Management
    public function adminUserPage()
    {
        $users = $this->userModel->getUsers();

        $data = ["users" => $users];

        if (isAdminUser()) {
            $this->view("admin/userList", $data);
        } else {
            redirect("products/index");
        }
    }

    // ADMIN User Remove
    public function destroy($id)
    {
        $this->userModel->deleteUser($id);
        flash("userDelete_success", "userDelete success");
        redirect("users/adminUserPage");
    }
}