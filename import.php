<div class="container">
<link rel="stylesheet" href="assets/css/style.css">
<?php
require_once '../config/config.php';
require_once '../lib/auth.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv'])) {
  $arquivo = fopen($_FILES['csv']['tmp_name'], 'r');
  fgetcsv($arquivo); 
  while (($dados = fgetcsv($arquivo)) !== false) {
    list($nome, $email, $telefone, $cep, $logradouro, $numero, $cidade, $estado) = $dados;
    $stmt = $db->prepare("INSERT INTO clientes (user_id, nome, email, telefone, cep, logradouro, numero, cidade, estado)
      VALUES (:uid, :nome, :email, :telefone, :cep, :logradouro, :numero, :cidade, :estado)");
    $stmt->execute([
      ':uid'=>current_user_id(), ':nome'=>$nome, ':email'=>$email, ':telefone'=>$telefone,
      ':cep'=>$cep, ':logradouro'=>$logradouro, ':numero'=>$numero,
      ':cidade'=>$cidade, ':estado'=>$estado
    ]);
  }
  fclose($arquivo);
  echo "Importação concluída!";
}
?>
<form method="post" enctype="multipart/form-data">
  <input type="file" name="csv" accept=".csv" required>
  <button type="submit">Importar</button>
</form>
</div>
