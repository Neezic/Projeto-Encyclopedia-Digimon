<?php 
    include 'includes/funcoes.php';
    include 'includes/cabecalho.php';
?>

<h1>Enciclópedia Digimon</h1>
<div class="digimon-list">
<?php foreach($digimons as $digimon):?>
    <div class="digimon-card">
    <img src="assets/img/<?= $digimon['imagem']?>" alt="<?= $digimon['nome']?>">
    <h3><?= $digimon['nome'] ?></h3>
    <p><strong>Categoria:</strong><?= $digimon['nivel']?> </p>
    <a href="detalhes.php?id=<?=$digimon['id'] ?>" class="btn">Ver Mais </a>
    </div>
<?php endforeach; ?>
</div>

<?php include 'includes/rodape.php';?>