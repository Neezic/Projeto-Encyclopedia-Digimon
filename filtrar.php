<?php
require_once 'includes/cabecalho.php';
require_once 'includes/API.php';

function filtrarDigimonsAPI($filtros) {
    $url = "https://digi-api.com/api/v1/digimon?";
    $params = [];
    
    if (!empty($filtros['nome'])) {
        $params[] = 'name=' . urlencode($filtros['nome']);
    }
    if (!empty($filtros['nivel'])) {
        $params[] = 'level=' . urlencode($filtros['nivel']);
    }
    if (!empty($filtros['tipo'])) {
        $params[] = 'type=' . urlencode($filtros['tipo']);
    }
    if (!empty($filtros['atributo'])) {
        $params[] = 'attribute=' . urlencode($filtros['atributo']);
    }
    
    if (empty($params)) {
        $params[] = 'pageSize=24';
    }
    
    $url .= implode('&', $params);
    $response = @file_get_contents($url);
    
    if ($response === FALSE) {
        return ['error' => 'Erro ao acessar a API'];
    }
    
    $data = json_decode($response, true);
    return $data['content'] ?? [];
}

$filtros = [
    'nome' => $_GET['nome'] ?? '',
    'nivel' => $_GET['nivel'] ?? '',
    'tipo' => $_GET['tipo'] ?? '',
    'atributo' => $_GET['atributo'] ?? ''
];

$resultado = filtrarDigimonsAPI($filtros);
$digimonsFiltrados = is_array($resultado) ? $resultado : [];
?>

