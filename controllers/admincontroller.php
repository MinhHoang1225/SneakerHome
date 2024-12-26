<?php
require_once $_SERVER['DOCUMENT_ROOT']."/SneakerHome/models/adminmodels.php";

class Controller {
    private $model;

    public function __construct() {
        $this->model = new Model();
    }
    public function getDashboardData() {
        return [
            'customers' => count($this->model->getCustomers()),
            'products' => count($this->model->getProducts()),
            'orders' => count($this->model->getOrders())

        ];
    }

    public function getCustomers() {
        return $this->model->getCustomers();
    }

    public function getProducts() {
        return $this->model->getProducts();
    }

    public function getOrders() {
        return $this->model->getOrders();
    }

    public function addProduct($name, $price, $stock, $image) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($image['name']);
        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            $this->model->addProduct($name, $price, $stock, $targetFile);
        }
    }

    public function handleAddProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];
            $image = $_FILES['image'];

            $this->addProduct($name, $price, $stock, $image);

            header("Location: admin.php?success=1");
            exit();
        }
    }
    public function deleteProduct($product_id) {
        $this->model->deleteProduct($product_id);
        // echo json_encode(["status" => "success"]);
    }
    
      public function getOrdersByUser() {
        return $this->model->getOrdersByUser();
    }

    public function getOrdersByStatus($status) {
        return $this->model->getOrdersByStatus($status);
    }
}
include $_SERVER['DOCUMENT_ROOT'].'/SneakerHome/views/adminview.php'
?>
