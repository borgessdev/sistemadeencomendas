<?php
require 'db.php';

$filtro = $_GET['status'] ?? '';
if (in_array($filtro, ['pendente', 'pronto', 'entregue'], true)) {
    $stmt = $pdo->prepare('SELECT * FROM pedidos WHERE status = ? ORDER BY data_entrega');
    $stmt->execute([$filtro]);
} else {
    $stmt = $pdo->query('SELECT * FROM pedidos ORDER BY data_entrega');
}
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);


$totalMes = $pdo->query(
    "SELECT COALESCE(SUM(valor),0) FROM pedidos
     WHERE status = 'entregue' AND MONTH(data_entrega) = MONTH(CURDATE()) AND YEAR(data_entrega) = YEAR(CURDATE())"
)->fetchColumn();

$aEntregar = $pdo->query("SELECT COUNT(*) FROM pedidos WHERE status <> 'entregue'")->fetchColumn();

function e($t) { return htmlspecialchars((string) $t, ENT_QUOTES, 'UTF-8'); } // evita XSS
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Encomendas</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;800&family=Nunito+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topo">
  <h1>Encomendas</h1>
  <p class="resumo"><strong><?= (int) $aEntregar ?></strong> a entregar &nbsp;|&nbsp; Recebido no mês: <strong>R$ <?= number_format($totalMes, 2, ',', '.') ?></strong></p>
</header>

<main>
  <section class="novo">
    <h2>Nova encomenda</h2>
    <form action="acoes.php" method="post">
      <input type="hidden" name="acao" value="criar">
      <label>Cliente <input name="cliente" required></label>
      <label>Telefone <input name="telefone" placeholder="21 99999-9999"></label>
      <label class="larga">O que foi pedido <input name="descricao" required></label>
      <label>Valor (R$) <input name="valor" type="number" step="0.01" min="0" required></label>
      <label>Entrega <input name="data_entrega" type="date" required></label>
      <button class="primario">Salvar encomenda</button>
    </form>
  </section>

  <section class="lista">
    <div class="barra">
      <nav class="filtros">
        <a href="index.php" class="<?= $filtro === '' ? 'ativo' : '' ?>">Todos</a>
        <a href="?status=pendente" class="<?= $filtro === 'pendente' ? 'ativo' : '' ?>">Pendentes</a>
        <a href="?status=pronto" class="<?= $filtro === 'pronto' ? 'ativo' : '' ?>">Prontos</a>
        <a href="?status=entregue" class="<?= $filtro === 'entregue' ? 'ativo' : '' ?>">Entregues</a>
      </nav>
      <input id="busca" type="search" placeholder="Buscar cliente ou pedido">
    </div>

    <?php if (!$pedidos): ?>
      <p class="vazio">Nenhuma encomenda aqui. Cadastre a primeira no formulário acima.</p>
    <?php endif; ?>

    <?php foreach ($pedidos as $p):
      $atrasado = $p['status'] !== 'entregue' && $p['data_entrega'] < date('Y-m-d');
      $hoje = $p['data_entrega'] === date('Y-m-d');
    ?>
    <article class="pedido <?= e($p['status']) ?>" data-texto="<?= e(strtolower($p['cliente'] . ' ' . $p['descricao'])) ?>">
      <div class="data <?= $atrasado ? 'atrasado' : '' ?>">
        <?= date('d/m', strtotime($p['data_entrega'])) ?>
        <small><?= $atrasado ? 'atrasado' : ($hoje ? 'hoje' : '') ?></small>
      </div>
      <div class="info">
        <h3><?= e($p['cliente']) ?></h3>
        <p><?= e($p['descricao']) ?></p>
        <p class="meta">R$ <?= number_format($p['valor'], 2, ',', '.') ?>
          <?php if ($p['telefone']): ?>
            | <a href="https://wa.me/55<?= preg_replace('/\D/', '', $p['telefone']) ?>" target="_blank" rel="noopener">WhatsApp</a>
          <?php endif; ?>
        </p>
      </div>
      <div class="acoes">
        <form action="acoes.php" method="post">
          <input type="hidden" name="acao" value="status">
          <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
          <select name="status" onchange="this.form.submit()" aria-label="Status">
            <?php foreach (['pendente', 'pronto', 'entregue'] as $s): ?>
              <option value="<?= $s ?>" <?= $p['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
            <?php endforeach; ?>
          </select>
        </form>
        <form action="acoes.php" method="post" class="excluir">
          <input type="hidden" name="acao" value="excluir">
          <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
          <button class="perigo">Excluir</button>
        </form>
      </div>
    </article>
    <?php endforeach; ?>
  </section>
</main>
<script src="script.js"></script>
</body>
</html>
