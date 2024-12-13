<?php
require_once 'models/profilemodels.php';

class ProfileController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = $db;
    }

    public function showProfile($user_id) {
        return $this->userModel->getUserById($user_id);
    }

    public function updateProfile($data) {
        $this->userModel->user_id = $data['user_id'];
        $this->userModel->name = $data['name'];
        $this->userModel->username = $data['username'];
        $this->userModel->email = $data['email'];

        return $this->userModel->updateUser();
    }
}
?>
