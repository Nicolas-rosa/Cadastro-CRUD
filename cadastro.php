<?php
// Inclui o arquivo de conexão com o banco de dados
include('conexao.php');

// Verifica se o formulário foi enviado
if(isset($_POST['submit'])){
    // Obtém os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $senha = $_POST['senha'];
    

    // Prepara a query SQL
    $stmt = mysqli_prepare($mysqli, "INSERT INTO usuarios(nome, email, telefone, senha) VALUES (?, ?, ?, ?)");

    // Verifica se o prepare foi bem-sucedido
    if ($stmt === false) {
        die("Erro na preparação da query: " . mysqli_error($mysqli));
    }

    // Associa os parâmetros à query
    mysqli_stmt_bind_param($stmt, "ssss", $nome, $email, $telefone, $senha);

    // Executa a query
    $result = mysqli_stmt_execute($stmt);

    // Verifica se a execução foi bem-sucedida
    if($result){
        // Redireciona o usuário para a página index.php
        header("Location: index.php ");
        exit(); // Encerra a execução do script após o redirecionamento
    }else{
        // Exibe uma mensagem de erro caso a inserção falhe
        echo "Erro ao cadastrar: " . mysqli_stmt_error($stmt);
    }

    // Fecha o statement
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <style>

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
    background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAICAYAAADA+m62AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAAaSURBVHjaYmBgYGBkYmZhZWNnZ2hoaWpqampoaGhgaWpqYmBgYGBkbFlY2NjY2dnZ2tra2thcXFwcHBwcHBoaGhqaGhoYGBgYGRkYmZhZWNnZ2hoaGhoaWpqYmJiYGBgY2RmZ2dnZ2hrbGxsbGxsbW1tbW1tbG1tbW1wcXFwcHBwcGhrGxsbGxsbm5ubm5ub29vb29vb3Nzc3Nzc3cPDw8PDw8eHh4eHh4fHx8fHx8fLy8vLy8vLi4uLi4uLj4+Pj4+Pj5+fn5+fn6+vr6+vr7+/v7+/v8PDw8PDw8PHx8fHx8fLy8vLy8vLz8/Pz8/Pz09PT09PT19fX19fX29vb29vb39/f39/f4+Pj4+Pj5+fn5+fn6+vr6+vr7+/v7+/v8/Pz8/P09PT09PT19fX19fX29vb29vb39/f39/f4+Pj4+Pj5+vr6+vr7+/v7+/v8/Pz8/P09PT09PT19fX29vb39/f4+Pj5+fn7+/v8/Pz9PT19fb29vf3+Pj4+fr7+////wMAC+cSmH4AAAAASUVORK5CYII="); /* Imagem de scanlines */
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

input [type="text"]:focus,
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

    </style>
</head>
<body>
    <h1>Acesse sua Conta</h1>
    <form action="cadastro.php" method="POST">
         <p>
        <label >Nome</label>
        <input type="text" name="nome" required>
        </p>

        <p>
        <label >E-mail</label>
        <input type="text" name="email" required>
        </p>

        <p>
        <label>Telefone</label>
        <input type="tel" name="telefone" required>
        </p>

        <p>
        <label>Senha</label>
        <input type="password" name="senha" required>
        </p>

        <button type="submit" name="submit">Acessar</button>

        <a href="index.php">Login</a>
    </form>
</body>
</html>