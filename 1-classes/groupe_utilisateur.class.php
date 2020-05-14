<?php 

class groupe_utilisateur{
	use Genos;
	public $id;
	public $groupe_utilisateur;

	function __construct(){
		$this->id = 0;
		$this->groupe_utilisateur = '';
	}
}