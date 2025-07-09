<?php
session_start();
$db = new PDO('mysql:host=localhost;dbname=seubanco;charset=utf8', 'root', '', [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
  
