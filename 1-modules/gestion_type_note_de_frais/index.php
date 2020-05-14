<?php include('../../0-config/config-genos.php');
if(empty($_SESSION) || $_SESSION['id_grp_user'] != 1) header('Location:'.RACINE_GLOBAL_RELATIF.'index.php');
?>
<?php Head("Gestion des types de NDF", 6);?>

<main id="app">
	<!-- Modal d'ajout -->
	<div class="modal fade" id="modal_ajout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-success">
	        <h5 class="modal-title">Ajouter un type de NDF</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="container-fluid">
	        	<div class="row">
	        		<div class="col">
	        			<label for="type_note_de_frais">Libellé : </label>
	        			<input type="text" id="type_note_de_frais" class="form-control form-control-sm" v-model="ajout.type_note_de_frais">
	        		</div>
	        	</div>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Fermer</button>
	        <div v-show="ajout_en_cours == 1" class="spinner-border text-primary" role="status">
					  <span class="sr-only">Ajout...</span>
					</div>
	        <button v-show="ajout.type_note_de_frais != '' && ajout_en_cours == 0" type="button" class="btn btn-sm btn-success" @click="AjouterTNDF">Ajouter</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Modal de modif -->
	<div class="modal fade" id="modal_modif" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Modifier <span class="titre-modifier">{{ modif.type_note_de_frais }}</span></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="container-fluid">
	        	<div class="row">
	        		<div class="col">
	        			<label for="modif_type_note_de_frais">Libellé : </label>
	        			<input type="text" id="modif_type_note_de_frais" class="form-control form-control-sm" v-model="modif.type_note_de_frais">
	        		</div>
	        	</div>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Fermer</button>
	        <button v-show="modif.type_note_de_frais != ''" type="button" class="btn btn-sm btn-success" @click="ModifierTNDF">Sauvegarder</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Modal de suppression -->
	<!-- <div class="modal fade" id="modal_suppr" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Supprimer <span class="titre-supprimer">{{ suppr.type_note_de_frais }}</span></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	<div class="container-fluid">
	      		<div class="row">
	      			<div class="col text-center">
	        			<p>Êtes-vous certain de vouloir supprimer ce type ?</p>
	      				
	      				<div class="row">
	      					<div class="col">
	      						<button class="btn btn-lg btn-success">OUI</button>
	      						<button class="btn btn-lg btn-danger" data-dismiss="modal">NON</button>
	      					</div>
	      				</div>
	      			</div>
	      		</div>
	      	</div>
	      </div>
	    </div>
	  </div>
	</div> -->

	<!-- Corps de l'application -->
	<div class="container mt-4">
		<div class="row text-center">
			<div class="col">
				<h2 class="titre-page">Gestion des types de note de frais</h2>
			</div>
		</div>

		<div class="row mt-4 mb-4">
			<div class="col bloc">
				<h3 class="mt-3">Gérer les types de note de frais</h3>
				<hr>
				<div class="input-group mt-2">
					<input type="search" class="form-control form-control-sm" placeholder="Rechercher un type" v-model="rech">
					<div class="input-group-append">
						<button class="btn btn-sm btn-primary"><i class="fas fa-search"></i> Rechercher</button>
					</div>
				</div>
				<button class="btn btn-sm btn-success mt-4" @click="OuvrirModalAjout"><i class="fas fa-plus"></i> Ajouter</button>

				<div class="table-responsive mt-4">
					<table class="table table-hover table-stripped">
						<thead class="thead-dark">
							<tr class="text-center">
								<th scope="col">#</th>
								<th scope="col">Libellé</th>
								<th>Modifier</th>
								<!-- <th>Supprimer</th> -->
							</tr>
						</thead>
						<tbody>
							<tr v-for="(type, index) in liste_filtree" class="text-center">
								<td>{{ index+1 }}</td>
								<td>{{ type.type_note_de_frais }}</td>
								<td><button class="btn btn-sm btn-warning" @click="OuvrirModalModif(type)"><i class="fas fa-edit"></i></button></td>
								<!-- <td><button class="btn btn-sm btn-danger" @click="OuvrirModalSuppr(type)"><i class="fas fa-trash"></i></button></td> -->
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>




</main>



<?php Footer('app.vue.js'); ?>