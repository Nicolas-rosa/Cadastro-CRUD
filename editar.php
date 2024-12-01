<?php
require_once 'conexao.php'; // Inclui o arquivo de conexão com o banco de dados
require_once 'includes/Linked_list.php'; // Inclui a definição da lista encadeada

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Verifica se o método de requisição é POST
    // Sanitize as entradas do usuário para evitar SQL Injection
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT); // Filtra e sanitiza o ID do usuário
    $novoNome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING); // Filtra e sanitiza o nome
    $novoEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL); // Filtra e sanitiza o e-mail
    $novoTelefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING); // Filtra e sanitiza o telefone
    $novaSenha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING); // Filtra e sanitiza a nova senha

    // Validação básica (adicione mais validações conforme necessário)
    if (empty($id) || empty($novoNome) || empty($novoEmail) || empty($novoTelefone)) { // Verifica se algum campo obrigatório está vazio
        echo "Todos os campos são obrigatórios."; // Mensagem de erro se campos obrigatórios não forem preenchidos
    } else {
        // Cria uma instância da classe Database
        $database = new Database('localhost', 'root', 'usbw', 'login'); // Inicializa a conexão com o banco de dados
        // Instancia a lista encadeada (carregue os dados do banco para ela se necessário)
        $lista = new LinkedList(); // Cria uma nova lista encadeada
        $sql = "SELECT id, nome, email, telefone, senha FROM usuarios"; // Consulta SQL para selecionar todos os usuários
        $result = $database->getConexao()->query($sql); // Executa a consulta

        if ($result) { // Se a consulta retornar resultados
            while ($row = $result->fetch_assoc()) { // Para cada linha retornada
                $lista->inserir($row['id'], $row['nome'], $row['email'], $row['telefone'], $row['senha']); // Insere os dados na lista encadeada
            }
            $result->free(); // Libera a memória ocupada pelos resultados
        }

        // Tenta editar o usuário na lista e no banco de dados
        if ($lista->editarUsuario($id, $novoNome, $novoEmail, $novoTelefone, $novaSenha, $database)) { // Se a edição for bem-sucedida
            echo "Usuário atualizado com sucesso!"; // Mensagem de sucesso
            // Redirecione para a página de gerenciamento ou exiba uma mensagem de sucesso
            header('Location: gerenciamento.php'); // Redireciona para a página de gerenciamento
        } else {
            echo "Erro ao atualizar o usuário."; // Mensagem de erro se a atualização falhar
            // Exiba uma mensagem de erro mais específica, se possível
        }

        $database->fecharConexao(); // Fecha a conexão com o banco de dados
    }
}

// Se o formulário não foi submetido, exiba o formulário para edição
// Recupere os dados do usuário do banco de dados com base no ID
if (isset($_GET['id'])) { // Verifica se o ID do usuário foi passado via GET
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT); // Filtra e sanitiza o ID

    $database = new Database('localhost', 'root', 'usbw', 'login'); // Inicializa a conexão com o banco de dados

    $sql = "SELECT * FROM usuarios WHERE id = ?"; // Consulta SQL para selecionar o usuário pelo ID
    $stmt = $database->getConexao()->prepare($sql); // Prepara a consulta
    $stmt->bind_param("i", $id); // Liga o parâmetro ID à consulta
    $stmt->execute(); // Executa a consulta
    $result = $stmt->get_result(); // Obtém o resultado da consulta

    if ($result->num_rows == 1) { // Se um usuário for encontrado
        $usuario = $result->fetch_assoc(); // Captura os dados do usuário
    } else {
        echo "Usuário não encontrado."; // Mensagem de erro se o usuário não for encontrado
        exit; // Encerra o script ou redireciona para uma página de erro
    }
    $database->fecharConexao(); // Fecha a conexão com o banco de dados
} else {
    echo "ID do usuário não fornecido."; // Mensagem de erro se o ID não for fornecido
    exit; // Encerra o script
}
?>



<!DOCTYPE html>
<html>
<head>
<title>Editar Usuário</title>
    <style>

