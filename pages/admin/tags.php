<?php session_start() ?>
<!doctype html>
<html lang="fr">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<!-- FontAwesome CSS -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<title>[Code Academie] Promo #3 - Liste des tags</title>

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="../../assets/css/tags.css">

	<script type="text/javascript">
		function modifTag(idtag, idquiz) {
			if (idtag == 0) {
				document.getElementById("modifTag").innerHTML = "";
				return;
			} else {
				if (window.XMLHttpRequest) {
		            // code for IE7+, Firefox, Chrome, Opera, Safari
		            xmlhttp = new XMLHttpRequest();
		        } else {
		            // code for IE6, IE5
		            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		        }
		        xmlhttp.onreadystatechange = function() {
		        	if (this.readyState == 4 && this.status == 200) {
		        		document.getElementById("modifTag").innerHTML = this.responseText;
		        		$('#modalModif').modal('show');
		        	}
		        };
		        xmlhttp.open("GET","../../assets/php/modifTag.php?t="+idtag+"&q="+idquiz,true);
		        xmlhttp.send();
		    }
		}
		
		function deleteTag(idtag, idquiz) {
			if (idtag == 0) {
				document.getElementById("supprTag").innerHTML = "";
				return;
			} else {
				if (window.XMLHttpRequest) {
		            // code for IE7+, Firefox, Chrome, Opera, Safari
		            xmlhttp = new XMLHttpRequest();
		        } else {
		            // code for IE6, IE5
		            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		        }
		        xmlhttp.onreadystatechange = function() {
		        	if (this.readyState == 4 && this.status == 200) {
		        		document.getElementById("supprTag").innerHTML = this.responseText;
		        		$('#modalDelete').modal('show');
		        	}
		        };
		        xmlhttp.open("GET","../../assets/php/supprTag.php?t="+idtag+"&q="+idquiz,true);
		        xmlhttp.send();
		    }
		}
	</script>
</head>

<body>
	<?php
	require_once '../../database.php';
	if(!isset($_SESSION['Admin'])){
	    header('location:../deconnexion.php');
	}
	else {
	?>

	<!-- Modal pour ajouter un tag -->
	<div class="modal fade" id="modalAjout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="modal-title" id="exampleModalLabel"><b>Ajouter un tag</b></div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?php echo '<form action="tags.php?idquiz='.$_GET["idquiz"].'" method="post">'; ?>
						<p>Nom : <input type="text" name="nom" required maxlength="45"></p>
						<input type="submit" name="add" value="Ajouter" class="btn btn-info">
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
	// Code pour ajouter un tag
	if (isset($_POST['add']) && $_POST['add'] == 'Ajouter') {

		$nom = str_replace("'", "\'", $_POST['nom']);

		$sth = $bdd->prepare("INSERT INTO tags (nom) VALUES ('".$nom."')");
		$sth->execute();
	}
	?>

	<!-- Modal pour modifier un tag -->
	<div class="modal fade" id="modalModif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content" id="modifTag">
				<div class="modal-header">
					<div class="modal-title" id="exampleModalLabel"><b>Modifier le tag nom_tag</b></div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?php echo '<form action="tags.php?idquiz='.$_GET["idquiz"].'" method="post">'; ?>
						<p style="display:none">id : <input type="text" name="id" required value="0"></p>
						<p>Nom : <input type="text" name="nom" required maxlength="45" value="nom_tag"></p>
						<input type="submit" name="update" value="Modifier" class="btn btn-info">
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
	// Code pour modifier un tag
	if (isset($_POST['update']) && $_POST['update'] == 'Modifier') {

		$id = $_POST['id'];
		$nom = str_replace("'", "\'", $_POST['nom']);

		$sth = $bdd->prepare("UPDATE tags SET nom = '".$nom."' WHERE idtags = '".$id."';");
		$sth->execute();
	}
	?>

	<!-- Modal pour supprimer un tag -->
	<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="modal-title" id="exampleModalLabel"><b>ATTENTION</b></div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="supprTag">
					<p>Voulez-vous vraiment supprimer définitivement le tag nom_tag ?</p>
					<?php echo '<form action="tags.php?idquiz='.$_GET["idquiz"].'" method="post">'; ?>
						<p style="display:none">id : <input type="text" name="idSupp" required value="0"></p>
						<input type="submit" name="delete" value="Oui" class="btn btn-info">
						<button type="button" class="btn btn-info" data-dismiss="modal" style="margin: auto;">Non</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
	// Code pour supprimer un tag
	if (isset($_POST['delete']) && $_POST['delete'] == 'Oui') {

		$id = $_POST['idSupp'];

		$sth = $bdd->prepare("DELETE FROM tags_has_questions WHERE tags_idtags = '".$id."';
			DELETE FROM tags WHERE idtags = '".$id."';");
		$sth->execute();
	}
	?>

	<!-- <header>
		<div class="banner">
			<span class="code_ac">
				<img src="../../assets/images/Logo-code-academie.jpg" alt="Logo de la Code Académie" style="width:30%;">
			</span>
			<span class="face">
				<img src="../../assets/images/RENNES_PNG.png" alt="Logo de FACE Rennes" style="width:35%;">
			</span>
		</div>
	</header> -->
	<?php $path = '../..'; include($path."/assets/views/header.php"); ?>

	<section class="page">
		<div class="list">
			<p>Liste des tags et présence dans le quiz "
				<?php 
				// Code pour afficher le nom du quiz
				$sth = $bdd->prepare("SELECT * FROM quiz WHERE idquiz ='".$_GET["idquiz"]."'");
				$sth->execute();
				$result = $sth->fetch();
				echo $result['titre'];
				?>
			" :
			</p>
			<button class="add" data-toggle="modal" data-target="#modalAjout">Ajouter un tag</button>
			<a class="btn btn-info" href="mesquiz.php">Retour aux quiz</a>
		</div>
		<div class="bienvenue">
		<?php
		// Code pour afficher tous les tags ainsi que les questions associées
		$sth = $bdd->prepare('SELECT * FROM tags ORDER BY nom');
		$sth->execute();
		$result = $sth->fetchAll();
		if($sth->rowCount()) {
			foreach($result as $row){
				echo '
			<div class="tag_name">
				<div class="tag_example">
					 <p>';

				$sth2 = $bdd->prepare("SELECT questions.numero FROM tags, tags_has_questions, questions
					WHERE tags.idtags = tags_has_questions.tags_idtags
					AND tags_has_questions.questions_idquestions = questions.idquestions
					AND questions.quiz_idquiz = '".$_GET["idquiz"]."'
					AND tags.idtags = '".$row['idtags']."';");
				$sth2->execute();
				$result2 = $sth2->fetchAll();

				if($sth2->rowCount()) {
					echo '<i class="far fa-check-circle"></i> ';
				}

				echo $row['nom'].'</p>
				</div>';

				if($sth2->rowCount()) {
					echo '
				<div class="question_concerned">
					<p>Questions concernées : ';
					foreach($result2 as $row2){
						echo $row2['numero'].' ';
					}
					echo '</p>
				</div>';
				}

				echo '
				<div>
					<button class="btn btn-info" onclick="modifTag('.$row['idtags'].', '.$_GET["idquiz"].')">Modifier</button>
					<button class="poubelle" onclick="deleteTag('.$row['idtags'].', '.$_GET["idquiz"].')">
						<i class="fas fa-trash-alt"></i>
					</button>
				</div>
			</div>';
			}
		}
		else {echo "Il n'y a pas encore de tag.";}
		?>

		</div>
	</section>


	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<?php } ?>
</body>
</html>