
<?php
// // session_start();

// require_once $_SERVER['DOCUMENT_ROOT'] .'/SneakerHome/database/connect.php';
// require_once $_SERVER['DOCUMENT_ROOT'] .'/SneakerHome/models/UserModels.php';

// class LoginController {
//     private $db;
    
//     public function __construct($db) {
//         $this->db = $db;
//     }

//     public function login() {
//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//             if (isset($_POST['email']) && isset($_POST['password'])) {
//                 $email = $_POST['email'];
//                 $password = $_POST['password'];

//                 $loginModel = new LoginModel($this->db);
//                 $User = $loginModel->loginUser($email, $password);
                
//                 if ($User) {
//                     // Lưu thông tin người dùng vào session
//                     $_SESSION['user_id'] = $User['user_id'];
//                     $_SESSION['users'] = $User;

//                     // Kiểm tra và chuyển hướng dựa trên vai trò người dùng
//                     switch ($User['role']) {
//                         case 'admin':
//                             header('Location: ./admin');
//                             exit();
//                         case 'user':
//                             header('Location: ./home');
//                             exit();
//                     }
//                 } else {
//                     // Thông báo lỗi nếu không tìm thấy người dùng
//                     $_SESSION['error_message'] = "Invalid username or password";
//                     $_SESSION['username_input'] = $email;
//                 }
//             }
//         }

//         // Hiển thị form đăng nhập nếu không phải phương thức POST
//         require_once $_SERVER['DOCUMENT_ROOT'] .'/SneakerHome/views/loginview.php';
//     }
// }
// $db = connectdb();
// // Khởi tạo và xử lý login
// $loginController = new LoginController($db);
// $loginController->login();
?>
