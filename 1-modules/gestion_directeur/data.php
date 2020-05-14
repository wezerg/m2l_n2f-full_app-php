<?php include('../../0-config/config-genos.php');?>

<?php 
$cas = (isset($_GET['cas'])  && !empty($_GET['cas']))  ? $_GET['cas']  : '';
$nom = (isset($_POST['nom']) && !empty($_POST['nom'])) ? $_POST['nom'] : '';
$prenom = (isset($_POST['prenom']) && !empty($_POST['prenom'])) ? $_POST['prenom'] : '';
$login = (isset($_POST['login']) && !empty($_POST['login'])) ? $_POST['login'] : '';
$password = (isset($_POST['password']) && !empty($_POST['password'])) ? $_POST['password'] : '';
$id = (isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : '';

switch ($cas) {
    case 'liste_utilisateurs':
        $u = new utilisateur;
        $req = "SELECT u.id, u.nom, u.prenom, l.nom as ligue
                FROM utilisateur u LEFT JOIN ligue l ON u.id_ligue = l.id 
                WHERE u.id_groupe_utilisateur = 2
                ORDER BY u.nom";
        $champs = array('id', 'nom', 'prenom', 'ligue');
        $res = $u->StructList($req, $champs, "json");

        echo $res;
    break;

    case 'ajout_directeur':
		#Si il n'y a pas de valeur dans les champs, on ne va pas plus loin.
		if($login == '' || $password == '' || $nom == '' || $prenom == ''){
			echo -2;
			return;
		}
		$u = new utilisateur;

		#On regarde si le login est déjà attribué ou non.
		$tab_verif_login = $u->Find(array('login'=>$login));
		#Si c'est le cas, on ne va pas plus loin.
		if(count($tab_verif_login) > 0){
			echo -1;
			return;
        }
        
        // Récupère les champs du tableau
        $u->LoadForm();
        // Cryptage du mdp
        $u->password = sha1(md5($login.$password));
        // Ajout de l'utilisateur en BDD
		$id_directeur = $u->Add();

        $cu = new config_utilisateur;
        $cu->id_utilisateur = $id_directeur;
        $cu->Add();
        
		echo 1;
    break;
    
    case 'modif_directeur':
		#On charge les changements et on modifie le directeur
        if ($nom != '' && $prenom != '') {
            $u = new utilisateur;
            $u->id = $id;
            $u->Load();
            $u->nom = $nom;
            $u->prenom = $prenom;
            $u->Update();
        }
    break;
    
    case 'suppr_directeur':
		$u = new utilisateur;
        $l = new ligue;

		$u->id = $id;
        $u->Load();
        // On supprime l'id directeur de la ligue si notre directeur est affecté
        if ($u->id_ligue > 0) {
            $l->id = $u->id_ligue;
            $l->Load();
            $l->id_utilisateur = 0;
            $l->Update();
        }
		$u->Delete();

	break;
}