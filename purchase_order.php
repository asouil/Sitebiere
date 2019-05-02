<?php 
require_once('includes/function.php');
$user = userOnly();

$sql = "SELECT * FROM `beers`";
$pdo = getDB($dbuser, $dbpassword, $dbhost,$dbname);
$statement = $pdo->prepare($sql);
$statement->execute(); 

$beerArray = $statement->fetchAll();


include 'includes/header.php'; 
?>

	<form method="POST" action="<?= uri("calculPrice.php") ?>" id="formPurchase">
		<div class="form_row">
			<div class="form">
				<label>NOM</label>
				<input type="text" name="lastname" value="<?= $user["nom"] ?>" required/>
			</div>
			<div class="form">
				<label>PRENOM</label>
				<input type="text" name="firstname" value="<?= $user["prenom"] ?>" required/>
			</div>
		</div>
		<div class="form">
			<label>ADRESSE</label>
			<input type="text" name="address" value="<?= $user["adresse"] ?>" required/>
		</div>
		<div class="form_row">
			<div class="form">
				<label>Code Postal</label>
				<input type="text" name="zipCode" value="<?= $user["code_postal"] ?>" required/>
			</div>
			<div class="form">
				<label>VILLE</label>
				<input type="text" name="city" value="<?= $user["ville"] ?>" required/>
			</div>
		</div>
		<div class="form">
			<label>PAYS</label>
			<input type="text" name="country" value="<?= $user["pays"] ?>" required/>
		</div>
		<div class="form_row">
			<div class="form">
				<label>TEL</label>
				<input type="tel" name="phone" value="<?= $user["telephone"] ?>" required/>
			</div>
			<div class="form">
				<label>MAIL</label>
				<input type="text" name="mail" value="<?= $user["mail"] ?>" disabled/>
			</div>
		</div>
		<table>
			<thead>
				<tr>
					<th>Nomination</th>
					<th>Prix HT</th>
					<th>Prix TTC</th>
					<th>Quantité</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($beerArray as $key => $value) : ?>
					<tr>
						<td><?= $value["nom"] ?></td>
						<td id="PHT_<?= $key ?>"><?= number_format($value["prix"], 2, ',', '.') ?>€</td>
						<td id="PTTC_<?= $key ?>"><?= number_format($value["prix"]*$tva, 2, ',', '.') ?>€</td>
						<td><input type="number" min="0" name="qty[<?= $value["id"] ?>]" value="0" oninput="calcPrice(this, <?= $key ?>, <?= $value["prix"] ?>);" /></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<button type="submit">COMMANDER</button>
	</form>

<?php include 'includes/footer.php'; ?>
