var vue = new Vue({
	el: '#app',
	data:{
		liste:[],
		rech:"",
		ajout:{
			type_note_de_frais:"",
		},
		modif:{},
		suppr:{},

		ajout_en_cours:0,
	},
	mounted(){
		this.GetListeTypeNDF();
	},
	computed:{
		liste_filtree(){
			var resTmp = [];

			if (this.rech == '') resTmp = this.liste;
			if (this.rech != '') {
				resTmp = this.liste.filter(typeNDF => typeNDF.type_note_de_frais.toLowerCase().indexOf(this.rech.trim().toLowerCase()) > -1);
			}
			
			return resTmp;
		},
	},
	methods:{
		GetListeTypeNDF:function(){
			var scope = this;

			$.ajax({
				url:"data.php?cas=liste_type_ndf",
				type:"POST",
				data:{},
				success:function(res){
					scope.liste = JSON.parse(res);
				},
				error:function(){
				}
			});
		},

		OuvrirModalAjout:function(){
			this.ajout.type_note_de_frais = "";
			$('#modal_ajout').modal('show');
		},

		AjouterTNDF:function(){
			var scope = this;
			if(scope.ajout.type_note_de_frais == ''){
				Notify('info', 'Veuillez saisir un libellé');
				return;
			}
			scope.ajout_en_cours = 1;

			$.ajax({
				url:"data.php?cas=ajout_tndf",
				type:"POST",
				data:scope.ajout,
				success:function(res){
					if(res == -1) Notify('warning', 'Ce type existe déjà');
					if(res == 0) Notify('danger','Erreur lors de l\'ajout');
					if(res == 1){
						scope.GetListeTypeNDF();
						Notify('success',`Le type ${scope.ajout.type_note_de_frais} a été ajouté avec succès`);
						$('#modal_ajout').modal('hide');
					}
					scope.ajout_en_cours = 0;
				},
				error:function(){
				}
			});
		},

		OuvrirModalModif:function(elem){
			this.modif = JSON.parse(JSON.stringify(elem));
			$("#modal_modif").modal('show');
		},

		ModifierTNDF:function(){
			var scope = this;

			$.ajax({
				url:"data.php?cas=modif_tndf",
				type:"POST",
				data:scope.modif,
				success:function(res){
					if(res == -1) Notify('danger','Ce type existe déjà');
					if(res == 0) $('#modal_modif').modal('hide');
					if(res == 1){
						scope.GetListeTypeNDF();
						Notify('success','Le type a bien été modifié');
						$('#modal_modif').modal('hide');
					}
				},
				error:function(){
				}
			});
		},

		// OuvrirModalSuppr:function(elem){
		// 	this.suppr = JSON.parse(JSON.stringify(elem));
		// 	$('#modal_suppr').modal('show');
		// },

		// SupprimerTNDF:function(){
		// 	var scope = this;

		// 	$.ajax({
		// 		url:"data.php?cas=suppr_tndf",
		// 		type:"POST",
		// 		data:scope.suppr,
		// 		success:function(res){
		// 			Notify('success',`Le type ${scope.suppr.type_note_de_frais} a bien été supprimé`);
		// 			$('#modal_suppr').modal('hide');
		// 		},
		// 		error:function(){
		// 		}
		// 	});
		// },
	},
})