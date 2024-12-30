<?php
require_once './core/Controllers.php';
require_once './models/ProductModels.php';
// require './database/connect.php';
// var_dump($_SESSION);
class ProductController extends Controllers {
    private $db;

    // Constructor to initialize ProductModel
    public function __construct($db)
    {
        if (!$db) {
            die('Database connection is not established');
        }
        $this->db = $db;
    }


    public function displayProducts() {
        $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
        $limit = 8;
    
        $productModel = new ProductModel($this->db);
        $allProduct = $productModel->getBestSellers();
        $products = $productModel->getBestSellersByCategory($categoryId, $limit);
        $totalProducts = $productModel->getAllBestSellersCount($categoryId);
    
        error_log([ 
            'allProduct' => $allProduct,
            'products' => $products,
            'totalProducts' => $totalProducts,
            'categoryId' => $categoryId,
            'limit' => $limit
        ]);
        
        $this->view('homeview', [
            'allProduct' => $allProduct,
            'products' => $products,
            'totalProducts' => $totalProducts,
            'categoryId' => $categoryId,
            'limit' => $limit,
        ]);
    }
    
    

    public function productsCategory() {
        // Kiểm tra category_id từ URL hoặc gán mặc định là 0
        $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
    
        // Khởi tạo ProductModel
        $productModel = new ProductModel($this->db);
    
        try {
            // Lấy danh sách sản phẩm theo category_id
            $products = $productModel->getProductsByCategory($categoryId);
    
            // Debugging: Kiểm tra danh sách sản phẩm
            error_log(print_r($products, true));
    
            // Gọi view và truyền dữ liệu
            $this->view('productview', [
                'products' => $products,             // Danh sách sản phẩm
                'categoryId' => $categoryId,         // ID danh mục để dùng trong giao diện
                'error_message' => $_SESSION['error_message'] ?? null,
                'username_input' => $_SESSION['username_input'] ?? ''
            ]);
        } catch (Exception $e) {
            // Nếu có lỗi, ghi log và hiển thị thông báo lỗi
            error_log("Error in productsCategory: " . $e->getMessage());
            $this->view('productview', [
                'products' => [],                     // Trả về danh sách rỗng
                'error_message' => 'Không thể lấy danh sách sản phẩm. Vui lòng thử lại sau.',
                'username_input' => $_SESSION['username_input'] ?? ''
            ]);
        }
    }
    public function detailProduct() {
        // Kiểm tra nếu có 'product_id' trong URL
        $productId = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
    
        if ($productId > 0) {
            // Khởi tạo ProductModel
            $productModel = new ProductModel($this->db);
    
            try {
                // Lấy chi tiết sản phẩm theo product_id
                $product = $productModel->getProductById($productId);
    
                // Kiểm tra nếu sản phẩm tồn tại
                if ($product) {
                    // Gọi view và truyền dữ liệu sản phẩm
                    $this->view('detailproductview', [
                        'product' => $product,  // Thông tin chi tiết sản phẩm
                        'error_message' => $_SESSION['error_message'] ?? null,
                        'username_input' => $_SESSION['username_input'] ?? ''
                    ]);
                } else {
                    // Nếu không có sản phẩm, hiển thị lỗi
                    $this->view('errorview', [
                        'error_message' => 'Sản phẩm không tồn tại.'
                    ]);
                }
            } catch (Exception $e) {
                // Nếu có lỗi, ghi log và hiển thị thông báo lỗi
                error_log("Error in detailProduct: " . $e->getMessage());
                $this->view('errorview', [
                    'error_message' => 'Không thể lấy chi tiết sản phẩm. Vui lòng thử lại sau.'
                ]);
            }
        } else {
            // Nếu không có 'product_id', hiển thị lỗi
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
            // Nếu không có user_id trong session, chuyển hướng về trang đăng nhập
            header("Location: /SneakerHome/User/login");
            exit();
        }
    }
    
    
    
}
?>
