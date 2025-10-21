<?php

// Define o namespace da classe
namespace Model;

// Importa as classes PDO e PDOException
use PDO;
use PDOException;

// Classe para conexão com o banco
class Connection
{
    // Endereço do servidor
    private $host = 'localhost';

    // Nome do banco de dados
    private $dbname = 'intelecta'; 

    // Nome do usuário do banco
    private $username = 'root';

    // Senha do banco
    private $password = '';

    // Objeto de conexão PDO
    private $connection;

    // Construtor da classe
    public function __construct()
    {
        try {
            // Cria a conexão com o banco
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8", // DSN
                $this->username, // Usuário
                $this->password, // Senha
                [ // Opções PDO
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lança exceção em erro
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Retorna arrays associativos
                    PDO::ATTR_EMULATE_PREPARES => false, // Usa prepared statements reais
                ]
            );

        } catch (PDOException $error) {
            // Lança exceção com a mensagem de erro
            throw new \Exception('Erro na conexão com o banco de dados: ' . $error->getMessage());
        }
    }

    // Retorna o objeto PDO
    public function getConnection()
    {
        return $this->connection;
    }

    // Prepara uma query SQL
    public function prepare($sql)
    {
        return $this->connection->prepare($sql);
    }

    // Retorna o último ID inserido
    public function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }
}
?>