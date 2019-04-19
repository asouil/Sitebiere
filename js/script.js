/* fonction permettant de gérer la quantité et de modifier les valeurs en fonction */

function valeur(name, nombre){
	//on remplace les , par des . pour pouvoir utiliser le nombre
	nombre=parseFloat(nombre);
	var htb=document.getElementById('ht'+nombre).innerHTML;
	//htb=x,y€ << à transformer
	htb=parseFloat(htb.replace(',','.'));
	console.log(htb);
	//donne htb = x.y 
	//la variable quantity sortira la valeur de quantite$i
	var quantity=document.getElementById(name).value;
	//on crée une variable val qui va être égale au total

	val = parseFloat(htb) * parseFloat(quantity)*1.2;
	val=val.toFixed(2);
	console.log(val)
	document.getElementById('resultat'+nombre).innerHTML = val ;

	//on reformate le résultat avec la virgule

	resultat = document.getElementById('resultat'+nombre).innerHTML.replace('.',',');

	//le résultat apparaît en formaté dans la console
	console.log(resultat);
	// formater à deux chiffres après la virgule (substr << équivalent?)
	//	resultat=

	document.getElementById('resultat'+nombre).innerHTML= resultat+'€';
}


/**	parseFloat
		function getNewPrice(id, quantity, originPrice) {
			//On récupère l'objet HTML qui a l'id "pht_"+id
			//Donc si id = 0 alors on ira récupérer l'objet html qui a l'id "pht_0"
			//Ne pas hésiter à utiliser l'inspecteur pour bien comprendre
			var objHT = document.getElementById('ht'+id);

			//On multiplie le prix d'origine de la biere sélectionnée à la valeur du champs quantité de la bière
			var newPrice = originPrice * quantite+id.value;

			//On multiplie le prix à 1.2(TVA) pour obtenir le prix TTC
			var TTCprice = newPrice *1.2;

			if(quantity.value > 0) {
				//toFixed(2) permet de limiter de 2 le nombre de chiffre apres la virgule de la variable newPrice
				//String permet de convertir(Caster) le résultat en chaine de caractère
				//Puis replace('.', ',') va remplacer les "." par des ","
				//Exemple: 12.56 deviendra 12,56
				resultat+id.innerHTML = String(TTCprice.toFixed(2)).replace('.', ',')+'€';
			}
		}**/