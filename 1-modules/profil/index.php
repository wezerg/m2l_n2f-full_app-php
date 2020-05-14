<?php include('../../0-config/config-genos.php'); 
if(empty($_SESSION) || $_SESSION['id_grp_user'] == 1) header('Location:'.RACINE_GLOBAL_RELATIF.'index.php');
?>
<?php Head('Mon profil', 4) ?>
<?php 
	$u = new utilisateur;
	$u->id = $_SESSION['id_user'];
	$u->Load();
?>
	<main id="app">
		<!-- Modal de modification -->
		<div class="modal fade" id="modal_modif" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Modifier votre profil</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <div class="container-fluid text-center">
		        	<div class="row">
		        		<div class="col">
		        			<h3>Êtes-vous certain de vouloir modifier votre profil ?</h3>
		        		</div>
		        	</div>

		        	<div class="row mt-3">
		        		<div class="col">
		        			<button class="btn btn-lg btn-success" @click="ModifierProfil">OUI</button>
		        			<button class="btn btn-lg btn-danger" data-dismiss="modal">NON</button>
		        		</div>
		        	</div>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>

		<input type="hidden" value="<?php echo $_SESSION['id_user'] ?>" id="hidden_id">
		<div class="container mt-4">
			<div class="row text-center">
				<div class="col">
					<h2 class="titre-page">Mon profil</h2>
				</div>
			</div>

			<div class="row mt-4">
				<div class="col bloc">
					<div class="row mt-3">
						<div class="col">
							<h3>Gérer mon profil</h3>
						</div>
					</div>
					<hr>

					<div class="row">
						<div class="col-md mt-3">
							<label for="groupe_user">Groupe : </label>
							<input type="text" id="groupe_user" class="form-control form-control-sm" readonly v-model="elem.groupe_utilisateur">

							<label for="nom" class="mt-3">Nom : </label>
							<input type="text" id="nom" class="form-control form-control-sm" v-model="elem.nom" maxlength="50">

							<label for="login" class="mt-3">Login : </label>
							<input type="text" id="login" class="form-control form-control-sm" v-model="elem.login" readonly>
						</div>

						<div class="col-md mt-3">
							<label for="ligue">Ligue : </label>
							<input type="text" id="ligue" class="form-control form-control-sm" v-model="elem.ligue" readonly>

							<label for="prenom" class="mt-3">Prénom : </label>
							<input type="text" id="prenom" class="form-control form-control-sm" v-model="elem.prenom" maxlength="50">

							<label for="password" class="mt-3">Mot de passe : </label>
							<input type="password" id="password" class="form-control form-control-sm" value="tusauraspascestcrypté" readonly>
						</div>
					</div>

					<div class="row mt-3 text-center">
						<div class="col">
							<div class="alert alert-info">
								<?php if($_SESSION['id_grp_user'] == 2) {?>
									Directeur pendant une durée indeterminée de la ligue : "<?php echo $_SESSION['nom_ligue']; ?>".
								<?php } ?>
								<?php if($_SESSION['id_grp_user'] == 3) {
									if($u->vacataire == 1) {?>
										Vacataire pour la ligue "<?php echo $_SESSION['nom_ligue'] ?>". <br> Compte actif jusqu'au <b><?php echo date_format(date_create($u->date_validite),'d/m/Y'); ?></b>.
								<?php } ?>
								<?php if ($u->vacataire == 0) {?>
									Salarié à durée indéterminée de la ligue : "<?php echo $_SESSION['nom_ligue'] ?>".
								<?php }
								} ?>
							</div>
						</div>
					</div>

					<hr>

					<div class="row text-right">
						<div class="col">
							<button class="btn btn-success btn-sm mb-2" @click="OuvrirModalModif">Modifier</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

<?php Footer('app.vue.js'); ?>