<?php

require_once '../database/connect.php';
require_once '../models/loginmodels.php';

class LoginController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function login() {
        // Kiểm tra nếu là yêu cầu POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['email']) && isset($_POST['password'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];

                // Tạo đối tượng LoginModel để xử lý đăng nhập
                $loginModel = new LoginModel($this->db);
                $User = $loginModel->loginUser($email, $password);

                if ($User) {
                    // Lưu thông tin người dùng vào session
                    $_SESSION['users'] = $User;

                    // Redirect dựa trên vai trò của người dùng
                    switch ($User['role']) {
                        case 'admin':
                            header('Location: ./admin');
                            exit();
                        case 'user':
                            header('Location: ./home');
                            exit();
                    }
                } else {
                    // Nếu thông tin đăng nhập không hợp lệ
                    $_SESSION['error_message'] = "Invalid username or password";
                    $_SESSION['username_input'] = $email; // Lưu lại email người dùng nhập vào
                }
            }
        }

        // Hiển thị trang login nếu không phải là POST
        require_once '../views/loginview.php';
    }
}

// Khởi tạo đối tượng LoginController và gọi phương thức login
session_start(); // Đảm bảo session được bắt đầu
$loginController = new LoginController($db);
$loginController->login();

?>
