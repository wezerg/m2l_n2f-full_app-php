<?php include('../../0-config/config-genos.php'); 
if(empty($_SESSION)) header('Location:'.RACINE_GLOBAL_RELATIF.'index.php');
?>
<?php Head('Modifier mon thème', 5); ?>
	<main>
		<input type="hidden" id="couleur1_origine" value="<?php echo $_SESSION['couleur1'] ?>">
		<input type="hidden" id="couleur2_origine" value="<?php echo $_SESSION['couleur2'] ?>">

		<div class="container mt-4">
			<div class="row text-center">
				<div class="col">
					<h2 class="titre-page">Modifier le thème général</h2>
				</div>
			</div>
			<div class="row mt-4">
				<div class="col bloc">
					<h3 class="mt-3">Gérer mon thème</h3>
					<hr>
					
					<div class="row">
						<div class="col d-inline-flex">
							<input type="color" id="couleur2" class="form-control">
							<input type="text" class="form-control" id="couleur2-text">
						</div>
						<div class="col d-inline-flex">
							<input type="color" id="couleur1" class="form-control">
							<input type="text" class="form-control" id="couleur1-text">
						</div>
					</div>

					<div class="row mt-4 mb-2">
						<div class="col text-left">
							<button id="btn-default" class="btn btn-sm btn-degrade">Couleurs par défaut</button>
						</div>
						<div class="col text-right">
							<button id="btn-valider" class="btn btn-sm btn-success">Sauvegarder</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</main>
	<script>
		var body = document.getElementsByTagName('body')[0];
		var couleur1 = document.getElementById('couleur1');
		var couleur2 = document.getElementById('couleur2');
		var couleur1Text = document.getElementById('couleur1-text');
		var couleur2Text = document.getElementById('couleur2-text');
		var btnValider = document.getElementById('btn-valider');
		var btnDefault = document.getElementById('btn-default');

		couleur1.value = document.getElementById('couleur1_origine').value;
		couleur2.value = document.getElementById('couleur2_origine').value;
		couleur1Text.value = couleur1.value;
		couleur2Text.value = couleur2.value;

		function ChangerTexte(){
			couleur1Text.value = couleur1.value;
			couleur2Text.value = couleur2.value;

			ChangerCouleur();
		}

		function ChangerCouleur(){
			let str = "linear-gradient(to left, "+couleur1.value+" 0%, "+couleur2.value+" 100%)";
			body.style.background = str;
		}

		function RetablirDefaut(){
			couleur1.value = "#071B52";
			couleur2.value = "#008080";

			ChangerTexte();
			ValiderChangement();
		}

		function ValiderChangement(){
			$.ajax({
				url:"data.php?cas=changerCouleur",
				type:"POST",
				data:{couleur1 : couleur1.value, couleur2: couleur2.value},
				success:function(res){
					
				},
				error:function(){
				}
			});
		}

		couleur1.addEventListener('input', ChangerTexte);
		couleur2.addEventListener('input', ChangerTexte);
		couleur1Text.addEventListener('input', (e)=>{
			couleur1.value = e.target.value;
			ChangerCouleur();
		});
		couleur2Text.addEventListener('input', (e)=>{
			couleur2.value = e.target.value;
			ChangerCouleur();
		});
		btnValider.addEventListener('click', ValiderChangement);
		btnDefault.addEventListener('click', RetablirDefaut);
	</script>
<?php Footer(/*'app.vue.js'*/); ?>