<?php
require_once './database/connect.php';
$db = connectdb();
class UserModel {
    private $db;
    
    public $user_id;
    public $name;
    public $email;
    public $password;
    public function __construct() {
        $this->db = connectdb(); 
    }

    public function getUserById($user_id) {
        $query = "SELECT * FROM user WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrdersByUserId($user_id) {
        $query = "SELECT * FROM `order` WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateUser($user_id, $name, $email, $password = null) {
        $query = "UPDATE user SET name = :name, email = :email";

        if ($password) {
            $query .= ", password = :password";
        }

        $query .= " WHERE user_id = :user_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
        }

        return $stmt->execute();
    }
}
class LoginModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function loginUser($email, $password) {
        try {
            $query = "SELECT * FROM user WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user; // Return user data if password matches
            }
            return false; // Login failed
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
}

class RegisterModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function registerUser($email,$username, $password, $role = 'user') {
        try {
            // Kiểm tra email đã tồn tại
            $query = "SELECT * FROM user WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingUser) {
                return "Email already exists";
            }

            // Thêm người dùng mới
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO user (name, email, password, role) VALUES (:username,:email, :password, :role)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
}
class LogoutModel {

    public function logoutUser() {
        try {
            if (isset($_SESSION['userId'])) {
                session_unset();
                session_destroy();
                return true; 
            }
            return false; 
        } catch (Exception $e) {
            error_log("Error during logout: " . $e->getMessage());
            return false;
        }
    }
}

?>
