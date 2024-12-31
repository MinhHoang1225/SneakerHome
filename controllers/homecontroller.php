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
        $limit = 8;
 
        $productModel = new ProductModel($this->db);
        $allProduct = $productModel -> getBestSellers();
        $products = $productModel->getBestSellersByCategory($categoryId, $limit);
        $totalProducts = $productModel->getAllBestSellersCount($categoryId);   
        $this->view('homeview', [
            'allProduct' => $allProduct,
            'products' => $products,
            'totalProducts' => $totalProducts,
            'categoryId' => $categoryId,
            'limit' => $limit,
        ] , $data);
    }
    public function aboutus(){
        $this->view('aboutusview', [
            'error_message' => $_SESSION['error_message'] ?? null,
            'username_input' => $_SESSION['username_input'] ?? ''
        ]); 
    }
}
?> 