<?php
require_once '../database/connect.php';

class User {
    private $conn;
    private $table_name = "User";

    public $user_id;
    public $name;
    public $username;
    public $email;
    public $password;

    // Constructor sửa đổi để sử dụng connectdb()
    public function __construct() {
        $this->conn = connectdb(); // Gọi hàm connectdb() để khởi tạo kết nối
    }

    // Lấy thông tin người dùng dựa trên ID
    public function getUserById($user_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT); // Đảm bảo kiểu dữ liệu là INT
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về thông tin người dùng dưới dạng mảng liên kết
    }

    // Cập nhật thông tin người dùng
    public function updateUser() {
        $query = "UPDATE " . $this->table_name . " 
                  SET name = :name, username = :username, email = :email 
                  WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $this->name, PDO::PARAM_STR);
        $stmt->bindParam(":username", $this->username, PDO::PARAM_STR);
        $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);

        return $stmt->execute(); // Trả về true nếu thành công, false nếu thất bại
    }
}
?>
