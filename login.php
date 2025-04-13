<?php
require_once 'includes/cabecalho.php';

// Verifica se o usuário já está logado
if (isset($_SESSION['logado'])) {
    header('Location: protegido.php');
    exit;
}

// Credenciais válidas (em um sistema real, isso viria de um banco de dados)
$usuariosValidos = [
    'admin' => password_hash('digimon123', PASSWORD_DEFAULT),
    'treinador' => password_hash('digidex2023', PASSWORD_DEFAULT)
];

// Processa o formulário de login
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    // Verifica as credenciais
    if (array_key_exists($usuario, $usuariosValidos) && password_verify($senha, $usuariosValidos[$usuario])) {
        $_SESSION['logado'] = true;
        $_SESSION['usuario'] = $usuario;
        header('Location: protegido.php');
        exit;
    } else {
        $erro = 'Usuário ou senha incorretos!';
    }
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">
                        <i class="bi bi-key-fill"></i> Login DigiDex
                    </h2>
                    
                    <?php if ($erro): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuário</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-box-arrow-in-right"></i> Entrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/rodape.php'; ?>