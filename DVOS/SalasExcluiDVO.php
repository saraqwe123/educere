<?php
include_once('../DAOS/ConexaoBD.php'); // Inclua seu arquivo de conexão com o banco de dados

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

// Verifica se o id do evento foi enviado via POST
if (isset($_POST['id'])) {
    $id = $_POST['id']; // O id do evento a ser excluído

    // Prepara a consulta DELETE
    $query = "DELETE FROM agendamentos WHERE id = ?";

    // Prepara a consulta usando prepared statements para evitar SQL injection
    if ($stmt = $conexao->prepare($query)) {
        // Bind o parâmetro (id) ao prepared statement
        $stmt->bind_param("i", $id);

        // Executa a consulta
        if ($stmt->execute()) {
            // Se a exclusão for bem-sucedida, retorna sucesso
            echo json_encode(array("success" => true, "message" => "Agendamento excluído com sucesso"));
        } else {
            // Se houver algum erro, retorna uma mensagem de erro
            echo json_encode(array("success" => false, "message" => "Erro ao excluir o agendamento"));
        }

        $stmt->close(); // Fecha o prepared statement
    } else {
        // Se falhar ao preparar a consulta
        echo json_encode(array("success" => false, "message" => "Erro ao preparar a consulta"));
    }
} else {
    // Se o id não for fornecido
    echo json_encode(array("success" => false, "message" => "ID não fornecido"));
}

$conexao->close(); // Fecha a conexão com o banco de dados
?>
