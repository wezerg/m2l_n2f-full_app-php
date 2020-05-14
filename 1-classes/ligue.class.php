<?php 
class ligue {
	use Genos;
	public $id;
	public $nom;
	public $id_utilisateur;

	function __construct(){
		$this->id             = 0;
		$this->nom            = '';
		$this->id_utilisateur = 0;
	}
}