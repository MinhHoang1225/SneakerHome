<?php 
require_once './database/connect.php';

class ProductModel {
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
public function getBestSellersByCategory($categoryId, $limit = 8) {
    try {
        $sql = "SELECT product_id, name, price, old_price, discount, image_url 
                FROM product 
                WHERE is_best_seller = 1" .
                ($categoryId > 0 ? " AND category_id = :category_id" : "") . 
                " LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        if ($categoryId > 0) {
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        }
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  
    } catch (PDOException $e) {
        error_log("Error in getBestSellersByCategory: " . $e->getMessage());
        return [];  
    }
}

public function getAllBestSellersCount($categoryId = null) {
    try {
        $sql = "SELECT COUNT(*) 
                FROM product 
                WHERE is_best_seller = 1" .
                ($categoryId ? " AND category_id = :category_id" : "");

        $stmt = $this->db->prepare($sql);


        if ($categoryId) {
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        }
        $stmt->execute();

        return $stmt->fetchColumn();  
    } catch (PDOException $e) {
        error_log("SQL Error in getAllBestSellersCount: " . $e->getMessage());
        return 0;  
    }
}

public function getBestSellers($limit = 8) {
    try {
        $sql = "SELECT product_id, name, price, old_price, discount, image_url 
                FROM product 
                WHERE is_best_seller = 1 
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);

        
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  
    } catch (PDOException $e) {
        error_log("Error in getBestSellers: " . $e->getMessage());
        return []; 
    }
}


    public function getProductDetails($product_id)
    {
        try {
            $sql = "SELECT product_id, category_id, name, price, old_price, discount, image_url, description, stock, color
                    FROM product 
                    WHERE product_id = :product_id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            die("Lỗi khi truy vấn cơ sở dữ liệu: " . $e->getMessage());
        }
    }

    
    public function getRelatedProducts($product_id, $category_id) {
        $sql = "SELECT product_id, name, price, old_price, discount, image_url
                FROM product 
                WHERE category_id = :category_id AND product_id != :product_id";
    
        $stmt = $this->db->prepare($sql); 
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getProductsByCategory($categoryId = null) {
        try {
            $sql = $categoryId 
                ? "SELECT * FROM product WHERE category_id = :category_id"
                : "SELECT * FROM product";

            $stmt = $this->db->prepare($sql);
            if ($categoryId) {
                $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            }
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database query error: " . $e->getMessage());
        }
    }
    public function getProductById($productId) {
        $sql = "SELECT * FROM product WHERE product_id = :product_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);  
    }
    
}
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
class FavoriteModel {
    private $db;

    public function __construct($db) {
        $this->db = $db; 
    }

    public function toggleFavorite($userId, $productId) {
        try {

            $stmt = $this->db->prepare("SELECT COUNT(*) FROM favorite WHERE user_id = ? AND product_id = ?");
            $stmt->execute([$userId, $productId]);
            $exists = $stmt->fetchColumn();
            $response = ['success' => false, 'message' => 'Có lỗi xảy ra khi cập nhật danh sách yêu thích.'];
    
            if ($exists) {
                $stmt = $this->db->prepare("DELETE FROM favorite WHERE user_id = ? AND product_id = ?");
                $result = $stmt->execute([$userId, $productId]);
    
                if ($result) {
                    $response['success'] = true;
                    $response['is_favorited'] = false; 
                    $response['message'] = 'Sản phẩm đã bị xóa khỏi danh sách yêu thích'; 
                }
            } else {
                $stmt = $this->db->prepare("INSERT INTO favorite (user_id, product_id) VALUES (?, ?)");
                $result = $stmt->execute([$userId, $productId]);
    
                if ($result) {
                    $response['success'] = true;
                    $response['is_favorited'] = true; 
                    $response['message'] = 'Sản phẩm đã được thêm vào danh sách yêu thích'; 
                }
            }
    
            return $response; 
    
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Đã xảy ra lỗi khi xử lý yêu cầu.'];
        }
    }
    
    

    public function getFavorites($userId) {
        try {
            $stmt = $this->db->prepare("SELECT p.* FROM product p JOIN favorite f ON p.product_id = f.product_id WHERE f.user_id = ?");
            $stmt->execute([$userId]);
            $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log(print_r($favorites, true));
            
            return $favorites;
        } catch (PDOException $e) {
            error_log('Error fetching favorites: ' . $e->getMessage());
            return [];
        }
    }
    
    public function removeFavorite($userId, $productId) {
        try {
            $stmt = $this->db->prepare("DELETE FROM favorite WHERE user_id = ? AND product_id = ?");
            return $stmt->execute([$userId, $productId]);
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>