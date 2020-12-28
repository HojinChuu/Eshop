<?php

class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model("User");
        $this->orderModel = $this->model("Order");
        $this->validator = $this->validate("Validate");
    }

    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            $this->view("users/register");
        } else {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = $this->validator->userRegisterCheck($_POST, $this->userModel);

            if (empty($data["email_err"]) && empty($data["name_err"]) && empty($data["password_err"]) && empty($data["confirm_password_err"])) {
                $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
                if ($this->userModel->register($data)) {
                    flash("register_success", "register success");
                    redirect("users/login");
                }
            }
            $this->view("users/register", $data);
        }
    }

    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            $this->view("users/login");
        } else {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = $this->validator->userLoginCheck($_POST, $this->userModel);

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
            }
            $this->view("users/login", $data);
        }
    }

    /**
     * @param $user
     */
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

    /**
     * @param $id
     */
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

        if ($money >= 2147483647) {
            flash("money_error2", "お金入れすぎ！", "alert alert-danger");
            redirect("users/mypage");
            exit();
        } else {
            $this->userModel->charge($id, $_POST["money"]);
        }

        $this->myPage();
    }

    /**
     * @param $id
     */
    public function update($id)
    {
        $user = $this->userModel->getUserById($id);

        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            $data = [
                "id" => $user->id,
                "name" => $user->name,
            ];
            $this->view("users/edit", $data);
        } else {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = $this->validator->userUpdateCheck($_POST, $user);

            if (empty($data["name_err"]) && empty($data["password_err"]) && empty($data["confirm_password_err"])) {
                $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);

                if ($this->userModel->update($data)) {
                    flash("update_success", "update success");
                    redirect("users/mypage");
                }
            }
            $this->view("users/edit", $data);
        }
    }

    public function admin()
    {
        isAdminUser() ?
            $this->view("admin/index") :
            redirect("products/index");
    }

    public function adminUserPage()
    {
        $users = $this->userModel->getUsers();
        $data = ["users" => $users];

        isAdminUser() ?
            $this->view("admin/userList", $data) :
            redirect("products/index");
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        $this->userModel->deleteUser($id);
        flash("userDelete_success", "userDelete success");
        redirect("users/adminUserPage");
    }
}