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


    public function getCheckoutCart($userId) {
        $sql = "SELECT ci.cart_id, ci.product_id, p.name, p.price, ci.quantity, p.image_url 
                    FROM shoppingcart sc
                    JOIN cartitem ci ON sc.cart_id = ci.cart_id
                    JOIN product p ON p.product_id = ci.product_id
                    WHERE sc.user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function calculateCheckoutTotal($userId)

        {
            $sql = "SELECT SUM(ci.quantity * p.price) AS total
                    FROM cartitem ci
                    JOIN product p ON ci.product_id = p.product_id
                    JOIN shoppingcart sc ON ci.cart_id = sc.cart_id
                    WHERE sc.user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn();
        }
    


    public function getCheckoutBuyNow($productId, $quantity) {
        try {
            $query = "SELECT * FROM product WHERE product_id = :product_id AND stock >= :quantity";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->execute();
    
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getCheckoutBuyNow: " . $e->getMessage());
            return null;
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

    public function getCheckoutSuccess($userId) {
        $sql = "SELECT ci.cart_id, ci.product_id, p.name, p.price, ci.quantity, p.image_url 
                    FROM shoppingcart sc
                    JOIN cartitem ci ON sc.cart_id = ci.cart_id
                    JOIN product p ON p.product_id = ci.product_id
                    WHERE sc.user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function calculateCheckoutSuccessTotal($userId)
        {
            $sql = "SELECT SUM(ci.quantity * p.price) AS total
                    FROM cartitem ci
                    JOIN product p ON ci.product_id = p.product_id
                    JOIN shoppingcart sc ON ci.cart_id = sc.cart_id
                    WHERE sc.user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn();
        }

        public function getCheckoutSuccessBuyNow($productId, $quantity) {
            try {
                // Lấy thông tin sản phẩm từ bảng product
                $query = "SELECT product_id, name, price, image_url, :quantity AS quantity 
                          FROM product 
                          WHERE product_id = :product_id";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $stmt->execute();
        
                // Trả về một mảng chứa sản phẩm
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
                return $product ? [$product] : [];
            } catch (PDOException $e) {
                error_log("Error in getCheckoutSuccessBuyNow: " . $e->getMessage());
                return [];
            }
        }
    
    // public function calculateCheckoutSuccessBuyNowBuyNowTotal($userId)
    // {
    //     $sql = "SELECT SUM(ci.quantity * p.price) AS total
    //             FROM cartitem ci
    //             JOIN product p ON ci.product_id = p.product_id
    //             JOIN shoppingcart sc ON ci.cart_id = sc.cart_id
    //             WHERE sc.user_id = :user_id";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    //     $stmt->execute();
    //     return $stmt->fetchColumn();
    // }   



    public function saveOrder($productId, $quantity, $totalPrice)
{
    try {
        // Debug: Kiểm tra session user_id
        error_log('Session User ID: ' . $_SESSION['user_id']);

        // Chèn vào bảng order
        $query = "INSERT INTO `order` (user_id, order_date, status, total_amount) 
                  VALUES (:user_id, NOW(), 'pending', :total_amount)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $_SESSION['userId'], PDO::PARAM_INT);
        $stmt->bindParam(':total_amount', $totalPrice, PDO::PARAM_STR);
        $stmt->execute();

        // Lấy ID đơn hàng vừa tạo
        $orderId = $this->db->lastInsertId();
        error_log("Order ID: $orderId");

        // Chèn vào bảng orderitem
        $query = "INSERT INTO orderitem (order_id, product_id, quantity, price) 
                  VALUES (:order_id, :product_id, :quantity, :price)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':price', $totalPrice, PDO::PARAM_STR);
        $stmt->execute();

        return $orderId;
    } catch (PDOException $e) {
        error_log("Error in saveOrder: " . $e->getMessage());
        return null;
    }
}


public function saveOrderCart($products, $totalPrice)
{
    try {
        // Debug: Kiểm tra session user_id
        error_log('Session User ID: ' . $_SESSION['user_id']);

        // Bắt đầu giao dịch
        $this->db->beginTransaction();

        // Chèn vào bảng `order`
        $query = "INSERT INTO `order` (user_id, order_date, status, total_amount) 
                  VALUES (:user_id, NOW(), 'pending', :total_amount)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':total_amount', $totalPrice, PDO::PARAM_STR);
        $stmt->execute();

        // Lấy ID đơn hàng vừa tạo
        $orderId = $this->db->lastInsertId();
        error_log("Order ID: $orderId");

        // Chèn vào bảng `orderitem` cho từng sản phẩm trong giỏ hàng
        $query = "INSERT INTO orderitem (order_id, product_id, quantity, price) 
                  VALUES (:order_id, :product_id, :quantity, :price)";
        $stmt = $this->db->prepare($query);

        foreach ($products as $product) {
            // Binding các tham số cho câu lệnh SQL
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $product['id'], PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $product['quantity'], PDO::PARAM_INT);
            $stmt->bindParam(':price', $product['price'], PDO::PARAM_STR);
            $stmt->execute();
        }

        // Commit giao dịch
        $this->db->commit();

        return $orderId;

    } catch (PDOException $e) {
        // Rollback giao dịch nếu có lỗi
        $this->db->rollBack();
        error_log("Error in saveOrder: " . $e->getMessage());
        return null;
    }
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

    public function favorite($userId, $productId) {
    

    $input = json_decode(file_get_contents('php://input'), true);
        try {
            // Kiểm tra xem sản phẩm đã có trong danh sách yêu thích chưa
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM favorite WHERE user_id = ? AND product_id = ?");
            $stmt->execute([$userId, $productId]);
            $exists = $stmt->fetchColumn();

            if ($exists) {
                // Nếu đã yêu thích, xóa khỏi danh sách yêu thích
                // $stmt = $this->db->prepare("DELETE FROM favorite WHERE user_id = ? AND product_id = ?");
                $result = $stmt->execute([$userId, $productId]);
                if ($result) {
                    return ['success' => true, 'is_favorited' => false, 'message' => 'Sản phẩm đã có trong danh sách yêu thích'];
                }
            } else {
                // Nếu chưa yêu thích, thêm vào danh sách yêu thích
                $stmt = $this->db->prepare("INSERT INTO favorite (user_id, product_id) VALUES (?, ?)");
                $result = $stmt->execute([$userId, $productId]);
                if ($result) {
                    return ['success' => true, 'is_favorited' => true, 'message' => 'Sản phẩm đã được thêm vào danh sách yêu thích'];
                }
            }

            return ['success' => false, 'message' => 'Không thể cập nhật yêu thích'];

        } catch (PDOException $e) {
            error_log('Error in toggleFavorite method: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Có lỗi xảy ra khi xử lý yêu cầu.'];
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
            error_log('Error removing favorite: ' . $e->getMessage());
            return false;
        }
    }
    
}
