<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }

$acao = $_POST['acao'] ?? '';

if ($acao === 'criar') {
    $sql = 'INSERT INTO pedidos (cliente, telefone, descricao, valor, data_entrega) VALUES (?, ?, ?, ?, ?)';
    $pdo->prepare($sql)->execute([
        trim($_POST['cliente']),
        trim($_POST['telefone']),
        trim($_POST['descricao']),
        (float) $_POST['valor'],
        $_POST['data_entrega'],
    ]);
}

if ($acao === 'status') {
    $permitidos = ['pendente', 'pronto', 'entregue'];
    if (in_array($_POST['status'], $permitidos, true)) {
        $pdo->prepare('UPDATE pedidos SET status = ? WHERE id = ?')
            ->execute([$_POST['status'], (int) $_POST['id']]);
    }
}

if ($acao === 'excluir') {
    $pdo->prepare('DELETE FROM pedidos WHERE id = ?')->execute([(int) $_POST['id']]);
}

header('Location: index.php');
exit;
