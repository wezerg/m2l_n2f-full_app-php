<?php include('../../0-config/config-genos.php') ?>

<?php 
$id_utilisateur = (isset($_POST['id_utilisateur']) && !empty($_POST['id_utilisateur'])) ? $_POST['id_utilisateur'] : 0;
$cas = (isset($_GET['cas']) && !empty($_GET['cas'])) ? $_GET['cas'] : '';

switch ($cas) {
	case 'changerCouleur':
		$cu = new config_utilisateur;
		$cu->id = $_SESSION['id_config'];
		$cu->Load();
		$cu->LoadForm();
		$cu->Update();

		$_SESSION['couleur1'] = $_POST['couleur1'];
		$_SESSION['couleur2'] = $_POST['couleur2'];
	break;
}