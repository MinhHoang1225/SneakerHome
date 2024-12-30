<?php
require_once './core/Controllers.php';
require_once './models/ProductModels.php';
class ProductController extends Controllers {
    private $db;
    public function __construct($db)
    {
        if (!$db) {
            die('Database connection is not established');
        }
        $this->db = $db;
    }

    public function productsCategory() {
        //  category_id từ URL
        $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
        $productModel = new ProductModel($this->db);   
        try {
            $products = $productModel->getProductsByCategory($categoryId);
            error_log(print_r($products, true));
            $this->view('productview', [
                'products' => $products,             
                'categoryId' => $categoryId,        
                'error_message' => $_SESSION['error_message'] ?? null,
                'username_input' => $_SESSION['username_input'] ?? ''
            ]);
        } catch (Exception $e) {
            error_log("Error in productsCategory: " . $e->getMessage());
            $this->view('productview', [
                'products' => [],         
                'error_message' => 'Không thể lấy danh sách sản phẩm. Vui lòng thử lại sau.',
                'username_input' => $_SESSION['username_input'] ?? ''
            ]);
        }
    }
    
    public function detailProduct() {
        $productId = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
    
        if ($productId > 0) {
            $productModel = new ProductModel($this->db);
    
            try {
                $product = $productModel->getProductById($productId);  
                if ($product) {
                    $categoryId = $product['category_id'];
                    $related_products = $productModel->getRelatedProducts($productId, $categoryId);
                    $this->view('detailproductview', [
                        'product' => $product,
                        'related_products' => $related_products,
                        'error_message' => $_SESSION['error_message'] ?? null,
                        'username_input' => $_SESSION['username_input'] ?? '',
                    ]);
                } else {
                    $this->view('errorview', [
                        'error_message' => 'Sản phẩm không tồn tại.'
                    ]);
                }
            } catch (Exception $e) {
                error_log("Error in detailProduct: " . $e->getMessage());
                $this->view('errorview', [
                    'error_message' => 'Không thể lấy chi tiết sản phẩm. Vui lòng thử lại sau.'
                ]);
            }
        } else {
            $this->view('errorview', [
                'error_message' => 'Sản phẩm không hợp lệ.'
            ]);
        }
    }
    public function favorite() {
        if (isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
    
            $favoriteModel = new FavoriteModel($this->db);
            $favorites = $favoriteModel->getFavorites($userId);
    
    
            $this->view('favoriteview', [
                'favorites' => $favorites,  
                'error_message' => $_SESSION['error_message'] ?? null,
                'username_input' => $_SESSION['username_input'] ?? ''
            ]);
        } else {
            header("Location: /SneakerHome/User/login");
            exit();
        }
    }
    
    
    
}
?>
