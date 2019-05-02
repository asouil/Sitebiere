<?php

	include 'includes/header.php';

?>

<h1 class="titreduhaut">Nos Produits</h1>
<section id="boutiques">
	<?php
	$sql = "SELECT * FROM `beers`" ;
	$pdo=getDB($dbuser, $dbpassword, $dbhost,$dbname);
		$statement = $pdo->prepare($sql);
		$statement->execute([$sql]);
		$beers = $statement->fetchAll();
	 	foreach ($beers as $beer) : ?>
		<article class="bieres">
			<h2><?= $beer['nom']; ?></h2>
			<div><img src="<?= $beer["image"]; ?>" alt="<?= $beer['nom']; ?>" /></div>
			<p><?= $beer["description"]; ?></p>
			<p class="price"><?= number_format($beer["prix"], 2, ',','.'); ?> € HT</p>
			<p class="price"><?= number_format($beer["prix"]*1.2, 2, ',','.'); ?> € TTC</p>
		</article>
	<?php endforeach; ?>
</section>

<?php
	include 'includes/footer.php'; 