<div class="container">
<link rel="stylesheet" href="assets/css/style.css">
<?php
session_start();
$db = new PDO('mysql:host=localhost;dbname=seubanco;charset=utf8', 'usuario', 'senha', [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
