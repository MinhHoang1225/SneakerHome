<?php

  function connectdb() {
    $host     = 'localhost'; 
    $database = 'Sneaker_home';
    $user     = 'root'; 
    $password = ''; 
    try { 
        $db = new PDO("mysql:host=$host;dbname=$database", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        // echo "Connection failed: " . $e->getMessage();
    }
    return $db;
  }
?> 
