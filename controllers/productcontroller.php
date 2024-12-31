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

    public function checkoutBuyNow() {
        $productId = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
        $quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1; 
        $_SESSION['product_id'] = $productId;
        $_SESSION['quantity'] = $quantity;
        if ($productId <= 0 || $quantity <= 0) {
            $this->view('errorview', [
                'error_message' => 'Sản phẩm hoặc số lượng không hợp lệ.'
            ]);
            return;
        }
    
        $productModel = new ProductModel($this->db);
    
        try {
            $product = $productModel->getCheckoutBuyNow($productId, $quantity);
    
            if ($product) {
                // Cập nhật thông tin giỏ hàng
                $product['quantity'] = $quantity;
                $product['total_price'] = $product['price'] * $quantity; // Tính tổng giá
                
                $cartItems = [$product];
                $cartTotalCheckOut = $product['total_price'];
    
                $this->view('checkoutview', [
                    'cartItems' => $cartItems,
                    'cartTotalCheckOut' => $cartTotalCheckOut,
                    'product' => $product,
                    'error_message' => $_SESSION['error_message'] ?? null,
                    'username_input' => $_SESSION['username_input'] ?? ''
                ]);
            } else {
                $this->view('errorview', [
                    'error_message' => 'Sản phẩm không tồn tại hoặc đã bị xóa.'
                ]);
            }
        } catch (Exception $e) {
            error_log("Error in checkoutBuyNow: " . $e->getMessage());
            $this->view('errorview', [
                'error_message' => 'Có lỗi xảy ra. Vui lòng thử lại sau.'
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
    
    public function checkoutCart(){
        if (isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
    
            $productModel = new ProductModel($this->db);
            $products = $productModel -> getCheckoutCart($userId);
            $cartTotal = $productModel -> calculateCheckoutTotal($userId);
    
            $this->view('checkoutCartviews', [
                'products' => $products,  
                'cartTotal' => $cartTotal,
                'error_message' => $_SESSION['error_message'] ?? null,
                'username_input' => $_SESSION['username_input'] ?? ''
            ]);
        } else {
            header("Location: /SneakerHome/User/login");
            exit();
        }
        
    }

    public function checkoutSuccessCart() {
        $username_input = htmlspecialchars($_POST['fullname'] ?? 'Guest');
        $address = htmlspecialchars($_POST['address'] ?? 'Unknown Address');

        // Store data in session (optional, for persistence across steps)
        $_SESSION['username_input'] = $username_input;
        $_SESSION['address'] = $address;
        if (isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
    
            $productModel = new ProductModel($this->db);
            $products = $productModel -> getCheckoutSuccess($userId);
            $priceTotal = $productModel -> calculateCheckoutSuccessTotal($userId);
        $this->view('checkoutSuccessCart', [
            'products' => $products,  
            'priceTotal' => $priceTotal,
            'username_input' => $username_input,
            'address' => $address,
            'error_message' => $_SESSION['error_message'] ?? null,
            'username_input' => $_SESSION['username_input'] ?? ''
        ]);
    }  
}

public function checkoutSuccessBuyNow() {
    // Retrieve information from POST or session
    $username_input = htmlspecialchars($_POST['fullname'] ?? $_SESSION['username_input'] ?? 'Guest');
    $address = htmlspecialchars($_POST['address'] ?? $_SESSION['address'] ?? 'Unknown Address');
    $quantity = $_POST['quantity'] ?? $_SESSION['quantity'] ?? 0;
    $productId = $_POST['product_id'] ?? $_SESSION['product_id'] ?? 0;

    // Store POST data in session for future requests
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_SESSION['username_input'] = $username_input;
        $_SESSION['address'] = $address;
        $_SESSION['quantity'] = $quantity;
        $_SESSION['product_id'] = $productId;
    }

    // Initialize ProductModel and get product details
    $productModel = new ProductModel($this->db);
    try {
        $products = $productModel->getCheckoutSuccessBuyNow($productId, $quantity);
        // $totalPrice = $products['price'] * $quantity;
        $totalPrice = 5;

        // $totalPrice = 88 * $quantity;


        // Save the order and return the order ID
        $saveorder = $productModel->saveOrder($productId, $quantity, $totalPrice);  

        // Display the success view
        $this->view('checkoutSuccessBuyNow', [
            'saveorder' => $saveorder,
            'products' => $products,
            'username_input' => $username_input,
            'address' => $address,
            'error_message' => $_SESSION['error_message'] ?? null,
        ]);
    } catch (Exception $e) {
        error_log("Error in checkoutSuccessBuyNow: " . $e->getMessage());
        $this->view('errorview', [
            'error_message' => 'Có lỗi xảy ra. Vui lòng thử lại sau.'
        ]);
    }
}

public function saveOrder()
{
    // Debug: Kiểm tra phương thức yêu cầu
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        return;
    }

    // Debug: Kiểm tra dữ liệu JSON
    $input = json_decode(file_get_contents('php://input'), true);
    error_log('Input Data: ' . json_encode($input));

    $quantity = isset($input['quantity']) ? (int)$input['quantity'] : 0;
    $productId = isset($input['product_id']) ? (int)$input['product_id'] : 0;

    // Debug: Kiểm tra giá trị đầu vào
    error_log("Product ID: $productId, Quantity: $quantity");

    if ($quantity <= 0 || $productId <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid product ID or quantity.']);
        return;
    }

    // Debug: Kiểm tra session
    if (!isset($_SESSION['userId'])) {
        error_log('Session User ID not found.');
        http_response_code(401); // Unauthorized
        echo json_encode(['success' => false, 'message' => 'User not logged in.']);
        return;
    }

    try {
        // Lấy thông tin sản phẩm
        $productModel = new ProductModel($this->db);
        $product = $productModel->getProductById($productId);

        // Debug: Kiểm tra sản phẩm
        error_log('Product Data: ' . json_encode($product));

        if (!$product) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Product not found.']);
            return;
        }

        // Tính toán tổng giá
        $totalPrice = $product['price'] * $quantity;
        error_log("Total Price: $totalPrice");

        // Lưu đơn hàng
        $orderId = $productModel->saveOrder($productId, $quantity, $totalPrice);

        if ($orderId) {
            echo json_encode(['success' => true, 'message' => 'Order saved successfully.', 'order_id' => $orderId]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to save order.']);
        }
    } catch (Exception $e) {
        error_log("Error in saveOrder: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'An error occurred while processing your order.']);
    }
}

}
?>
