<?php
require_once 'includes/cabecalho.php';
require_once 'includes/API.php';

// Configuração de paginação
$pagina = $_GET['pagina'] ?? 1;
$itensPorPagina = 20; // Aumente para mostrar mais itens

// Função atualizada para buscar mais resultados
function getDigimonsPaginados($pagina = 1, $itensPorPagina = 20) {
    $url = "https://digi-api.com/api/v1/digimon?pageSize=$itensPorPagina&page=$pagina";
    $response = @file_get_contents($url);
    
    if ($response === FALSE) {
        return ['content' => [], 'error' => 'Erro ao acessar a API'];
    }
    
    $data = json_decode($response, true);
    
    return [
        'content' => $data['content'] ?? [],
        'pageInfo' => [
            'currentPage' => $pagina,
            'totalItems' => count($data['content'] ?? [])
        ]
    ];
}

$digimons = getDigimonsPaginados($pagina, $itensPorPagina);
?>

<div class="container my-4">
    <h1 class="text-center mb-4">DigiDex</h1>
    
    <div class="row">
        <?php foreach ($digimons['content'] as $digimon): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <!-- Imagem corrigida -->
                    <?php if (!empty($digimon['image'])): ?>
                        <img src="<?= htmlspecialchars($digimon['image']) ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($digimon['name']) ?>"
                             style="height: 200px; object-fit: contain;">
                    <?php elseif (!empty($digimon['images'][0]['href'])): ?>
                        <img src="<?= htmlspecialchars($digimon['images'][0]['href']) ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($digimon['name']) ?>"
                             style="height: 200px; object-fit: contain;">
                    <?php else: ?>
                        <div class="text-center py-4 bg-light">
                            <i class="bi bi-image" style="font-size: 3rem;"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($digimon['name']) ?></h5>
                        <p class="card-text">
                            <small class="text-muted">
                                Nível: <?= htmlspecialchars($digimon['level'] ?? $digimon['levels'][0]['level'] ?? 'N/A') ?>
                            </small>
                        </p>
                    </div>
                    
                    <div class="card-footer bg-transparent">
                        <a href="detalhes.php?id=<?= $digimon['id'] ?>" class="btn btn-sm btn-primary w-100">
                            Ver Detalhes
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Paginação simples -->
    <div class="d-flex justify-content-center mt-4">
        <a href="?pagina=<?= max(1, $pagina - 1) ?>" class="btn btn-outline-primary me-2">Anterior</a>
        <span class="mx-2 align-self-center">Página <?= $pagina ?></span>
        <a href="?pagina=<?= $pagina + 1 ?>" class="btn btn-outline-primary">Próxima</a>
    </div>
</div>

<?php require_once 'includes/rodape.php'; ?>