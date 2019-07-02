<?php session_start();
	$code_classe = $_SESSION['code_classe'];

	if(isset($_POST['valider'])){
		header("Location:evaluer_eleve.php?code=" . $code_classe);
		$_SESSION['nom'] = $_POST['nom'];

		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=Noter_Eleves;charset=utf8', 'root', 'root');
		}
		catch(Exception $e)
		{
      	  	die('Erreur : '.$e->getMessage());
		}

		$reponse = $bdd->query('SELECT id_eleve FROM eleve WHERE code_classe="'.$code_classe.'"');

		while($donnees = $reponse->fetch()){
			$tab_id_eleve[] = $donnees['id_eleve'];
		}

		$reponse->closeCursor();

		$nbreEleve = sizeof($tab_id_eleve);		

		for($i = 0;$i < $nbreEleve;$i++){
			$id_eleve = $tab_id_eleve[$i];
			//echo "id eleve " . $id_eleve;
			$notes_eleve = $_POST['notes_' . $id_eleve];
			//echo "notes eleves " . $notes_eleve;
			$tab_notes_eleve = ["id" => $id_eleve, "notes" => $notes_eleve];
			$tab_notes[] = $tab_notes_eleve;
		}

		print_r($tab_notes);
		/*$notes_ligne_1 = split('_',$_POST['notes_1']);
		print_r($notes_ligne_1);
		$notes_ligne_2 = split('_',$_POST['notes_2']);
		print_r($notes_ligne_2);

		$tab1 = ['id' => '1',"notes" => $notes_ligne_1];
		print_r($tab1);
		$tab2 = ['id' => '2',"notes" => $notes_ligne_2];

		$tab[] = $tab1;
		$tab[] = $tab2;*/
		//print_r($tab);
		//echo json_encode($tab);
		$json = json_encode($tab_notes);

		/*$json_data = json_decode($json,true);

	    //var_dump($json_data);
	    $tab2 = $json_data['notes'];
	    $tab2 = split(' ', $tab2);
	   	print_r($tab2);*/
		
// Nom du fichier à créer
$nom_du_fichier = 'fichier.json';

// Ouverture du fichier
$fichier = fopen($nom_du_fichier, 'w+');

// Ecriture dans le fichier
fwrite($fichier, $json);

// Fermeture du fichier
fclose($fichier);
	}
 ?>