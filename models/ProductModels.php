<!-- Cac chuc nang lien quan den cac chuc nang san pham -->

<?php 
require_once './database/connect.php';

class ProductModel {
    private $db;

    // Constructor để khởi tạo đối tượng ProductModel
    public function __construct($db)
    {
        $this->db = $db;
    }

    // Lấy sản phẩm bán chạy theo danh mục với giới hạn
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
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$result) {
                error_log("No products found for category ID: " . $categoryId);
            }
 
            return $result;
        } catch (PDOException $e) {
            error_log("SQL Error in getBestSellersByCategory: " . $e->getMessage());
            die("Database error: " . $e->getMessage());
        }
    }

    public function getAllBestSellersCount($categoryId = null) {
        try {
            $sql = "SELECT COUNT(*) FROM product WHERE is_best_seller = 1" . 
                   ($categoryId ? " AND category_id = :category_id" : "");

            $stmt = $this->db->prepare($sql);

            if ($categoryId) {
                $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            }
            $stmt->execute();

            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("SQL Error in getAllBestSellersCount: " . $e->getMessage());
            die("Database error: " . $e->getMessage());
        }
    }

    // Lấy danh sách sản phẩm bán chạy (tất cả danh mục)
    // public function getBestSellers($limit = 8)
    public function getBestSellers()
    {
        try {
            $sql = "SELECT product_id, name, price, old_price, discount, image_url FROM product WHERE is_best_seller = 1 LIMIT 8";

            $stmt = $this->db->prepare($sql);
            // $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Lỗi khi truy vấn cơ sở dữ liệu: " . $e->getMessage());
        }
    }

    // Lấy chi tiết sản phẩm
    public function getProductDetails($product_id)
    {
        try {
            $sql = "SELECT product_id, category_id, name, price, old_price, discount, image_url, description, stock, color
                    FROM product 
                    WHERE product_id = :product_id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về thông tin sản phẩm
        } catch (PDOException $e) {
            die("Lỗi khi truy vấn cơ sở dữ liệu: " . $e->getMessage());
        }
    }
}
    
    function getRelatedProducts($product_id, $category_id) {
        $conn = connectdb();
        $sql = "SELECT product_id, name, price, old_price, discount, image_url
                FROM product 
                WHERE category_id = :category_id AND product_id != :product_id";
    
        $stmt = $conn->prepare($sql);
    
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
   // Lấy danh sách sản phẩm theo category_id
function getProductsByCategory($category_id = null) {
    $conn = connectdb();
    if ($category_id) {
        $stmt = $conn->prepare("SELECT * FROM product WHERE category_id = :category_id");
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    } else {
        $stmt = $conn->prepare("SELECT * FROM product");
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        $this->db = $db; // Inject the database connection into the constructor
    }

    public function toggleFavorite($userId, $productId) {
        try {
            // Check if the product is already a favorite
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM favorite WHERE user_id = ? AND product_id = ?");
            $stmt->execute([$userId, $productId]);
            $exists = $stmt->fetchColumn();
    
            // Prepare the response array
            $response = ['success' => false, 'message' => 'Có lỗi xảy ra khi cập nhật danh sách yêu thích.'];
    
            if ($exists) {
                // If exists, remove it from favorites
                $stmt = $this->db->prepare("DELETE FROM favorite WHERE user_id = ? AND product_id = ?");
                $result = $stmt->execute([$userId, $productId]);
    
                if ($result) {
                    $response['success'] = true;
                    $response['is_favorited'] = false; // Product was removed from favorites
                    $response['message'] = 'Sản phẩm đã bị xóa khỏi danh sách yêu thích'; // Correct message for removal
                }
            } else {
                // If not, add it to favorites
                $stmt = $this->db->prepare("INSERT INTO favorite (user_id, product_id) VALUES (?, ?)");
                $result = $stmt->execute([$userId, $productId]);
    
                if ($result) {
                    $response['success'] = true;
                    $response['is_favorited'] = true; // Product was added to favorites
                    $response['message'] = 'Sản phẩm đã được thêm vào danh sách yêu thích'; // Correct message for addition
                }
            }
    
            return $response; // Return the response array
    
        } catch (PDOException $e) {
            // Log the error or handle accordingly
            return ['success' => false, 'message' => 'Đã xảy ra lỗi khi xử lý yêu cầu.'];
        }
    }
    
    

    public function getFavorites($userId) {
        try {
            $stmt = $this->db->prepare("SELECT p.* FROM product p JOIN favorite f ON p.product_id = f.product_id WHERE f.user_id = ?");
            $stmt->execute([$userId]);
            $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Debugging: Log dữ liệu trả về
            error_log(print_r($favorites, true));
            
            return $favorites;
        } catch (PDOException $e) {
            // Log the error or handle accordingly
            error_log('Error fetching favorites: ' . $e->getMessage());
            return [];
        }
    }
    
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

?>