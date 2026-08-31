<?php
    header('Content-Type: application/json; charset=utf-8');
    
    require '../config.php';

    $sqlCategoria = "select * from categoria order by categoria";
    $consultaCategoria = $pdo->prepare($sqlCategoria);
    $consultaCategoria->execute();

    $dadosCategoria = $consultaCategoria->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($dadosCategoria);
?>