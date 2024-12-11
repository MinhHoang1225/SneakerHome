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
        if (!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else {
            $url = '/';
        }
        return $url;
    }

    public function handleUrl() {
        $url = $this->getUrl();
        $urlArr = array_filter(explode('/', $url));

        $routes = [
            '/' => 'homecontroller.php',
            '/home' => 'homecontroller.php',
            '/login' => 'logincontroller.php',
            '/register' => 'registercontroller.php',
            '/admin' => 'admincontroller.php',
        ];

        if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin') {
            $routes = [
                '/' => 'homecontroller.php',
                '/home' => 'homecontroller.php',
                '/login' => 'logincontroller.php',
                '/register' => 'registercontroller.php',
                '/admin' => 'admincontroller.php',
            ];
        }

        foreach ($routes as $route => $controllerFile) {
            if ($route == $url) {
                require_once 'controller/' . $controllerFile;
                break;
            }
        }
    }
}
