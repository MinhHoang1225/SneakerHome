<?php
require_once './core/Controllers.php';
require_once './models/ProductModels.php';
// require './database/connect.php';
var_dump($_SESSION);
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


    // Method to display products
    public function displayProducts() {
        $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
        $limit = 8;
 
        $productModel = new ProductModel($this->db);
        $products = $productModel->getBestSellersByCategory($categoryId, $limit);
        $totalProducts = $productModel->getAllBestSellersCount($categoryId);
    
        $this->view('homeview', [
            'products' => $products,
            'totalProducts' => $totalProducts,
            'categoryId' => $categoryId,
            'limit' => $limit,
        ]);
    }
    

    public function productsCategory(){
        $this->view('productview', [
            'error_message' => $_SESSION['error_message'] ?? null,
            'username_input' => $_SESSION['username_input'] ?? ''
        ]);
    }

    public function favorite() {
        // Kiểm tra session để đảm bảo user_id tồn tại
        if (isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];  // Lấy user_id từ session
    
            $favoriteModel = new FavoriteModel($this->db);
            $favorites = $favoriteModel->getFavorites($userId);
    
            // Debugging: Kiểm tra dữ liệu favorites
            error_log(print_r($favorites, true));
    
            // Gọi view và truyền dữ liệu vào view
            $this->view('favoriteview', [
                'favorites' => $favorites,  // Danh sách sản phẩm yêu thích
                'error_message' => $_SESSION['error_message'] ?? null,
                'username_input' => $_SESSION['username_input'] ?? ''
            ]);
        } else {
            // Nếu không có user_id trong session, chuyển hướng về trang đăng nhập
            header("Location: /User/login");
            exit();
        }
    }
    
    
    
}
?>
