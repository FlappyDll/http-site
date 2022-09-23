<?php
    define('USER', 'worker');
    define('PASSWORD', 'gagitagachaich');
    define('HOST', 'localhost');
    define('DATABASE', 'users');
    try {
        $connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
    } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }
?>