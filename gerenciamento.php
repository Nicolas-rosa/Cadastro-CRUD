<?php

function checkAdminPermission() { // Função para verificar se o usuário tem permissão de administrador
    session_start(); // Inicia a sessão

    if (!isset($_SESSION['id']) || $_SESSION['id'] !== 1) { // Verifica se o ID da sessão está definido e se é igual a 1 (administrador)
        return false; // Retorna falso se não tiver permissão
    }

    return true; // Retorna verdadeiro se tiver permissão
}

// Verifica a permissão antes de qualquer saída HTML
if (!checkAdminPermission()) { // Se o usuário não tiver permissão
    // Inclui o arquivo HTML de erro
    include('protect_adm.php'); // Cria um arquivo acesso_negado.php com o HTML de erro
    exit; // Encerra o script após exibir a mensagem de erro
}

// Se chegou aqui, o usuário tem permissão
include('conexao.php'); // Inclui o arquivo de conexão com o banco de dados

// Lógica de busca
$search_term = ""; // Inicializa a variável de busca
if (isset($_GET['search'])) { // Verifica se o termo de busca foi passado via GET
    $search_term = $_GET['search']; // Captura o termo de busca
    $search_term = $mysqli->real_escape_string($search_term); // Previne SQL injection sanitizando o termo de busca

    // Consulta SQL para buscar usuários com base no termo de busca
    $sql = "SELECT * FROM usuarios WHERE nome LIKE '%$search_term%' OR email LIKE '%$search_term%' OR telefone LIKE '%$search_term%' ORDER BY id DESC";
} else {
    // Consulta SQL para buscar todos os usuários se não houver termo de busca
    $sql = "SELECT * FROM usuarios ORDER BY id DESC";
}

$result = $mysqli->query($sql); // Executa a consulta SQL

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central de Gerenciamento</title>
    <style>
body {
    font-family: 'Courier New', monospace; /* Fonte monospaçada para aparência digital */
    background-color: #222; /* Fundo escuro como uma tela antiga */
    color: #eee; /* Texto claro */
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


table {
    width: 90%;
    border-collapse: collapse;
    margin: 20px auto; /* Centraliza a tabela */
    background-color: #00110f; /* Verde escuro */
    border: 1px solid #333; /* Borda simulando tela antiga */
    box-shadow: none; /* Sem sombra neumorphic */

}

th, td {
    padding: 10px;
    text-align: left;
    border: 1px solid #333; /* Bordas das células como pixels */
}

th {
    background-color: #003322; /* Verde mais escuro para o cabeçalho */
    color: #669988; /* Verde claro para o texto do cabeçalho */
    font-weight: normal;
    text-shadow: 1px 1px 0 #000; /* Sombra de texto para simular baixa resolução */
    border-radius: 0; /* Sem cantos arredondados */
    box-shadow: none; /* Remova a sombra neumorphic do cabeçalho */
}


tbody tr:nth-child(even) {
    background-color: #00221a; /* Verde escuro alternado */
}

tbody tr:hover {
    background-color: #004433; /* Verde mais claro ao passar o mouse */
    filter: brightness(1.1); /* Aumenta o brilho ao passar o mouse */

}



h1 {
    color: #669988;
    text-align: center;
    margin-bottom: 20px;
    text-shadow: 1px 1px 0 #000; /* Sombra de texto */
    font-family: 'Courier New', monospace;

}
form {
    display: flex; /* Alinha os elementos horizontalmente */
    align-items: center; /* Centraliza verticalmente */
    justify-content: center; /* Centraliza horizontalmente */
    margin-bottom: 20px; /* Espaçamento abaixo do formulário */
}

label {
    margin-right: 10px; /* Espaçamento entre o label e o input */
    color: #669988; /* Cor do texto do label */
}

input[type="text"] {
    padding: 8px;
    border: 1px solid #333; /* Borda estilo pixel */
    background-color: #00110f; /* Fundo escuro */
    color: #eee; /* Cor do texto */
    border-radius: 0; /* Sem cantos arredondados */
}

button {
    padding: 8px 15px; /* Espaçamento interno do botão */
    background-color: #003322; /* Cor de fundo do botão */
    color: #669988; /* Cor do texto do botão */
    border: 1px solid #333; /* Borda estilo pixel */
    cursor: pointer; /* Cursor de ponteiro ao passar o mouse */
    border-radius: 0; /* Sem cantos arredondados */
    transition: background-color 0.3s;  /* Transição suave na cor de fundo */
}


button:hover {
    background-color: #004433; /* Cor de fundo do botão ao passar o mouse */

}

.container {
  box-shadow: none;
  background-color: transparent;
  padding: 0;
}
    </style>
</head>
<body>

<h1>Central de Gerenciamento</h1>

<!-- Formulário de Busca -->
<form method="GET" action="">
    <label for="search">Buscar:</label>
    <input type="text" id="search" name="search" value="<?php echo $search_term; ?>">
    <button type="submit">Pesquisar</button>
</form>


<table border="1">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>E-Mail</th>
            <th>Telefone</th>
            <th>Senha</th>
            <th>Editar</th>
            <th>Excluir</th>
        </tr>
    </thead>

    <tbody>
        <?php 
        if ($result->num_rows > 0) { // Verifica se há resultados
            while($user_data = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$user_data['id']."</td>";
                echo "<td>".$user_data['nome']."</td>";
                echo "<td>".$user_data['email']."</td>";
                echo "<td>".$user_data['telefone']."</td>";
                echo "<td>".$user_data['senha']."</td>";
  /*edita */              echo "<td> <a href='editar.php?id=$user_data[id]'><img width='50' height='50' src='https://img.icons8.com/?size=100&id=41647&format=png&color=000000' alt='Editar'></a></td>";
  /*exclui */              echo "<td><a href='delete.php?id=$user_data[id]'><img width='50' height='50' src='https://img.icons8.com/?size=100&id=OZuepOQd0omj&format=png&color=000000' alt='Excluir'></a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Nenhum resultado encontrado.</td></tr>"; // Mensagem se não houver resultados
        }
        ?>
    </tbody>
</table>
</body>
</html>