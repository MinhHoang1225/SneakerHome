<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/models/favoritemodel.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/database/connect.php';

$response = ['success' => false]; // Default to failure
$favoriteModel = new FavoriteModel(connectdb());
$userId = $_SESSION['user_id'] ?? null;
$favorites = $favoriteModel->getFavorites($userId);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['action'], $data['user_id'], $data['product_id']) && $data['action'] === 'toggle_favorite') {
        $userId = $data['user_id'];
        $productId = $data['product_id'];

        $favoriteModel = new FavoriteModel(connectdb());
        $result = $favoriteModel->toggleFavorite($userId, $productId);

        if (isset($result['success']) && $result['success'] === true) {
            $response['success'] = true;
            $response['is_favorited'] = $result['is_favorited']; 
            $response['message'] = $result['message']; 
        } else {
            $response['message'] = $result['message'] ?? 'Có lỗi xảy ra khi cập nhật danh sách yêu thích.';
        }
    } else {
        $response['message'] = 'Dữ liệu yêu cầu không hợp lệ.';
    }

    echo json_encode($response); // Send the response back to the frontend
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/views/favoriteview.php';
?>
