<?php
class App {
    private $__controller, $__action, $__params;

    public function __construct() {
        global $routes;
        // Mặc định controller
        if (!empty($routes['default_controller'])) {
            $this->__controller = $routes['default_controller'];
        }
        $this->__action = 'index';
        $this->__params = [];
        $this->handleUrl(); // Xử lý URL
    }

    public function getUrl() {
        // Lấy URL từ REQUEST_URI
        $url = $_SERVER['REQUEST_URI'];

        // Cắt bỏ phần domain và public folder (nếu có) để chỉ lấy đường dẫn
        $url = parse_url($url, PHP_URL_PATH);

        // Trả về URL đã cắt bỏ các phần không cần thiết
        return $url;
    }

    public function handleUrl() {
        $fullurl = $this->getUrl();
        $url = str_replace('/SneakerHome/controller', '', $fullurl);
        // Cắt các phần của URL bằng dấu '/'
        $urlArr = array_filter(explode('/', $url)); 

        // Mảng các routes mặc định
        $routes = [
            '/' => 'homecontroller.php',
            '/home' => 'homecontroller.php',
            '/login' => 'logincontroller.php',
            '/register' => 'registercontroller.php',
        ];

        // Nếu người dùng đã đăng nhập và là admin, thêm các routes admin vào
        if (isset($_SESSION['users']) && $_SESSION['users']['role'] == 'admin') {
            $routes = [ 
                '/login' => 'logincontroller.php',
                '/home' => 'homecontroller.php',
                '/register' => 'registercontroller.php',
                '/admin' => 'admincontroller.php',
            ];
        }

        // Xử lý nếu URL trùng khớp với các route đã định nghĩa
        foreach ($routes as $route => $controllerFile) {
            if ('/' . implode('/', $urlArr) == $route) { // Kiểm tra route
                require_once 'controller/' . $controllerFile; // Gọi controller tương ứng
                break;
            }
        }

        // Nếu không tìm thấy route, có thể cần thêm xử lý lỗi hoặc chuyển hướng mặc định
        if (!isset($controllerFile)) {
            echo "Page not found!";
            exit();
        }
    }
}
