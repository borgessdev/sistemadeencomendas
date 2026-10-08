<?php
$host = 'localhost';
$banco = 'encomendas';
$usuario = 'root';   
$senha = '';         

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Não foi possível conectar ao banco. Confira se o MySQL está ligado no XAMPP.');
}
