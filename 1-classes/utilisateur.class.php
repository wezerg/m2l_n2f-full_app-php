<?php 

class utilisateur {
	use Genos;
	public $id;
	public $nom;
	public $prenom;
	public $login;
	public $password;
	public $vacataire;
	public $date_validite;
	public $id_groupe_utilisateur;
	public $id_ligue;

	function __construct(){
		$this->id                    = 0;
		$this->nom                   = '';
		$this->prenom                = '';
		$this->login                 = '';
		$this->password              = '';
		$this->vacataire             = 0;
		$this->date_validite         = NULL;
		$this->id_groupe_utilisateur = 0;
		$this->id_ligue              = 0;
	}

	/**
	* @author cBourtoire
	* @since 18/01/2020
	*	@version 1.0.0
	* @return Tableau d'utilisateur
	* @param [int] enlever_admin -> Si 1 on enlève l'admin de la liste, si 0 on le laisse.
	*/
	public static function GetListeUtilisateurs($enlever_admin = 0){
		$u = new utilisateur;
		$req = "SELECT u.id, CONCAT(u.prenom,' ',u.nom) as identite, COALESCE(l.nom, '') as ligue 
						FROM utilisateur u LEFT JOIN ligue l ON u.id = l.id_utilisateur ";
		if($enlever_admin == 1) $req .= " WHERE u.id_groupe_utilisateur != 1 ";
		$req .= " ORDER BY ligue ";
		$champs = array('id','identite','ligue');
		$res = $u->StructList($req, $champs);

		return $res;
	}
}