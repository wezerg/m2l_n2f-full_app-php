<?php 

class config_utilisateur{
	use Genos;
	public $id;
	public $id_utilisateur;
	public $couleur1;
	public $couleur2;

	function __construct(){
		$this->id             = 0;
		$this->id_utilisateur = 0;
		$this->couleur1       = "#071B52";
		$this->couleur2       = "#008080";
	}

	public static function ChargerConfigUtilisateur($id_utilisateur){
		if(!isset($id_utilisateur) && empty($id_utilisateur)) return;

		$cu = new config_utilisateur;
		$config = $cu->Find(array('id_utilisateur'=>$id_utilisateur));

		if(count($config) == 0){
			self::CreerConfigUtilisateurInitiale($id_utilisateur);
			self::ChargerConfigUtilisateur($id_utilisateur);
		}
		if(count($config) > 0){
			$_SESSION['couleur1'] = $config[0]['couleur1'];
			$_SESSION['couleur2'] = $config[0]['couleur2'];
			$_SESSION['id_config'] = $config[0]['id'];
		}
	}

	public static function CreerConfigUtilisateurInitiale($id_utilisateur){
		$cu = new config_utilisateur;
		$cu->id_utilisateur = $id_utilisateur;
		$cu->Add();
	}
}