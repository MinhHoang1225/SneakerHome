<?php 
class login_model {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    public function login_user($email, $password) {
        try {
            $query = "SELECT * FROM user WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Kiểm tra mật khẩu sử dụng `password_verify`
            if ($user) {
                return $user; // Đăng nhập thành công
            } else {
                return false; // Sai tài khoản hoặc mật khẩu
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage()); // Ghi log lỗi
            return false;
        }
    }
    
}
?>
