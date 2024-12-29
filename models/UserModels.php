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

    // Login user
    public function loginUser($email, $password) {
        try {
            $query = "SELECT * FROM user WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}

// Validation functions
function validate_username($name) {
    return ctype_alnum($name);
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_password($password) {
    return strlen($password) >= 6;
}

function check_email_exists($db, $email) {
    $query = "SELECT COUNT(*) FROM user WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

// Register user
function register_user($db, $name, $email, $password, $role = 'user') {
    try {
        if (!$db) {
            throw new Exception("Database connection is null.");
        }

        if (check_email_exists($db, $email)) {
            throw new Exception("Email is already registered.");
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO user (name, email, password, role) VALUES (:name, :email, :password, :role)";
        $stmt = $db->prepare($query);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":role", $role);

        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Registration failed. PDO Error: " . $e->getMessage();
        return false;
    } catch (Exception $e) {
        echo "Registration failed. Error: " . $e->getMessage();
        return false;
    }
}
?>
