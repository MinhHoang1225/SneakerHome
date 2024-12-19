<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/SneakerHome/database/connect.php';

class Product {
    private $db;

    public function __construct() {
        $this->db = connectdb();
    }

    public function searchByName($keyword) {
        $query = "SELECT * FROM Product WHERE name LIKE :keyword";
        $stmt = $this->db->prepare($query);
        $keyword = "%$keyword%";
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
