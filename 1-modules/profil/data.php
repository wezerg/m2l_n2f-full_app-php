<?php include('../../0-config/config-genos.php');

$cas = $_GET['cas'];

switch ($cas) {
	case 'getElem':
		$u = new utilisateur;
		$u->id = $_POST['id'];
		$u->Load();

		$gu = new groupe_utilisateur;
		$gu->id = $u->id_groupe_utilisateur;
		$gu->Load();

		$l = new ligue;
		$l->id = $u->id_ligue;
		$l->Load();

		$u->groupe_utilisateur = $gu->groupe_utilisateur;
		$u->ligue = $l->nom;

		echo json_encode($u);
	break;

	case 'modif':
		$u = new utilisateur;
		$u->id = $_POST['id'];
		$u->Load();
		$u->LoadForm();
		$_SESSION['nom_user'] = $_POST['nom'];
		$_SESSION['prenom_user'] = $_POST['prenom'];

		$u->Update();
	break;
}