<?php

class note_de_frais {
  use Genos;
  public $id;
  public $libelle;
  public $path_image;
  public $commentaire;
  public $montant;
  public $id_utilisateur;
  public $id_type_note_de_frais;
  public $id_etat_note_de_frais;

  function __construct(){
	  $this->id                    = 0;
    $this->libelle               = '';
    $this->path_image            = '';
    $this->commentaire           = '';
    $this->montant               = 0;
    $this->id_utilisateur        = 0;
    $this->id_type_note_de_frais = 0;
    $this->id_etat_note_de_frais = 1;
	}
}
