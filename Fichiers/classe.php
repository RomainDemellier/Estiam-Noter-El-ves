<!DOCTYPE html>
<html>
<head>
	<!--<link rel="stylesheet" type="text/css" href="css/style.css">-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Noter les élèves</title>
</head>
<body>
	
		<form action="" method="post" class="form-inline">
			
				<div class="form-group"><input type="text" name="cours" class="form-control" placeholder="Cours"></div>
				<div class="form-group"><input type="text" name="classe" class="form-control" placeholder="Classe"></div>
				<div class="form-group"><input type="date" name="date" class="form-control" placeholder="Date"></div>
				<div class="form-group"><input type="text" name="heure" class="form-control" placeholder="Heure"></div>
				<div class="form-group"><input type="text" name="lieu" class="form-control" placeholder="Campus"></div>	
				<p><button type="submit" class="btn btn-primary filtre">Rechercher</button></p>
			
			
		</form>
	
	

	<?php 
		//if(isset($_POST['valider'])){
			if(isset($_POST['cours'])){
				$cours = $_POST['cours'];
				$c = '%' . $cours . '%';
			}
			if(isset($_POST['classe'])){
				$classe = $_POST['classe'];
				$cl = '%' . $classe . '%';
			}
			if(isset($_POST['date'])){
				$date = $_POST['date'];
				$d = '%' . $date . '%';
			}
			if(isset($_POST['heure'])){
				$heure = $_POST['heure'];
				$h = '%' . $heure . '%';
			}
			if(isset($_POST['lieu'])){
				$lieu = $_POST['lieu'];
				$l = '%' . $lieu . '%';
			}

			if(empty($_POST['cours']) && empty($_POST['classe']) && empty($_POST['lieu'])){
				
				$vide = true;
			} else {
				$vide = false;
				
			}

			try
			{
				$bdd = new PDO('mysql:host=localhost;dbname=Noter_Eleves;charset=utf8', 'root', 'root');
			}
			catch(Exception $e)
			{
        		die('Erreur : '.$e->getMessage());
			}

			if($vide) {
				$reponse = $bdd->query('SELECT nom_cours, code_classe, lieu_cours, DATE_FORMAT(date_cours,\'%d/%m/					  %Y\') AS date_cours FROM liste_cours');
			} else {
				$reponse = $bdd->query('SELECT nom_cours, code_classe, lieu_cours, DATE_FORMAT(date_cours,\'%d/%m/					  %Y\') AS date_cours FROM liste_cours WHERE nom_cours LIKE "'.$c.'"
										AND code_classe LIKE "'.$cl.'" AND lieu_cours LIKE "'.$l.'"');
			}

			/*$reponse = $bdd->query('SELECT nom_cours, code_classe, lieu_cours, DATE_FORMAT(date_cours,\'%d/%m/					  %Y\') AS date_cours FROM liste_cours WHERE nom_cours LIKE "'.$c.'"
										AND code_classe LIKE "'.$cl.'" AND lieu_cours LIKE "'.$l.'"');*/

?>
	<div class="container">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
					<td>Nom du cours</td>
					<td>Nom de la classe</td>
					<td>Date</td>
					<td>Campus</td>
				</tr>
				</thead>
				<tbody>
<?php
			$entier = 0;
			while ($donnees = $reponse->fetch())
			{
				/*if($entier == 0){
					echo '<tr class="active">';
					$entier = 1;
				} else {
					echo '<tr class="success">';
					$entier = 0;
				}*/	

				$nom = $donnees['nom_cours'];
				$code = $donnees['code_classe'];
				$date = $donnees['date_cours'];
				$lieu = $donnees['lieu_cours'];

				echo '<tr class="success">';
					
				echo "<td>" .$nom. "</td>";
				echo "<td><a href='evaluer_eleve.php?code=" .$code. "' class='lien_classe'>" .$code. "</a></td>";
				echo "<td>" .$date. "</td>";
				echo "<td>" .$lieu. "</td>";
						
				echo "</tr>";
				

			}
			echo "</tbody>";
			echo "</table>";
			echo "</div>";
			$reponse->closeCursor();
		//}
	 ?>	
	 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>