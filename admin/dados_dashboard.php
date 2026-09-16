<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    http_response_code(403);
    header("Content-Type: application/json");
    echo json_encode(["erro" => "Não autorizado"]);
    exit;
}

require "../config.php";

$dataInicio = $_GET['data_inicio'] ?? null;
$dataFim = $_GET['data_fim'] ?? null;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$tamanhoPagina = isset($_GET['tamanho_pagina']) ? (int)$_GET['tamanho_pagina'] : 1000;

try {
    $stmt = $pdo->prepare("CALL sp_dashboard_indicadores(?, ?, ?, ?)");
    $stmt->execute([$dataInicio, $dataFim, $pagina, $tamanhoPagina]);
    $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    header("Content-Type: application/json");
    echo json_encode($itens);
} catch (PDOException $e) {
    http_response_code(500);
    header("Content-Type: application/json");
    echo json_encode(["erro" => "Não foi possível carregar os dados no momento."]);
}