<div class="container">
<link rel="stylesheet" href="assets/css/style.css"><?php
require_once '../config/config.php';
require_once '../lib/auth.php';
require_login();

$por_pagina = 10;
$pag = max(1, intval($_GET['pag'] ?? 1));
$ini = ($pag - 1) * $por_pagina;

$stmt = $db->prepare("SELECT SQL_CALC_FOUND_ROWS c.*, u.username
  FROM clientes c JOIN users u ON c.user_id = u.id
  ORDER BY c.created_at DESC
  LIMIT :ini,:lim");
$stmt->bindValue(':ini', $ini, PDO::PARAM_INT);
$stmt->bindValue(':lim', $por_pagina, PDO::PARAM_INT);
$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = $db->query("SELECT FOUND_ROWS()")->fetchColumn();
$totalPags = ceil($total / $por_pagina);
?>
<a href="cadastro_cliente.php">Novo Cliente</a> |
<a href="import.php">Importar CSV</a> |
<a href="logout.php">Sair</a>
<table border="1">
<tr><th>#</th><th>Nome</th><th>Email</th><th>Usuário</th><th>Ações</th></tr>
<?php foreach($clientes as $c): ?>
<tr>
  <td><?=htmlspecialchars($c['id'])?></td>
  <td><?=htmlspecialchars($c['nome'])?></td>
  <td><?=htmlspecialchars($c['email'])?></td>
  <td><?=htmlspecialchars($c['username'])?></td>
  <td>
    <?php if ($c['user_id']==current_user_id()): ?>
      <a href="editar_cliente.php?id=<?=$c['id']?>">Editar</a>
      <a href="excluir_cliente.php?id=<?=$c['id']?>" onclick="return confirm('Confirma?')">Excluir</a>
    <?php endif; ?>
  </td>
</tr>
<?php endforeach; ?>
</table>
<?= $pag>1 ? "<a href='?pag=".($pag-1)."'>«Anterior</a>" : '' ?>
<?= $pag<$totalPags ? "<a href='?pag=".($pag+1)."'>Próximo»</a>" : '' ?>
</div>
