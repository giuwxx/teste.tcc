<?php
// Inicia a sessão para controle futuro
session_start();

// Carrega automaticamente as classes via Composer
require_once '../vendor/autoload.php';

// Importa a classe UserController
use Controller\UserController;

// Cria uma instância do UserController
$userController = new UserController();

// --- Lógica de Mensagens e Processamento ---
$registerMessage = '';
$messageType = ''; // 'success' ou 'error'

// Verifica se o formulário foi enviado (método POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Confere se todos os campos foram preenchidos
    if (isset($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['confirmar_senha'])) {
        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $senha = $_POST['senha'];
        $confirmarSenha = $_POST['confirmar_senha'];

        // 2. Validação básica de senhas
        if ($senha !== $confirmarSenha) {
            $registerMessage = 'As senhas não coincidem. Por favor, tente novamente.';
            $messageType = 'error';
        } 
        // 3. Verifica se o e-mail já existe (usando seu método checkUserByEmail)
        else if ($userController->checkUserByEmail($email)) {
            $registerMessage = 'Este e-mail já está cadastrado. Tente fazer login.';
            $messageType = 'error';
        } 
        // 4. Tenta criar o usuário no banco
        else {
            $userId = $userController->createUser($nome, $email, $senha);

            if ($userId) {
                $registerMessage = 'Cadastro realizado com sucesso! Redirecionando para o login...';
                $messageType = 'success';
                // Redireciona para a página de login após 3 segundos
                header('Refresh: 3; URL=login.php'); 
            } else {
                // Erro no PDO ou na inserção. O erro interno já foi logado pelo Model/User.php
                $registerMessage = 'Ocorreu um erro interno ao tentar registrar. Verifique os logs do servidor.';
                $messageType = 'error';
            }
        }
    } else {
        $registerMessage = 'Por favor, preencha todos os campos obrigatórios.';
        $messageType = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Intelecta</title>
    <link rel="stylesheet" href="../src/css/login.css"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    </head>
<body>
    <div class="background-visual"></div>
    <div class="cadastro-container">
        <div class="cadastro-form-container"> <div class="logo-container">
                 <i class="fa-solid fa-lightbulb logo-icon"></i>
                 <h1 class="logo-text">Intelecta</h1>
            </div>

            <h2 class="welcome-title">Crie sua conta Intelecta</h2>
            <p class="welcome-subtitle">Aprenda de forma rápida e eficiente. É grátis!</p>
        
            <?php if (!empty($registerMessage)): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <?php echo $registerMessage; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="cadastro.php">
                <div class="input-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" required
                        placeholder="Seu nome e sobrenome"
                        value="<?php echo isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : ''; ?>"
                    >
                </div>
                
                <div class="input-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" required
                        placeholder="seu.email@exemplo.com"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    >
                </div>
                
                <div class="input-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" required
                        placeholder="Crie uma senha forte"
                    >
                </div>

                <div class="input-group">
                    <label for="confirmar_senha">Confirme a Senha</label>
                    <input type="password" id="confirmar_senha" name="confirmar_senha" required
                        placeholder="Repita sua senha"
                    >
                </div>
                
                <button type="submit" class="cadastro-btn">Cadastrar</button>
            </form>
            
            <div class="divider">
                <span>ou cadastre-se com</span>
            </div>
            <div class="social-buttons">
                <div class="social-btn facebook-btn"> <i class="fab fa-facebook-f"></i> </div>
                <div class="social-btn google-btn"> <i class="fab fa-google"></i> </div>
                <div class="social-btn apple-btn"> <i class="fab fa-apple"></i> </div>
            </div>

            <div class="login-link">
                <p>Já tem uma conta? <a href="login.php">Fazer Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>