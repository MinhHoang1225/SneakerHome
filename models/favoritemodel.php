<?php
class FavoriteModel {
    private $db;

    public function __construct($db) {
        $this->db = $db; // Inject the database connection into the constructor
    }

    public function toggleFavorite($userId, $productId) {
        try {
            // Check if the product is already a favorite
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM favorite WHERE user_id = ? AND product_id = ?");
            $stmt->execute([$userId, $productId]);
            $exists = $stmt->fetchColumn();
        
            if ($exists) {
                // If exists, remove it from favorites
                $stmt = $this->db->prepare("DELETE FROM favorite WHERE user_id = ? AND product_id = ?");
                return $stmt->execute([$userId, $productId]);
            } else {
                // If not, add it to favorites
                $stmt = $this->db->prepare("INSERT INTO favorite (user_id, product_id) VALUES (?, ?)");
                return $stmt->execute([$userId, $productId]);
            }
        } catch (PDOException $e) {
            // Log the error or handle accordingly
            return false;
        }
    }

    public function getFavorites($userId) {
        try {
            $stmt = $this->db->prepare("SELECT p.* FROM product p JOIN favorite f ON p.product_id = f.product_id WHERE f.user_id = ?");
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log the error or handle accordingly
            return [];
        }
    }

    // PHP method to handle removing a favorite from the database
    public function removeFavorite($userId, $productId) {
        try {
            $stmt = $this->db->prepare("DELETE FROM favorite WHERE user_id = ? AND product_id = ?");
            return $stmt->execute([$userId, $productId]);
        } catch (PDOException $e) {
            // Log the error or handle accordingly
            return false;
        }
    }
}
