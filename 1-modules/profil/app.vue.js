const profil = new Vue({
	el:'#app',
	data:{
		elem:{},
	},
	mounted(){
		var id = $('#hidden_id').val();
		this.GetElem(id);
	},
	methods:{
		GetElem:function(id){
			var scope = this;

			$.ajax({
				url:"data.php?cas=getElem",
				type:"POST",
				data:{id},
				success:function(res){
					scope.elem = JSON.parse(res);
				},
				error:function(){
				}
			});
		},

		OuvrirModalModif:function(){
			$('#modal_modif').modal('show');
		},

		ModifierProfil:function(){
			var scope = this;
			if(scope.elem.nom == '' || scope.elem.prenom == ''){
				Notify('warning','Vous ne pouvez pas effacer ces informations');
				return;
			}

			$.ajax({
				url:"data.php?cas=modif",
				type:"POST",
				data:scope.elem,
				success:function(res){
					Notify('success','Votre profil vient d\'être modifié');
					$('#modal_modif').modal('hide');
				},
				error:function(){
					Notify('danger','Erreur, contactez votre administrateur');
				}
			});
		},
	},
})