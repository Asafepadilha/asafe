<div class="container">
<link rel="stylesheet" href="assets/css/style.css">
<?php
require_once '../config/config.php';
require_once '../lib/auth.php';
require_login();
$id = $_GET['id'] ?? null;
$user_id = current_user_id();
$stmt = $db->prepare("DELETE FROM clientes WHERE id = :id AND user_id = :uid");
$stmt->execute([':id' => $id, ':uid' => $user_id]);
header("Location: listar_clientes.php");
exit;
