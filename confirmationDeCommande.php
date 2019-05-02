<?php
	require_once('includes/function.php');
	$user = userOnly();
	//$_SESSION["auth"] < id/nom/prenom/adresse/code_postal/ville/pays/telephone/mail

	if(!isset($_GET['id'])) {
		header('location:'.uri("profil.php"));
		exit();
	}

	$id = (int)$_GET['id']; //On "CAST"(convertit) $_GET['id'] en Integer

	$pdo = getDB($dbuser, $dbpassword, $dbhost,$dbname);
	$sql = "SELECT * FROM commandes WHERE id = ?";
	$statement = $pdo->prepare($sql);
	$statement->execute([$id]);
	$order = $statement->fetch();

	if(!$order || $order['id_client'] !== $user["id"]) { //On vérifie l'id de l'utilisateur
		header('location: '.uri("profil.php"));				//Et l'existence de la commande
		exit();
	}

	$sql = "SELECT * FROM beers";
	$statement = $pdo->prepare($sql);
	$statement->execute();
	$results = $statement->fetchAll();

	foreach($results as $result) {
		$beers[$result["id"]] = $result;
	}
	//var_dump($beers);die;

	$lines = unserialize($order['id_biere']); //Rétablis le tableau à sa forme originale
	
	$priceTTC = 0;
	foreach( $lines as $line) {
		$priceTTC += ((float)$line["prix"] * (int)$line["qty"]) * $tva;
	}
	$priceTTC=number_format($priceTTC, 2,'.','.');
	$order["pTTC"]=number_format($order["pTTC"], 2,'.','.');
	if($priceTTC != $order["pTTC"]) { //On CAST $priceTTC en String pour 														comparaison avec $order["priceTTC"]
		header('location:'.uri('profil.php'));
		exit();
	}
	include 'includes/header.php';
?>
<h1 class="titreduhaut">Confirmation de commande</h1>
<section id="commandSection">
	<table>
		<thead>
			<tr>
				<th>Nomination</th>
				<th>Prix HT</th>
				<th>Prix TTC</th>
				<th>Quantité</th>
				<th>Total TTC</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($lines as $key => $line ) : ?>
				<tr>
					<td><?= $beers[$key]["nom"] ?></td>
					<td><?= number_format($line["prix"], 2, ',', '.'); ?>€</td>
					<td><?= number_format($line["prix"]*$tva, 2, ',', '.');  ?>€</td>
					<td><?= $line["qty"] ?></td>
					<td><?= number_format($line["prix"]*$line["qty"]*$tva, 2, ',', '.'); ?>€</td>
				</tr>
			<?php endforeach; ?>
			<tr>
				<td><strong>Total TTC</strong></td>
				<td></td>
				<td></td>
				<td></td>
				<td><strong><?= number_format($order["pTTC"], 2, ',', '.'); ?>€</strong></td>
			</tr>
		</tbody>
	</table>
	<p style="text-align: center;">Celle-ci vous sera livrée au <?= $user["adresse"] ?> <?= $user["code_postal"] ?> <?= $user['ville'] ?> sous deux jours</p>
		<p style="text-align:center;">
			<small>Si vous ne réglez pas sous 10 jours, le prix de votre commande sera majoré.(25%/jour de retard)</small>
		</p>
</section>
<?php
	include 'includes/footer.php';


