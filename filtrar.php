<?php 
include 'includes/cabecalho.php';
include 'includes/funcoes.php';

$level = $_GET['level'] ?? 'Rookie';
$digimons = filtrarDigimonPorLevel($level);


?>

<form method="GET" class="my-4">
    <select name="level" class="form-select">
        <option value="Rookie" <?= $level == 'Rookie' ? 'selected' : '' ?>>Rookie</option>
        <option value="Champion" <?= $level == 'Champion' ? 'selected' : '' ?>>Champion</option>
        <option value="Ultimate" <?= $level == 'Ultimate' ? 'selected' : '' ?>>Ultimate</option>
        <option value="Mega" <?= $level == 'Mega' ? 'selected' : '' ?>>Mega</option>
    </select>
    <button type="submit" class="btn btn-primary mt-2">Filtrar</button>

</form>

<div class="row">
    <?php foreach ($digimons as $digimon): ?>
        <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="assets/img/<?= $digimon['image'] ?>" class="card-img-top" alt="<?= $digimon['name'] ?>">
                    <div class="card-body">
                        <h3><?= $digimon['name'] ?></h3>
                        <p><strong>Nivel:</strong><?= $digimon['level'] ?? 'N/A' ?> </p>
                        <a href="detalhes.php?id=<?= $digimon['id'] ?>" class="btn btn-primary">Ver Mais </a>
                        </div>
                    </div>
                </div>
        </div>
    <?php endforeach; ?>
</div>
<?php include 'includes/rodape.php'; ?>