<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    http_response_code(403);
    header("Content-Type: application/json");
    echo json_encode(["erro" => "Não autorizado"]);
    exit;
}
require "../config.php";

$stmt = $pdo->query("SELECT id_produto, nm_produto, nr_estoque FROM PRODUTO WHERE fl_ativo = TRUE ORDER BY nr_estoque ASC");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

header("Content-Type: application/json");
echo json_encode($produtos);