<?php
require_once '../core/Controllers.php';
require_once '../models/UserModels.php';
var_dump($_SESSION);
// session_unset();
// unset($_SESSION);
class UserController extends Controllers
{
    private $db;

    public function __construct() {
        $this->db = connectdb(); 
    }

    public function login()
    {
        // Hiển thị view login
        // session_start();
        $this->view('loginview', [
            'error_message' => $_SESSION['error_message'] ?? null,
            'username_input' => $_SESSION['username_input'] ?? ''
        ]);
    }

    public function userLogin() {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Validate input
            if (empty($email) || empty($password)) {
                $_SESSION['error_message'] = "Email and password are required.";
                header("Location: /user/login");
                exit;
            }

            // Login logic
            $loginModel = new LoginModel($this->db);
            $user = $loginModel->loginUser($email, $password);

            if ($user === false) {
                $_SESSION['error_message'] = "Invalid email or password. Please try again.";
                header("Location: /user/login");
                exit;
            }

            // Set session and redirect based on role
            $_SESSION['isLogin'] = true;
            $_SESSION['email'] = $user['email'];
            $_SESSION['userId'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'user') {
                header("Location: /SneakerHome/home");
            } elseif ($user['role'] === 'admin') {
                header("Location: /Admin/admin");
            } else {
                $_SESSION['error_message'] = "Unknown role detected.";
                header("Location: /user/login");
            }
            exit;
        }
    }                                                                                                                                                         

    public function register()
    {
        // Hiển thị view login
        // session_start();
        $this->view('registerview', [
            'error_message' => $_SESSION['error_message'] ?? null,
            'username_input' => $_SESSION['username_input'] ?? ''
        ]);
    }

    public function userRegister(){
            session_start();
    
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $username = $_POST['name'] ??'';
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';
                $confirmPassword = $_POST['confirm_password'] ?? '';
    
                // Kiểm tra nhập liệu
                if (empty($email) || empty($password) || empty($confirmPassword)) {
                    $_SESSION['error_message'] = "All fields are required.";
                    header("Location: /user/register");
                    exit;
                }
    
                if ($password !== $confirmPassword) {
                    $_SESSION['error_message'] = "Passwords do not match.";
                    header("Location: /user/register");
                    exit;
                }
    
                // Đăng ký người dùng
                $registerModel = new RegisterModel($this->db);
                $result = $registerModel->registerUser($email,$username, $password);
    
                if ($result === true) {
                    $_SESSION['success_message'] = "Registration successful. Please log in.";
                    header("Location: /SneakerHome/user/login");
                    exit;
                } elseif ($result === "Email already exists") {
                    $_SESSION['error_message'] = "This email is already registered.";
                    header("Location: /user/register");
                    exit;
                } else {
                    $_SESSION['error_message'] = "Registration failed. Please try again.";
                    header("Location: /user/register");
                    exit;
                }
            }
        
    }


    public function profile()
    {
        // Hiển thị view login
        // session_start();
        $this->view('profileview', [
            'error_message' => $_SESSION['error_message'] ?? null,
            'username_input' => $_SESSION['username_input'] ?? ''
        ]);
    }
}
