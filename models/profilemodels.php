<?php
require_once '../database/connect.php';
$db = connectdb();

class User {
    private $conn;
    private $table_name = "User";

    public $user_id;
    public $name;
    public $username;
    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    public function getUserById($user_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser() {
        $query = "UPDATE " . $this->table_name . " 
                  SET name = :name, username = :username, email = :email 
                  WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":user_id", $this->user_id);

        return $stmt->execute();
    }
}
?>
