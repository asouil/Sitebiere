/* fonction permettant de gérer la quantité et de modifier les valeurs en fonction */

function valeur(name, nombre){
	var taxe=document.getElementById('ttc'+ nombre).innerHTML.replace(',','.');
	console.log(taxe);
	var quantity=document.getElementById(name).value;
	console.log(quantity);
	console.log(taxe);
	val = Number(taxe) * Number(quantity);
	document.getElementById('resultat'+nombre).innerHTML = val ;
	resultat = document.getElementById('resultat'+nombre).innerHTML;
	console.log(resultat);
	//remettre la virgule et formater à deux chiffres après celle-ci
	//	resultat=


}