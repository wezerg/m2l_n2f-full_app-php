var vue = new Vue({
	el: '#app',
	data:{
		liste_utilisateurs:[],
		recherche:'',
		ajout:{
			nom:'',
			prenom:'',
			login:'',
			password:'',
			vacataire:0,
			data_valide:null,
			id_groupe_utilisateur:2,
			id_ligue:0,
		},
		modif:{},
		suppr:{},
		ajout_en_cours:0,
	},
	mounted(){
		this.GetListeUtilisateur();
	},
	computed:{
		liste_utilisateur_filtree(){
			var resTmp = [];

			if (this.recherche == '') resTmp = this.liste_utilisateurs;
			if (this.recherche != '') {
				resTmp = this.liste_utilisateurs.filter( utilisateur => {
					let recherche = this.recherche.toLowerCase().trim();
					let nom = utilisateur.nom.toLowerCase();
					let prenom = utilisateur.prenom.toLowerCase();
					let ligue = utilisateur.ligue.toLowerCase();

					return nom.indexOf(recherche) > -1 || ligue.indexOf(recherche) > -1 || prenom.indexOf(recherche) > -1;
				})
			}
				return resTmp;
		},
	},
	methods:{
		GetListeUtilisateur:function(){
			var scope = this;

			$.ajax({
				url:"data.php?cas=liste_utilisateurs",
				type:"POST",
				data:{},
				success:function(res){
					scope.liste_utilisateurs = JSON.parse(res);
				},
				error:function(){}
			});
		},

		OuvrirModalAjout:function(){
			this.ajout.nom = '';
			this.ajout.prenom = '';
			this.ajout.login = '';
			this.ajout.password = '';
			$('#modal_ajout').modal('show');
		},

		AjoutDirecteur:function(){
			var scope = this;
			var test = (scope.ajout.nom == '' || scope.ajout.prenom == '' || scope.ajout.login == '' || scope.ajout.password == '')
			if(test){
				Notify('info','Veuillez saisir les informations de connexion.');
				return;
			}
			scope.ajout_en_cours = 1;

			$.ajax({
				url:"data.php?cas=ajout_directeur",
				type:"POST",
				data:scope.ajout,
				success:function(res){
					if(res == -2) Notify('info','Veuillez saisir les informations de connexion');
					if(res == -1) Notify('warning','Ce login est déjà attribué');
					if(res == 1){
						Notify('success',`Le directeur ${scope.ajout.nom+" "+scope.ajout.prenom} a été crée`);
						scope.ajout.nom = '';
						scope.ajout.prenom = '';
						scope.ajout.login = '';
						scope.ajout.password = '';
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

		ModifierDirecteur:function(){
			var scope = this;
			if(scope.modif.nom == '' || scope.modif.prenom == ''){
				Notify('danger','Vous ne pouvez pas supprimer le nom ou le prénom d\'un directeur');
				return;
			}

			$.ajax({
				url:"data.php?cas=modif_directeur",
				type:"POST",
				data:scope.modif,
				success:function(res){
					Notify('success',`Directeur "${scope.modif.nom+" "+scope.modif.prenom}" modifié`);
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

		SupprimerDirecteur:function(){
			var scope = this;

			$.ajax({
				url:"data.php?cas=suppr_directeur",
				type:"POST",
				data:scope.suppr,
				success:function(res){
					Notify('success',`Le directeur ${scope.suppr.nom+" "+scope.suppr.prenom} a été suprimé`);
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