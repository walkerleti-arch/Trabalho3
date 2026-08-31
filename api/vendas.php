<?php
    header('Content-Type: application/json; charset=utf-8');
    
    require '../config.php';

    $sqlVendas = "select p.*, c.categoria from produto p
    inner join categoria c on (c.id = p.categoria_id)
    order by nome";
    $consultaVendas = $pdo->prepare($sqlVendas);
    $consultaVendas->execute();

    $dadosVendas = $consultaVendas->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($dadosVendas);
?>
