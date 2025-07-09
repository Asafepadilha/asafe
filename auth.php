<?php
$host = 'localhost';
$dbname = 'seubanco';
$user = 'usuario';
$pass = 'senha';

try {
  $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Erro na conexão: " . $e->getMessage());
}
