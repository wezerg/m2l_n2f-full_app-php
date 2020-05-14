<?php include("../../../0-config/config-genos.php");
	$cas = $_GET["cas"];

switch ($cas) {

	case 'deconnexion':
		connexion::Deconnexion();
	break;

	case 'get_nbAttente':
		$n = new note_de_frais;
		$req = 'SELECT count(*) as total 
						FROM note_de_frais n 
						INNER JOIN utilisateur u ON n.id_utilisateur = u.id 
						WHERE n.id_etat_note_de_frais = 1 AND u.id_ligue = :id_ligue ';
		$bind = array('id_ligue'=>$_SESSION['id_ligue']);
		$champs = array('total');

		$res = $n->StructList($req, $champs, $bind);
		
		echo $res[0]['total'];
	break;

}

?>