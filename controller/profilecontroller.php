<?php
require_once '../database/connect.php';
require_once '../models/profilemodels.php'; 

class ProfileController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User(); 
    }
    // Thêm phương thức trong ProfileController

    public function getOrdersByUserId($user_id) {
        $orders = $this->userModel->getOrdersByUserId($user_id);
        return $orders;
    }

    // Hiển thị thông tin hồ sơ người dùng
    public function showProfile($user_id) {
        if (empty($user_id) || !is_numeric($user_id)) {
            throw new InvalidArgumentException("Invalid user ID provided.");
        }
        return $this->userModel->getUserById($user_id);
    }

    // Cập nhật thông tin hồ sơ người dùng
    public function updateProfile($data) {
        if (empty($data['user_id']) || !is_numeric($data['user_id'])) {
            throw new InvalidArgumentException("Invalid user ID.");
        }
        // Gán dữ liệu vào model
        $this->userModel->user_id = $data['user_id'];
        $this->userModel->name = htmlspecialchars(strip_tags($data['name'])); 
        $this->userModel->password = htmlspecialchars(strip_tags($data['password'])); 
        $this->userModel->email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);

        if (!$this->userModel->email) {
            throw new InvalidArgumentException("Invalid email address.");
        }

        return $this->userModel->updateUser();

    }
}
include_once "../views/profileview.php" ;


?>

