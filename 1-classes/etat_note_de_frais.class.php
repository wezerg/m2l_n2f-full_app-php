<?php

class etat_note_de_frais {
  use Genos;
  public $id;
  public $etat_note_de_frais;

  function __construct(){
    $this->id                   = 0;
    $this->etat_note_de_frais   = '';
  }

  public static function GetListe(){
  	$e = new self;
  	$req = 'SELECT * FROM etat_note_de_frais ORDER BY etat_note_de_frais ';
  	$champs = $e->FieldList();
  	$res = $e->StructList($req, $champs);

  	return $res;
  }
}