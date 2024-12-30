<?php
require_once './core/Controllers.php';
class HomeController extends Controllers{

    public function index()

    {
        $data = ['default']; 
        $this->view('homeview', $data);
    }

    public function aboutus(){
        $this->view('aboutusview', [
            'error_message' => $_SESSION['error_message'] ?? null,
            'username_input' => $_SESSION['username_input'] ?? ''
        ]); 
    }
}
?> 