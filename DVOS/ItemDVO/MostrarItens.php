<?php
include_once('../../DAOS/ConexaoBD.php');

if (!$conexao) {
    die("Erro de conexão com o banco de dados");
}

$resultado = $conexao->query("SELECT * FROM itens"); //pegando todos os itens

$itens = array();

while ($linha = $resultado->fetch_assoc()) { //while pra adc todas as chaves da coluna
    $itens[] = $linha; 
}



echo json_encode($itens);