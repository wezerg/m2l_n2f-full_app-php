var Menu = new Vue({
	el:'#menu',
	data:{
		nbAttente:0,
	},
	mounted(){
		var type_agent = $('#type-agent').val();
		if(type_agent === 'manager') this.GetNbAttente();
	},
	methods:{
		Deconnexion:function(){
			var scope = this;

			$.ajax({
				url:RACINE_GLOBAL_RELATIF+"js/composants/menu/data.php?cas=deconnexion",
				type:"POST",
				datas:{},
				success:function(data){
					window.location.href = RACINE_GLOBAL_RELATIF+"login.php";
				},
				error:function(){
				}
			});
		},

		GetNbAttente:function(){
			var scope = this;

			$.ajax({
				url:RACINE_GLOBAL_RELATIF+"js/composants/menu/data.php?cas=get_nbAttente",
				type:"POST",
				data:{},
				success:function(res){
					scope.nbAttente = res;
				},
				error:function(){
				}
			});
		},
	}
})