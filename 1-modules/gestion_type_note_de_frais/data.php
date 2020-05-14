<?php include('../../0-config/config-genos.php');?>

<?php 
$cas = (isset($_GET['cas'])  && !empty($_GET['cas']))  ? $_GET['cas']  : '';
$libelle = (isset($_POST['type_note_de_frais']) && !empty($_POST['type_note_de_frais'])) ? strtoupper($_POST['type_note_de_frais']) : "";

switch ($cas) {
  case 'liste_type_ndf':
    echo json_encode(type_note_de_frais::GetListe());
  break;

  case 'ajout_tndf':
    $t = new type_note_de_frais;
    if(count($t->Find(array('type_note_de_frais'=>$libelle))) > 0){
      echo -1;
      return;
    }

    $t->type_note_de_frais = $libelle;
    if($t->Add() > 0) echo 1;
    else echo 0;
  break;

  case 'modif_tndf':
    $t = new type_note_de_frais;
    $t->id = $_POST['id'];
    $t->Load();

    if($t->type_note_de_frais == $libelle){
      echo 0;
      return;
    }

    $test_redondance = $t->StructList('SELECT * FROM type_note_de_frais WHERE type_note_de_frais LIKE :tndf AND id != :id_actuel ', $t->FieldList(), array('tndf'=>$libelle,'id_actuel'=>$_POST['id']));
    if(count($test_redondance) > 0){
      echo -1;
      return;
    }

    $t->type_note_de_frais = $libelle;
    $t->Update();
    echo 1;
  break;

  // case 'suppr_modif':
  //   $t = new type_note_de_frais;
  //   $req = 'DELETE FROM note_de_frais WHERE id_type_note_de_frais = :id';
  //   $bind = array('id'=>$_POST['id']);

  //   $t->Load();
  //   $t->Delete();
  // break;
}