<!-- Appel du fichier de config Genos ainsi que de la fonctio header + sécurité pour empécher l'admin d'accéder a cette page -->
<?php include('../../0-config/config-genos.php');
if(empty($_SESSION) || $_SESSION['id_grp_user'] == 1) header('Location:'.RACINE_GLOBAL_RELATIF.'index.php');
Head("Gestion des notes de frais", 2);
?>
<main id="app" v-cloak>
  <!-- Modals ajout note de frais -->
  <div class="modal fade" id="modal_ajout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ajouter une note de frais</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- Corps du modal d'ajout -->
        <form method="POST" enctype="multipart/form-data" id="fileUploadForm" @submit.prevent="onSubmit">
          <div class="modal-body">
           <div class="container-fluid">
            <div class="row">
             <div class="col">

              <label for="libelle" class="mt-3">Libelle de la note de frais</label>
              <input type="text" class="form-control form-control-sm" id="libelle" v-model="ajout.libelle" maxlength="50">

              <label for="montant" class="mt-3">Montant de la note de frais</label>
              <input type="number" class="form-control form-control-sm" id="montant" v-model="ajout.montant">

              <label for="libelle" class="mt-3">Type</label>
              <select id="select-type-ndf" class="custom-select custom-select-sm" v-model="ajout.id_type_note_de_frais">
                <option value="0">Sélectionner un type</option>
                <option v-for="t in liste_type_NDF" :value="t.id">{{ t.type_note_de_frais }}</option>
              </select>

              <label for="inputImg" class="mt-3">Image justificative</label>
              <input type="file" id="inputImg" class="form-control form-control-sm">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Annuler</button>
        <div v-if="ajout_en_cours == 0">
          <button v-show="ajout.libelle != '' && (ajout.montant != '' && ajout.montant > 0) && ajout.id_type_note_de_frais > 0" type="submit" class="btn btn-sm btn-success" @click="AjoutNote">Ajouter</button>
        </div>
        <div v-else class="spinner-border text-primary" role="status">
          <span class="sr-only">Ajout...</span>
        </div>
      </div>
    </form>
  </div>
</div>
</div>

<!-- Modals refus note de frais -->
<div class="modal fade" id="modal_refus" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Raison du refus <small class="text-info">{{ refus.libelle }}</small></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Corps du modal de refus -->
      <div class="modal-body">
        <div class="container-fluid">
         <div class="row">
          <div class="col">
            <label for="">Commentaire de refus</label>
            <input type="text" class="form-control form-control-sm" v-model="refus.commentaire" maxlength="50">
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Annuler</button>
      <button v-if="refus.commentaire != ''" type="bouton" class="btn btn-sm btn-success" @click="RefuserNDF">Refuser</button>
      <button v-else type="bouton" class="btn btn-sm btn-light" style="cursor: not-allowed;">Refuser</button>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="modal_valid" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row text-center">
            <div class="col">
              <p>Êtes-vous certain de vouloir valider "<span class="text-info">{{ valid.libelle }}</span>" ?</p>

              <div class="row text-center">
                <div class="col">
                  <button class="btn btn-lg btn-success" @click="ValiderNDF">OUI</button>
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

