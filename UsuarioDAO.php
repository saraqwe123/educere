<?php
include_once('ConexaoBD.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $rg = $_POST['rg'];
    $email = $_POST['email'];
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $premium = $_POST['premium'];

    $hashedSenha = hash('sha256', $senha);

    $stmt = $conexao->prepare("SELECT cpf FROM cadastro_usuarios WHERE cpf = ?");
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // CPF já cadastrado
        echo json_encode(array("error" => "CPF já cadastrado. Tente novamente!"));
    } else { 
        $stmt = $conexao->prepare("INSERT INTO cadastro_usuarios (cpf, rg, email, nome, senha, chave) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssssss", $cpf, $rg, $email, $nome, $hashedSenha, $premium);

        if ($stmt->execute()) {
            echo json_encode(array("success" => true)); //aq tem enviar para a página de itens
        } else {
            echo json_encode(array("error" => "Erro ao inserir dados: ". $stmt->error)); 
        }
    }
}
$stmt->close();