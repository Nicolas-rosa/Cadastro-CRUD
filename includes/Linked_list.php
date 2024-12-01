<?php

class Node { // Classe que representa um nó na lista encadeada
    public $id; // ID do usuário
    public $nome; // Nome do usuário
    public $email; // Email do usuário
    public $telefone; // Telefone do usuário
    public $senha; // Senha do usuário
    public $proximo; // Referência para o próximo nó na lista

    // Construtor da classe Node
    public function __construct($id, $nome, $email, $telefone, $senha) {
        $this->id = $id; // Inicializa o ID
        $this->nome = $nome; // Inicializa o nome
        $this->email = $email; // Inicializa o email
        $this->telefone = $telefone; // Inicializa o telefone
        $this->senha = $senha; // Inicializa a senha
        $this->proximo = null; // Inicializa a referência para o próximo nó como nula
    }
}

class LinkedList { // Classe que representa a lista encadeada
    private $cabeca; // Referência para o primeiro nó da lista
    private $tamanho; // Tamanho da lista

    // Construtor da classe LinkedList
    public function __construct() {
        $this->cabeca = null; // Inicializa a cabeça como nula
        $this->tamanho = 0; // Inicializa o tamanho como zero
    }

    // Método para buscar um usuário pelo email
    public function buscarPorEmail($email) {
        $atual = $this->cabeca; // Começa a busca a partir da cabeça da lista
        while ($atual !== null) { // Enquanto não chegar ao final da lista
            if ($atual->email == $email) { // Se o email do nó atual corresponder
                return $atual; // Retorna o nó encontrado
            }
            $atual = $atual->proximo; // Avança para o próximo nó
        }
        return null; // Retorna null se não encontrar o email
    }

    // Método para inserir um novo usuário na lista
    public function inserir($id, $nome, $email, $telefone, $senha) {
        $novoNo = new Node($id, $nome, $email, $telefone, $senha); // Cria um novo nó
        
        if ($this->cabeca === null) { // Se a lista estiver vazia
            $this->cabeca = $novoNo; // O novo nó se torna a cabeça da lista
        } else {
            $novoNo->proximo = $this->cabeca; // Inserção no início - mais eficiente
            $this->cabeca = $novoNo; // Atualiza a cabeça para o novo nó
        }
        $this->tamanho++; // Incrementa o tamanho da lista
    }

    // Método para buscar um usuário pelo ID
    public function buscarPorId($id) {
        $atual = $this->cabeca; // Começa a busca a partir da cabeça da lista
        while ($atual !== null) { // Enquanto não chegar ao final da lista
            if ($atual->id == $id) { // Se o ID do nó atual corresponder
                return $atual; // Retorna o nó encontrado
            }
            $atual = $atual->proximo; // Avança para o próximo nó
        }
        return null; // Retorna null se não encontrar o ID
    }

    // Método para remover um usuário da lista pelo ID
    public function remover($id) {
        if ($this->cabeca === null) {
            return false; // Retorna falso se a lista estiver vazia
        }

        if ($this->cabeca->id == $id) { // Se o ID do nó da cabeça corresponder
            $this->cabeca = $this->cabeca->proximo; // Atualiza a cabeça para o próximo nó
            $this->tamanho--; // Decrementa o tamanho da lista
            return true; // Retorna verdadeiro indicando que foi removido
        }

        $anterior = $this->cabeca; // Nó anterior
        $atual = $this->cabeca->proximo; // Nó atual

        while ($atual !== null) { // Enquanto não chegar ao final da lista
            if ($atual->id == $id) { // Se o ID do nó atual corresponder
                $anterior->proximo = $atual->proximo; // Remove o nó atual
                $this->tamanho--; // Decrementa o tamanho da lista
                return true; // Retorna verdadeiro indicando que foi removido
            }
            $anterior = $atual; // Av ança o nó anterior
            $atual = $atual->proximo; // Avança para o próximo nó
        }

        return false; // Retorna falso se o ID não for encontrado
    }

    // Método para obter o tamanho da lista
    public function getTamanho() {
        return $this->tamanho; // Retorna o tamanho atual da lista
    }
    
    // Método para imprimir todos os usuários na lista
    public function imprimirLista() {
        $atual = $this->cabeca; // Começa a impressão a partir da cabeça da lista
        while ($atual !== null) { // Enquanto não chegar ao final da lista
            echo "ID: " . $atual->id . ", Nome: " . $atual->nome . ", Email: " . $atual->email . "<br>"; // Imprime os dados do nó atual
            $atual = $atual->proximo; // Avança para o próximo nó
        }
    }

