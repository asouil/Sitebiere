<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Mon compte</title>
</head>
<body>
<!-- TODO : contenu du profil -->
<?php
	require "connect.php";
	require_once "db.php";
	$sql = "SELECT * FROM `utilisateurs`" ;
		$statement = $pdo->prepare($sql);
		$statement->execute([$sql]);
		$users = $statement->fetchAll();

		foreach($users as $user):
				//boucle sur le tableau users
			if($user["mail"]==$mail){
				 echo 'Bienvenue '.$user["prenom"];
?>
				<section>
				<!-- boucle sur le tableau users -->
					<article>
						<p> Ici vous pourrez modifier vos informations.<p><br>
						<form method="POST" action="mon_compte.php">
							<label>Votre téléphone</label><br>
							<input type="text" name="telephone" value="<?= $user["telephone"] ?>"><br>
							<label>Votre nom</label><br>
							<input type="text" name="nom" value="<?= $user["nom"] ?>"><br>
							<label>Votre prénom</label><br>
							<input type="text" name="prenom" value="<?= $user["prenom"] ?>"><br>
							<label>Votre adresse</label><br>
							<input type="text" name="adresse" value="<?= $user["adresse"] ?>"><br>
							<label>Votre code postal</label><br>
							<input type="text" name="cp" value="<?= $user["code_postal"] ?>"><br>
							<label>Votre ville</label><br>
							<input type="text" name="ville" value="<?= $user["ville"] ?>"><br>
							<label>Votre pays</label><br>
							<input type="text" name="pays" value="<?= $user["pays"] ?>"><br>
							<input type="text" name="password" placeholder="modification mdp"><br>
							<input type="hidden" name="id" value="<?= $user["id"]?>">
							<button type="submit">Modifier</button>
						</form>
					</article> 
				<?php
				} //fin du if
		endforeach; ?>
		<!-- fin boucle -->
			</section>

				<div>
					<br/>
						
				</div>
			<?php

				if(!empty($_POST)){
					$mail = strtolower($_POST["mail"]);
					$password = $_POST["password"];
					$id = $_POST["id"];

					if(!empty($id)){
						if(!empty($username)){
							require_once 'db.php';
							$sql = "SELECT * FROM utilisateurs WHERE `nom`= ?";
							$statement = $pdo->prepare($sql);
							$statement->execute([$mail]);
							$user = $statement->fetch();
						
							if(!$user){
								if(!empty($password)){
									if(strlen($password) <= 10 && strlen($password) >= 5){
										$password = password_hash($password, PASSWORD_BCRYPT);
										require_once 'db.php';
										$sql = "UPDATE`utilisateurs` (`nom`, `prenom`, `password`, `adresse`, `code_postal`, `ville`, `pays`, `telephone`) VALUES (:nom , :prenom,  :password, :adresse, :code_postal, :ville, :pays, :telephone)";
										$statement = $pdo->prepare($sql);
										$result = $statement->execute([
											":nom"		=>	$name,
											":prenom"	=>	$prenom,
											":password"	=>  $password,
											":adresse" 	=>	$adresse,
											":code_postal"=>$cp, 
											":ville" 	=>	$ville,
											":pays"		=>	$pays,
											":telephone"=>	$telephone,
										]);
									}else{
										die("Problème de format du mot de passe qui doit faire entre 5 et 10 caractères");
										// TODO cree erreur
									}
								}
							}else{
								if(!empty($password)){
									if(strlen($password) <= 10 && strlen($password) >= 5){
										$password = password_hash($password, PASSWORD_BCRYPT);
										require_once 'db.php';
										$sql = "UPDATE `utilisateurs` SET `nom` = :nom, `password` = :password WHERE `utilisateurs`.`id` = :id";
										$statement = $pdo->prepare($sql);
										$result = $statement->execute([
											":nom"		=>	$username,
											":password"	=>  $password,
											":id"		=>	$id
										]);
									}
								}else{
									die("username existe déjà");
									// TODO cree erreur
								}
							}
						}
					}
				}
			
 			
			?>

	<nav>
		<a href="index.php"> Accueil</a><br>
		<a href="purchase_order.php"> Commander</a><br>
		<!--si pas connecté sinon cacher-->
		<a href="connexion.php"> Connexion</a><br>
		<a href="inscription.php"> Vous inscrire</a><br>
		<!--si connecté sinon cacher-->
		<a href="mon_compte.php"> Mon compte</a><br>
		<a href="deconnexion.php"> Déconnexion</a><br>
	</nav>
</body>
</html>