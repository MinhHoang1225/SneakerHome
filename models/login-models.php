<?php 
class login_model {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function login_user($username, $password) {
        try {
            $query = "SELECT * FROM users WHERE name = :username";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':Username', $username);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC); // duyet database

            if ($user && $password === $user['password']) { // kiem tra mat khau
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
?>
