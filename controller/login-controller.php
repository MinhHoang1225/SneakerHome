<?php 
    require_once "./database/connect.php";
    require_once "./models/login-models.php";

    if ($_SERVER ['REQUEST_METHOD'] === 'POST'){
        if (isset($_POST['username']) && isset($_POST['password'])){
            $username = $_POST['username'];
            $password = $_POST['password'];

            $login_model = new login_model($db);
            $user = $login_model -> login_user($username, $password);
            
            if ($user){
                $_SESSION['user'] = $user;

                switch($user['role']){
                    case 'admin':
                        header('location: ./admin');
                        exit();
                    case 'customer':
                        header('location: ./home');
                }
            }
            else{
                $_SESSION['error_message'] = "username or password invalid";
                $_SESSION['username_input'] = ''; 
            }
        }
    }
    require_once './views/login-view.php';
?>