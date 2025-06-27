<div class="container">
<link rel="stylesheet" href="assets/css/style.css">
<?php
require_once '../config/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $db->prepare("SELECT * FROM users WHERE username = :u");
  $stmt->execute([':u' => $_POST['username']]);
  $user = $stmt->fetch();
  if ($user && password_verify($_POST['password'], $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    header("Location: listar_clientes.php"); exit;
  } else {
    $erro = "Usuário ou senha inválidos.";
  }
}
?>
<form method="post">
  <input name="username" placeholder="Usuário">
  <input name="password" type="password" placeholder="Senha">
  <button type="submit">Entrar</button>
</form>
<?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
<p><a href="register.php">Cadastrar</a></p>
</div>
