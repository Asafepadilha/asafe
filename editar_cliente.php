<div class="container">
  <link rel="stylesheet" href="assets/css/style.css">
  <?php
  require_once '../config/config.php';
  require_once '../lib/auth.php';
  require_login();

  $id = $_GET['id'] ?? null;
  $user_id = current_user_id();

  $stmt = $db->prepare("SELECT * FROM clientes WHERE id = :id AND user_id = :uid");
  $stmt->execute([':id' => $id, ':uid' => $user_id]);
  $cliente = $stmt->fetch();

  if (!$cliente) {
      echo "<p class='error'>❌ Cliente não encontrado ou acesso negado.</p>";
      exit;
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $stmt = $db->prepare("UPDATE clientes SET nome=:nome, email=:email, telefone=:tel,
          cep=:cep, logradouro=:logra, numero=:num, cidade=:cidade, estado=:estado
          WHERE id = :id AND user_id = :uid");
      $stmt->execute([
          ':nome' => $_POST['nome'],
          ':email' => $_POST['email'],
          ':tel' => $_POST['telefone'],
          ':cep' => $_POST['cep'],
          ':logra' => $_POST['logradouro'],
          ':num' => $_POST['numero'],
          ':cidade' => $_POST['cidade'],
          ':estado' => $_POST['estado'],
          ':id' => $id,
          ':uid' => $user_id
      ]);
      header("Location: listar_clientes.php");
      exit;
  }
  ?>

  <h2>Editar Cliente</h2>

  <form method="post">
    <input name="nome" value="<?=htmlspecialchars($cliente['nome'])?>" placeholder="Nome" required>
    <input name="email" value="<?=htmlspecialchars($cliente['email'])?>" placeholder="Email" required>
    <input name="telefone" value="<?=htmlspecialchars($cliente['telefone'])?>" placeholder="Telefone">
    <input name="cep" value="<?=htmlspecialchars($cliente['cep'])?>" placeholder="CEP">
    <input name="logradouro" value="<?=htmlspecialchars($cliente['logradouro'])?>" placeholder="Logradouro">
    <input name="numero" value="<?=htmlspecialchars($cliente['numero'])?>" placeholder="Número">
    <input name="cidade" value="<?=htmlspecialchars($cliente['cidade'])?>" placeholder="Cidade">
    <input name="estado" value="<?=htmlspecialchars($cliente['estado'])?>" placeholder="Estado">

    <div style="display: flex; gap: 10px; margin-top: 15px;">
    <div style="display: flex; gap: 12px; margin-top: 20px;">
  <button type="submit" class="btn-salvar">Salvar</button>
  <a href="listar_clientes.php" class="btn-cancelar">Cancelar</a>
</div>

    </div>
  </form>
</div>
