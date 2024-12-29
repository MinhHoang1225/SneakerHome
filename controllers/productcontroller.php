<?php
require './core/Controllers.php';  // Ensure correct path
require "../SneakerHome/models/ProductModels.php";
class ProductController extends Controller {
    private $db;
    private $productModel;

    // Constructor to initialize ProductModel
    public function __construct($db)
    {
        $this->db = $db;
        $this->productModel = new ProductModel($this->db); // Initialize ProductModel
    }

    // Method to display products
    public function displayProducts(){
        $this->view('homeview', [
            'error_message' => $_SESSION['error_message'] ?? null,
            'username_input' => $_SESSION['username_input'] ?? ''
        ]);
    }

    public function productsCategory(){
        $this->view('productview', [
            'error_message' => $_SESSION['error_message'] ?? null,
            'username_input' => $_SESSION['username_input'] ?? ''
        ]);
    }

    public function favorite(){
        $this->view('favoriteview', [
            'error_message' => $_SESSION['error_message'] ?? null,
            'username_input' => $_SESSION['username_input'] ?? ''
        ]);
    }
}
?>
