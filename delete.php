<?php
require_once 'conexao.php'; // Inclui o arquivo de conexão com o banco de dados
require_once 'includes/Linked_list.php'; // Inclui a definição da lista encadeada

if (isset($_GET['id'])) { // Verifica se o ID do usuário foi passado via GET
    $id = $_GET['id']; 

    $database = new Database('localhost', 'root', 'usbw', 'login'); // Inicializa a conexão com o banco de dados
    $lista = new LinkedList(); // Cria uma nova lista encadeada

    $sql = "SELECT id, nome, email, telefone, senha FROM usuarios"; // Consulta SQL para selecionar todos os usuários

    // Use o método getConexao() para acessar a conexão
    $result = $database->getConexao()->query($sql); // Executa a consulta

    if ($result) { // Se a consulta retornar resultados
        while ($row = $result->fetch_assoc()) { // Para cada linha retornada
            $lista->inserir($row['id'], $row['nome'], $row['email'], $row['telefone'], $row['senha']); // Insere os dados na lista encadeada
        }
        $result->free(); // Libera a memória ocupada pelos resultados
    }

    // Tenta remover o usuário da lista e do banco de dados
    if ($lista->removerUsuario($id, $database)) { // Se a remoção for bem-sucedida
        echo "Usuário removido com sucesso!"; // Mensagem de sucesso
        header('Location: gerenciamento.php'); // Redireciona para a página de gerenciamento
    } else {
        echo "Erro ao remover o usuário."; // Mensagem de erro se a remoção falhar
    }

    $database->fecharConexao(); // Fecha a conexão com o banco de dados
} else {
    echo "ID do usuário não fornecido."; // Mensagem de erro se o ID não for fornecido
}
?> 