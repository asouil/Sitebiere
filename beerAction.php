<?php
require_once 'ressources/donnees.php';
require_once 'includes/function.php';

if(!file_exists ('ressources/lock.php')){
	$sql = "INSERT INTO
			`beers` (`nom`, `image`, `description`, `prix`)
			VALUES (:nom, :image, :description, :prix)";

	$pdo = getDB($dbuser, $dbpassword, $dbhost,$dbname);
	$statement = $pdo->prepare($sql);
	foreach ($beerArray as $value) {
		$statement->execute([
		':nom'	=> $value[0],
		':image'		=> $value[1],
		':description'	=> $value[2],
		':prix'	=> $value[3]
	]);
	}
	//cree fichier ressources/lock.php
	fopen('ressources/lock.php', 'w');
	echo "données insérées";
}else{
	echo "aucune modification";
}