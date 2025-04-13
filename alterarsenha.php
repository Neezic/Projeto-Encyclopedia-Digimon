<?php
require_once 'includes/cabecalho.php';

if (!isset($_SESSION['logado'])) {
    header('Location: login.php');
    exit;
}

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senhaAtual = $_POST['senha_atual'] ?? '';
    $novaSenha = $_POST['nova_senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';
    
    // Verificar senha atual (em um sistema real, verificar no banco de dados)
    $senhaValida = password_verify($senhaAtual, $usuariosValidos[$_SESSION['usuario']]);
    
    if (!$senhaValida) {
        $erro = 'Senha atual incorreta!';
    } elseif ($novaSenha !== $confirmarSenha) {
        $erro = 'As novas senhas não coincidem!';
    } elseif (strlen($novaSenha) < 6) {
        $erro = 'A senha deve ter pelo menos 6 caracteres!';
    } else {
        // Em um sistema real, atualizaria no banco de dados
        $sucesso = 'Senha alterada com sucesso!';
    }
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">
                        <i class="bi bi-key"></i> Alterar Senha
                    </h2>
                    
                    <?php if ($erro): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
                    <?php endif; ?>
                    
                    <?php if ($sucesso): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($sucesso) ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label for="senha_atual" class="form-label">Senha Atual</label>
                            <input type="password" class="form-control" id="senha_atual" name="senha_atual" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="nova_senha" class="form-label">Nova Senha</label>
                            <input type="password" class="form-control" id="nova_senha" name="nova_senha" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirmar_senha" class="form-label">Confirmar Nova Senha</label>
                            <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Alterar Senha
                            </button>
                            <a href="protegido.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Voltar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/rodape.php'; ?>