<?php
require_once './core/Controllers.php';
require_once './models/adminmodels.php';

class AdminController extends Controllers
{
    private $conn;
    public function __construct() {
        $this->conn = connectdb();
    }

    public function adminview() {
        $adminModel = new AdminModel($this->conn);
        $customers = $adminModel->getCustomers();
        $products = $adminModel->getProducts();
        $orders = $adminModel->getOrders();
        $getOrdersByUser = $adminModel->getOrdersByUser();
        $ordersByStatusCompleted = $adminModel->getOrdersByStatus('completed');
        $ordersByStatusCancelled = $adminModel->getOrdersByStatus('cancelled');
        $ordersByStatusInprogress = $adminModel->getOrdersByStatus('In progress');
        $dashboardData = $adminModel->getDashboardData();
        $productsByCategory = $adminModel->getProductsByCategory();
        $ordersByDate = $adminModel->getOrdersByDate();
        $dashboardData = $adminModel->getDashboardData();
        $productsByCategoryForLast4Weeks = $adminModel->getProductsByCategoryForLast4Weeks();
        $ordersPerWeekForLast4Weeks = $adminModel->getOrdersPerWeekForLast4Weeks();

        $this->view('AdminView','adminview', [
            'customers' => $customers,
            'products' => $products,
            'orders' => $orders,
            'getOrdersByUser' => $getOrdersByUser,
            'ordersByStatusCompleted' => $ordersByStatusCompleted,
            'ordersByStatusCancelled' => $ordersByStatusCancelled,
            'ordersByStatusInprogress' => $ordersByStatusInprogress,
            'dashboardData' => $dashboardData,
            'productsByCategory' => $productsByCategory,
            'ordersByDate' => $ordersByDate,
            'dashboardData' => $dashboardData,
            'productsByCategoryForLast4Weeks' => $productsByCategoryForLast4Weeks,
            'ordersPerWeekForLast4Weeks' => $ordersPerWeekForLast4Weeks 
        ]);
    }

    public function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? '';
            $stock = $_POST['stock'] ?? '';
            $imagePath = $_FILES['image']['name'] ?? '';

            if (empty($name) || empty($price) || empty($stock) || empty($imagePath)) {
                $_SESSION['error_message'] = "All fields are required.";
                header("Location: /SneakerHome/admin/adminview");
                exit;
            }

            $imageTemp = $_FILES['image']['tmp_name'];
            $targetDir = "../uploads/";
            $targetFile = $targetDir . basename($imagePath);
            move_uploaded_file($imageTemp, $targetFile);

            $adminModel = new AdminModel($this->conn);
            $adminModel->addProduct($name, $price, $stock, $targetFile);

            $_SESSION['success_message'] = "Product added successfully.";
            header("Location: /SneakerHome/admin/adminview");
            exit;
        }
    }

    public function getProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
            $productId = $_POST['product_id'];
    
            $adminModel = new AdminModel($this->conn);
            $getproduct = $adminModel->getProductById($productId);
    
            if (!$getproduct) {
                $_SESSION['error_message'] = "Product not found.";
                header("Location: /SneakerHome/admin/adminview");
                exit;
            }
                $this->view('AdminView','editProduct', ['getproduct' => $getproduct]);
            exit;
        }
    }
    public function editProduct()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];
        $name = trim($_POST['name']);
        $price = (float)$_POST['price'];
        $stock = (int)$_POST['stock'];

        $adminModel = new AdminModel($this->conn);

        $currentProduct = $adminModel->getProductById($productId);
        if (!$currentProduct) {
            $_SESSION['error_message'] = "Product not found.";
            header("Location: /SneakerHome/admin/adminview");
            exit;
        }
        $imagePath = $currentProduct['image_url']; 
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../uploads/';
            $fileName = basename($_FILES['image']['name']);
            $newImagePath = $uploadDir . $fileName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $newImagePath)) {
                $_SESSION['error_message'] = "Failed to upload image.";
                header("Location: /SneakerHome/admin/adminview");
                exit;
            }

            $imagePath = '/uploads/' . $fileName;
        }

        try {
            $adminModel->updateProduct($productId, $name, $price, $stock, $imagePath);

            $_SESSION['success_message'] = "Product updated successfully.";
            header("Location: /SneakerHome/admin/adminview");
            exit;
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Failed to update product: " . $e->getMessage();
            header("Location: /SneakerHome/admin/adminview");
            exit;
        }
    } else {
        $_SESSION['error_message'] = "Invalid request.";
        header("Location: /SneakerHome/admin/adminview");
        exit;
    }
}


    public function deleteProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? '';

            if (empty($product_id)) {
                $_SESSION['error_message'] = "Product ID is required.";
                header("Location: /SneakerHome/admin/adminview");
                exit;
            }

            $adminModel = new AdminModel($this->conn);
            $adminModel->deleteProduct($product_id);

            $_SESSION['success_message'] = "Product deleted successfully.";
            header("Location: /SneakerHome/admin/adminview");
            exit;
        }
    }
    public function cancelOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
            $orderId = $_POST['order_id'];
            
            $orderModel = new AdminModel($this->conn);  
            $cancelResult = $orderModel->cancelOrder($orderId);

            if (!$cancelResult) {
                $_SESSION['error_message'] = "Lỗi khi hủy đơn hàng.";
                header("Location: /SneakerHome/admin/adminview");
                exit;
            }

            $_SESSION['success_message'] = "Order has been canceled successfully.";
            header("Location: /SneakerHome/admin/adminview");
            exit;
        }
    }

    public function completeOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
            $orderId = $_POST['order_id'];

            $orderModel = new AdminModel($this->conn);  
            $completeResult = $orderModel->completeOrder($orderId);

            if (!$completeResult) {
                $_SESSION['error_message'] = "Lỗi khi hoàn thành đơn hàng.";
                header("Location: /SneakerHome/admin/adminview");
                exit;
            }

            $_SESSION['success_message'] = "Order has been completed.";
            header("Location: /SneakerHome/admin/adminview");
            exit;
        }
    }
    public function searchUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['keyword'])) {
            $keyword = trim($_POST['keyword']); 
            $adminModel = new AdminModel($this->conn); 
            $users = $adminModel->searchByName($keyword);
                if (empty($users)) {
                $_SESSION['error_message'] = "Không tìm thấy kết quả cho từ khóa '$keyword'.";
                $users = []; 
            }
                        $this->view('AdminView', 'searchUser', ['users' => $users]);
            // header("Location: /SneakerHome/admin/adminview");
            // exit;
        }
    }
    public function searchProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['keyword'])) {
            $keyword = trim($_POST['keyword']); 
            $adminModel = new AdminModel($this->conn); 
            $products = $adminModel->searchProductByName($keyword);
            
            if (empty($products)) {
                $_SESSION['error_message'] = "Không tìm thấy kết quả cho từ khóa '$keyword'.";
                $products = []; 
            }

            $this->view('AdminView', 'searchProduct', ['products' => $products]);
        } else {
            header('Location: /SneakerHome/Admin/adminview');
            exit;
        }
    }
    
    
}
