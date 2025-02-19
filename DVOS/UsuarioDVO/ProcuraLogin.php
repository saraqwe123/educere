
<?php
include_once('../../DAOS/ConexaoBD.php');

if (!$conexao) {
    die("Erro de conexão com o banco de dados");
}

header('Content-Type: application/json');
error_reporting(0);

$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';

$hashedSenha = hash('sha256', $senha);

// Prepare a consulta para prevenir SQL Injection
$stmt = $conexao->prepare("SELECT nome, senha FROM cadastro_usuarios WHERE nome = ? AND senha = ?");
$stmt->bind_param("ss", $nome, $hashedSenha);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $resposta = array("status" => "valido");
} else {
    $resposta = array("status" => "invalido");
}

echo json_encode($resposta);
?>