    // Método para remover um usuário da lista e do banco de dados
    public function removerUsuario($id, $database) {
        // Tenta remover da lista encadeada
        if ($this->remover($id)) {
            // Tenta remover do banco de dados
            if ($database->removerUsuarioDoBanco($id)) {
                return true; // Retorna verdadeiro se a remoção foi bem-sucedida
            } else {
                // Retorna falso se houve um problema ao remover do banco de dados
                return false;
            }
        } else {
            return false; // Retorna falso se o usuário não foi encontrado na lista
        }
    }

    // Método para editar os dados de um usuário
    public function editarUsuario($id, $novoNome, $novoEmail, $novoTelefone, $novaSenha, $database) {
        $usuario = $this->buscarPorId($id); // Busca o usuário pelo ID
        if ($usuario) {
            // Atualiza os dados do usuário
            $usuario->nome = $novoNome;
            $usuario->email = $novoEmail;
            $usuario->telefone = $novoTelefone;
            $usuario->senha = $novaSenha;

            // Tenta atualizar no banco de dados
            if ($database->atualizarUsuarioNoBanco($id, $novoNome, $novoEmail, $novoTelefone, $usuario->senha)) {
                return true; // Retorna verdadeiro se a atualização foi bem-sucedida
            } else {
                // Retorna falso se houve um problema ao atualizar no banco de dados
                return false;
            }
        } else {
            return false; // Retorna falso se o usuário não foi encontrado
        }
    }
}

class Database { // Classe que representa a conexão com o banco de dados
    private $conexao; // Objeto de conexão

    // Construtor da classe Database
    public function __construct($host, $usuario, $senha, $banco) {
        $this->conexao = new mysqli($host, $usuario, $senha, $banco); // Cria a conexão com o banco de dados
        if ($this->conexao->connect_error) {
            die("Erro na conexão com o banco de dados: " . $this->conexao->connect_error); // Exibe erro se a conexão falhar
        }
    }

    // Método para inserir um novo usuário no banco de dados
    public function inserirUsuario($nome, $email, $telefone, $senha) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT); // Gera o hash da senha
        $stmt = $this->conexao->prepare("INSERT INTO usuarios (nome, email, telefone, senha) VALUES (?, ?, ?, ?)"); // Prepara a consulta
        $stmt->bind_param("ssss", $nome, $email, $telefone, $senhaHash); // Liga os parâmetros

        if ($stmt->execute()) {
            return true; // Retorna verdadeiro se a inserção foi bem-sucedida
        } else {
            echo "Erro ao inserir usuário no banco de dados: " . $stmt->error; // Exibe erro se a inserção falhar
            return false;
        }
    }

    // Método para verificar se um email já existe no banco de dados
    public function emailExiste($email) {
        $stmt = $this->conexao->prepare("SELECT id FROM usuarios WHERE email = ?"); // Prepara a consulta
        $stmt->bind_param("s", $email); // Liga o parâmetro
        $stmt->execute(); // Executa a consulta
        $stmt->store_result(); // Armazena o resultado
        $num_rows = $stmt->num_rows; // Obtém o número de linhas retornadas
        $stmt->close(); // Fecha a declaração
        return $num_rows > 0; // Retorna verdadeiro se o email existir
    }

    // Método para remover um usuário do banco de dados pelo ID
    public function removerUsuarioDoBanco($id) {
        $stmt = $this->conexao->prepare("DELETE FROM usuarios WHERE id = ?"); // Prepara a consulta
        $stmt->bind_param("i", $id); // Liga o parâmetro
        if ($stmt->execute()) {
            return true; // Retorna verdadeiro se a remoção foi bem-sucedida
        } else {
            echo "Erro ao remover usuário do banco de dados: " . $stmt->error; // Exibe erro se a remoção falhar
            return false;
        }
    }

    // Método para obter a conexão com o banco de dados
    public function getConexao() {
        return $this->conexao; // Retorna o objeto de conexão
    }

    // Método para atualizar os dados de um usuário no banco de dados
    public function atualizarUsuarioNoBanco($id, $novoNome, $novoEmail, $novoTelefone, $novaSenha) {
        $stmt = $this->conexao->prepare("UPDATE usuarios SET nome = ?, email = ?, telefone = ?, senha = ? WHERE id = ?"); // Prepara a consulta
        $stmt->bind_param("ssssi", $novoNome, $novoEmail, $novoTelefone, $novaSenha, $id); // Liga os parâmetros

        if ($stmt->execute()) {
            return true; // Retorna verdadeiro se a atualização foi bem-sucedida
        } else {
            echo "Erro ao atualizar usuário no banco de dados: " . $stmt->error; // Exibe erro se a atualização falhar
            return false;
        }
    }

    // Método para fechar a conexão com o banco de dados
    public function fecharConexao() {
        $this->conexao->close(); // Fecha a conexão
    }
}
?>