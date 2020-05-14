<?php include('../../0-config/config-genos.php'); 

$cas           = $_GET['cas'];
$id         	 = (isset($_POST['id'])         	 && !empty($_POST['id']))         	 ? $_POST['id']         	 : '';
$login         = (isset($_POST['login'])         && !empty($_POST['login']))         ? $_POST['login']         : '';
$password      = (isset($_POST['password'])      && !empty($_POST['password']))      ? $_POST['password']      : '';
$nom           = (isset($_POST['nom'])           && !empty($_POST['nom']))           ? $_POST['nom']           : '';
$prenom        = (isset($_POST['prenom'])        && !empty($_POST['prenom']))        ? $_POST['prenom']        : '';
$vacataire     = (isset($_POST['vacataire'])     && !empty($_POST['vacataire']))     ? $_POST['vacataire']     : 0;
$date_validite = (isset($_POST['date_validite']) && !empty($_POST['date_validite'])) ? $_POST['date_validite'] : '';

switch ($cas) {
	case 'liste_salarie':
		$u = new utilisateur;
		$bind = array('id_ligue'=>$_SESSION['id_ligue']);
		$req = 'SELECT u.id, 
									 u.nom, 
									 u.prenom, 
									 u.vacataire, 
									 COALESCE(DATE_FORMAT(u.date_validite, "%Y-%m-%d" ), "Aucune") as date_validite, 
									 u.login, 
									 gu.groupe_utilisateur, 
									 l.nom as ligue 
						FROM utilisateur u 
						INNER JOIN groupe_utilisateur gu ON u.id_groupe_utilisateur = gu.id 
						LEFT JOIN ligue l ON u.id_ligue = l.id 
						WHERE u.id_ligue = :id_ligue AND u.id_groupe_utilisateur = 3 
						ORDER BY u.prenom ';
		$champs = array('id','nom','prenom','vacataire','date_validite','login','groupe_utilisateur','ligue');
		$res = $u->StructList($req, $champs, $bind, "json");

		echo $res;
	break;

	case 'verif_dispo_login':
		$u = new utilisateur;
		$res = $u->Find(array('login'=>$login));

		echo (count($res) > 0) ? -1 : 1;
	break;

	case 'ajout_salarie':
		if($prenom == '' || $nom == '' || $login == '' || $password == ''){
			echo -2;
			return;
		}
		$u = new utilisateur;
		$tab_pw = $u->Find(array('$login'=>$login));
		if(count($tab_pw) > 0){
			echo -1;
			return;
		}

		$u->LoadForm();
		if($u->vacataire == 0) $u->date_validite = NULL;
		$u->id_ligue = $_SESSION['id_ligue'];
		$u->id_groupe_utilisateur = 3;
		$u->password = sha1(md5($login.$password));

		$id_agent = $u->Add();

		$cu = new config_utilisateur;
		$cu->id_utilisateur = $id_agent;
		$cu->Add();
		
		echo 1;
	break;

	case 'modif_salarie':
		if($prenom == '' || $nom == '' || $login == ''){
			echo -1;
			return;
		}

		$u = new utilisateur;
		$u->id = $id;
		$u->Load();
		$u->LoadForm();
		if($vacataire == 0) $u->date_validite = NULL;
		$u->Update();

		echo 1;
	break;

	case 'suppr_salarie':
		$u = new utilisateur;
		$u->id = $id;
		$u->Load();
		$u->Delete();
		echo 1;
	break;
}