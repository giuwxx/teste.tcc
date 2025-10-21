<?php

// Define o namespace da classe
namespace Model;

// Usa a classe Connection do mesmo namespace
use Model\Connection;

// Usa a classe PDOException para tratar erros do banco
use PDOException;

// Classe para manipular dados de usuários
class User
{
    // Instância da conexão com o banco
    private $db;

    // Nome da tabela no banco
    private $table = 'user';

    // Construtor cria a conexão
    public function __construct(?Connection $dbConnection = null)
    {
        $this->db = $dbConnection ?? new Connection();
    }

    // Registra um novo usuário
    public function registerUser($nome, $email, $senha)
    {
        try {
            // Query SQL para inserir dados do usuário
            $sql = "INSERT INTO {$this->table} (nome, email, senha, data_criacao) VALUES (?, ?, ?, NOW())";

            // Prepara a query
            $stmt = $this->db->prepare($sql);

            // Executa com os valores passados
            $result = $stmt->execute([$nome, $email, $senha]);

            // Se inseriu, retorna o último ID inserido
            if ($result) {
                return $this->db->lastInsertId();
            }

            // Se não, retorna falso
            return false;
        } catch (PDOException $e) {
            // Loga o erro no servidor
            error_log('Erro ao registrar usuário: ' . $e->getMessage());

            // Retorna falso em caso de erro
            return false;
        }
    }

    // Busca usuário pelo email
    public function getUserByEmail($email)
    {
        try {
            // Query SQL para selecionar pelo email
            $sql = "SELECT * FROM {$this->table} WHERE email = ? LIMIT 1";

            // Prepara a query
            $stmt = $this->db->prepare($sql);

            // Executa com o email passado
            $stmt->execute([$email]);

            // Busca o resultado
            $user = $stmt->fetch();

            // Retorna usuário ou falso se não achar
            return $user ? $user : false;
        } catch (PDOException $e) {
            // Loga o erro no servidor
            error_log('Erro ao buscar usuário por email: ' . $e->getMessage());

            // Retorna falso em caso de erro
            return false;
        }
    }

    // Busca usuário pelo ID
    public function getUserById($id)
    {
        try {
            // Query SQL para selecionar pelo ID
            $sql = "SELECT * FROM {$this->table} WHERE id = ? LIMIT 1";

            // Prepara a query
            $stmt = $this->db->prepare($sql);

            // Executa com o ID passado
            $stmt->execute([$id]);

            // Busca o resultado
            $user = $stmt->fetch();

            // Retorna usuário ou falso se não achar
            return $user ? $user : false;
        } catch (PDOException $e) {
            // Loga o erro no servidor
            error_log('Erro ao buscar usuário por ID: ' . $e->getMessage());

            // Retorna falso em caso de erro
            return false;
        }
    }
}
?>