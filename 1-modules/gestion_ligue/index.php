<?php include('../../0-config/config-genos.php'); 
if(empty($_SESSION) || $_SESSION['id_grp_user'] != 1) header('Location:'.RACINE_GLOBAL_RELATIF.'index.php');
?>
<?php Head('Gestion des ligues', 2); ?>
	<main id="app">
		<!-- Modal d'ajout de ligue -->
		<div class="modal fade" id="modal_ajout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Ajouter une ligue</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <div class="container-fluid">
		        	<div class="row">
		        		<div class="col">
		        			<label for="">Nom de la ligue</label>
		        			<input type="text" class="form-control form-control-sm" v-model="ajout.nom" maxlength="50">

		        			<label class="mt-3" for="select_directeur_ajout">Directeur : </label>
		        			<select name="select_directeur_ajout" id="select_directeur_ajout" class="custom-select custom-select-sm" v-model="ajout.id_utilisateur">
		        				<option value="0">Sélectionner un directeur <small>(optionnel)</small></option>
		        				<option v-for="directeur in liste_utilisateurs" :value="directeur.id">
		        					{{ directeur.identite }} | 
		        					<small>
		        						{{ (directeur.ligue == '') ? 'Non affecté' : 'Affecté à "'+directeur.ligue+'"' }}
		        					</small>
		        				</option>
		        			</select>
		        		</div>
		        	</div>
		        </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Annuler</button>
		        <div v-if="ajout_en_cours == 0">
		        	<button v-show="ajout.nom != ''" type="button" class="btn btn-sm btn-success" @click="AjoutLigue">Ajouter</button>
		        </div>
		        <div v-else class="spinner-border text-primary" role="status">
						  <span class="sr-only">Loading...</span>
						</div>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Modal de modification d'une ligue -->
		<div class="modal fade" id="modal_modif" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Modifier <span class="titre-modifier">{{ modif.nom }}</span></h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <div class="container-fluid">
		        	<div class="row">
		        		<div class="col">
		        			<label for="">Nom de la ligue</label>
		        			<input type="text" class="form-control form-control-sm" v-model="modif.nom" maxlength="50">

		        			<label class="mt-3" for="select_directeur_modif">Directeur : </label>
		        			<select name="select_directeur_modif" id="select_directeur_modif" class="custom-select custom-select-sm" v-model="modif.id_utilisateur">
		        				<option value="0">Sélectionner un directeur <small>(optionnel)</small></option>
		        				<option v-for="directeur in liste_utilisateurs" :value="directeur.id">
		        					{{ directeur.identite }} | 
		        					<small>
		        						{{ (directeur.ligue == '') ? 'Non affecté' : 'Affecté à "'+directeur.ligue+'"' }}
		        					</small>
		        				</option>
		        			</select>
		        		</div>
		        	</div>
		        </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Annuler</button>
		        <button type="button" class="btn btn-sm btn-success" @click="ModifierLigue">Sauvegarder</button>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Modal de suppression d'une ligue -->
		<div class="modal fade" id="modal_suppr" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Supprimer <span class="titre-supprimer">{{ suppr.nom }}</span></h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	<div class="container-fluid">
		      		<div class="row">
		      			<div class="col text-center">
		        			<p>Êtes-vous certain de vouloir supprimer cette ligue ?</p>
		      				
		      				<div class="row">
		      					<div class="col">
		      						<button class="btn btn-lg btn-success" @click="SupprimerLigue">OUI</button>
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
					<h2 class="titre-page">Gestion des ligues</h2>
				</div>
			</div>
			<!-- <div class="row">
				<div class="col separation"></div>
			</div> -->
			<div class="row mt-4 mb-4">
				<div class="col bloc">
					<h3 class="mt-3">Gérer les ligues de la M2L</h3>
					<hr>
					<div class="input-group mt-2">
						<input type="search" class="form-control form-control-sm" placeholder="Recherche une ligue" v-model='recherche'>
						<div class="input-group-append">
							<button class="btn btn-sm btn-primary"><i class="fas fa-search"></i> Rechercher</button>
						</div>
					</div>

					<button class="btn btn-sm btn-success mt-4" @click="OuvrirModalAjout"><i class="fas fa-plus"></i> Ajouter</button>

					<div class="table-responsive mt-4">
					  <table class="table table-hover table-striped">
					    <thead class="thead-dark">
					    	<tr class="text-center">
					    		<th scope="col">#</th>
					    		<th scope="col">Ligue</th>
					    		<th scope="col">Directeur</th>
					    		<th>Modifier</th>
					    		<th>Supprimer</th>
					    	</tr>
					    </thead>
					    <tbody>
					    	<tr v-for="(ligue, index) in liste_ligue_filtree" class="text-center">
					    		<td>{{ index+1 }}</td>
					    		<td>{{ ligue.nom }}</td>
					    		<td>{{ ligue.directeur }}</td>
					    		<td><button class="btn btn-sm btn-warning" @click="OuvrirModalModif(ligue)"><i class="fas fa-edit"></i></button></td>
					    		<td><button class="btn btn-sm btn-danger" @click="OuvrirModalSuppr(ligue)"><i class="fas fa-trash"></i></button></td>
					    	</tr>
					    </tbody>
					  </table>
					</div>
				</div>
			</div>
		</div>
		
	</main>

<?php Footer('app.vue.js'); ?>