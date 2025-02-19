<?php
include_once('../../DAOS/ConexaoBD.php');

if (!$conexao) {
    die("Erro de conexão com o banco de dados");
}

$premium2 = $_POST['premium2']; //criando a variável com o valor do form

$stmt = $conexao->prepare("SELECT role FROM cadastro_usuarios WHERE chave = ?");
$stmt->bind_param("s", $premium2); 
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) { // Verificando se a chave existe
    $linha = $resultado->fetch_assoc(); // Obtendo a linha correspondente
    $resposta = array("status" => "valido", "role" => $linha['role']); // Retornando o role
} else {
    $resposta = array("status" => "invalido"); 
}

echo json_encode($resposta);
