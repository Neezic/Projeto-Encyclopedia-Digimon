<?php 
include 'includes/funcoes.php';
$id = $_GET['id'] ?? null;
$digimon = buscarDigimonPorId($id,$digimons);

if (!$digimon){
    header("Location:index.php");
    exit;
}
include 'includes/cabecalho.php';
?>

<h1><?= $digimon['nome'] ?></h1>
<img src="assets/img/<?=$digimon['imagem'] ?>">
<p><strong>Nivel:</strong> <?=$digimon['nivel']?></p>
<p><strong>Tipo:</strong> <?=$digimon['tipo']?></p>
<p><strong>Descrição</strong> <?=$digimon['descricao']?></p>

<?php include 'includes/rodape.php';?>