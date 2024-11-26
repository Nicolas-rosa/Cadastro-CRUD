<?php 
include('conexao.php'); // Inclui a conexão com o banco de dados

// Verifica se o ID do usuário foi passado
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Busca o usuário no banco de dados
    $result = $mysqli->query("SELECT * FROM usuarios WHERE id = $id");
    $usuario = $result->fetch_assoc();

    // Se o usuário não for encontrado, redireciona para a lista
    if (!$usuario) {
        header("Location: gerenciamento.php");
        exit;
    }
}

// Manipula a atualização do usuário
if (isset($_POST['update'])) {
    $nome = $mysqli->real_escape_string($_POST['nome']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $telefone = $mysqli->real_escape_string($_POST['telefone']);
    $senha = $mysqli->real_escape_string($_POST['senha']);

    // Atualiza os dados do usuário no banco de dados
    $mysqli->query("UPDATE usuarios SET nome = '$nome', email = '$email', telefone = '$telefone', senha = '$senha' WHERE id = $id");

    // Redireciona para a lista de usuários após a atualização
    header("Location: gerenciamento.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <h1>Editar Usuário</h1>

    <form method="POST">
        <label>Nome:</label>
        <input type="text" name="nome" value="<?php echo $usuario['nome']; ?>" required>
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $usuario['email']; ?>" required>
        <label>Telefone:</label>
        <input type="tel" name="telefone" value="<?php echo $usuario['telefone']; ?>" required>
        <label>Senha:</label>
        <input type="password" name="senha">
        <button type="submit" name="update">Atualizar</button>
    </form>

    <p><a href="gerenciamento.php">Voltar para a lista de usuários</a></p>
</body>
</html>