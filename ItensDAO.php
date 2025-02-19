<?php
include_once('conexaoBD.php');

// Verificando se houve um envio do formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturando os dados do formulário
    $id = isset($_POST['id']) ? $_POST['id'] : null; // Captura o ID, se existir
    $categoria = $_POST['categoria'];
    $nome = $_POST['nome'];
    $data_compra = $_POST['data_compra'];
    $data_exclusao = $_POST['data_exclusao'];
    $justificativa = $_POST['justificativa'];
    $depreciacao = $_POST['depreciacao'];
    $valor = $_POST['valor']; 
    $residual = $_POST['residual'];
    $marca = $_POST['marca'];
    $local = $_POST['local'];
    $modelo = $_POST['modelo'];
    $estado = $_POST['estado'];

    if ($id) {
        if (empty($data_exclusao)) {
            $data_exclusao = NULL;
        }
        // Se o ID existir, atualiza o registro
        $stmt = $conexao->prepare("UPDATE itens SET categoria=?, nome=?, data_compra=?, data_exclusao=?, justificativa=?, depreciacao=?, valor=?, residual=?, marca=?, local=?, modelo=?, estado=? WHERE id=?");
        $stmt->bind_param("ssssssdissssi", $categoria, $nome, $data_compra, $data_exclusao, $justificativa, $depreciacao, $valor, $residual, $marca, $local, $modelo, $estado, $id);
    } else {
        if (empty($data_exclusao)) {
            $data_exclusao = NULL;
        }
        // Se o ID não existir, insere um novo registro
        $stmt = $conexao->prepare("INSERT INTO itens (categoria, nome, data_compra, data_exclusao, justificativa, depreciacao, valor, residual, marca, local, modelo, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssdissss", $categoria, $nome, $data_compra, $data_exclusao, $justificativa, $depreciacao, $valor, $residual, $marca, $local, $modelo, $estado);
    }

    if ($stmt->execute()) {
        include("phpqrcode/qrlib.php");

        // Se for uma atualização, busca o item atualizado
        if ($id) {
            $resultado = $conexao->query("SELECT * FROM itens WHERE id = $id");
        } else {
            // Se for uma inserção, busca o item inserido
            $resultado = $conexao->query("SELECT * FROM itens WHERE nome = '$nome' ORDER BY id DESC LIMIT 1");
        }

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $id = $row["id"];
                $nome = $row["nome"];
                $categoria = $row["categoria"];
                $local = $row["local"];
                $depreciacao = $row["depreciacao"];
                $data_compra = $row["data_compra"];
                $data_exclusao = $row["data_exclusao"];
                $estado = $row["estado"];

                // Dados para o QR Code
                $dados = "Digito Verificador: $id";

                $dados_utf8 = mb_convert_encoding($dados, 'UTF-8', 'auto');

                $qr = "../ENTITIES/Item/qrcode/qr_$id.png";
                QRcode::png($dados_utf8, $qr, QR_ECLEVEL_L, 4, 2);
                
                $update_sql = "UPDATE itens SET qr_code_path='$qr' WHERE id=$id";
                if (!$conexao->query($update_sql)) {
                    echo "Erro ao atualizar o registro com ID $id: " . $conexao->error . "<br>";
                    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao gerar o QR Code.']);
                    exit;
                }
            }
            echo json_encode(['status' => 'sucesso']);
        } else {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao encontrar o item recém inserido.']);
        }
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao inserir ou atualizar o item.']);
    }

    $stmt->close();
}
?>