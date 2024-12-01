<?php
// Conecta no banco de dados
// Variáveis de conexão
$usuario = 'root'; // Usuário do banco de dados (geralmente 'root' para localhost)
$senha = 'usbw'; // Senha do banco de dados
$database = 'login'; // Nome do banco de dados
$host = 'localhost'; // Host do banco de dados (geralmente 'localhost')

// Cria uma nova instância do objeto mysqli para conectar ao banco de dados
$mysqli = new mysqli($host, $usuario, $senha, $database);

// Verifica se ocorreu algum erro na conexão
if ($mysqli->error) {
    // Se houver erro, exibe uma mensagem de erro e encerra o script
    die("Falha ao conectar no banco de dados: " . $mysqli->error);
}