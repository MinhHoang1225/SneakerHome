<?php
require_once './core/Controllers.php';
require_once './models/UserModels.php';
// var_dump($_SESSION);
class UserController extends Controller
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
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

    public function userLogin()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $passWord = htmlspecialchars($_POST['passWord'] ?? '');

            if (empty($email) || empty($passWord)) {
                $_SESSION['error_message'] = "Email and password are required.";
                $_SESSION['username_input'] = $email;
                header("Location: /user/Login");
                exit;
            }

            $userModel = new LoginModel($this->db);
            $result = $userModel->loginUser($email, $passWord);

            if ($result === false) {
                // Nếu mật khẩu hoặc email sai
                $_SESSION['error_message'] = "Invalid email or password. Please try again.";
                $_SESSION['username_input'] = $email;
                header("Location: /user/Login");
                exit;
            } else {
                // Nếu đăng nhập thành công
                // session_unset();
                $_SESSION['isLogin'] = true;
                $_SESSION['email'] = $result->email;
                $_SESSION['userId'] = $result->userId;
                $_SESSION['role'] = $result->role;

                if ($result->role == 'admin') {
                    header("Location: /admin");
                } elseif ($result->role == 'user') {
                    header("Location: /home");
                } else {
                    echo "Invalid role.";
                }
                exit;
            }
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
