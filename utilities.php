<?php 
function Head($titre, $menu){ ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
  	<link rel="icon" href="<?php echo RACINE_GLOBAL_RELATIF ?>img/logo_on.png" />
    <title><?php echo $titre ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo RACINE_GLOBAL_RELATIF ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo RACINE_GLOBAL_RELATIF ?>css/style.css">
    <link rel="stylesheet" href="<?php echo RACINE_GLOBAL_RELATIF ?>css/animate.min.css">
    <link rel="stylesheet" href="<?php echo RACINE_GLOBAL_RELATIF ?>css/notify.css">
    <link rel="stylesheet" href="<?php echo RACINE_GLOBAL_RELATIF ?>css/all.css">
    <style>
    	body{
    		background: linear-gradient(to left, <?php echo isset($_SESSION['couleur1']) ? $_SESSION['couleur1'] : '#071B52'; ?> 0%, <?php echo isset($_SESSION['couleur2']) ? $_SESSION['couleur2'] : '#008080'; ?> 100%);
    	}
    </style>
  </head>
  <body>
  	<?php if($menu > 0) Menu($menu); ?>
<?php }

function Menu($menu){ ?>
	<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(36, 36, 36, 0.6);" id="menu" v-cloak>
		<input type="hidden" id="type-agent" value="<?php echo ($_SESSION['id_grp_user'] == 2) ? 'manager' : 'autre' ?>">
	  <a class="navbar-brand <?php echo ($menu == 1) ? 'active' : 'text-white-50'; ?>" href="<?php echo RACINE_GLOBAL_RELATIF ?>index.php">
	  	<img src="<?php echo RACINE_GLOBAL_RELATIF ?>img/<?php echo ($menu == 1) ? 'logo_on.svg' : 'logo.svg' ?>" alt="N2F">
	  	<!-- N2F -->
	  </a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav mr-auto">
	    	<?php if($_SESSION["id_grp_user"] != 1) {?>
		      <li class="nav-item">
		        <a class="nav-link <?php echo ($menu == 2) ? 'active' : '' ?>" href="<?php echo RACINE_GLOBAL_RELATIF ?>1-modules/note_de_frais">Gérer <?php echo ($_SESSION["id_grp_user"] == 3) ? 'mes' : 'les' ?> notes de frais</a>
		      </li>
		    <?php } ?>
		    <?php if($_SESSION["id_grp_user"] == 2) {?>
		      <li class="nav-item">
		      	<?php if($_SESSION['id_ligue'] > 0) {?>
			        <a class="nav-link <?php echo ($menu == 3) ? 'active' : '' ?>" href="<?php echo RACINE_GLOBAL_RELATIF ?>1-modules/gestion_salarie">
			        	Gestion des salariés
			        </a>
		      	<?php } else { ?>
							<a class="nav-link text-muted" style="cursor: not-allowed;">
			        	Gestion des salariés
			        </a>
		      	<?php } ?>
		      </li>
		    <?php } ?>
		    <?php if($_SESSION["id_grp_user"] == 1) {?>
		    	<li class="nav-item">
		        <a class="nav-link <?php echo ($menu == 2) ? 'active' : '' ?>" href="<?php echo RACINE_GLOBAL_RELATIF ?>1-modules/gestion_ligue">Gestion des ligues</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link <?php echo ($menu == 3) ? 'active' : '' ?> " href="<?php echo RACINE_GLOBAL_RELATIF ?>1-modules/gestion_directeur">Gestion des directeurs</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link <?php echo ($menu == 6) ? 'active' : '' ?> " href="<?php echo RACINE_GLOBAL_RELATIF ?>1-modules/gestion_type_note_de_frais">Gestion des types de NDF</a>
		      </li>
		    <?php } ?>
	    </ul>
	    <div class="my-2 my-lg-0">
	    	<?php if($_SESSION['id_grp_user'] == 2) {?>
	    		<a href="<?php echo RACINE_GLOBAL_RELATIF ?>1-modules/note_de_frais">
	    			<i class="fas fa-bell fa-lg">
	    				<small>
			    			<sup>
			    				<span class="badge badge-pill badge-light">{{ nbAttente }}</span>
			    			</sup>
	    				</small>
	    			</i>
	    		</a>
	    	<?php } ?>
	    	<?php if($_SESSION["id_grp_user"] != 1) {?>
	    		<a href="<?php echo RACINE_GLOBAL_RELATIF ?>1-modules/profil" data-toggle="tooltip" data-placement="bottom" title="Profil"><i class="fas fa-user fa-lg <?php echo ($menu == 4) ? 'text-white' : 'text-info' ?>"></i></a> &nbsp;
	    	<?php } ?>
	    	<a href="<?php echo RACINE_GLOBAL_RELATIF ?>1-modules/config_utilisateur" data-toggle="tooltip" data-placement="bottom" title="Changer le thème"><i class="fas fa-palette fa-lg <?php echo ($menu == 5) ? 'text-white' : 'text-secondary' ?>"></i></a>
	    	<a href="#" @click="Deconnexion" class="ml-2" data-toggle="tooltip" data-placement="bottom" title="Se déconnecter"><i class="fas fa-power-off text-danger fa-lg"></i></a>
	    </div>
	  </div>
	</nav>
<?php }

function Footer($path_supplementaire = '', $menu_present = 1){ ?>
	<?php $path_supplementaire = (isset($path_supplementaire) && !empty($path_supplementaire)) ? $path_supplementaire : ''; ?>
    <script>
    	RACINE_GLOBAL_RELATIF = '<?php echo RACINE_GLOBAL_RELATIF ?>';
    </script>
    <script src="<?php echo RACINE_GLOBAL_RELATIF ?>js/jquery-3.4.1.min.js"></script>
    <script src="<?php echo RACINE_GLOBAL_RELATIF ?>js/lodash.js"></script>
		<script src="<?php echo RACINE_GLOBAL_RELATIF ?>js/notify.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="<?php echo RACINE_GLOBAL_RELATIF ?>js/bootstrap.min.js"></script>
    <script src="<?php echo RACINE_GLOBAL_RELATIF ?>js/vue.min.js"></script>
    <?php if($menu_present == 1) {?>
    	<script src="<?php echo RACINE_GLOBAL_RELATIF ?>js/composants/menu/menu.comp.vue.js"></script>
  	<?php } ?>
    <script>
    	$(document).ready(function () {
			  $('[data-toggle="tooltip"]').tooltip()
			})
    </script>
    <?php if($path_supplementaire != '') {?>
    	<script src='<?php echo $path_supplementaire ?>'></script>
    <?php } ?>
  </body>
</html>
<?php }

function return_bytes($valeur){
	$valeur = trim($valeur);
	$dernier_char = strtolower($valeur[strlen($valeur)-1]);

	$valeur = substr($valeur, 0, (strlen($valeur)-1));
	switch ($dernier_char) {
		case 'g':
			$valeur *= 1024;
		break;

		case 'm':
			$valeur *= 1024;
		break;

		case 'k':
			$valeur *= 1024;
		break;
	}
	return $valeur;
}

function GetTailleMaxUpload(){
	//Taille max d'un upload
	$max_upload = return_bytes(ini_get('upload_max_filesize'));
	//Taille maximum d'un $_POST
	$max_post = return_bytes(ini_get('post_max_size'));
	//Limite mémoire
	$limite_memoire = return_bytes(ini_get('memory_limit'));

	return min($max_upload, $max_post, $limite_memoire)*1000;
}