<div class="container my-4">
    <h1 class="text-center mb-4">Filtrar Digimons</h1>
    
    <!-- Formulário de Filtro -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="filtrar.php">
            <div class="row g-3">
                <!-- Campo Nome -->
                <div class="col-md-3">
                    <label for="nome" class="form-label">Nome do Digimon</label>
                    <input type="text" id="nome" name="nome" class="form-control" 
                           value="<?= htmlspecialchars($_GET['nome'] ?? '') ?>" 
                           placeholder="Ex: Agumon">
                </div>
                
                <!-- Campo Nível -->
                <div class="col-md-3">
                    <label for="nivel" class="form-label">Nível</label>
                    <select id="nivel" name="nivel" class="form-select">
                        <option value="">Todos os níveis</option>
                        <option value="Fresh" <?= ($_GET['nivel'] ?? '') === 'Fresh' ? 'selected' : '' ?>>Fresh</option>
                        <option value="In Training" <?= ($_GET['nivel'] ?? '') === 'In Training' ? 'selected' : '' ?>>In Training</option>
                        <option value="Rookie" <?= ($_GET['nivel'] ?? '') === 'Rookie' ? 'selected' : '' ?>>Rookie</option>
                        <option value="Champion" <?= ($_GET['nivel'] ?? '') === 'Champion' ? 'selected' : '' ?>>Champion</option>
                        <option value="Ultimate" <?= ($_GET['nivel'] ?? '') === 'Ultimate' ? 'selected' : '' ?>>Ultimate</option>
                        <option value="Mega" <?= ($_GET['nivel'] ?? '') === 'Mega' ? 'selected' : '' ?>>Mega</option>
                    </select>
                </div>
                
                <!-- Campo Tipo -->
                <div class="col-md-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select id="tipo" name="tipo" class="form-select">
                        <option value="">Todos os tipos</option>
                        <option value="Reptile" <?= ($_GET['tipo'] ?? '') === 'Reptile' ? 'selected' : '' ?>>Reptile</option>
                        <option value="Dragon" <?= ($_GET['tipo'] ?? '') === 'Dragon' ? 'selected' : '' ?>>Dragon</option>
                        <option value="Beast" <?= ($_GET['tipo'] ?? '') === 'Beast' ? 'selected' : '' ?>>Beast</option>
                        <option value="Aquatic" <?= ($_GET['tipo'] ?? '') === 'Aquatic' ? 'selected' : '' ?>>Aquatic</option>
                        <option value="Bird" <?= ($_GET['tipo'] ?? '') === 'Bird' ? 'selected' : '' ?>>Bird</option>
                        <option value="Insect" <?= ($_GET['tipo'] ?? '') === 'Insect' ? 'selected' : '' ?>>Insect</option>
                        <option value="Plant" <?= ($_GET['tipo'] ?? '') === 'Plant' ? 'selected' : '' ?>>Plant</option>
                        <option value="Machine" <?= ($_GET['tipo'] ?? '') === 'Machine' ? 'selected' : '' ?>>Machine</option>
                    </select>
                </div>
                
                <!-- Campo Atributo -->
                <div class="col-md-3">
                    <label for="atributo" class="form-label">Atributo</label>
                    <select id="atributo" name="atributo" class="form-select">
                        <option value="">Todos os atributos</option>
                        <option value="Vaccine" <?= ($_GET['atributo'] ?? '') === 'Vaccine' ? 'selected' : '' ?>>Vaccine</option>
                        <option value="Data" <?= ($_GET['atributo'] ?? '') === 'Data' ? 'selected' : '' ?>>Data</option>
                        <option value="Virus" <?= ($_GET['atributo'] ?? '') === 'Virus' ? 'selected' : '' ?>>Virus</option>
                        <option value="Free" <?= ($_GET['atributo'] ?? '') === 'Free' ? 'selected' : '' ?>>Free</option>
                        <option value="Variable" <?= ($_GET['atributo'] ?? '') === 'Variable' ? 'selected' : '' ?>>Variable</option>
                    </select>
                </div>
                
                <!-- Botões -->
                <div class="col-12">
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-funnel-fill"></i> Aplicar Filtros
                        </button>
                        <a href="filtrar.php" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle-fill"></i> Limpar
                        </a>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    
    <!-- Resultados -->
    <div class="row">
        <?php if (!empty($digimonsFiltrados)): ?>
            <?php foreach ($digimonsFiltrados as $digimon): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100">
                        <!-- Imagem com fallback melhorado -->
                        <?php 
                        $imagem = $digimon['image'] ?? 
                                 $digimon['images'][0]['href'] ?? 
                                 'assets/img/digimon-default.png';
                        ?>
                        <div class="text-center p-2" style="height: 200px; background-color: #f8f9fa;">
                            <img src="<?= htmlspecialchars($imagem) ?>" 
                                 class="img-fluid h-100" 
                                 alt="<?= htmlspecialchars($digimon['name']) ?>"
                                 onerror="this.src='assets/img/digimon-default.png'">
                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($digimon['name']) ?></h5>
                            <div class="d-flex flex-wrap gap-1 mb-2">
                                <!-- Ícone e Tipo -->
                                <?php if (!empty($digimon['types'][0]['type'])): ?>
                                    <span class="badge bg-primary">
                                        <i class="bi bi-tag-fill"></i> 
                                        <?= htmlspecialchars($digimon['types'][0]['type']) ?>
                                    </span>
                                <?php endif; ?>
                                
                                <!-- Ícone e Nível -->
                                <?php if (!empty($digimon['levels'][0]['level'])): ?>
                                    <span class="badge bg-success">
                                        <i class="bi bi-star-fill"></i> 
                                        <?= htmlspecialchars($digimon['levels'][0]['level']) ?>
                                    </span>
                                <?php endif; ?>
                                
                                <!-- Ícone e Atributo -->
                                <?php if (!empty($digimon['attributes'][0]['attribute'])): ?>
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-shield-fill"></i> 
                                        <?= htmlspecialchars($digimon['attributes'][0]['attribute']) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-transparent">
                            <a href="detalhes.php?id=<?= $digimon['id'] ?>" class="btn btn-sm btn-primary w-100">
                                <i class="bi bi-info-circle"></i> Ver Detalhes
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    <?php if (isset($resultado['error'])): ?>
                        Erro: <?= $resultado['error'] ?>
                    <?php else: ?>
                        Nenhum Digimon encontrado com os filtros selecionados!
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/rodape.php'; ?>