<?php 
// Verifica se o ID foi fornecido na URL via método GET
if(!empty($_GET['id']))
{
    // Inclui o arquivo de conexão com o banco de dados
    include('conexao.php');

    // Obtém o ID do usuário a ser excluído
    $id = $_GET['id'];

    // Query para selecionar o usuário com o ID especificado (verificação de existência antes da exclusão)
    $sqlSelect = "SELECT * FROM usuarios WHERE id=$id";
    $result = $mysqli->query($sqlSelect);

    // Verifica se o usuário existe no banco de dados
    if($result->num_rows > 0)
    {
        // Query para excluir o usuário com o ID especificado.  IMPORTANTE: Vulnerável a SQL Injection.
        $sqlDelete = "DELETE FROM usuarios WHERE id=$id";
        $resultDelete = $mysqli->query($sqlDelete);
    }
}

// Redireciona o usuário para a página de gerenciamento após a exclusão (ou tentativa de exclusão)
header('Location: gerenciamento.php');

?>