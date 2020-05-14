<?php include('../../0-config/config-genos.php'); 
$test_validitee = (empty($_SESSION) || $_SESSION['id_grp_user'] != 2 || $_SESSION['id_ligue'] == 0);
if($test_validitee) header('Location:'.RACINE_GLOBAL_RELATIF.'index.php');
?>
<?php Head('Gestion des ligues', 3); ?>
	<main id="app">
		<!-- Modal d'ajout de ligue -->
		<div class="modal fade" id="modal_ajout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Créer un utilisateur</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <div class="container-fluid">
		        	<div class="row">
		        		<div class="col">
		        			<label for="nom">Nom <sup class="text-danger">*</sup> : </label>
		        			<input type="text" class="form-control form-control-sm" id="nom" v-model="ajout.nom" :placeholder="'Nom du '+[(ajout.vacataire == 0) ? 'salarié' : 'vacataire']" maxlength="50">
		        		</div>
		        		<div class="col">
		        			<label for="prenom">Prénom <sup class="text-danger">*</sup> : </label>
		        			<input type="text" class="form-control form-control-sm" id="prenom" v-model="ajout.prenom" :placeholder="'Prénom du '+[(ajout.vacataire == 0) ? 'salarié' : 'vacataire']" maxlength="50">
		        		</div>
		        	</div>

		        	<div class="row mt-3">
		        		<div class="col">
		        			<label for="login">Login <sup class="text-danger">*</sup> : </label>
		        			<input type="text" class="form-control form-control-sm" id="login" v-model="ajout.login" placeholder="Identifiant de connexion" maxlength="50">
		        			<div class="ml-1">
		        				<small v-show="verif_dispo_login == 0">Veuillez saisir un login</small>
		        				<small v-show="verif_dispo_login == -1" class="text-danger">Ce login n'est pas disponible</small>
		        				<small v-show="verif_dispo_login == 1" class="text-success">Ce login est disponible</small>
		        			</div>
		        		</div>
		        		<div class="col">
		        			<label for="password">Mot de passe <sup class="text-danger">*</sup> : </label>
		        			<input type="password" class="form-control form-control-sm" id="password" v-model="ajout.password" placeholder="Mot de passe de connexion">
		        		</div>
		        	</div>

		        	<div class="row">
		        		<div class="col mt-5">									
									<div class="text-center">
										<div class="btn-group">
											<button :class="'btn btn-sm '+[(ajout.vacataire == 0) ? 'btn-primary' : 'btn-outline-primary']" @click="ChangerValeurVacataire(0, 'crea')">
												Salarié
											</button>
											<button :class="'btn btn-sm '+[(ajout.vacataire == 1) ? 'btn-primary' : 'btn-outline-primary']" @click="ChangerValeurVacataire(1, 'crea')">
												Vacataire
											</button>
										</div>
									</div>
		        		</div>
		        		<div class="col">									
									<div v-show="ajout.vacataire == 1">
		        				<label for="" class="mt-3">Date limite de validité du compte : </label>
										<input type="date" v-model="ajout.date_validite" class="form-control form-control-sm">
									</div>
		        		</div>
		        	</div>

		        	<div class="row mt-3">
		        		<div class="col">
		        			<div v-if="verif_dispo_login == 1 && ajout.nom != '' && ajout.prenom != '' && ajout.password != ''" class="alert alert-success">
		        				Vous pouvez ajouter cet utilisateur
		        			</div>
		        			<div v-else class="alert alert-danger">
		        				Les champs marqués d'un <sup class="text-danger">*</sup> sont obligatoires.
		        			</div>
		        		</div>
		        	</div>
		        </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Annuler</button>
		        <div v-if="ajout_en_cours == 0">
		        	<button v-show="verif_dispo_login == 1 && ajout.nom != '' && ajout.prenom != '' && ajout.password != ''" type="button" class="btn btn-sm btn-success" @click="AjouterUtilisateur">Ajouter</button>
		        </div>
		        <div v-else class="spinner-border text-primary" role="status">
						  <span class="sr-only">Ajout...</span>
						</div>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Modal de modification d'une ligue -->
		<div class="modal fade" id="modal_modif" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Modifier <span class="titre-modifier">{{ modif.prenom+' '+modif.nom }}</span></h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
						<div class="container-fluid">
		        	<div class="row">
		        		<div class="col">
		        			<label for="nom">Nom <sup class="text-danger">*</sup> : </label>
		        			<input type="text" class="form-control form-control-sm" id="modif_nom" v-model="modif.nom" placeholder="Nom du salarié" maxlength="50">
		        		</div>
		        		<div class="col">
		        			<label for="prenom">Prénom <sup class="text-danger">*</sup> : </label>
		        			<input type="text" class="form-control form-control-sm" id="modif_prenom" v-model="modif.prenom" placeholder="Prénom du salarié" maxlength="50">									
		        		</div>
		        	</div>

		        	<div class="row">
		        		<div class="col">
		        			<label for="login" class="mt-3">Login <sup class="text-danger">*</sup> : </label>
		        			<input type="text" class="form-control form-control-sm" id="modif_login" v-model="modif.login" placeholder="Identifiant de connexion" readonly>
		        		</div>
		        	</div>

		        	<div v-show="modif.vacataire == 1" class="row">
		        		<div class="col">
									<div class="text-center mt-5">
										<div class="btn-group">
											<button :class="'btn btn-sm '+[(modif.vacataire == 0) ? 'btn-primary' : 'btn-outline-primary']" @click="ChangerValeurVacataire(0,'modif')">
												Salarié
											</button>
											<button :class="'btn btn-sm '+[(modif.vacataire == 1) ? 'btn-primary' : 'btn-outline-primary']" @click="ChangerValeurVacataire(1,'modif')">
												Vacataire
											</button>
										</div>
									</div>
		        		</div>
		        		<div class="col">
									<div v-show="modif.vacataire == 1">
		        				<label for="" class="mt-3">Date limite de validité du compte : </label>
										<input type="date" v-model="modif.date_validite" class="form-control form-control-sm">
									</div>
		        		</div>
		        	</div>
		        </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Annuler</button>
		        <button type="button" class="btn btn-sm btn-success" @click="ModifierUtilisateur">Sauvegarder</button>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Modal de suppression d'une ligue -->
		<div class="modal fade" id="modal_suppr" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Supprimer <span class="titre-supprimer">{{ suppr.prenom+' '+suppr.nom }}</span></h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	<div class="container-fluid">
		      		<div class="row">
		      			<div class="col text-center">
		        			<p>Êtes-vous certain de vouloir supprimer cet utilisateur ?</p>
		      				
		      				<div class="row">
		      					<div class="col">
		      						<button class="btn btn-lg btn-success" @click="SupprimerUtilisateur">OUI</button>
		      						<button class="btn btn-lg btn-danger" data-dismiss="modal">NON</button>
		      					</div>
		      				</div>
		      			</div>
		      		</div>
		      	</div>
		      </div>
		    </div>
		  </div>
		</div>

		<div class="container mt-4">
			<div class="row text-center">
				<div class="col">
					<h2 class="titre-page">Gestion des salariés</h2>
				</div>
			</div>
			<!-- <div class="row">
				<div class="col separation"></div>
			</div> -->
			<div class="row mt-4">
				<div class="col bloc">
					<h3 class="mt-3">Gestion des salariés de <span class="text-primary"><?php echo $_SESSION['nom_ligue'] ?></span></h3>
					<hr>
					<div class="input-group mt-2">
						<input type="search" class="form-control form-control-sm" placeholder="Recherche un salarié/vacataire" v-model='recherche'>
						<div class="input-group-append">
							<button class="btn btn-sm btn-primary"><i class="fas fa-search"></i> Rechercher</button>
						</div>
					</div>

					<button class="btn btn-sm btn-success mt-4" @click="OuvrirModalAjout"><i class="fas fa-plus"></i> Ajouter</button>
					
					<div class="text-right mt-4">
						<span class="text-warning"><i class="fas fa-business-time"></i></span> Vacataire | 
						<span class="text-warning"><i class="fas fa-user"></i></span> Salarié
					</div>
					<div class="table-responsive">
					  <table class="table table-hover table-striped">
					    <thead class="thead-dark">
					    	<tr class="text-center">
					    		<th scope="col">#</th>
					    		<th scope="col"></th>
					    		<th scope="col">Identité</th>
					    		<th scope="col">Ligue</th>
					    		<th>Modifier</th>
					    		<th>Supprimer</th>
					    	</tr>
					    </thead>
					    <tbody>
					    	<tr v-for="(u, index) in liste_salaries_triee" class="text-center">
					    		<td>{{ index+1 }}</td>
					    		<td>
					    			<i :class="'fas text-warning fa-lg '+[(u.vacataire == 1) ? 'fa-business-time' : 'fa-user']" data-toggle="tooltip" :title="[(u.vacataire == 1) ? 'Vacataire' : 'Salarié']"></i>
					    		</td>
					    		<td>{{ u.prenom+' '+u.nom }}</td>
					    		<td>{{ u.ligue }}</td>
					    		<td><button class="btn btn-sm btn-warning" @click="OuvrirModalModif(u)"><i class="fas fa-edit"></i></button></td>
					    		<td><button class="btn btn-sm btn-danger" @click="OuvrirModalSuppr(u)"><i class="fas fa-trash"></i></button></td>
					    	</tr>
					    </tbody>
					  </table>
					</div>
				</div>
			</div>
		</div>
	</main>
<?php Footer('app.vue.js'); ?>