<?php 

/* Bonjour { nom prénom} Vous habitez le {adresse} à {ville} après avoir rempli et envoyé : 
Champs : nom/prénom/(n°)/(type de voie)/nom de rue/CP/ ville */
//si on poste sur la meme page, on peut ne rien mettre dans action
?> 

<!DOCTYPE html>
<html>
<head>
	<title>votre adresse</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
	

<div class="container">
	<nav>
		<a href="/starterphp/">retour</a>
		<br />
		<hr />
	</nav>

	<?php if (!$submited): ?>

	<form method="get" action="">
	  
	   <div class="form-group">
	    <label for="prenom">prenom</label>
	    <input type="text" class="form-control" name="prenom" id="prenom" aria-describedby="prenom" value="<?= $_GET["prenom"] ?>" required placeholder="Enter votre prenom">
	  </div>
	  <?php if ($erreurs["prenom"]){
	  	echo "<p class=\"bg-danger\">merci de remplir le champ prenom</p>";
	  } ?>
	  <div class="form-group">
	    <label for="nom">nom</label>
	    <input type="text" class="form-control" name="nom" id="nom" aria-describedby="nom" placeholder="Enter votre nom" value="<?= $_GET["nom"] ?>" required>
	  </div>
	  	  <?php if ($erreurs["nom"]){
	  	echo "<p class=\"bg-danger\">merci de remplir le champ nom</p>";
	  } ?>
	  <div class="form-group">
	    <label for="numero">numero de rue</label>
	    <input type="number" class="form-control" name="numero" id="numero" aria-describedby="numero" value="<?= $_GET["number"] ?>" placeholder="Enter votre numero de rue">
	  </div>
	   <div class="form-group">
	    <label for="voie">type de voie</label>
	    <select class="form-control" name="voie" id="voie">
	    	<? foreach ($typeVoies as $key => $value) {
	    		echo "<option value=\"".$key."\">".$value."</option>";
	    	}
	    ?>
	    </select>
	  </div>
	  <div class="form-group">
	    <label for="nomrue">nom de rue</label>
	    <input type="text" class="form-control" id="nomrue" name="nomrue" aria-describedby="nomrue" value="<?= $_GET["nomrue"] ?>" placeholder="Enter votre nom de rue" required>
	  </div>
	  	  	  <?php if ($erreurs["nomrue"]){
	  	echo "<p class=\"bg-danger\">merci de remplir le champ nom de rue</p>";
	  } ?>
	   <div class="form-group">
	    <label for="cp">Code postal</label>
	    <input type="text" class="form-control" id="cp" name="cp" aria-describedby="cp" placeholder="Enter votre Code postal" value="<?= $_GET["cp"] ?>" required>
	  </div>
	  <?php if ($erreurs["cp"]){
	  	echo "<p class=\"bg-danger\">merci de remplir le champ Code postal</p>";
	  } ?>

	  <div class="form-group">
	    <label for="ville">Ville</label>
	    <input type="text" class="form-control" id="ville" name ="ville" aria-describedby="ville" required placeholder="Enter votre Ville" value="<?php $_GET["ville"] ?>">
	  </div>
	  <?php //erreurRemplissage("ville") ?>
	  <?php if ($erreurs["ville"]){
	  	echo "<p class=\"bg-danger\">merci de remplir le champ ville</p>";
	  } ?>
	  <button type="submit" class="btn btn-primary">Submit</button>
	</form>
	<?php else : ?>
		<p><?= $phrase ?></p>
	<?php endif ?>

	<footer class="m-5">
		<p>By Julien</p>
	</footer>
<?php
$submited = (count($_GET) == 0)?false: true;
$phrase;
$typesVoie =[
			"ALL" 	=> "Allée",
			"AV"	=>	"Avenue",
			"BD"	=>	"Boulevard",
			"CAR"	=>	"Carrefour",
			"CHE"	=>	"Chemin",
			"CHS"	=>	"Chaussée",
			"CITE"	=>	"Cité",
			"COR"	=>	"Corniche",
			"CRS"	=>	"Cours",
			"DOM"	=>	"Domaine",
			"DSC"	=>	"Descente",
			"ECA"	=>	"Ecart",
			"ESP"	=>	"Esplanade",
			"FG"	=>	"Faubourg",
			"GR"	=>	"Grande Rue", 
			"HAM"	=>	"Hameau",
			"HLE"	=>	"Halle",
			"IMP"	=>	"Impasse",
			"LD"	=>	"Lieu-dit",
			"LOT"	=>	"Lotissement",
			"MAR"	=>	"Marché",
			"MTE"	=>	"Montée",
			"PAS"	=>	"Passage",
			"PL"	=>	"Place",
			"PLN"	=>	"Plaine",
			"PLT"	=>	"Plateau",
			"PRO"	=>	"Promenade",
			"PRV"	=>	"Parvis",
			"QUA"	=>	"Quartier",
			"QUAI"	=>	"Quai",
			"RES"	=>	"Résidence",
			"RLE"	=>	"Ruelle",
			"ROC"	=>	"Rocade",
			"RPT"	=>	"Rond-point",
			"RTE"	=>	"Route",
			"RUE"	=>	"Rue",
			"SEN"	=>	"Sente - Sentier", 
			"SQ"	=>	"Square",
			"TPL"	=>	"Terre-plein",
			"TRA"	=>	"Traverse",
			"VLA"	=>	"Villa",
			"VLGE"	=>	"Village"
];
 //var_dump($_GET);
if (	$_GET["prenom"] &&
		$_GET["nom"] 	&&
		$_GET["nomrue"] &&
		$_GET["cp"] 	&&
		$_GET["ville"]	
	){
	$identity = strtoupper($_GET["nom"]. " " .$_GET["prenom"]);
	$address = "";
	if(isset($_GET["numero"])){
		$address .= $_GET["numero"].' ';
	}
	if(isset($_GET["voie"])){
		$address .= $typeVoies[$_GET["voie"]].' ';
	}
	$address .= ucfirst($_GET["nomrue"]);
	$ville = $_GET["cp"]." ".ucfirst($_GET["ville"]);
	$phrase = "Bonjour, {$identity} vous habitez le {$address} à {$ville}";
}else{
	$erreurs = [];
	//.   nom du champ.  verifie qu'il n'est pas vide si vide  on met true sinon false 
	$erreurs["prenom"] = ($_GET["prenom"]!="") ?false: true;
	$erreurs["nom"] = ($_GET["nom"]!="") ?false:  true; 	
	$erreurs["nomrue"] = ($_GET["nomrue"]!="") ?false: true;
	$erreurs["cp"] = ($_GET["cp"]!="") ?false: true; 	
	$erreurs["ville"] = ($_GET["ville"]!="") ?false: true;
	$submited = false;
}
?>
</div>
</body>
</html>
