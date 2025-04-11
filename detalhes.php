<?php
include 'includes/cabecalho.php';
include 'includes/funcoes.php';
$id = $_GET['id'] ?? null;
if (!$id) header("Location: index.php");
$digimons = getDigimonsPorId($id);
?>
<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <img src="<?= $digimon['image'] ?>" class="img-fluid" alt="<?= $digimon['name'] ?>">
        </div>
        <div class="col-md-6">
            <h1><?= $digimon['name']?></h1>
            <p><strong>Nível:</strong> <?= $digimon['level'] ?? 'N/A'?></p>
            <p><strong>Tipo:</strong> <?= $digimon['type'] ?? 'N/A'?></p>
            <p><strong>Atributo:</strong> <?= $digimon['attriute'] ?? 'N/A'?></p>
            <h4>Evoluções:</h4>
            <ul>
                <?php foreach ($digimon['evolutions'] as $evo):?>
                    <li><?= $evo['digimon']?> (<?= $evo['condition']?>)</li>
                <?php endforeach;?>
            </ul>
        </div>

    </div>

</div>

<?php include 'includes/rodape.php'; ?>