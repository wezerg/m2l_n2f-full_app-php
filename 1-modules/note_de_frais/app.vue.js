var vue = new Vue({
    el: '#app',
    data:{
        liste_NDF:[],
        liste_type_NDF:[],
        liste_etat_NDF:[],
        recherche:'',
        ajout:{
            libelle:'',
            montant:0,
            id_type_note_de_frais:0,
        },
        valid:{},
        refus:{},
        path_image:'',
        rech_etat:0,
        recherche:'',
        rech_type:0,
        total_rembourse:0,

        ajout_en_cours:0,
    },
    mounted(){
        this.GetListeTypeNDF();
        this.GetListeEtatNDF();
        this.GetListeNDF();
    },
    computed:{
        liste_NDF_filtree(){
            var resTmp = [];
            if(this.rech_etat == 0) resTmp = this.liste_NDF;
            if(this.rech_etat > 0){
                for (let i = 0 ; i < this.liste_NDF.length ; i++){
                    if(this.liste_NDF[i].id_etat_note_de_frais == this.rech_etat) resTmp.push(this.liste_NDF[i]);
                }
            }

            var resTmp2 = [];
            if(this.rech_type == 0) resTmp2 = resTmp;
            if(this.rech_type > 0){
                for (let i = 0 ; i < resTmp.length ; i++){
                    if(resTmp[i].id_type_note_de_frais == this.rech_type) resTmp2.push(resTmp[i]);
                }
            }

            var resTmp3 = [];
            if(this.recherche == '') resTmp3 = resTmp2;
            if(this.recherche != ''){
                resTmp3 = resTmp2.filter(ndf => { 
                    let libelle = ndf.libelle.toLowerCase();
                    let recherche = this.recherche.toLowerCase().trim();

                    return libelle.indexOf(recherche) > -1;
                });
            }

            var total = 0;
            for(let i = 0 ; i < resTmp3.length ; i++){
                if(resTmp3[i].id_etat_note_de_frais == 2){
                    total += parseFloat(resTmp3[i].montant);
                }
            }
            this.total_rembourse = total;

            return resTmp3;
        }
    },
    methods:{
        GetListeTypeNDF:function(){
            var scope = this;

            $.ajax({
                url:"data.php?cas=liste_type_NDF",
                type:"POST",
                data:{},
                success:function(res){
                    scope.liste_type_NDF = JSON.parse(res);
                    setTimeout(function() {
                        $(document).ready(function () {
                          $('[data-toggle="tooltip"]').tooltip()
                        })
                    }, 50);
                },
                error:function(){
                }
            });
        },

        GetListeEtatNDF:function(){
            var scope = this;

            $.ajax({
                url:"data.php?cas=liste_etat_NDF",
                type:"POST",
                data:{},
                success:function(res){
                    scope.liste_etat_NDF = JSON.parse(res);
                },
                error:function(){
                }
            });
        },

        GetListeNDF:function(){
            var scope = this;
            $.ajax({
                url:'data.php?cas=liste_NDF',
                type:'POST',
                data:{},
                success:function(res){
                    scope.liste_NDF = JSON.parse(res);
                },
                error:function(){}
            });
        },

        OuvrirModalAjout:function(){
            this.ajout.libelle = '';
            this.ajout.montant = '';
			this.ajout.path_image = '';
			$('#modal_ajout').modal('show');
        },

        AjoutNote:function(){
            var scope = this;
            // $("#fileUploadForm").submit(function(e) {
            //     e.preventDefault();
            // });
            // A modifier, il faut trouver un moyen d'upload la photo
			var test = (scope.ajout.libelle == '' || scope.ajout.montant == '')
			if(test){
				Notify('info','Veuillez saisir les informations de connexion.');
				return;
            }
            scope.ajout_en_cours = 1;
            
            var form_data = new FormData();
            var img = $('#inputImg')[0].files[0];
            form_data.append('file',img);
            form_data.append('libelle',scope.ajout.libelle);
            form_data.append('montant',scope.ajout.montant);
            form_data.append('id_type_note_de_frais',scope.ajout.id_type_note_de_frais);

			$.ajax({
				url:"data.php?cas=ajout_note",
				type:"POST",
                processData: false,
                contentType: false,
				data:form_data,
				success:function(res){
                    if(res == -3) Notify('warning','Le fichier sélectionné est trop volumineux');
                    if(res == -2) Notify('warning','Type de fichier non-autorisé');
					if(res == -1) Notify('warning','Veuillez sélectionner un fichier');
                    if(res == 1){
                        Notify('success','N2F ajoutée');
                        scope.GetListeNDF();
                        $('#modal_ajout').modal('hide');
                        Menu.GetNbAttente();
                        scope.ajoutlibelle                = '';
                        scope.ajout.montant               = 0;
                        scope.ajout.id_type_note_de_frais = 0;
                    }
                    scope.ajout_en_cours = 0;
				},
				error:function(){
				}
			});
		},

        OuvrirModalValid:function(elem){
            this.valid = elem;
            $('#modal_valid').modal('show');
        },

        ValiderNDF:function(){
            var scope = this;

            $.ajax({
                url:"data.php?cas=valider_NDF",
                type:"POST",
                data:scope.valid,
                success:function(res){
                    Notify('success',`NDF ${scope.valid.libelle} Approuvée`);
                    scope.GetListeNDF();
                    scope.valid = {};
                    $('#modal_valid').modal('hide');
                    Menu.GetNbAttente();
                },
                error:function(){
                    Notify('danger','Contactez votre admin');
                }
            });
        },

        OuvrirModalRefus:function(elem){
            this.refus = JSON.parse(JSON.stringify(elem));
            $('#modal_refus').modal('show');
        },

        RefuserNDF:function(){
            var scope = this;
            $.ajax({
				url:"data.php?cas=refuser_NDF",
				type:"POST",
				data:scope.refus,
				success:function(res){
					Notify('success',`Note de frais "${scope.refus.libelle}" refusée`);
					scope.refus = {};
					scope.GetListeNDF();
					$('#modal_refus').modal('hide');
                    Menu.GetNbAttente();
				},
				error:function(){
                    Notify('danger','Veuillez prévenir votre administrateur de cette erreur');
				}
			});
        },

    },
})