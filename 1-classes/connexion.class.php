<?php 
class connexion{
	public static function ConnexionUtilisateur($id_user){
		$id_user = (isset($id_user) && !empty($id_user)) ? $id_user : 0;

		if($id_user == 0) return;

		$u = new utilisateur;
		$u->id = $id_user;
		$u->Load();

		if($u->id_ligue > 0){
			$l = new ligue;
			$l->id = $u->id_ligue;
			$l->Load();
			$_SESSION['nom_ligue'] = $l->nom;
			$_SESSION['id_ligue'] = $l->id;
		}
		else {
			$_SESSION['nom_ligue'] = "Aucune ligue";
			$_SESSION['id_ligue'] = 0;
		}
		
		$_SESSION['id_user'] = $u->id;
		$_SESSION['nom_user'] = $u->nom;
		$_SESSION['prenom_user'] = $u->prenom;
		$_SESSION['id_grp_user'] = $u->id_groupe_utilisateur;
		config_utilisateur::ChargerConfigUtilisateur($u->id);
		header('Location:index.php');
	}

	public static function Deconnexion(){
		session_destroy();
		header('Location:'.RACINE_GLOBAL_RELATIF.'/login.php');
	}
}