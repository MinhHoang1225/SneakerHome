<?php 
session_start();
require_once "../database/connect.php";
require_once "../models/login-models.php";
$db = connectdb();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo 'ashd';
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        echo 'ashd';

   
        $login_model = new login_model($db);
        $user = $login_model->login_user($email, $password);
        var_dump($user);

        if (isset($user)) {
            $_SESSION['user'] = $user;
            echo 'ashd';

            switch ($user['role']) {
                case 'admin':
                    header('Location: ./admin');
                    exit();
                case 'user':

                    header('Location: ./home');
                    require '../controller/homecontroller.php';
                    exit();
            }
        } else {
            $_SESSION['error_message'] = "Invalid username or password";
            $_SESSION['username_input'] = '';
            echo 'abc';
        }
    }
}
?>
