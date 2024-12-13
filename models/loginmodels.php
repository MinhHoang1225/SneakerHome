<?php
$db = connectdb();
class LoginModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function loginUser($email, $Password) {
        try {
            $query = "SELECT * FROM user WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && $Password === $user['password']) {
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
