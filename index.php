<?php
    include 'includes/funcoes.php' ;
    include 'includes/cabecalho.php' ;
    $digimons = getDigimons();
?>


    <h1 class="texte-center my-4">Enciclópedia Digimon</h1>
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