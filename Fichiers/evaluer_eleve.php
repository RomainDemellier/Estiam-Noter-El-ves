<?php session_start();
	   	
	if(isset($_GET['code']) || isset($_POST['code'])){
		if(isset($_GET['code'])){
			$code = $_GET['code'];
			$_SESSION['code_classe'] = $code;
		}
		if(isset($_POST['code'])){
			$code = $_POST['code'];
			$_SESSION['code_classe'] = $code;
		}

		//echo $code;
		//echo $_POST['nom'];
		/*if(isset($_POST['valider'])){
			if(isset($_POST['nom']) && !empty($_POST['nom'])){
				$nom = "%" . $_POST['nom'] . "%";
			}
		}*/
		if(isset($_SESSION['nom'])){
			$nom = "%" . $_SESSION['nom'] . "%";
		}
	
 ?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Evaluation des élèves</title>
	<meta charset="utf-8">
</head>
<body>

	<div class="container">
		<form action="post.php" method="post" class="form-inline" id="filtre" onsubmit="envoi_notes()">
		<div class="row container">
			<div class="form-group col-md-4"><input type="text" name="nom" id="nom_search" class="form-control" placeholder="Nom"></div>
			<div class="form-group col-md-4"><input type="text" name="prenom" class="form-control" placeholder="Prenom"></div>	
			<input type="hidden" name="code" value="<?php echo $code; ?>">
			<div class="form-group col-md-4"><button type="submit" id="valider" name="valider" class="btn btn-primary filtre">Rechercher</button></div>
		</div>
	</div>
<?php 
	
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=Noter_Eleves;charset=utf8', 'root', 'root');
	}
	catch(Exception $e)
	{
        die('Erreur : '.$e->getMessage());
	}
	/*if(!isset($prenom)){
		$reponse = $bdd->query('SELECT id_eleve, nom, prenom FROM eleve WHERE code_classe="'.$code.'"');
	} else {
		$reponse = $bdd->query('SELECT id_eleve, nom, prenom FROM eleve WHERE code_classe="'.$code.'" AND prenom LIKE "'.$prenom.'"');
	}*/
	$requete = 'SELECT id_eleve, nom, prenom FROM eleve WHERE code_classe="'.$code.'"';
	if(isset($nom) && !empty($nom)){
		//$reponse2 = $bdd->query('SELECT id_eleve, nom, prenom FROM eleve WHERE code_classe="'.$code.'"');
		$suite_requete = ' AND nom LIKE "'.$nom.'"';
		$requete .= $suite_requete;
	}

	$reponse2 = $bdd->query($requete);
	while($donnees2 = $reponse2->fetch()){
		//echo $donnees2['id_eleve']; 
		$tab_id_eleves[] = $donnees2['id_eleve']; 
	}
	$reponse2->closeCursor();

	$reponse = $bdd->query('SELECT id_eleve, nom, prenom FROM eleve WHERE code_classe="'.$code.'"');

?>
<div class="container">
	<table class="table table-striped table-bordered table-hover" id="tab_eleves">
		<thead>
			<tr id="header">
				<td>Image</td>
				<td>Nom</td>
				<td>Prenom</td>
				<td class="header_note center nombre">Notes 1</td>
				<td id="header_moyenne" class="nombre">Moyenne</td>
			</tr>
		</thead>
		<tbody>
<?php
	$compteur = 1;
	while($donnees = $reponse->fetch()){
		$id = $donnees['id_eleve'];
		$nom = $donnees['nom'];
		$prenom = $donnees['prenom'];
		
		$id_champ_nom = "nom_" . $id;
		$id_champ_prenom = "prenom_" . $id;
		$ligne = "ligne_" . $id;

		$nom_id = "id_" . $id;
		$note_name = "note_" . $id . "_1";

		$nom_cache = "notes_" . $id;

		?>
		<input type="hidden" name=<?php echo $nom_id; ?> id=<?php echo $nom_id; ?> value=<?php echo $id?>>
		<input type="hidden" name=<?php echo $nom_cache; ?> id=<?php echo $nom_cache; ?>>
		<?php

		
		if(in_array($id,$tab_id_eleves)){
			?>
			<tr class="not_header" id=<?php echo $ligne; ?>>
			<?php
		} else {
			//echo $prenom;
?>
	<tr class="not_header cache" id=<?php echo $ligne; ?>>
<?php
	}
?>
		<td>
			<?php echo $id; ?>
		</td>
		<td id=<?php echo $id_champ_nom; ?> class="champ_nom">
			<?php echo $nom; ?>
		</td>
		<td id=<?php echo $id_champ_nom; ?> class="champ_prenom">
			<?php echo $prenom; ?>
		</td>
		<td class="center nombre">
			<input type='text' name=<?php echo $note_name;?> id=<?php echo $note_name;?>  class='note' onblur="ajout_colonne()" onfocus="reactive()">
			
		</td>
		<td class="nombre moyenne">
			
		</td>
	</tr>
<?php
$compteur++;
	}
	$reponse->closeCursor();
 ?>
 	</tbody>
 	</table>
 	</form>
 	</div>
 	<!--<p class="centre"><button class="btn btn-info"  id="inser_cell">Insérer une colonne note</button></p>-->
 	<script type="text/javascript" src="js/script.js"></script>
 	<script type="text/javascript">
 		//console.log(typeof tabObjets);
 		/*if((typeof tabObjets) == "undefined"){
 			var nomElts = document.getElementsByClassName("champ_nom");
 			var prenomElts = document.getElementsByClassName("champ_prenom");
 			var nbreNoms = nomElts.length;

 			var tabObjets = new Array();

 			for(i = 0;i < nbreNoms;i++){
 				//console.log(nomElts[i].getAttribute("id"));
 				//console.log(nomElts[i].textContent);
 				var id = nomElts[i].getAttribute("id");
 				id = id.split('_')[1];
 				var nom = nomElts[i].textContent;
 				var prenom = prenomElts[i].textContent;
 				var eleve = new Eleve(id,nom,prenom);
 				tabObjets[tabObjets.length] = eleve;
 			}

 			tableau = "<table class='bordure'>";
 			for(j = 0;j < tabObjets.length;j++){
 				tableau += "<tr><td>";
 				tableau += tabObjets[j].id;
 				tableau += "</td><td>";
 				tableau += tabObjets[j].nom;
 				tableau += "</td><td>";
 				tableau += tabObjets[j].prenom;
 				tableau += "</td></tr>";
 			}
 			tableau += "</table>";
 			document.write(tableau);
 		}

 		function Eleve(id,nom,prenom){
 			this.id = id;
 			this.nom = nom;
 			this.prenom = prenom;
 			this.notes = new Array();
 		}	*/
	

 	</script>
</body>
</html>
<?php } ?>