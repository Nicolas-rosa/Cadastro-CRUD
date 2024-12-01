<?php
session_start(); // Inicia a sessão para armazenar dados do usuário

// Inclui a definição da lista encadeada (apenas para demonstração, não recomendado para produção)
include('includes/Linked_list.php'); // Importa a classe de lista encadeada

// Inicializa a lista encadeada (apenas em memória, por enquanto)
$listaUsuarios = new LinkedList(); // Cria uma nova lista encadeada para usuários, mas não é persistente

// Inicializa a conexão com o banco de dados
$database = new Database('localhost', 'root', 'usbw', 'login'); // Conecta ao banco de dados com as credenciais fornecidas

// Verifica se o formulário foi enviado
if (isset($_POST['submit'])) { // Se o botão de envio foi clicado
    // Obtém os dados do formulário
    $nome = $_POST['nome']; // Captura o nome do usuário
    $email = $_POST['email']; // Captura o e-mail do usuário
    $telefone = $_POST['telefone']; // Captura o telefone do usuário
    $senha = $_POST['senha']; // Captura a senha do usuário

    // Verifica se o e-mail já existe no BANCO DE DADOS
    $email_existe_no_banco = $database->emailExiste($email); // Checa se o e-mail já está cadastrado

    if ($email_existe_no_banco) { // Se o e-mail já existir
        echo "<p style='color:red;text-align:center;'>Erro: Este endereço de e-mail já está cadastrado.</p>"; // Exibe mensagem de erro
    } else {
        // Insere o usuário no banco de dados
        if ($database->inserirUsuario($nome, $email, $telefone, $senha)) { // Tenta inserir o usuário
            $_SESSION['cadastro_sucesso'] = "Usuário cadastrado com sucesso!"; // Mensagem de sucesso na sessão
            header("Location: index.php"); // Redireciona para a página inicial
            exit(); // Encerra o script
        } else {
            echo "<p style='color:red;text-align:center;'>Erro ao cadastrar usuário.</p>"; // Exibe mensagem de erro se a inserção falhar
        }
    }
}

