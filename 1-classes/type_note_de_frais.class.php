<?php 

class type_note_de_frais {
  use Genos;
  public $id;
  public $type_note_de_frais;

  function __construct(){
    $this->id                   = 0;
    $this->type_note_de_frais   = '';
  }

  public static function GetListe(){
  	$t = new self;
  	$req = 'SELECT * FROM type_note_de_frais ORDER BY type_note_de_frais ';
  	$champs = $t->FieldList();
  	$res = $t->StructList($req, $champs);

  	return $res;
  }
}