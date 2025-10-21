<?php
// Inicia a sessão para controlar o login do usuário
session_start();

// Carrega automaticamente as classes via Composer
require_once '../vendor/autoload.php';

// Importa a classe UserController do namespace Controller
use Controller\UserController;

// Cria uma instância do UserController
$userController = new UserController();

// Inicializa a variável para mensagens de login
$loginMessage = '';

// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Confere se os campos email e senha foram enviados
    if (isset($_POST['email'], $_POST['senha'])) {
        // Recebe os dados enviados pelo formulário
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Tenta logar o usuário usando o controller
        if ($userController->login($email, $senha)) {
            // Se login OK, redireciona para página interna
            header('Location: ../View/inicio.html');
            exit();
        } else {
            // Se login falhou, define mensagem de erro
            $loginMessage = 'E-mail ou senha incorretos.';
        }
    } else {
        // Se algum campo não foi preenchido, mostra mensagem
        $loginMessage = 'Por favor, preencha todos os campos.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Elegance</title>
    <link rel="stylesheet" href="../Templates/css/login.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="background-image">
            <img src="../Templates/img/9592633.jpg" alt="background">
        </div>
        <div class="login-form-container">
            <div class="logo-container">
                <i class="fa-solid fa-lips logo-icon"></i>
                <h1 class="logo-text">Elegance</h1>
            </div>
            
            <div class="login-form">
                <h2 class="welcome-title">Olá, administrador!</h2>
                <p class="welcome-subtitle">Para continuar, digite seu e-mail e senha</p>
                <?php if (!empty($loginMessage )): ?>
                    <div class="alert alert-error">
                        <?php echo $loginMessage; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" class="form">
                    <div class="input-group">
                        <label for="email">E-mail *</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required
                            placeholder="Digite seu e-mail"
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                        >
                    </div>
                    <div class="input-group">
                        <label for="password">Senha *</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            placeholder="Digite sua senha"
                        >
                    </div>
                    <button type="submit" class="login-btn">Continuar</button>                  
                </form>
                
                <div class="divider">
                    <span>ou utilize suas redes sociais</span>
                </div>
                <div class="social-buttons">
                    <div class="social-btn facebook-btn">
                        <i class="fab fa-facebook-f"></i>
                    </div>
                    
                    <div class="social-btn google-btn">
                        <i class="fab fa-google"></i>
                    </div>
                    
                    <div class="social-btn apple-btn">
                        <i class="fab fa-apple"></i>
                    </div>
                </div>
                
                <div class="register-link">
                    <p>Não tem uma conta? <a href="../index.php">Cadastrar Administrador</a></p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.querySelector('.facebook-btn').addEventListener('click', function() {
            alert('Login com Facebook em desenvolvimento')
        })
        
        document.querySelector('.google-btn').addEventListener('click', function() {
            alert('Login com Google em desenvolvimento')
        })
        document.querySelector('.apple-btn').addEventListener('click', function() {
            alert('Login com Apple em desenvolvimento')
        })
    </script>
</body>
</html>
