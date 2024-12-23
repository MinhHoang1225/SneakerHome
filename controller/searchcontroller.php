<?php
require_once '../database/connect.php';

function searchProducts($keyword) {
    $db = connectdb();
    try {
        $query = "SELECT name, price, image_url FROM product WHERE name LIKE :keyword";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}
include '../views/searchview.php'
?>