<!-- Titre de l'application -->
<!-- Corps de l'appli -->
<div class="container mt-4">
  <div class="row text-center">
    <div class="col">
      <h2 class="titre-page">Gestion <?php echo ($_SESSION['id_grp_user'] == 2) ? 'des' : 'de mes' ?> notes de frais</h2>
    </div>
  </div>
  <!-- Barre de recherche + liste déroulante -->
  <div class="row mt-4">
    <div class="col bloc">
      <h3 class="mt-3">Gérer <?php echo ($_SESSION['id_grp_user'] == 2) ? 'les' : 'mes'?> notes de frais</h3>
      <hr>
      <div class="btn-toolbar mt-2 justify-content-between">
        <div class="input-group">
          <div class="input-group-prepend">
            <button class="btn btn-sm btn-primary">Etat</button>
          </div>
          <select class="custom-select custom-select-sm" v-model="rech_etat">
            <option value="0">Tous</option>
            <option v-for="e in liste_etat_NDF" :value="e.id">{{ e.etat_note_de_frais }}</option>
          </select>
        </div>
        
        <div class="input-group">
          <input type="search" class="form-control form-control-sm" placeholder="Rechercher une N2F" v-model="recherche">
        </div>

        <div class="input-group">
          <select class="custom-select custom-select-sm" v-model="rech_type">
            <option value="0">Tous</option>
            <option v-for="t in liste_type_NDF" :value="t.id">{{ t.type_note_de_frais }}</option>
          </select>
          <div class="input-group-append">
            <button class="btn btn-sm btn-primary">Type</button>
          </div>
        </div>
        
      </div>
      <!-- Dans la grille de donnée on met en forme pour différencier les directeurs des salariés -->
      <?php if ($_SESSION['id_grp_user'] == 3) {?>
        <button class="btn btn-sm btn-success mt-4" @click="OuvrirModalAjout"><i class="fas fa-plus"></i> Ajouter</button>
      <?php }?>
      
      <div class="text-right mt-4">
        <i class="fas fa-hourglass-half fa-lg text-warning"></i> En attente | 
        <i class="fas fa-check fa-lg text-success"></i> Acceptée | 
        <i class="fas fa-ban fa-lg text-danger"></i> Refusée 
      </div>
      <div class="table-responsive">
        <table class="table table-hover table-stripped">
          <thead class="thead-dark">
            <tr class="text-center">
              <th scope="col">#</th>
              <?php if ($_SESSION['id_grp_user'] == 2){?>
                <th scope="col">Identité</th>
              <?php } ?>
              <th scope="col">Type</th>
              <th scope="col">Libellé</th>
              <th scope="col">Montant</th>
              <th scope="col">Image</th>
              <th scope="col">Statut</th>
              <?php 
              if ($_SESSION['id_grp_user'] == 2) {?>
                <th>Valider</th>
                <th>Refuser</th>
              <?php }?>
              <th scope="col">Commentaire</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(note_de_frais, index) in liste_NDF_filtree" class="text-center">
              <td>{{ index+1 }}</td>
              <?php if ($_SESSION['id_grp_user'] == 2){?>
                <td>{{ note_de_frais.nom+' '+note_de_frais.prenom }}</td>
              <?php } ?>
              <td>{{ note_de_frais.type }}</td>
              <td>{{ note_de_frais.libelle }}</td>
              <td>{{ note_de_frais.montant }} €</td>
              <td>
                <a v-if="note_de_frais.path_image != ''" class="btn btn-sm btn-info" :href="'<?php echo RACINE_GLOBAL_RELATIF ?>DATAS/'+note_de_frais.id_utilisateur+'/'+note_de_frais.path_image" target="_blank">
                  <i class="far fa-image"></i>
                </a>
              </td>
              <td>
                <i v-if="note_de_frais.id_etat_note_de_frais == 1" class="fas fa-hourglass-half fa-lg text-warning" data-toggle="tooltip" title="En attente"></i>
                <i v-else-if="note_de_frais.id_etat_note_de_frais == 2" class="fas fa-check fa-lg text-success" data-toggle="tooltip" title="Acceptée"></i>
                <i v-else class="fas fa-ban fa-lg text-danger" data-toggle="tooltip" title="Refusée"></i>
              </td>
              <?php if ($_SESSION['id_grp_user'] == 2 ) {?>
                <td>
                  <button v-if="note_de_frais.id_etat_note_de_frais == 1" class="btn btn-sm btn-success" @click="OuvrirModalValid(note_de_frais)">
                    <i class="fas fa-check"></i>
                  </button>
                </td>
                <td>
                  <button v-if="note_de_frais.id_etat_note_de_frais == 1" class="btn btn-sm btn-danger" @click="OuvrirModalRefus(note_de_frais)"><i class="fas fa-ban"></i></button>
                </td>
              <?php }?>
              <td>
                <span v-show="note_de_frais.id_etat_note_de_frais == 3" data-toggle="tooltip" data-placement="bottom" :title="note_de_frais.commentaire" style="cursor: pointer;">
                  <i class="fas fa-comment"></i>
                </span>
              </td>
            </tr>
            <tr class="bg-dark text-white">
              <td colspan="<?php echo ($_SESSION['id_grp_user'] == 2) ? '4' : '3' ?>" class="text-right"><b>TOTAL REMBOURSE</b></td>
              <td class="text-right"><b>{{ total_rembourse }}</b></td>
              <td colspan="<?php echo ($_SESSION['id_grp_user'] == 2) ? '5' : '3' ?>" class="text-left"><b>€</b></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <br>
</div>
</main>
<?php Footer('app.vue.js');?>