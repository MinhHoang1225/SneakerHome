<?php
require_once './core/Controllers.php';
require_once './models/UserModels.php';
var_dump($_SESSION);
// session_unset();
// unset($_SESSION);
class UserController extends Controllers
{
    private $db;
    public function __construct( ) {
        $this->db = connectdb(); 
    }
    // private $conn;
    // public function __construct() {
    //     $this->conn = connectdb(); 
    // }
    public function profile() {
        // session_start();

        if (!isset($_SESSION['isLogin']) || !$_SESSION['isLogin']) {
            $_SESSION['error_message'] = "Please log in to access your profile.";
            header("Location: /SneakerHome/User/login");
            exit;
        }

        $userModel = new UserModel();
        $user = $userModel->getUserById($_SESSION['userId']);
        $orders = $userModel->getOrdersByUserId($_SESSION['userId']);

        if (!$user) {
            $_SESSION['error_message'] = "User not found.";
            header("Location: /SneakerHome/User/login");
            exit;
        }

        $this->view('profileview', [
            'user' => $user,
            'orders' => $orders,
            'success_message' => $_SESSION['success_message'] ?? null
        ]);

        unset($_SESSION['success_message']);
    }

    public function updateProfile() {
        session_start();

        // if (!isset($_SESSION['isLogin']) || !$_SESSION['isLogin']) {
        //     $_SESSION['error_message'] = "Please log in to update your profile.";
        //     header("Location: /user/login");
        //     exit;
        // }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // if (empty($name) || empty($email)) {
            //     $_SESSION['error_message'] = "Name and email are required.";
            //     header("Location: /SneakerHome/User/profile");
            //     exit;
            // }

            $userModel = new UserModel();
            $userModel->user_id = $_SESSION['userId'];
            $userModel->name = $name;
            $userModel->email = $email;

            if (!empty($password)) {
                $userModel->password = password_hash($password, PASSWORD_BCRYPT);
            }

            $updated = $userModel->updateUser(  $_SESSION['userId'], $name, $email, $password = null);

            if ($updated) {
                $_SESSION['success_message'] = "Profile updated successfully.";
            } else {
                $_SESSION['error_message'] = "Failed to update profile.";
            }

        }
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
    public function logout()
    {
        $logoutModel = new LogoutModel();
        $result = $logoutModel->logoutUser();
        if ($result) {
            $_SESSION['success_message'] = "You have been logged out successfully.";
            header("Location: /SneakerHome/home"); 
            exit();
        } else {
            $_SESSION['error_message'] = "You are not logged in.";
            header("Location: /SneakerHome/User/login"); 
            exit();
        }
    }
}
