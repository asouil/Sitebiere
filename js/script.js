/* fonction permettant de gérer la quantité et de modifier les valeurs en fonction */

function valeur(name, nombre){
	//on remplace les , par des . pour pouvoir utiliser le nombre
	nombre=parseFloat(nombre);
	var htb=document.getElementById('ht'+nombre).innerHTML;
	//htb=x,y€ << à transformer
	htb=parseFloat(htb.replace(',','.'));
	//donne htb = x.y €
	//la variable quantity sortira la valeur de quantite$i
	var quantity=document.getElementById(name).value;
	//on crée une variable val qui va être égale au total

	val = parseFloat(htb) * parseFloat(quantity)*1.2;

	document.getElementById('resultat'+nombre).innerHTML = val ;

	//on reformate le résultat avec la virgule

	resultat = document.getElementById('resultat'+nombre).innerHTML.replace('.',',');

	//le résultat apparaît en formaté dans la console
	console.log(resultat);
	// formater à deux chiffres après la virgule (substr << équivalent?)
	//	resultat=

	document.getElementById('resultat'+nombre).innerHTML= resultat+'€';
}

//parseFloat