<?php

require_once '../database/connect.php';
require_once '../models/loginmodels.php';
class LoginController {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['email']) && isset($_POST['password'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];

                $loginModel = new LoginModel($this->db);
                $User = $loginModel->loginUser($email, $password);

                if ($User) {
                    $_SESSION['users'] = $User;

                    switch ($User['role']) {
                        case 'admin':
                            header('Location: ./admin');
                            exit();
                        case 'user':
                            header('Location: ./home');
                            exit();
                    }
                } else {
                    $_SESSION['error_message'] = "Invalid username or password";
                    $_SESSION['username_input'] = $email;
                }
            }
        }
        require_once '../views/loginview.php';
    }
}
session_start();
$loginController = new LoginController($db);
$loginController->login();
?>