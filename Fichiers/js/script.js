function ajaxGet(){
	// Création d'une requête HTTP
	var req = new XMLHttpRequest();
	// Requête HTTP GET synchrone vers le fichier langages.txt publié localement
	req.open("GET", "fichier.json", true);


	req.addEventListener("load", function () {
        if (req.status >= 200 && req.status < 400) {
            // Appelle la fonction callback en lui passant la réponse de la requête
            console.log(req.responseText);
            if(req.responseText != ''){
            	reconstruireTableau(req.responseText);
            }
            
        } else {
            console.error(req.status + " " + req.statusText);
        }
    });

	// Envoi de la requête
	req.send(null);
}

ajaxGet();

function reconstruireTableau(json_data){

	var tableau_data = JSON.parse(json_data);
	console.log(tableau_data);
	var nbreEleves = tableau_data.length;
	var nbreNotes = tableau_data[0].notes.split("_").length;

	alert(nbreNotes);
	for(i = 0;i < nbreNotes;i++){
		if(i > 0){
			var trElt = document.getElementById("header");
			var tdElt = document.createElement("td");
			tdElt.setAttribute("class","header_note");
			tdElt.appendChild(document.createTextNode("Notes " + (i+1)));
			var nbreChilds = trElt.childNodes.length;
			var lastTdElt = trElt.childNodes[nbreChilds - 2];
			trElt.insertBefore(tdElt,lastTdElt);
		}

		for(j = 0;j < nbreEleves;j++){
			var id_eleve = tableau_data[j].id;
			var tabNotes = tableau_data[j].notes.split("_");
			if(i == 0){
				var id_note = "note_" + id_eleve + "_" + (i + 1);
				var inputElt = document.getElementById(id_note);
				if(tabNotes[i] != ''){
					inputElt.value = tabNotes[i];
					inputElt.setAttribute("class","rouge");
				} else {
					inputElt.setAttribute("class","note");
				}
			} else {
				var trElt = document.getElementById("ligne_" + id_eleve);
				var tdElt = document.createElement("td");
				var inputElt = document.createElement("input");
				inputElt.setAttribute("type","text");
				var id_note = "note_" + id_eleve + "_" + (i + 1);
				//alert(id_note);
				inputElt.setAttribute("name",id_note);
				inputElt.setAttribute("id",id_note);
				if(tabNotes[i] != ''){
					inputElt.value = tabNotes[i];
					inputElt.setAttribute("class","rouge");
				} else {
					inputElt.value = '';
					inputElt.setAttribute("class","note");
				}
				inputElt.setAttribute('onblur', 'ajout_colonne()');
				inputElt.setAttribute('onfocus', 'reactive()');
				tdElt.appendChild(inputElt);
				var nbreChilds = trElt.childNodes.length;
				var lastTdElt = trElt.childNodes[nbreChilds - 2];
				trElt.insertBefore(tdElt,lastTdElt);
			}
		}
	}
}




function envoi_notes(){
	var nbreElt = document.getElementsByClassName("header_note").length;

	var trElts = document.getElementsByClassName("not_header");
	var nbreTrElts = trElts.length;

	for(i = 0;i < nbreTrElts;i++){
		var id_eleve = trElts[i].getAttribute("id").split("_")[1];
		//alert("id eleve : " + id_eleve);
		var cacheElt = document.getElementById("notes_" + id_eleve);
		cacheElt.value = '';
		for(j = 1;j <= nbreElt;j++){
			var note = "note_" + id_eleve + "_" + j;
			//alert("Ligne : " + i + " id : " + note);
			if(j == 1){
				cacheElt.value = document.getElementById(note).value;
			} else {
				cacheElt.value += "_" + document.getElementById(note).value;
			}
		}
	}
}

function Eleve(id,nom,prenom){
	this.id = id;
 	this.nom = nom;
 	this.prenom = prenom;
 	this.notes = new Array();
 }	


var classInput;
var tabEntier = ['0','1','2','3','4','5','6','7','8','9'];



