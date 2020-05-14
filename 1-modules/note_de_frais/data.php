<?php include('../../0-config/config-genos.php');?>

<?php
$cas = (isset($_GET['cas'])  && !empty($_GET['cas']))  ? $_GET['cas']  : '';
$id = (isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : '';
$path_image = (isset($_POST['path_image']) && !empty($_POST['path_image'])) ? $_POST['path_image'] : '';
$commentaire = (isset($_POST['commentaire']) && !empty($_POST['commentaire'])) ? $_POST['commentaire'] : '';

switch ($cas) {

  case 'liste_type_NDF':
    echo json_encode(type_note_de_frais::GetListe());
  break;

  case 'liste_etat_NDF':
    echo json_encode(etat_note_de_frais::GetListe());
  break;

  case 'liste_NDF':
    $n = new note_de_frais;

    $bind = array();
    $req = 'SELECT n.*, endf.etat_note_de_frais as etat, tndf.type_note_de_frais as type, u.nom, u.prenom 
            FROM note_de_frais n 
            INNER JOIN type_note_de_frais tndf ON n.id_type_note_de_frais = tndf.id 
            INNER JOIN etat_note_de_frais endf ON n.id_etat_note_de_frais = endf.id 
            INNER JOIN utilisateur u ON n.id_utilisateur = u.id ';
    if($_SESSION['id_grp_user'] == 2){
      $bind['id_ligue'] = $_SESSION['id_ligue'];
      $req .= " WHERE u.id_ligue = :id_ligue ";
    }
    if($_SESSION['id_grp_user'] == 3){
      $bind['id_user'] = $_SESSION['id_user'];
      $req .= " WHERE u.id = :id_user ";
    }
    $req .= ' ORDER BY n.id_etat_note_de_frais ';

    $champs = $n->FieldList();
    array_push($champs, 'etat');
    array_push($champs, 'type');
    array_push($champs, 'nom');
    array_push($champs, 'prenom');

    $res = $n->StructList($req, $champs, $bind, 'json');

    echo $res;
  break;

  //Revoir l'upload de l'image
  case 'ajout_note':
    $n = new note_de_frais;

    if(empty($_FILES) || $_FILES['file']['error'] == 4){
      echo -1;
      return;
    }

    $fileSize = $_FILES['file']['size'];
    $tailleMaxUpload = GetTailleMaxUpload();
    if($_FILES['file']['error'] == 1 || $fileSize > $tailleMaxUpload){
      echo -3;
      return;
    }

    #Si jamais l'utilisateur n'a pas de dossier de stockage, on lui en fait un.
    $path_dossier_salarie = RACINE_GLOBAL_RELATIF.'DATAS/'.$_SESSION['id_user'];
    if(!file_exists($path_dossier_salarie)) mkdir($path_dossier_salarie, '0755');

    $extension = strtolower(explode('.', $_FILES['file']['name'])[1]);
    $nom_fichier = 'NDF_'.$_SESSION['nom_user'].'_'.$_SESSION['prenom_user'].'_'.date("Y-m-d-H-i-s").'.'.$extension;

    // $fileSize = @getimagesize($_FILES['file']['tmp_name']); //Pour vérifier le mime, et donc le vrai type
    $extensions_autorisees = array('pdf','png','jpg','jpeg');
    if(!in_array($extension, $extensions_autorisees)){
      echo -2;
      return;
    }

    $path_final = $path_dossier_salarie.'/'.$nom_fichier;
    move_uploaded_file($_FILES['file']['tmp_name'], $path_final);
    
    $n->LoadForm();
    $n->id_utilisateur = $_SESSION['id_user'];  
    $n->path_image = $nom_fichier;
    $n->Add();

    echo 1;
  break;

  case 'valider_NDF':
    $n = new note_de_frais;
    $n->id = $id;
    $n->Load();
    $n->id_etat_note_de_frais = 2;
    $n->Update();
  break; 

  case 'refuser_NDF':
    $n = new note_de_frais;
    $n->id = $id;
    $n->Load();
    $n->LoadForm();
    $n->id_etat_note_de_frais = 3;
    $n->Update();
  break;

}