<?php
require_once '../models/profilemodels.php'; 

class ProfileController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User(); // Tạo một instance của class User
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

        if (empty($data['name']) || empty($data['username']) || empty($data['email'])) {
            throw new InvalidArgumentException("Name, username, and email cannot be empty.");
        }

        // Gán dữ liệu vào model
        $this->userModel->user_id = $data['user_id'];
        $this->userModel->name = htmlspecialchars(strip_tags($data['name'])); // Bảo vệ dữ liệu đầu vào
        $this->userModel->username = htmlspecialchars(strip_tags($data['username']));
        $this->userModel->email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);

        if (!$this->userModel->email) {
            throw new InvalidArgumentException("Invalid email address.");
        }

        return $this->userModel->updateUser();
    }
}
?>
