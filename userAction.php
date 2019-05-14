<?php
require_once 'includes/function.php';


if(!empty($_POST)){
	if(	isset($_POST["lastname"]) && !empty($_POST["lastname"]) &&
		isset($_POST["firstname"]) && !empty($_POST["firstname"]) &&
		isset($_POST["address"]) && !empty($_POST["address"]) &&
		isset($_POST["zipCode"]) && !empty($_POST["zipCode"]) &&
		isset($_POST["city"]) && !empty($_POST["city"]) &&
		isset($_POST["country"]) && !empty($_POST["country"]) &&
		isset($_POST["phone"]) && !empty($_POST["phone"]) &&
		isset($_POST["mail"]) && !empty($_POST["mail"]) &&
		isset($_POST["mailVerify"]) && !empty($_POST["mailVerify"]) &&
		isset($_POST["password"]) && !empty($_POST["password"]) &&
		isset($_POST["passwordVerify"]) && !empty($_POST["passwordVerify"])&&
		isset($_POST["robot"]) && empty($_POST["robot"])//protection robot
	){
		
		if(
			( filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL) && 
				$_POST["mail"] == $_POST["mailVerify"]
			) &&
			( $_POST["password"] == $_POST["passwordVerify"])
		){

			$sql = "SELECT * FROM utilisateurs WHERE `mail`= ?";
			$pdo = getDB($dbuser, $dbpassword, $dbhost,$dbname);
			$statement = $pdo->prepare($sql);
			$statement->execute(
				[	htmlspecialchars($_POST["mail"])	]
			);
			$user = $statement->fetch();

			if(!$user){
				// Génération aléatoire d'une clé
				$cle = md5(microtime(TRUE)*100000);
				$password = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_BCRYPT);
				$sql = "INSERT INTO `utilisateurs` (`nom`, `prenom`, `adresse`, `code_postal`, `ville`, `pays`, `telephone`, `mail`, `password`, `cle`) VALUES (
				 :nom,				 
				 :prenom,
				 :adresse,
				 :code_postal, 
				 :ville,
				 :pays,
				 :telephone,
				 :mail,
				 :password,
				 :cle)
				 ";
				$statement = $pdo->prepare($sql);
				$result = $statement->execute([
					":nom"			=> htmlspecialchars($_POST["lastname"]),
					":prenom"		=> htmlspecialchars($_POST["firstname"]),
					":adresse"		=> htmlspecialchars($_POST["address"]),
					":code_postal"	=> htmlspecialchars($_POST["zipCode"]),
					":ville"		=> htmlspecialchars($_POST["city"]),
					":pays"			=> htmlspecialchars($_POST["country"]),
					":telephone"	=> htmlspecialchars($_POST["phone"]),
					":mail"			=> htmlspecialchars($_POST["mail"]),
					":password"		=> $password,
					":cle"			=> $cle
				]);
				// on ajoute l'envoi d'un lien de vérification
				if($result){
					require 'vendor/autoload.php';
					// Récupération des variables nécessaires au mail de confirmation	
					$mail = $_POST['mail'];
					 
					// Préparation du mail contenant le lien d'activation
					$destinataire = $mail;
					$sujet = "Activer votre compte" ;
					 
					// Le lien d'activation est composé du login(log) et de la clé(cle)
					$message = 'Bienvenue sur SITEBIERE,
					 
					Pour activer votre compte, veuillez cliquer sur le lien ci dessous
					ou copier/coller dans votre navigateur internet.
					 
					http://localhost/site_biere_php/validation.php?log='.urlencode($mail)."&cle=".urlencode($cle).'
					
					 
					---------------
					Ceci est un mail automatique, Merci de ne pas y répondre.';
					 
					 
					sendmail($destinataire, $sujet, $message) ;
				}else{
					echo("une erreur s'est produite");
					//TODO : signaler erreur
				}
			}else{//fin verif user existe
				userConnect($_POST["mail"], $_POST["password"]);
			}
		}//fin verification mail et password

	}else{//fin champ tous définis
		die('champs vides');//securisation
	}

}// fin if post

//debut html
require 'includes/header.php';

echo 	'<h1>Inscription</h1>'.
		'<form method="POST" name="inscription" action="">'.
 		input("lastname", "Votre nom","").
 		input("firstname", "Votre prénom","").
 		input("address", "Votre adresse","").
 		input("zipCode", "Votre code postal","").
 		input("city", "Votre ville","").
 		input("country", "Votre pays","").
 		input("phone", "Votre numéro de portable","", "tel").
  		input("mail", "Votre courriel","", "email").
  		input("mailVerify", "Vérification de votre courriel","", "email").
  		input("password", "Votre mot de passe","", "password").
  		input("passwordVerify", "Confirmez votre mot de passe","", "password").
  		input("robot", "","", "hidden").
  		"<button type=\"submit\">Envoyez</button>".
  		'</form>';


require 'includes/footer.php';
