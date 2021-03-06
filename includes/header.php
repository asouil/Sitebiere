<?php
require_once 'function.php';
	$connect= userOnly(true);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title>Bread Beer Shop</title>
	<!-- <link rel="stylesheet" type="text/css" href="./assets/css/styles.css"> -->
	<link rel="stylesheet" type="text/css" href="<?= uri("/assets/css/styles.css") ?>">
</head>
<body>
	<header class="menu">
		<input type="checkbox" class="burger">
		<nav>
			<ul>
				<li><a href="<?= uri() ?>">Home</a></li>
				<li><a href="<?= uri("?p=boutique.php") ?>">Boutique</a></li>
				 <?php if($connect): ?>
					<li><a href="<?= uri("?p=purchase_order.php") ?>">Bon de commande</a></li>
					<li><a href="<?= uri("?p=profil.php") ?>">profil</a></li>
					<li><a href="<?= uri("includes\deconnect.php") ?>">deconnexion</a></li>
				<?php else: ?>
					<li><a href="<?= uri("?p=login.php") ?>">Connexion</a></li>
					<li><a href="<?= uri("?p=userAction.php") ?>">Inscription</a></li>
				<?php endif; ?>
					<li><a href="<?= uri("contact.php") ?>">Contact</a></li>
			</ul>
		</nav>
	</header>