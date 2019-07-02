<?php session_start();
	if(isset($_POST['valider'])){
		if(isset($_POST['nom_eleve'])){
			$nom_eleve = $_POST['nom_eleve'];
			//$nom_classe = $_POST['nom_classe'];
			$nom_classe = $_SESSION['nom_classe'];
			try
			{
				$bdd = new PDO('mysql:host=localhost;dbname=Noter_Eleves;charset=utf8', 'root', 'root');
			}
			catch(Exception $e)
			{
        		die('Erreur : '.$e->getMessage());
			}
			
			$nom = '%' . $nom_eleve . '%';
			
			$reponse = $bdd->query('SELECT id, nom, prenom FROM nom_prenom WHERE code_classe = "'.$nom_classe.'" AND nom LIKE "'.$nom.'"');

			echo '<form action="noter_eleve.php" method="post">';
			
			echo '<select name="liste_eleves" id="liste_eleves">';

			while ($donnees = $reponse->fetch())
			{	

				//echo $donnees['nom'] . '<br />';
				echo '<option value="' . $donnees["id"] . '">' . $donnees["nom"] . ' ' . $donnees["prenom"] . '</option>';
			}

			echo '</select>';
			echo '<p><input type="submit" name="valider" value="Valider"></p>';
			echo '</form>';
			$reponse->closeCursor();
		}
	}
 ?>