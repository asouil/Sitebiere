<?php
require_once 'includes/function.php';


// foreach ($_POST as $key => $value) {
// 	$$key = $value;
//  c'est égale a :
//  $lastname = $value;
// }

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
			( 	filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL) && 
				$_POST["mail"] == $_POST["mailVerify"]
			) &&
			( $_POST["password"] == $_POST["passwordVerify"])
		){

			$sql = "SELECT * FROM utilisaeurs WHERE `mail`= ?";
			$pdo = getDB($dbuser, $dbpassword, $dbhost,$dbname);
			$statement = $pdo->prepare($sql);
			$statement->execute(
				[
					htmlspecialchars($_POST["mail"])
				]
			);
			$user = $statement->fetch();
		
			if(!$user){
				$password = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_BCRYPT);
				$sql = "INSERT INTO `utilisateurs` (`nom`, `prenom`, `adresse`, `code_postal`, `ville`, `pays`, `telephone`, `mail`, `password`) VALUES (
				 :nom,				 
				 :prenom,
				 :adresse,
				 :code_postal, 
				 :ville,
				 :pays,
				 :telephone,
				 :mail,
				 :password)
				 ";
				$statement = $pdo->prepare($sql);
				$result = $statement->execute([
					":nom"		=> htmlspecialchars($_POST["lastname"]),
					":prenom"	=> htmlspecialchars($_POST["firstname"]),
					":adresse"		=> htmlspecialchars($_POST["address"]),
					":code_postal"		=> htmlspecialchars($_POST["zipCode"]),
					":ville"			=> htmlspecialchars($_POST["city"]),
					":pays"		=> htmlspecialchars($_POST["country"]),
					":telephone"		=> htmlspecialchars($_POST["phone"]),
					":mail"			=> htmlspecialchars($_POST["mail"]),
					":password"		=> $password
				]);
				if($result){
					userConnect($_POST["mail"], $_POST["password"]);
				}else{
					die("pas ok");
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
