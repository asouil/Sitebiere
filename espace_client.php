<?php
require 'db.php';
require 'connect.php';

?><!--
-Créer un espace client html5
-Celui ci présentera:
	-Un tableau affichant le contenu des commandes passé par l’utilisateur.
-->
<!DOCTYPE html>
<html>
<head>	
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./assets/css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Espace Client</title>
</head>
<body>
	<a id="to_nav" href="#menu"> Vers le menu </a><br>
	<h2> Votre historique de commande </h2>
	<div>
		<?php
			require_once "db.php";
			$quantite =0;
			$prix = 0;
			$contenu =[];
				//parcourt de la base des commandes
			$sql = "SELECT * FROM `commandes`" ;
			$statement = $pdo->prepare($sql);
			$statement->execute([$sql]);
			$commandes = $statement->fetchAll();
				//pour chaque commande
					
			foreach($commandes as $commande){
				$prix = $commande["pTTC"];
				$contenu = unserialize($commande["id_biere"]);
				$sql2 = "SELECT * FROM `utilisateurs`" ;
				$state = $pdo->prepare($sql2);
				$state->execute([$sql2]);
				$users = $state->fetchAll();

				foreach($users as $user){
					// si l'utilisateur est l'utilisateur connecté
					if($user["id"]==$commande['id_client']){
						$nomCo=$user['nom'];
						$prenomCo=$user['prenom'];
							
						/*$sqlb = "SELECT * FROM `beers`" ;
						$stat = $pdo->prepare($sqlb);
						$stat->execute([$sqlb]);
						$bieres = $stat->fetchAll();	
						foreach($bieres as $biere){
							for($i=0; $i<count($idbiere); $i++){
								if($biere['id']==$idbiere[$i]){
									array_push($contenu, $biere['nom']);
								}
							}
						}*/

						echo("<table><thead>Votre Commande ");
						echo("n°:".$commande["id"]).' </thead><tr>';
						for($i=0;$i<count($contenu);$i++){
							echo('<tr><td>référence de bière '.$contenu[$i].' </td></tr>');
							$sqlquery="SELECT FROM `beers` WHERE `id`= :id";
							$sta = $pdo->prepare($sqlquery);
							$sta->execute([":id" =>	$contenu[$i]]);
							$bee = $sta -> fetchAll();
							
							//	écrire bière concernée

						}	
					}

				}
				$quantite= count($contenu);
				echo "<tr><td>Vous avez dépensé un montant de ".number_format($prix,2,',','.').'€ pour '.$quantite.' type(s) de bières.</td></tr></table>';

			}

		?>
	</div>
	<nav id="menu">
		<a href="index.php"> Accueil</a><br>
		<a href="purchase_order.php"> Commander</a><br>
		<?php 
		if(empty($_SESSION["connect"])) { ?>
			<!--si pas connecté sinon cacher -->
			<a href="connexion.php"> Connexion</a><br>
			<a href="inscription.php"> Vous inscrire</a><br>
		<?php } else if($_SESSION["connect"]) { ?>
			<!--si connecté sinon cacher-->
			<a href="mon_compte.php"> Mon compte</a><br>
			<a href="deconnexion.php"> Déconnexion</a><br>
		<?php  } ?>
	</nav>

</body>
</html>