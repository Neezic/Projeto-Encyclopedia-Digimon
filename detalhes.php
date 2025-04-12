<?php
require_once 'includes/cabecalho.php';
require_once 'includes/API.php';

// Verifica se o ID foi passado e é numérico
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header("Location: index.php");
    exit;
}

// Busca os dados do Digimon
$digimon = getDigimonsPorId($id);

// Se o Digimon não existir ou a API falhar, redireciona
if (empty($digimon) || isset($digimon['error'])) {
    header("Location: index.php");
    exit;
}
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <!-- Imagem principal -->
            <?php if (!empty($digimon['images'][0]['href'])): ?>
                <img src="<?= htmlspecialchars($digimon['images'][0]['href']) ?>" 
                     class="img-fluid" 
                     alt="<?= htmlspecialchars($digimon['name']) ?>">
            <?php else: ?>
                <div class="alert alert-warning">Imagem não disponível</div>
            <?php endif; ?>
            
            <!-- Campos adicionais -->
            <div class="mt-3">
                <h4>Informações Básicas</h4>
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>ID:</strong> <?= htmlspecialchars($digimon['id']) ?>
                    </li>
                    <li class="list-group-item">
                        <strong>Ano de Lançamento:</strong> <?= htmlspecialchars($digimon['releaseDate'] ?? 'N/A') ?>
                    </li>
                    <li class="list-group-item">
                        <strong>X-Antibody:</strong> <?= $digimon['xAntibody'] ? 'Sim' : 'Não' ?>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="col-md-6">
            <h1><?= htmlspecialchars($digimon['name']) ?></h1>
            
            <!-- Nível -->
            <p class="h5">
                <strong>Nível:</strong> 
                <?= htmlspecialchars($digimon['levels'][0]['level'] ?? 'N/A') ?>
            </p>
            
            <!-- Tipo -->
            <p class="h5">
                <strong>Tipo:</strong> 
                <?= htmlspecialchars($digimon['types'][0]['type'] ?? 'N/A') ?>
            </p>
            
            <!-- Atributo -->
            <p class="h5">
                <strong>Atributo:</strong> 
                <?= htmlspecialchars($digimon['attributes'][0]['attribute'] ?? 'N/A') ?>
            </p>
            
            <!-- Descrição em Inglês -->
            <?php if (!empty($digimon['descriptions'])): ?>
                <div class="mt-4">
                    <h4>Descrição</h4>
                    <?php 
                    $descEn = array_filter($digimon['descriptions'], function($desc) {
                        return ($desc['language'] ?? '') === 'en_us';
                    });
                    ?>
                    <p><?= htmlspecialchars(current($descEn)['description'] ?? 'Descrição não disponível') ?></p>
                </div>
            <?php endif; ?>
            
            <!-- Habilidades -->
            <?php if (!empty($digimon['skills'])): ?>
                <div class="mt-4">
                    <h4>Habilidades</h4>
                    <ul class="list-group">
                        <?php foreach ($digimon['skills'] as $skill): ?>
                            <li class="list-group-item">
                                <strong><?= htmlspecialchars($skill['skill']) ?>:</strong>
                                <?= htmlspecialchars($skill['description']) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Seção de Evoluções -->
    <div class="row mt-5">
        <div class="col-md-6">
            <?php if (!empty($digimon['priorEvolutions'])): ?>
                <h4>Evoluções Anteriores</h4>
                <div class="row">
                    <?php foreach ($digimon['priorEvolutions'] as $evo): ?>
                        <div class="col-4 mb-3">
                            <a href="detalhes.php?id=<?= $evo['id'] ?>">
                                <img src="<?= htmlspecialchars($evo['image']) ?>" 
                                     class="img-thumbnail" 
                                     alt="<?= htmlspecialchars($evo['digimon']) ?>">
                                <p class="text-center mt-1"><?= htmlspecialchars($evo['digimon']) ?></p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="col-md-6">
            <?php if (!empty($digimon['nextEvolutions'])): ?>
                <h4>Próximas Evoluções</h4>
                <div class="row">
                    <?php foreach ($digimon['nextEvolutions'] as $evo): ?>
                        <div class="col-4 mb-3">
                            <a href="detalhes.php?id=<?= $evo['id'] ?>">
                                <img src="<?= htmlspecialchars($evo['image']) ?>" 
                                     class="img-thumbnail" 
                                     alt="<?= htmlspecialchars($evo['digimon']) ?>">
                                <p class="text-center mt-1">
                                    <?= htmlspecialchars($evo['digimon']) ?>
                                    <?php if (!empty($evo['condition'])): ?>
                                        <small class="d-block text-muted"><?= htmlspecialchars($evo['condition']) ?></small>
                                    <?php endif; ?>
                                </p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Campos (Fields) -->
    <?php if (!empty($digimon['fields'])): ?>
        <div class="mt-5">
            <h4>Campos Relacionados</h4>
            <div class="row">
                <?php foreach ($digimon['fields'] as $field): ?>
                    <div class="col-2 text-center mb-3">
                        <img src="<?= htmlspecialchars($field['image']) ?>" 
                             class="img-fluid" 
                             alt="<?= htmlspecialchars($field['field']) ?>">
                        <p class="mt-1"><?= htmlspecialchars($field['field']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/rodape.php'; ?>