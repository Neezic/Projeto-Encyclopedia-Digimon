<?php
require_once 'includes/cabecalho.php';
require_once 'includes/API.php';

$termoPesquisa = trim($_GET['pesquisa'] ?? ''); // Adicionado trim() para remover espaços extras
$pagina = $_GET['pagina'] ?? 1;
$itensPorPagina = 20;
$resultadoAPI = buscarDigimonsAPI($termoPesquisa, $pagina, $itensPorPagina);
$digimonsAPI = $resultadoAPI['content'];
$erro = $resultado['error'] ?? null;

// Função corrigida para buscar Digimons
function buscarDigimonsAPI($termo = '', $pagina = 1, $itensPorPagina = 20)
{
    $url = "https://digi-api.com/api/v1/digimon?pageSize=$itensPorPagina&page=$pagina";

    if (!empty($termo)) {
        // Modificação importante: usando filtro por nome exato
        $url = "https://digi-api.com/api/v1/digimon?name=" . urlencode($termo);
    }

    $response = @file_get_contents($url);

    if ($response === FALSE) {
        return ['content' => [], 'error' => 'Erro ao acessar a API'];
    }

    $data = json_decode($response, true);

    // Tratamento especial para pesquisa por nome
    if (!empty($termo) && isset($data['id'])) {
        // Se a API retornar um único Digimon (pesquisa por nome exato)
        return ['content' => [$data], 'error' => null];
    }

    return ['content' => $data['content'] ?? [], 'error' => null];
}

$digimons = $digimonsAPI;
if (empty($termoPesquisa)) {
    $digimonsAdicionados = $_SESSION['digimons_adicionados'] ?? [];
    $digimons = array_merge($digimonsAdicionados, $digimonsAPI);
}

?>

<div class="container my-4">
    <h1 class="text-center mb-4">DigiDex</h1>

    <!-- Barra de Pesquisa -->
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <form method="GET" action="index.php" class="input-group">
                <input type="text" name="pesquisa" class="form-control"
                    value="<?= htmlspecialchars($termoPesquisa) ?>"
                    placeholder="Pesquisar Digimon...">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i> Buscar
                </button>
                <?php if (!empty($termoPesquisa)): ?>
                    <a href="index.php" class="btn btn-outline-secondary">
                        Limpar
                    </a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Lista de Digimons -->
    <div class="row">
        <?php if (!empty($digimons)): ?>
            <?php foreach ($digimons as $digimon): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100">
                        <!-- Imagem Corrigida -->
                        <?php
                        // Verifica vários formatos possíveis de imagem
                        $imagem = '';

                        // Formato 1: Campo direto 'image'
                        if (!empty($digimon['image'])) {
                            $imagem = $digimon['image'];
                        }
                        // Formato 2: Array 'images'
                        elseif (!empty($digimon['images'][0]['href'])) {
                            $imagem = $digimon['images'][0]['href'];
                        }
                        ?>

                        <?php if (!empty($imagem)): ?>
                            <img src="<?= htmlspecialchars($imagem) ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars($digimon['name']) ?>"
                                style="height: 200px; object-fit: contain;"
                                onerror="this.onerror=null;this.src='assets/img/digimon-default.png'">
                        <?php else: ?>
                            <div class="text-center py-4 bg-light">
                                <i class="bi bi-image" style="font-size: 3rem;"></i>
                            </div>
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($digimon['name']) ?></h5>
                            <p class="card-text">
                                <small class="text-muted">
                                    <?php if (isset($digimon['added_manually'])): ?>
                                        <span class="badge bg-success ms-2">Adicionado</span>
                                    <?php endif; ?>
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
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    <?php if (!empty($termoPesquisa)): ?>
                        Nenhum Digimon encontrado para "<?= htmlspecialchars($termoPesquisa) ?>"
                    <?php else: ?>
                        Nenhum Digimon encontrado. A API pode estar indisponível.
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Paginação -->
    <?php if (!empty($digimons)): ?>
        <div class="d-flex justify-content-center mt-4">
            <a href="?pesquisa=<?= urlencode($termoPesquisa) ?>&pagina=<?= max(1, $pagina - 1) ?>"
                class="btn btn-outline-primary me-2 <?= $pagina <= 1 ? 'disabled' : '' ?>">
                Anterior
            </a>
            <span class="mx-2 align-self-center">Página <?= $pagina ?></span>
            <a href="?pesquisa=<?= urlencode($termoPesquisa) ?>&pagina=<?= $pagina + 1 ?>"
                class="btn btn-outline-primary <?= count($digimons) < $itensPorPagina ? 'disabled' : '' ?>">
                Próxima
            </a>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/rodape.php'; ?>