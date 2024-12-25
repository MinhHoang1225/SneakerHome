<?php
session_start();
$userId = $_SESSION['user_id'] ?? null;
require_once $_SERVER['DOCUMENT_ROOT']. '/SneakerHome/models/favoritemodel.php';
include_once '../database/connect.php'; // Kết nối DB

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true); // Đọc dữ liệu từ body

    if (isset($data['action']) && $data['action'] === 'toggle_favorite' && isset($data['user_id']) && isset($data['product_id'])) {
        $userId = $data['user_id'];
        $productId = $data['product_id'];

        // Kiểm tra dữ liệu
        if (!$userId || !$productId) {
            $response['message'] = 'Thiếu user_id hoặc product_id';
            echo json_encode($response);
            exit;
        }

        $favoriteModel = new FavoriteModel(connectdb()); // Kết nối DB
        $success = $favoriteModel->toggleFavorite($userId, $productId); // Thực hiện toggle

        if ($success) {
            $response['success'] = true;
            $response['message'] = 'Sản phẩm đã được thêm vào danh sách yêu thích!';
        } else {
            $response['message'] = 'Có lỗi xảy ra khi cập nhật danh sách yêu thích';
        }
    } else {
        $response['message'] = 'Dữ liệu yêu cầu không hợp lệ';
    }
}
if ($userId) {
    $favoriteModel = new FavoriteModel(connectdb());
    $favorites = $favoriteModel->getFavorites($userId); // Giả sử bạn có một phương thức lấy yêu thích theo user_id
} else {
    $favorites = [];
}
include_once '../views/favoriteview.php';
?>