$database->fecharConexao(); // Fecha a conexão com o banco de dados
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configura a responsividade -->
    <title>Cadastro</title> <!-- Título da página -->
    <style>
        /* Estilos conforme seu código original */
        body {
            font-family: 'Courier New', monospace; /* Fonte monospaçada para aparência digital */
            background-color: #222; /* Fundo escuro como uma tela antiga */
            color: #eee; /* Texto claro */
            overflow: hidden; /* Para o efeito de scanlines */
            position: relative; /* Para posicionar as scanlines */
        }
        /* Scanlines (linhas de varredura) */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAICAYAAADA+m62AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAAaSURBVHjaYmBgYGBkYmZhZWNnZ2hoaWpqampoaGhgaWpqYmBgYGBkbFlY2NjY2dnZ2tra2thcXFwcHBwcHBoaGhqaGhoYGBgYGRkYmZhZWNnZ2hoaGhoaWpqYmJiYGBgY2RmZ2dnZ2hrbGxsbGxsbW1tbW1tbG1tbW1wcXFwcHBwcGhrGxsbGxsbm5ubm5ub29vb29vb3Nzc3Nzc3cPDw8PDw8eHh4eHh4fHx8fHx8fLy8vLy8vLi4uLi4uLj4+Pj4+Pj5+fn5+fn6+vr6+vr7+/v7+/v8PDw8PDw8PHx8fHx8fLy8vLy8vLz8/Pz8/P09PT09PT19fX19fX29vb29vb39/f39/f4+Pj4+Pj5+fn5+fn6+vr6+vr7+/v7+/v8/Pz8/P09PT09PT19fX19fX29vb29vb39/f39/f4+Pj4+Pj5+vr6+vr7+/v7+/v8/Pz8/P09PT09PT19fX29vb39/f4+Pj5+fn7+/v8/Pz9PT19fb29vf3+Pj4+fr7+////wMAC+cSmH4AAAAASUVORK5CYII="); /* Imagem de scanlines */
            opacity: 0.1; /* Opacidade das scanlines */
            mix-blend-mode: overlay;  /* Mistura as scanlines com o fundo */
            pointer-events: none; /* Permite clicar nos elementos atrás das scanlines */
        }

        h1 {
            color: #669988;
            text-align: center;
            margin-bottom: 20px;
            text-shadow: 1px 1px 0 #000; /* Sombra de texto */
            font-family: 'Courier New', monospace;
        }

        form {
            width: 90%;
            max-width: 400px; /* Limita a largura do formulário */
            margin: 20px auto; /* Centraliza o formulário */
            background-color: #00110f; /* Verde escuro */
            border: 1px solid #333; /* Borda simulando tela antiga */
            padding: 20px; /* Espaçamento interno */
            border-radius: 5px; /* Cantos arredondados */
            box-shadow: none; /* Sem sombra neumorphic */
        }

        p {
            margin-bottom: 15px; /* Espaçamento entre os campos */
        }

        label {
            display: block; /* Faz o label ocupar toda a largura */
            margin-bottom: 5px; /* Espaçamento abaixo do label */
            color: #669988; /* Cor do texto do label */
        }

        input[type="text"],
        input[type="tel"],
        input[type="password"] {
            width: 100%; /* Largura total */
            padding: 10px; /* Espaçamento interno */
            border: 1px solid #333; /* Borda simulando pixels */
            background-color: #003322; /* Verde escuro para o fundo do input */
            color: #eee; /* Texto claro */
            font-family: 'Courier New', monospace; /* Fonte monospaçada */
            border-radius: 3px; /* Cantos arredondados */
        }

        input[type="text"]:focus,
        input[type="tel"]:focus,
        input[type="password"]:focus {
            outline: none; /* Remove o contorno padrão */
            border-color: #669988; /* Cor da borda ao focar */
            background-color: #004433; /* Fundo mais claro ao focar */
        }

        button {
            background-color: #669988; /* Cor do botão */
            color: #222; /* Texto escuro */
            padding: 10px 15px; /* Espaçamento interno */
            border: none; /* Sem borda */
            border-radius: 3px; /* Cantos arredondados */
            cursor: pointer; /* Cursor de ponteiro */
            font-family: 'Courier New', monospace; /* Fonte monospaçada */
            transition: background-color 0.3s; /* Transição suave para a cor de fundo */
        }

        button:hover {
            background-color: #004433; /* Cor do botão ao passar o mouse */
        }
    </style>

</head>
<body>
    <h1>Cadastro de Usuário</h1> <!-- Título da página -->
    <form action="cadastro.php" method="POST"> <!-- Formulário de cadastro -->
        <p>
            <label>Nome</label> <!-- Label para o campo de nome -->
            <input type="text" name="nome" required> <!-- Campo de entrada para o nome -->
        </p>

        <p>
            <label>E-mail</label> <!-- Label para o campo de e-mail -->
            <input type="text" name="email" required> <!-- Campo de entrada para o e-mail -->
        </p>

        <p>
            <label>Telefone</label> <!-- Label para o campo de telefone -->
            <input type="tel" name="telefone" required> <!-- Campo de entrada para o telefone -->
        </p>

        <p>
            <label>Senha</label> <!-- Label para o campo de senha -->
            <input type="password" name="senha" required> <!-- Campo de entrada para a senha -->
        </p>

        <button type="submit" name="submit">Cadastrar</button> <!-- Botão de envio do formulário -->
        <a href="index.php">Voltar</a> <!-- Link para voltar à página inicial -->
        <?php
        // Exibe a mensagem de sucesso, se existir
        if (isset($_SESSION['cadastro_sucesso'])) { // Se a mensagem de sucesso estiver definida
            echo "<p style='color:green;text-align:center;'>" . $_SESSION['cadastro_sucesso'] . "</p>"; // Exibe a mensagem de sucesso
            unset($_SESSION['cadastro_sucesso']); // Remove a mensagem da sessão para que não seja exibida novamente
        }
        ?>
    </form>
</body>
</html>