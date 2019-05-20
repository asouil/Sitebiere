<?php

if(!empty($_POST)){
	if(	isset($_POST["mail"]) && !empty($_POST["mail"]) &&
		isset($_POST["password"]) && !empty($_POST["password"]) &&
		isset($_POST["robot"]) && empty($_POST["robot"])//protection robot
	){
		die();
		userConnect($_POST["mail"], $_POST["password"]);
	}else{
		die('bac à sable');
	}
}

echo 	'<h1>login</h1>'.
		'<form method="POST" name="inscription" action="">'.
  		input("mail", "Votre courriel","", "email").
  		input("password", "Votre mot de passe","", "password").
  		input("robot", "","", "hidden").
  		"<button type=\"submit\">Envoyer</button>".
  		'</form>';
