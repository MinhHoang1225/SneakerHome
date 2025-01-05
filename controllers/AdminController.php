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

        $this->view('AdminView','adminview', [
            'customers' => $customers,
            'products' => $products,
            'orders' => $orders,
            'getOrdersByUser' => $getOrdersByUser,
            'ordersByStatusCompleted' => $ordersByStatusCompleted,
            'ordersByStatusCancelled' => $ordersByStatusCancelled,
            'ordersByStatusInprogress' => $ordersByStatusInprogress,
            'dashboardData' => $dashboardData
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
                $this->view('adminview', ['getproduct' => $getproduct]);
            exit;
        }
    
        // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //     $id = $_POST['product_id'] ?? '';
        //     $name = $_POST['name'] ?? '';
        //     $price = $_POST['price'] ?? '';
        //     $stock = $_POST['stock'] ?? '';
        //     $imagePath = $_FILES['image']['name'] ?? '';
    
        //     if (empty($id) || empty($name) || empty($price) || empty($stock)) {
        //         $_SESSION['error_message'] = "All fields are required.";
        //         // header("Location: /SneakerHome/admin/adminview");
        //         exit;
        //     }
    
        //     $targetFile = '';
        //     if (!empty($imagePath)) {
        //         $imageTemp = $_FILES['image']['tmp_name'];
        //         $targetDir = "../uploads/";
        //         $targetFile = $targetDir . basename($imagePath);
        //         move_uploaded_file($imageTemp, $targetFile);
        //     }
    
        //     $adminModel = new AdminModel($this->conn);
        //     $adminModel->updateProduct($id, $name, $price, $stock, $targetFile);
    
        //     $_SESSION['success_message'] = "Product updated successfully.";
        //     // header("Location: /SneakerHome/admin/adminview");
        //     exit;
        // }
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
                header("Location: /SneakerHome/admin/orders");
                exit;
            }

            $_SESSION['success_message'] = "Đơn hàng đã được hủy thành công.";
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

            $_SESSION['success_message'] = "Đơn hàng đã được hoàn thành.";
            header("Location: /SneakerHome/admin/adminview");
            exit;
        }
    }
    public function searchName() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['keyword'])) {
            $keyword = $_POST['keyword'];
            
            $adminModel = new AdminModel($this->conn); 
            $customers = $adminModel->searchByName($keyword);

            if (empty($searchResults)) {
                $_SESSION['error_message'] = "Không tìm thấy kết quả cho từ khóa '$keyword'.";
            }
            $this->view('adminview', ['$customers' => $customers]);
            exit;
        }
        header("Location: /SneakerHome/admin/adminview");
        exit;
    }
    
}
