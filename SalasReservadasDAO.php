<?php
include_once('ConexaoBD.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sala = $_POST['sala'];
    $responsavel = $_POST['responsavel'];
    $inicio = $_POST['inicio'];
    $fim = $_POST['fim'];

    // Converte as datas para o formato correto
    $inicio = DateTime::createFromFormat('Y-m-d\TH:i', $inicio)->format('Y-m-d H:i:s');
    $fim = DateTime::createFromFormat('Y-m-d\TH:i', $fim)->format('Y-m-d H:i:s');

    // Prepara a consulta SQL
    $stmt = $conexao->prepare("INSERT INTO agendamentos (sala, responsavel, inicio, fim) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $sala, $responsavel, $inicio, $fim);

    if ($stmt->execute()) {
        echo json_encode(array("success" => true)); 
    } else {
        echo json_encode(array("error" => "Erro ao inserir dados: ". $stmt->error)); 
    }
}
    