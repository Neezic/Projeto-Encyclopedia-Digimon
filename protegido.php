<?php
require_once 'includes/cabecalho.php';

if (!isset($_SESSION['logado'])) {
    header('Location: login.php');
    exit;
}

// Inicializa a lista de Digimons adicionados se não existir
if (!isset($_SESSION['digimons_adicionados'])) {
    $_SESSION['digimons_adicionados'] = [];
}

// Processa o formulário de adição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novoDigimon = [
        'id' => uniqid(),
        'name' => $_POST['nome'],
        'level' => $_POST['nivel'],
        'type' => $_POST['tipo'],
        'image' => $_POST['imagem'] ?? 'assets/img/digimon-default.png',
        'added_manually' => true  // Flag para identificar Digimons adicionados
    ];
    
    array_unshift($_SESSION['digimons_adicionados'], $novoDigimon);
    $_SESSION['mensagem'] = 'Digimon adicionado com sucesso!';
    header('Location: protegido.php');
    exit;
}

$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);
?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>
            <i class="bi bi-shield-lock"></i> Área Administrativa
        </h1>
        <a href="logout.php" class="btn btn-outline-danger">
            <i class="bi bi-box-arrow-left"></i> Sair
        </a>
    </div>
    
    <?php if ($mensagem): ?>
        <div class="alert alert-success"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-plus-circle"></i> Adicionar Novo Digimon
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="nivel" class="form-label">Nível</label>
                            <select class="form-select" id="nivel" name="nivel" required>
                                <option value="Fresh">Fresh</option>
                                <option value="In Training">In Training</option>
                                <option value="Rookie">Rookie</option>
                                <option value="Champion">Champion</option>
                                <option value="Ultimate">Ultimate</option>
                                <option value="Mega">Mega</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <input type="text" class="form-control" id="tipo" name="tipo" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="imagem" class="form-label">URL da Imagem</label>
                            <input type="url" class="form-control" id="imagem" name="imagem">
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Salvar Digimon
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-person-circle"></i> Informações da Conta
                </div>
                <div class="card-body">
                    <p><strong>Usuário:</strong> <?= htmlspecialchars($_SESSION['usuario'] ?? 'Admin') ?></p>
                    <p><strong>Último acesso:</strong> <?= date('d/m/Y H:i:s') ?></p>
                    <hr>
                    <a href="alterar-senha.php" class="btn btn-outline-primary">
                        <i class="bi bi-key"></i> Alterar Senha
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/rodape.php'; ?>