<div class="container">
<link rel="stylesheet" href="assets/css/style.css">
<?php
require_once '../config/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $senha_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $stmt = $db->prepare("INSERT INTO users (username, password, email) VALUES (:u, :p, :e)");
  $stmt->execute([
    ':u' => $_POST['username'],
    ':p' => $senha_hash,
    ':e' => $_POST['email']
  ]);
  header("Location: login.php"); exit;
}
?>
<form method="post">
  <input name="username" placeholder="Usuário" required>
  <input name="email" placeholder="Email" required>
  <input name="password" type="password" placeholder="Senha" required>
  <button type="submit">Registrar</button>
</form>
<p><a href="login.php">Voltar ao login</a></p>
</div>