body {
    font-family: 'Courier New', monospace;
    background-color: #222;
    color: #eee;
    overflow: hidden;
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center; /* Centraliza horizontalmente */
    min-height: 100vh; /* Garante altura total da tela */
    margin: 0; /* Remove margens padrão */
    padding: 20px;  /* Adiciona preenchimento ao corpo */
    box-sizing: border-box; /* Inclui padding e border no tamanho total */

}


/* Scanlines */
body::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAICAYAAADA+m62AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAAaSURBVHjaYmBgYGBkYmZhZWNnZ2hoaWpqampoaGhgaWpqYmBgYGBkbFlY2NjY2dnZ2tra2thcXFwcHBwcHBoaGhqaGhoYGBgYGRkYmZhZWNnZ2hoaGhoaWpqYmJiYGBgY2RmZ2dnZ2hrbGxsbGxsbW1tbW1tbG1tbW1wcXFwcHBwcGhrGxsbGxsbm5ubm5ub29vb29vb3Nzc3Nzc3cPDw8PDw8eHh4eHh4fHx8fHx8fLy8vLy8vLi4uLi4uLj4+Pj4+Pj5+fn5+fn6+vr6+vr7+/v7+/v8PDw8PDw8PHx8fHx8fLy8vLy8vLz8/Pz8/Pz09PT09PT19fX19fX29vb29vb39/f39/f4+Pj4+Pj5+fn5+fn6+vr6+vr7+/v7+/v8/Pz8/P09PT09PT19fX19fX29vb29vb39/f39/f4+Pj4+Pj5+vr6+vr7+/v7+/v8/Pz8/P09PT09PT19fX29vb39/f4+Pj5+fn7+/v8/Pz9PT19fb29vf3+Pj4+fr7+////wMAC+cSmH4AAAAASUVORK5CYII=");
    opacity: 0.1;
    mix-blend-mode: overlay;
    pointer-events: none;
}

h1 {
    color: #669988;
    text-shadow: 1px 1px 0 #000;
    text-align: center;
    margin-bottom: 20px;
}

form {
    width: 300px; /* Largura fixa para o formulário */
    margin: 0 auto; /* Centraliza o formulário */
    background-color: #00110f;
    border: 1px solid #333;
    padding: 20px;
    border-radius: 5px;
    box-shadow: none;
    
}

/* Estilo para labels */
label {
    display: block;
    margin-bottom: 5px;
    color: #669988;
}

/* Estilo para inputs */
input[type="text"],
input[type="email"],
input[type="tel"],
input[type="password"] {
    width: calc(100% - 22px); /* Largura total menos o padding */
    padding: 10px;
    margin-bottom: 10px; /* Espaço entre os inputs */
    border: 1px solid #333;
    background-color: #003322;
    color: #eee;
    font-family: 'Courier New', monospace;
    border-radius: 3px;
    box-sizing: border-box; /* Inclui padding e border no tamanho total */

}

input:focus {
    outline: none;
    border-color: #669988;
    background-color: #004433;
}


button {
    background-color: #669988;
    color: #222;
    padding: 10px 15px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    font-family: 'Courier New', monospace;
    transition: background-color 0.3s;
    display: block; /* Ocupa toda a largura */
    margin: 20px auto 0; /* Margem superior e centralizado */
    width: 100%; /* Largura total dentro do formulário */
     box-sizing: border-box;

}

p a{
 text-decoration: none;
 color: #669988;
}

    </style>
</head>
<body>

<h1>Editar Usuario</h1>

<form method="post">
    <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

    <label for="nome">Nome:</label><br>
    <input type="text" id="nome" name="nome" value="<?php echo $usuario['nome']; ?>"><br><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" value="<?php echo $usuario['email']; ?>"><br><br>


    <label for="telefone">Telefone:</label><br>
    <input type="text" id="telefone" name="telefone" value="<?php echo $usuario['telefone']; ?>"><br><br>

      <label for="senha">Nova Senha:</label><br>
    <input type="password" id="senha" name="senha" ><br><br>


    <button type="submit" value="Salvar">Editar</button>
</form>

</body>
</html>