function ajout_colonne(){
		
	console.log("class de la cible " + event.target.className);
	

	var nbreElt = document.getElementsByClassName("header_note").length;
	console.log("nombre de header_note " + nbreElt);

	var divElt2;

	var cible = event.target;

	var str = event.target.className.split(' ')[0];
	var name = event.target.getAttribute("name");
	var id = event.target.getAttribute("id");
	//var num = str.charAt(str.length-1);
	//var num = name.charAt(name.length - 1);
	var num = id.split("_")[2];
	console.log("numero nom " + num); 

	/* TEST */
	console.log("parent : ");
	var trElt = cible.parentNode.parentNode;
	//var id_eleve = trElt.getAttribute("id").split("_")[1];
	var idElt = trElt.childNodes[1].textContent;
	console.log("id Element : ");
	console.log(idElt);
	/* TEST */

	str = event.target.value;
	if(str.length > 0){
		var queDesEntiers = true;
		//event.target.setAttribute("disabled",true);
		var attr = cible.getAttribute("class");
		for(i = 0;i < str.length;i++){
			if(!tabEntier.includes(str.charAt(i))){
				queDesEntiers = false;
				console.log(queDesEntiers);
				break;
			}
		}

		if(!queDesEntiers){
			alert("Ne rentrez que des entiers");
		} else {
			
			event.target.setAttribute("class","rouge");
			if(num == nbreElt){

				var tdElt = document.createElement("td");
				tdElt.textContent = "Test";
				var trElts = document.getElementsByTagName("tr");

				for(i = 0;i < trElts.length;i++){
					trElt = trElts[i];

					
					var tdElt = document.createElement("td");
					var n = nbreElt + 1;

					if(i == 0){
						tdElt.setAttribute('class','header_note center');
						var n = nbreElt + 1;
						tdElt.appendChild(document.createTextNode("Note " + n));
					} else {

						var id_eleve = trElt.getAttribute("id").split("_")[1];
						//var numCol = transforme(id_eleve,n);
						var numCol = "note_" + id_eleve + "_" + n;
						tdElt.setAttribute('class','center');
						var newInput = document.createElement('input');
						newInput.setAttribute('type', 'text');
						newInput.setAttribute('class', 'note');
						newInput.setAttribute("name",numCol);
						newInput.setAttribute("id",numCol);
						newInput.setAttribute('onblur', 'ajout_colonne()');
						newInput.setAttribute('onfocus', 'reactive()');
						tdElt.appendChild(newInput);
					}
		
					var lastTdElt = trElt.childNodes[trElt.childNodes.length-2];
					trElt.insertBefore(tdElt,lastTdElt);
				}
			}
			if(queDesEntiers){
				moyenne(event.target);
			}
		}	
	}

}

function reactive(){

	var cible = event.target;

	if(cible.className == "rouge" ){
		cible.setAttribute("class","note");
	}
}

function moyenne(cible){

	var parentElt = cible.parentNode.parentNode;
	//console.log("Enfant 7 : ");
	//console.log(parentElt.childNodes[7].childNodes[1]);
	listeChild = parentElt.childNodes;
	var nbreChild = listeChild.length;

	var moyenne = 0;
	var compteur = 0;

	for(i = 0;i < nbreChild ;i++){
		var child = listeChild[i];
		var nbreChild2 = child.childNodes.length;
		//console.log("Nombre de petits enfants : " + nbreChild2);
		if(child.tagName == "TD"){
			for(j = 0;j < nbreChild2;j++){
				if(child.childNodes[j].tagName == "INPUT" && child.childNodes[j].getAttribute("type") == "text"){
					
					if(child.childNodes[j].value != ''){
						moyenne += Number(child.childNodes[j].value);
						compteur++;
					}
				}
			}
		}
	}
	//console.log("nombre de DIV : " + compteur);
	moyenne = moyenne/compteur;
	moyenne*=100;
	moyenne = Math.round(moyenne);
	moyenne/=100;
	listeChild[nbreChild - 2].textContent = moyenne;
}


function transforme(nbre,i){
	//return "note_" + i + "_" + nbre;
	return "note_" + nbre + "_" + i;
}

