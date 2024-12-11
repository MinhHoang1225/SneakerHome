<?php

require_once '../database/connect.php';
require_once '../models/loginmodels.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $loginModel = new LoginModel($db);
        $User = $loginModel-> loginUser($email, $password);

        if ($User) {
            $_SESSION['user'] = $User;

            switch ($User['role']) {
                case 'admin':
                    echo"admin";
                    header('Location: ./admin');
                    exit();
                case 'user':
                    echo"home";
                    header('Location: ./home');
                    exit();
            }
        } else {
            $_SESSION['error_message'] = "Invalid email or password";
            $_SESSION['email_input'] = ''; // Xóa giá trị của biến $_SESSION['username_input']
        }
    }
}


?>
