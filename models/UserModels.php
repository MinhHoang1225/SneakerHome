<?php
require_once './database/connect.php';
$db = connectdb();
class User {
    private $conn;
    private $table_name = "user";

    public $user_id;
    public $name;
    public $email;
    public $password;

    // Constructor to initialize database connection
    public function __construct() {
        $this->conn = connectdb(); 
    }

    // Get orders by user ID
    public function getOrdersByUserId($user_id) {
        $query = "SELECT * FROM `order` WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    // Get user by ID
    public function getUserById($user_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT); 
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update user information
    public function updateUser() {
        $query = "UPDATE " . $this->table_name . " 
                  SET name = :name, email = :email, password = :password
                  WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $this->name, PDO::PARAM_STR);
        $stmt->bindParam(":password", $this->password, PDO::PARAM_STR);
        $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);

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
?>
