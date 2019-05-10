<?php
require_once 'config.php';

/**
* retourne le nom du dossier
*
* @return string
*/
//function uri($cible="")//:string
//{
//	global $racine; //Permet de récupérer une variable externe à la fonction
//	$uri = "http://".$_SERVER['HTTP_HOST']; 
//	$folder = "";
//	if(!$racine) {
//		$folder = basename(dirname(dirname(__FILE__))).'/'; //Dossier courant
//	}
//	return $uri.'/'.$folder.$cible;
//}
define('_ENV_', 'dev');
//putenv('modenv'='prod');
/*trouver comment modifier les style.mini.css et script.mini.js*/

function uri($cible="")//:string
{

	$cibles=explode('.', $cible);
	if(count($cibles)==2){
		$ext= ['css','js'];
		if(in_array($cibles[1], $ext)){
			if("_ENV_"!="dev"){
				$mini= ".mini.";
			}
			$cible=$cibles[0].$mini.$cible[1];			
		}
		
	}else{
		$cible=$cibles[0];
	}

	$uri = "http://".$_SERVER['HTTP_HOST'];
	$folder = basename(dirname(dirname(__FILE__)));
	return $uri.'/'.$folder.'/'.$cibles[0];
}
//uri("style.css")


/**
* crée une connexion à la base de données
*	@return \PDO
*/

function getDB(	$dbuser='root', 
				$dbpassword='', 
				$dbhost='localhost',
				$dbname='sitebeer') //:\PDO
{
	

	$dsn = 'mysql:dbname='.$dbname.';host='.$dbhost.';charset=UTF8';
	try {
    	$pdo = new PDO($dsn, $dbuser, $dbpassword);

    	//definit mode de recupération en mode tableau associatif
    	// $user["lastname"];
    	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    	//definit mode de recupération en mode Objet
    	//$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    	// $user->lastname;
    	return $pdo;

	} catch (PDOException $e) {
    	echo 'Connexion échouée : ' . $e->getMessage();
    	die();
	}
}


/**
*	génère un champ de formulaire de type input
*	@return String
*/

function input($name, $label,$value="", $type='text', $require=true)//:string
{
	$input = "
	<div class=\"form-group\">
		<label for=\"".$name."\">".$label."</label>
		<input id=\"".$name."\" type=\"".$type."\" name=\"".$name."\" value=\"".$value."\" ";
	$input .= ($require)? "required": "";
	$input .= ">
	</div>";

	return $input;
}

/**
* Connect le client
* @return boolean|void
*/
function userConnect($mail, $password, $verify=false){//:boolean|void
	require 'config.php';

	$sql = "SELECT * FROM utilisateurs WHERE `mail`= ?";
	$pdo = getDB($dbuser, $dbpassword, $dbhost,$dbname);

		$statement = $pdo->prepare($sql);
		$statement->execute([htmlspecialchars($mail)]);
		$user = $statement->fetch();
		if(	$user && 
			password_verify(
			htmlspecialchars($password), $user['password']
		)){
				if($verify){
					return true;
					//exit();
				}

				if (session_status() != PHP_SESSION_ACTIVE){
					session_start();
				}
				unset($user['password']);
				$_SESSION['auth'] = $user;
				//connecté
				header('location: profil.php');
				exit();

		}else{

			if($verify){
				return false;
				//exit();
			}
			if (session_status() != PHP_SESSION_ACTIVE){
					session_start();
				}
			$_SESSION['auth'] = false;
			header('location: p=?login.php');
			//TODO : err pas connecté
		}

}



/**
* verifie que l'utilisateur est connecté
* @return array|void
*/
function userOnly($verify=false){//:array|void|boolean
	if (session_status() != PHP_SESSION_ACTIVE){
		session_start();
	}
	// est pas defini et false
	if(!isset($_SESSION["auth"]) || (!$_SESSION["auth"])){
		if($verify){
			return false;
		//exit();
		}
		header('location: p=?login.php');
		exit();
	}
	return $_SESSION["auth"];
}






