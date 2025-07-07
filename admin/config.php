<?php
$host = 'localhost';
$db = 'skyview';
$user = 'root';
$pass = '';
//ilison rani nato ug unsa final

try{
  $pdo = new PDO("mysql: host = $host; dbname = $db", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
  die("Database connection failed: ". $e->getMessage());
}
