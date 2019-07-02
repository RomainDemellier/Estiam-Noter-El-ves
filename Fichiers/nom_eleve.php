<?php  session_start();

	if(isset($_POST['valider']) || isset($_SESSION['id_cours'])){
		if(isset($_POST['nom_classe'])){
			$nom_classe = $_POST['nom_classe'];
			$_SESSION['nom_classe'] = $nom_classe;
			$_SESSION['id_cours'] = $_POST['liste_cours'];
		} /*else if(isset($_SESSION['nom_classe'])){
			$nom_classe = $_SESSION['nom_classe'];
		}*/	
			
			
			//echo $_SESSION['id_cours'];
?>
	<form method="post" action="choisir_eleve.php">
		<p>
			Rentrez le nom d'un élève :
			<input type="text" name="nom_eleve">
		</p>
		<!--<input type="hidden" name="nom_classe" value="<?php //echo $nom_classe ?>">-->
		<p>
			<input type="submit" name="valider" value="Valider">
		</p>
	</form>
<?php			
		
	}
?>