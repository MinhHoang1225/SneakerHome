<?php
  $host     = 'localhost'; 
  $database = 'sneaker_home';
  $user     = 'root'; 
  $password = ''; 

  try {
      $db = new PDO("mysql:host=$host;dbname=$database", $user, $password);
      // set the PDO error mode to exception
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // echo  "connect successfully";
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
  }


  function connectdb() {
    $host     = 'localhost'; 
    $database = 'sneaker_home';
    $user     = 'root'; 
    $password = ''; 
    try {
        $db = new PDO("mysql:host=$host;dbname=$database", $user, $password);
        // set the PDO error mode to exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // 
      } catch(PDOException $e) {
        // echo "Connection failed: " . $e->getMessage();
    }

    return $db;
  }

?> 
