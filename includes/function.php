<?php
require_once 'config.php';
require_once '/vendor/autoload.php';
/**
* retourne le nom du dossier
*
* @return string
*/

define('_ENV_', 'dev');


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
				$dbname='site') //:\PDO
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
			&&($user['actif']))){
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
				header('location: ?=profil.php');
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
			header('location: ?p=login');
			//TODO : err pas connecté
		}
}

/**
* verifie que l'utilisateur est connecté
* @return array|void
*/
function userOnly($verify=false){//:array|void|boolean
	//définir, si $user[actif]==0], pas de connexion

	if (session_status() != PHP_SESSION_ACTIVE){
		session_start();
	}
	// est pas defini et false
	if(!isset($_SESSION["auth"]) || (!$_SESSION["auth"])){
		if($verify){
			return false;
		exit();
		}
		else{
		//header('location: p=?login.php');
			header('location: ?=login.php');
			exit();
		}
	}
	return $_SESSION["auth"];
}


/***
**Envoi un mail au destinataire contenant le sujet et le message
** @return boolean
**/

function sendmail($destinataire, $sujet, $msg, $cci=true){
	
 	require 'config.php';

	$transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
	  ->setUsername('amaella.souil')
	  ->setPassword($mdpgmail)
	;
	
	$mailer = new Swift_Mailer($transport);
		$message = (new Swift_Message($sujet))
		->setFrom(['amaella.souil@gmail.com' => 'Admin']);
		
	if(!is_array($destinataire)){
		$destinataire=[$destinataire];
	}

	if(is_array($msg) && array_key_exists("html", $msg) && array_key_exists("text", $msg)){
		$message->setBody($msg["html"], "text/html");
		$message->addPart($msg["text"],"text/plain");

	}elseif(is_array($msg) && array_key_exists("html", $msg)){
		$message->setBody($msg["html"], "text/html");
		$message->addPart($msg["html"], "text/plain");
	}elseif(is_array($msg) && array_key_exists("text", $msg)){
		$message->setBody($msg["text"], "text/plain");
	}
	else $message->setBody($msg);
	if($cci){
		$message->setBcc($destinataire);
	}else {
		$message->setTo($destinataire);
	}

	return $mailer->send($message);
}


