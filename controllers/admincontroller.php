<?php
require_once "../models/adminmodels.php";

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
        $imageFileType = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
            $validTypes = ["jpg", "png", "jpeg", "gif"];
        if (!in_array($imageFileType, $validTypes)) {
            echo "Chỉ chấp nhận các tệp JPG, JPEG, PNG, GIF.";
            return false;
        }
            $imageData = file_get_contents($image['tmp_name']);
            return $this->model->addProduct($name, $price, $stock, $imageData);
    }
    public function deleteProduct($product_id) {
        $this->model->deleteProduct($product_id);
    }
    
      public function getOrdersByUser() {
        return $this->model->getOrdersByUser();
    }

    public function getOrdersByStatus($status) {
        return $this->model->getOrdersByStatus($status);
    }
}

// include $_SERVER['DOCUMENT_ROOT'].'/SneakerHome/views/adminview.php'
?>
