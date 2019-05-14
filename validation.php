<?php
include 'includes/header.php';

 require 'config.php';


// Connexion à la base de données
$pdo = getDB($dbname, $dbpassword, $dbhost, $dbname);
// Récupération des variables nécessaires à l'activation
$mail = $_GET['log'];
$cle = $_GET['cle'];
 
// Récupération de la clé correspondant au $login dans la base de données
$stmt = $pdo->prepare("SELECT cle,actif FROM utilisateurs WHERE mail like :mail ");
if($stmt->execute(array(':mail' => $mail)) && $row = $stmt->fetch())
  {
    $clebdd = $row['cle'];	// Récupération de la clé
    $actif = $row['actif']; // $actif contiendra alors 0 ou 1
  }
 
// On teste la valeur de la variable $actif récupéré dans la BDD
if($actif == '1') // Si le compte est déjà actif on prévient
  {
     echo "Votre compte est déjà actif !";
  }
else // Si ce n'est pas le cas on passe aux comparaisons
  {
     if($cle == $clebdd) // On compare nos deux clés	
       {
          // Si elles correspondent on active le compte !	
          echo "Votre compte a bien été activé !";
 
          // La requête qui va passer notre champ actif de 0 à 1
          $stmt = $pdo->prepare("UPDATE utilisateurs SET actif = 1 WHERE mail like :mail ");
          $stmt->bindParam(':mail', $mail);
          $stmt->execute();
       }
     else // Si les deux clés sont différentes on provoque une erreur...
       {
          echo "Erreur: Echec de l'activation de compte";
       }
  }
 	
// Fermeture de la connexion	