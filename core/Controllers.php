<?php
class Controllers
{
    // Phương thức để hiển thị view
    public function view($view, $data = [])
    {
        // Extract dữ liệu ra các biến riêng biệt
        extract($data);
        require_once "./views/$view.php";
        echo "$view";
    }
}
