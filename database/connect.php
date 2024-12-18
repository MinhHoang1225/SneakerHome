<?php
// connect.php - Kết nối cơ sở dữ liệu
function connectdb() {
    $host     = 'localhost'; 
    $database = 'mrdinh';
    $user     = 'root'; 
    $password = ''; 

    try { 
        $db = new PDO("mysql:host=$host;dbname=$database", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit; // Dừng chương trình nếu không kết nối được

    }
    return $db;
}
?>
