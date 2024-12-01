<?php   
// Inicia a sessão se ela ainda não estiver iniciada
if(!isset($_SESSION)){
    session_start();
}

// Verifica se o ID do usuário está definido na sessão
if(!isset($_SESSION['id'])){
    // Se o ID não estiver definido, exibe uma mensagem de erro e um link para a página de login
    die("Você não pode acessar esta página. Realize o login <p> <a href=\"index.php\">Entrar</a> </p>");
}
?>