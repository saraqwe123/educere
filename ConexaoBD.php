<?php
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'controle_patrimonio';
$porta = '3307';

//VARIAVEL PRA FAZER A CONEXAO COM O MYSQL
$conexao = new mysqli($host, $usuario, $senha, $banco, $porta);

if ($conexao->connect_errno) {
    echo "Erro de conexão com o banco de dados: " . $conexao->connect_error;
}
