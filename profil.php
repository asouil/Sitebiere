<?php
require_once 'includes/function.php';

$user = userOnly();


if(!empty($_POST)){
	//verif pour modif mdp
	if(	isset($_POST["passwordOld"]) && !empty($_POST["passwordOld"]) &&
		isset($_POST["password"]) && !empty($_POST["password"]) &&
		isset($_POST["passwordVerify"]) && !empty($_POST["passwordVerify"]) &&
		isset($_POST["robot"]) && empty($_POST["robot"])//protection robot
	){
		if(userConnect($user["mail"], $_POST["passwordOld"], true)){
			if ($_POST["password"] == $_POST["passwordVerify"]) {
				$password = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_BCRYPT);
				$sql = "UPDATE `utilisateurs` SET `password`=:password WHERE `id`=:id";
				$pdo = getDB($dbuser, $dbpassword, $dbhost,$dbname);
				$statement = $pdo->prepare($sql);
				$statement->execute([
					":password" => $password,
					":id" 	=> $user["id"]
				]);
				//message modif ok
				$_SESSION['success'] = 'Votre mot de passe a bien été modifié';
			}else{
				//mdp correspondent pas
				$_SESSION['error'] = 'Les deux mots de passes ne correspondent pas.';
			}
		}else{
			//erreur 
			$_SESSION['error'] = 'Mot de passe incorrect';
		}
	}
	elseif(isset($_POST["lastname"]) && !empty($_POST["lastname"]) &&
		isset($_POST["firstname"]) && !empty($_POST["firstname"]) &&
		isset($_POST["address"]) && !empty($_POST["address"]) &&
		isset($_POST["robot"]) && empty($_POST["robot"])){

			if(isset($_POST["lastname"]) && !empty($_POST["lastname"]) &&
				isset($_POST["firstname"]) && !empty($_POST["firstname"]) &&
				isset($_POST["address"]) && !empty($_POST["address"]) &&
				isset($_POST["zipCode"]) && !empty($_POST["zipCode"]) &&
				isset($_POST["city"]) && !empty($_POST["city"]) &&
				isset($_POST["country"]) && !empty($_POST["country"]) &&
				isset($_POST["phone"]) && !empty($_POST["phone"]) &&
				isset($_POST["robot"]) && empty($_POST["robot"])
			){
				$sql = 'SELECT * FROM utilisateurs WHERE id = ?';
				$pdo = getDB($dbuser, $dbpassword, $dbhost,$dbname);
				$statement = $pdo->prepare($sql);
				$statement->execute([htmlspecialchars($_POST['id'])]);
				$user = $statement->fetch();

				if($user) {
					$sqlparts = []; //:Array
					$fields = []; //:Array
					foreach($_POST as $key => $userInfo) {
						if($key != 'robot' && $key != 'id') {

							//On push "$key = ?" dans array $sqlparts
	 						$sqlparts[] = $key.' = ?';

	 						//On push la valeur de $userInfo dans $fields
							$fields[] = $userInfo;
						}
					}

					//On push l'id de l'utilisateur en dernier
					$fields[] = $_POST['id'];

					//On convertit le tableau $sqlparts en String en séparant ses cases par des virgules ',' 
					$sqlparts = implode(',', $sqlparts);

					//UPDATE users SET lastname = ?,firstname = ?,address = ?,zipCode = ?,city = ?,country = ?,phone = ? WHERE id = ?
					$sql = "UPDATE utilisateurs SET ".$sqlparts.' WHERE id = ?';
					$req = $pdo->prepare($sql);
					$req->execute($fields);
				}
				
				}else{//fin verif user existe
					userConnect($_POST["mail"], $_POST["password"]);
				}
			}
	}

$pdo = getDB($dbuser, $dbpassword, $dbhost,$dbname);
$sql = "SELECT * FROM commandes WHERE id_client = ?";
$statement = $pdo->prepare($sql);
$statement->execute([$user["id"]]);
$orders = $statement->fetchAll();
require 'includes/header.php';

echo 	'<h1>Profil</h1>';

if(isset($_SESSION['success'])) {
	echo '<div style="background-color: lightgreen; text-align: center;">
			'.$_SESSION["success"].'
	</div>';
	unset($_SESSION["success"]); //Supprime la SESSION['success']
}
if(isset($_SESSION['error'])) {
	echo '<div style="background-color: red; text-align: center; color: #FFFFFF;">
			'.$_SESSION["error"].'
	</div>';
	unset($_SESSION["error"]); //Supprime la SESSION['error']
}

echo	'<hr /><form method="POST" name="inscription" action="">'.
 		input("lastname", "Votre nom :",$user["nom"]).
 		input("firstname", "Votre prénom :",$user["prenom"]).
 		input("address", "Votre adresse :",$user["adresse"]).
 		input("zipCode", "Votre code postal :",$user["code_postal"]).
 		input("city", "Votre ville :",$user["ville"]).
 		input("country", "Votre pays :",$user["pays"]).
 		input("phone", "Votre numéro de portable :",$user["telephone"], "tel").
  		"Votre courriel : ".$user["mail"].
  		input("robot", "","", "hidden").
  		input("id_user", "",$user["id"], "hidden").
  		"<button type=\"submit\">Envoyez</button>".
  		'</form><hr />';

echo 	'<form method="POST" name="inscription" action="">'.
  		input("passwordOld", "Votre ancien mot de passe :","", "password").
  		input("password", "Votre mot de passe :","", "password").
  		input("passwordVerify", "Confirmez votre mot de passe :","", "password").
  		input("robot", "","", "hidden").
  		"<button type=\"submit\">Envoyer</button>".
  		'</form><hr />';

//tableau des commandes
foreach ($orders as $order) {
	echo '<a href="'.uri("confirmationDeCommande.php?id=").$order["id"].'">commande n°'.$order["id"].'- '.number_format($order["pTTC"], 2, ',' ,'.').'€ </a><br />';
}

require 'includes/footer.php';