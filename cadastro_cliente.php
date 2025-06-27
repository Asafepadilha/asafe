<div class="container">
<link rel="stylesheet" href="assets/css/style.css">
<?php
require_once '../config/config.php';
require_once '../lib/auth.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erro = 'Email inválido';
  } else {
    $stmt = $db->prepare("
      INSERT INTO clientes (user_id, nome, email, telefone, cep, logradouro, numero, cidade, estado)
      VALUES (:uid,:nome,:email,:telefone,:cep,:logradouro,:numero,:cidade,:estado)
    ");
    $stmt->execute([
      ':uid'=>current_user_id(), ':nome'=>$nome, ':email'=>$email, ':telefone'=>$_POST['telefone'] ?? '',
      ':cep'=>$_POST['cep'] ?? '', ':logradouro'=>$_POST['logradouro'] ?? '',
      ':numero'=>$_POST['numero'] ?? '', ':cidade'=>$_POST['cidade'] ?? '', ':estado'=>$_POST['estado'] ?? ''
    ]);
    header('Location: listar_clientes.php');
    exit;
  }
}
?>
<form method="post">
  <input name="nome" required placeholder="Nome">
  <input name="email" required placeholder="Email">
  <input id="cep" name="cep" placeholder="CEP">
  <button type="button" onclick="buscarCep()">Buscar CEP</button>
  <input id="logradouro" name="logradouro" placeholder="Rua">
  <input name="numero" placeholder="Número">
  <input id="cidade" name="cidade" placeholder="Cidade">
  <input id="estado" name="estado" placeholder="Estado">
  <button type="submit">Cadastrar</button>
</form>
<script>
function buscarCep() {
  const cep = document.getElementById('cep').value;
  fetch('ajax_cep.php?cep='+cep)
    .then(r=>r.json())
    .then(d=>{
      if (d.erro) alert('CEP não encontrado');
      else {
        document.getElementById('logradouro').value = d.logradouro;
        document.getElementById('cidade').value = d.localidade;
        document.getElementById('estado').value = d.uf;
      }
    });
}
</script>
</div>
