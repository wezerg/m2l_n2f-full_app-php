var vue = new Vue({
	el: '#app',
	data:{
		liste_ligues:[],
		liste_utilisateurs:[],
		recherche:'',
		ajout:{
			nom:'',
			id_utilisateur:0,
		},
		modif:{},
		suppr:{},
		ajout_en_cours: 0,
	},
	mounted(){
		this.GetListeLigue();
		this.GetListeUtilisateur();
	},
	computed:{
		liste_ligue_filtree(){
			var resTmp = [];

			if(this.recherche == '') resTmp = this.liste_ligues;
			if(this.recherche != ''){
				resTmp = this.liste_ligues.filter( ligue => { 
					let recherche = this.recherche.toLowerCase();
					let nom = ligue.nom.toLowerCase();
					let directeur = ligue.directeur.toLowerCase();

					return nom.indexOf(recherche) > -1 || directeur.indexOf(recherche) > -1;
				});
			}

			return resTmp;
		},
	},
	methods:{
		GetListeLigue:function(){
			var scope = this;

			$.ajax({
				url:"data.php?cas=liste_ligues",
				type:"POST",
				data:{},
				success:function(res){
					scope.liste_ligues = JSON.parse(res);
				},
				error:function(){
				}
			});
		},

		OuvrirModalAjout:function(){
			this.ajout.nom = '';
			this.ajout.id_utilisateur = 0;
			$('#modal_ajout').modal('show');
		},

		GetListeUtilisateur:function(){
			var scope = this;

			$.ajax({
				url:"data.php?cas=liste_utilisateurs",
				type:"POST",
				data:{},
				success:function(res){
					scope.liste_utilisateurs = JSON.parse(res);
				},
				error:function(){
				}
			});
		},

		AjoutLigue:function(){
			var scope = this;

			if(scope.ajout.nom == ''){
				Notify('info','Veuillez saisir un nom');
				return;
			}
			scope.ajout_en_cours = 1;

			$.ajax({
				url:"data.php?cas=ajout_ligue",
				type:"POST",
				data:scope.ajout,
				success:function(res){
					if(res == -2) Notify('info','Veuillez saisir un nom');
					if(res == -1) Notify('warning','Ce nom est déjà attribué');
					if(res == 1){
						Notify('success',`La ligue ${scope.ajout.nom} a été crée`);
						// Notify('success','La ligue '+scope.ajout.nom+' a été crée');
						scope.ajout.nom = '';
						scope.ajout.id_utilisateur = 0;
						scope.GetListeLigue();
						$('#modal_ajout').modal('hide');
						scope.GetListeUtilisateur();
					}
					scope.ajout_en_cours = 0;
				},
				error:function(){
				}
			});
		},

		OuvrirModalModif:function(elem){
			this.modif = JSON.parse(JSON.stringify(elem));
			$('#modal_modif').modal('show');
		},

		ModifierLigue:function(){
			var scope = this;
			if(scope.modif.nom == ''){
				Notify('danger','Vous ne pouvez pas supprimer le nom d\'une ligue');
				return;
			}

			$.ajax({
				url:"data.php?cas=modif_ligue",
				type:"POST",
				data:scope.modif,
				success:function(res){
					Notify('success',`Ligue "${scope.modif.nom}" modifiée`);
					scope.GetListeLigue();
					$('#modal_modif').modal('hide');
					scope.GetListeUtilisateur();
					scope.modif = {};
				},
				error:function(){
				}
			});
		},

		OuvrirModalSuppr:function(elem){
			this.suppr = JSON.parse(JSON.stringify(elem));
			$('#modal_suppr').modal('show');
		},

		SupprimerLigue:function(){
			var scope = this;

			$.ajax({
				url:"data.php?cas=suppr_ligue",
				type:"POST",
				data:scope.suppr,
				success:function(res){
					Notify('success',`La ligue ${scope.suppr.nom} a été suprimée`);
					scope.GetListeLigue();
					$('#modal_suppr').modal('hide');
					scope.GetListeUtilisateur();
					scope.suppr = {};
				},
				error:function(){
				}
			});
		},
	},
})