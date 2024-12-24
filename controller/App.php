<?php
class App {
    private $__controller, $__action, $__params;

    public function __construct() {
        global $routes;
        if (!empty($routes['default_controller'])) {
            $this->__controller = $routes['default_controller'];
        }
        $this->__action = 'index';
        $this->__params = [];
        $this->handleUrl();
    }

    public function getUrl() {
        $url = $_SERVER['REQUEST_URI'];
        $url = parse_url($url, PHP_URL_PATH);
        return $url;
    }

    public function handleUrl() {
        $fullurl = $this->getUrl();
        $url = str_replace('/SneakerHome/controller', '', $fullurl);
        $urlArr = array_filter(explode('/', $url)); 

        $routes = [
            '/' => 'homecontroller.php',
            '/home' => 'homecontroller.php',
            '/login' => 'logincontroller.php',
            '/register' => 'registercontroller.php',
            '/aboutus' => 'aboutuscontroller.php',
            '/shoes' =>  'shoescontroller.php',
            '/accessories' => 'accessoriescontroller.php',
            '/clother' => 'clothercontroller.php',
            '/promotion' => 'promotioncontroller.php',
            '/profile' => 'profilecontroller.php',
            '/product' => 'productcontroller.php',
            '/detailproduct' => 'detailproductcontroller.php',
            '/shoppingcart' => 'shoppingcartcontroller.php',
            '/checkout' => 'checkoutcontroller.php'
            


            
        ];

        if (isset($_SESSION['users']) && $_SESSION['users']['role'] == 'admin') {
            $routes = [ 
                '/login' => 'logincontroller.php',
                '/home' => 'homecontroller.php',
                '/register' => 'registercontroller.php',
                '/admin' => 'admincontroller.php',
                '/aboutus' => 'aboutuscontroller.php',
                '/shoes' =>  'shoescontroller.php',
                '/accessories' => 'accessoriescontroller.php',
                '/clother' => 'clothercontroller.php',
                '/promotion' => 'promotioncontroller.php'
            ];
        }
        foreach ($routes as $route => $controllerFile) {
            if ('/' . implode('/', $urlArr) == $route) {
                require_once 'controller/' . $controllerFile; 
            }
        }

        if (!isset($controllerFile)) {
            echo "Page not found!";
            exit();
        }
    }
}
