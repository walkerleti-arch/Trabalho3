<?php
    header('Content-Type: application/json; charset=utf-8');
    
    require '../config.php';

    $sqlProduto = "select p.*, c.categoria from produto p
    inner join categoria c on (c.id = p.categoria_id) 
    order by nome";
    $consultaProduto = $pdo->prepare($sqlProduto);
    $consultaProduto->execute();

    $dadosProduto = $consultaProduto->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($dadosProduto);
    ?>