<?php session_start();
	if(isset($_POST['valider'])){
		if(isset($_POST['liste_eleves'])){
			$id_eleve = $_POST['liste_eleves'];
?>
<form action="enregistrer_note.php" method="post">
	<p>
		Rentrez une note :
		<input type="text" name="note">
	</p>	
	<p>
		<input type="hidden" name="id_eleve" value="<?php echo $id_eleve ?>">
	</p>
	<p>
		<input type="submit" name="valider" value="Valider">
	</p>
</form>

<?php

		}
	}
 ?>