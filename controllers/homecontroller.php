<?php
require_once './models/ProductModels.php';
require_once './core/Controllers.php';
class HomeController extends Controllers{
    private $db;
    
    public function __construct($db)
    {
        if (!$db) {
            die('Database connection is not established');
        }
        $this->db = $db;
    }


    public function home() {
        $data = ['default'];
    
        $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
        $limit = 24;
        $productId = isset($_GET['product_id']) ? (int)$_GET['product_id'] : null;
        $userId = $_SESSION['user_id'] ?? null;
        $productModel = new ProductModel($this->db);
        $allProduct = $productModel->getBestSellers();
        $products = $productModel->getBestSellersByCategory($categoryId, $limit);
        $totalProducts = $productModel->getAllBestSellersCount($categoryId);   
        $favorite = $productId ? $productModel->favorite($userId, $productId) : null;
    
        $this->view('homeview', [
            'allProduct' => $allProduct,
            'products' => $products,
            'totalProducts' => $totalProducts,
            'categoryId' => $categoryId,
            'limit' => $limit,
        // ] , $data);
        // $this -> view('favorite',[
            'userId' => $userId,
            'productId' => $productId,
        ],$data);
    }
    public function favorite() {
        header('Content-Type: application/json');
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $userId = $input['user_id'] ?? null;
            $productId = $input['product_id'] ?? null;
            if (!$userId || !$productId) {
                echo json_encode(['success' => false, 'message' => 'Missing user or product ID.']);
                return;
            }

            $favoriteModel = new FavoriteModel($this->db);
            $result = $favoriteModel->favorite($userId, $productId);

            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
    public function aboutus(){
        $this->view('aboutusview', [
            'error_message' => $_SESSION['error_message'] ?? null,
            'username_input' => $_SESSION['username_input'] ?? ''
        ]); 
    }
}
?> 