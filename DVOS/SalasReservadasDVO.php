<?php
include_once('../DAOS/ConexaoBD.php'); // Inclua seu arquivo de conexão com o banco de dados

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

// Consulta para buscar os agendamentos
$query = "SELECT id, sala, responsavel, inicio, fim FROM agendamentos";
$result = $conexao->query($query);

$agendamentos = array(); // Array para armazenar os agendamentos

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $agendamentos[] = array(
            "id" => $row['id'],
            "resourceId" => $row['sala'],
            "title" => $row['responsavel'],
            "start" => $row['inicio'],
            "end" => $row['fim']
        ); // Adiciona cada agendamento ao array
    }
}

// Retorna os dados como JSON
echo json_encode($agendamentos);
?>
