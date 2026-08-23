<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    http_response_code(403);
    header("Content-Type: application/json");
    echo json_encode(["erro" => "Não autorizado"]);
    exit;
}
require "../config.php";

$stmt = $pdo->query("
    SELECT vp.id_venda, vp.nr_quantidade, p.nr_preco
    FROM VENDA_PRODUTO vp
    INNER JOIN PRODUTO p ON vp.id_produto = p.id_produto
");
$itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

header("Content-Type: application/json");
echo json_encode($itens);