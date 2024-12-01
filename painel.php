<?php include('protect.php'); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            background-color: #222;
            color: #eee;
            overflow: hidden;
            position: relative;
            display: flex; /* Centraliza verticalmente */
            flex-direction: column; /* Centraliza verticalmente */
            justify-content: center; /* Centraliza verticalmente */
            align-items: center; /* Centraliza horizontalmente */
            min-height: 100vh; /* Garante que ocupe a altura total da tela */
        }

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
            font-size: 2em; /* Tamanho maior */
            margin-bottom: 1em; /* Margem inferior ajustada */
        }

        p {
            margin-top: 1em; /* Margem superior ajustada */
        }

        a {
            color: #669988;
            text-decoration: none;
            font-size: 1.2em; /* Tamanho maior */
            transition: color 0.3s;
            padding: 0.5em 1em; /* Adiciona padding */
            border: 1px solid #669988; /* Adiciona borda */
            border-radius: 5px; /* Borda arredondada */
        }

        a:hover {
            color: #004433;
            background-color: #669988; /* Cor de fundo ao passar o mouse */
        }

    </style>
</head>
<body>

    <h1>Bem vindo ao Painel, <?php echo $_SESSION['name']; ?></h1>
    <p><a href="gerenciamento.php">Todos os Cadastros</a></p>
    <p><a href="logout.php">Sair</a></p>

</body>
</html>