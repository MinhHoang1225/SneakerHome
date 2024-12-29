<?php
class Controller
{
    // Phương thức để hiển thị view
    public function view($view, $data = [])
    {
        // Extract dữ liệu ra các biến riêng biệt
        extract($data);
        // Yêu cầu tệp view
       
        require_once "./views/$view.php";
    }
}
