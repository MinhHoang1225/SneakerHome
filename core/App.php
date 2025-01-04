<?php
require_once './database/connect.php'; // Đường dẫn tới file kết nối DB

class App
{
    private $db;

    public function __construct()
    {
        // Kết nối cơ sở dữ liệu
        $this->db = connectdb();

        // Xử lý URL và thực thi controller/action
        $this->handleUrl();
    }

    private function getUrl()
    {
        if (!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else {
            $url = '/home/home'; // URL mặc định
        }
        return trim($url, '/');
    }

    private function handleUrl()
    {
        // Lấy URL
        $url = $this->getUrl();

        // Phân tách URL thành các phần
        $urlParts = explode('/', $url);
        $controllerName = ucfirst($urlParts[0]) . 'Controller'; // Ví dụ: home -> HomeController
        $action = isset($urlParts[1]) ? $urlParts[1] : 'home'; // Mặc định action là home
        $params = array_slice($urlParts, 2); // Các tham số còn lại từ URL

        // Kiểm tra file controller
        if (file_exists('./controllers/' . $controllerName . '.php')) {
            require_once './controllers/' . $controllerName . '.php';

            if (class_exists($controllerName)) {
                // Tạo instance của controller, truyền đối tượng DB
                $controller = new $controllerName($this->db);

                // Kiểm tra phương thức (action) có tồn tại
                if (method_exists($controller, $action)) {
                    // Nếu action là addToCart và phương thức này không yêu cầu tham số từ URL
                    if ($action == 'addToCart') {
                        // Kiểm tra phương thức yêu cầu POST
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            // Lấy dữ liệu từ body JSON
                            $data = json_decode(file_get_contents('php://input'), true);
                            // Gọi action mà không truyền tham số từ URL mà truyền tham số từ JSON
                            call_user_func_array([$controller, $action], [$data]);
                        } else {
                            // Gọi action với tham số từ URL
                            call_user_func_array([$controller, $action], $params);
                        }
                    } else {
                        // Gọi action bình thường với tham số từ URL
                        call_user_func_array([$controller, $action], $params);
                    }
                } else {
                    echo "404 - Action not found: $action";
                }
            } else {
                echo "404 - Controller class not found: $controllerName";
            }
        } else {
            echo "404 - Controller file not found: $controllerName";
        }
    }
}
