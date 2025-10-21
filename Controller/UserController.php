<?php

namespace Controller;

use Model\User;
use Exception;

class UserController
{
    private $userModel;

    // A MUDANÇA ESSENCIAL: Aceita o Model (ou Mock) como dependência (DI)
    public function __construct(User $userModel = null)
    {
        // Se um Model (ou Mock) foi injetado, usa ele; senão, cria o real (new User())
        $this->userModel = $userModel ?? new User();
    }

    public function createUser($nome, $email, $senha)
    {
        if (empty($nome) or empty($email) or empty($senha)) {
            return false;
        }

        $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);

        return $this->userModel->registerUser($nome, $email, $hashedPassword);
    }

    public function checkUserByEmail($email)
    {
        return $this->userModel->getUserByEmail($email);
    }

    public function login($email, $senha)
    {
        // Busca o usuário por e-mail
        $user = $this->userModel->getUserByEmail($email);

        // Verifica se o usuário existe e a senha está correta
        if ($user && password_verify($senha, $user['senha'])) {
            // Salva dados na sessão
            $_SESSION['id'] = $user['id'];
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['email'] = $user['email'];
            return true;
        }

        return false;
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['id']);
    }

    public function getUserData()
    {
        if ($this->isLoggedIn()) {
            return [
                'id' => $_SESSION['id'],
                'nome' => $_SESSION['nome'],
                'email' => $_SESSION['email']
            ];
        }

        return null;
    }
}

?>