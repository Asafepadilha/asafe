<div class="container" style="max-width: 1000px;"> <!-- Aumentamos a largura aqui -->
  <link rel="stylesheet" href="assets/css/style.css">
  <?php
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

  <h2>📋 Lista de Clientes</h2>

  <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
    <a href="cadastro_cliente.php" class="btn">+ Novo Cliente</a>
    <a href="import.php" class="btn">📂 Importar CSV</a>
    <a href="logout.php" class="btn">Sair</a>
  </div>

  <!-- Removido overflow-x -->
  <table style="width: 100%; border-collapse: collapse; font-size: 16px;">
  <thead>
    <tr style="background: #f0f0f0;">
      <th style="padding: 12px 16px;">#</th>
      <th style="padding: 12px 16px;">Nome</th>
      <th style="padding: 12px 16px;">Email</th>
      <th style="padding: 12px 16px;">Usuário</th>
      <th style="padding: 12px 16px;">Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($clientes as $c): ?>
    <tr>
      <td style="padding: 12px 16px;"><?= htmlspecialchars($c['id']) ?></td>
      <td style="padding: 12px 16px;"><?= htmlspecialchars($c['nome']) ?></td>
      <td style="padding: 12px 16px;"><?= htmlspecialchars($c['email']) ?></td>
      <td style="padding: 12px 16px;"><?= htmlspecialchars($c['username']) ?></td>
      <td style="padding: 12px 16px;">
        <?php if ($c['user_id'] == current_user_id()): ?>
          <a href="editar_cliente.php?id=<?= $c['id'] ?>" class="btn btn-sm">Editar</a>
          <a href="excluir_cliente.php?id=<?= $c['id'] ?>" onclick="return confirm('Confirma?')" class="btn btn-sm">Excluir</a>
        <?php else: ?>
          <em>Sem permissão</em>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>


  <div style="text-align: center; margin-top: 20px;">
    <?php if ($pag > 1): ?>
      <a href="?pag=<?= $pag - 1 ?>" class="btn btn-sm">« Anterior</a>
    <?php endif; ?>
    <?php if ($pag < $totalPags): ?>
      <a href="?pag=<?= $pag + 1 ?>" class="btn btn-sm">Próximo »</a>
    <?php endif; ?>
  </div>
</div>
