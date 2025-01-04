<?php
class Controllers
{
    // Phương thức để hiển thị view
    public function view($folderView,$view, $data = [])
    {
        // Extract dữ liệu ra các biến riêng biệt
        extract($data);
        require_once "./views/$folderView/$view.php";
        echo "$view";
    }
}
