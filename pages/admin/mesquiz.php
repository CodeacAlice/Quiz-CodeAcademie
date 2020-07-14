<?php session_start(); $path = "../.."; ?>
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

	<title>[Code Academie] Promo #3 - Liste des quiz</title>

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="../../assets/css/stylesheet.css">

	<script type="text/javascript">
		function showDetails(idQuiz) {
			if (idQuiz == 0) {
				document.getElementById("infosQuiz").innerHTML = "";
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
		        		document.getElementById("infosQuiz").innerHTML = this.responseText;
		        		$('#modalDetails').modal('show');
		        	}
		        };
		        xmlhttp.open("GET","../../assets/php/showDetailsQuiz.php?q="+idQuiz,true);
		        xmlhttp.send();
		    }
		}
		function modifQuiz(idQuiz) {
			if (idQuiz == 0) {
				document.getElementById("modifQuiz").innerHTML = "";
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
		        		document.getElementById("modifQuiz").innerHTML = this.responseText;
		        		$('#modalModif').modal('show');
		        	}
		        };
		        xmlhttp.open("GET","../../assets/php/modifQuiz.php?q="+idQuiz,true);
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


	<?php include($path."/assets/views/header.php"); ?>


	<!-- Modal pour ajouter un quiz -->
	<div class="modal fade" id="modalAjout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="modal-title" id="exampleModalLabel"><b>Ajouter un quiz</b></div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="mesquiz.php" method="post">
						<p>Titre : <input type="text" name="titre" required maxlength="50"></p>
						<p>Durée : <input type="text" name="duree" required maxlength="45"></p>
						<p>Description : <textarea rows="2" name="description" required maxlength="255"></textarea></p>
						<input type="submit" name="add" value="Ajouter" class="btnface-small">
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
	// Code pour ajouter un quiz
	if (isset($_POST['add']) && $_POST['add'] == 'Ajouter') {

		$titre = str_replace("'", "\'", $_POST['titre']);
		$duree = str_replace("'", "\'", $_POST['duree']);
		$desc = str_replace("'", "\'", $_POST['description']);

		$sth = $bdd->prepare("INSERT INTO quiz (titre, duree, description) VALUES ('".$titre."', '".$duree."', '".$desc."')");
		$sth->execute();
	}
	?>

	<!-- Modal pour modifier un quiz -->
	<div class="modal fade" id="modalModif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content" id="modifQuiz">
				<div class="modal-header">
					<div class="modal-title" id="exampleModalLabel"><b>Modifier le quiz nom_quiz</b></div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="mesquiz.php" method="post">
						<p>Titre : <input type="text" name="titre" required maxlength="50"></p>
						<p>Durée : <input type="text" name="duree" required maxlength="45"></p>
						<p>Description : <textarea rows="2" name="description" required maxlength="255"></textarea></p>
						<input type="submit" name="update" value="Modifier" class="btnface-small">
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
	// Code pour modifier un quiz
	if (isset($_POST['update']) && $_POST['update'] == 'Modifier') {

		$titre = str_replace("'", "\'", $_POST['titre']);
		$duree = str_replace("'", "\'", $_POST['duree']);
		$desc = str_replace("'", "\'", $_POST['description']);
		$id = $_POST['id'];

		$sth = $bdd->prepare("UPDATE quiz 
			SET titre = '".$titre."', duree = '".$duree."', description = '".$desc."'
			WHERE idquiz = '".$id."'");
		$sth->execute();
	}
	?>

	<section>
		<h2>Liste des quiz</h2>

		<div id="listedesquiz">
			<?php
			$sth = $bdd->prepare('SELECT * FROM quiz ORDER BY titre');
			$sth->execute();
			$result = $sth->fetchAll();
			if($sth->rowCount()) {
				foreach($result as $row){ ?>
					<div class="my-4">
						<h4><?=$row['titre']?></h4>
						<button class="btnface-small" onclick="showDetails(<?=$row['idquiz']?>)">Détails</button> 
						<a href="questions.php?idquiz=<?=$row['idquiz']?>" class="btnface-small">Questions</a> 
						<a href="tags.php?idquiz=<?=$row['idquiz']?>" class="btnface-small">Tags</a> 
						<a href="../quiz_test.php?idquiz=<?=$row['idquiz']?>&nq=1" class="btnface-small">Tester</a>
						<button class="btnface-small" onclick="modifQuiz(<?=$row['idquiz']?>)">Modifier</button>
					</div>
				<?php }
			}
			else {echo "Il n'y a pas encore de quiz.";}
			?>

		</div>
		<button style="margin-top:2.5rem;" data-toggle="modal" data-target="#modalAjout">Ajouter</button>
	</section>

	
	<!-- Modal pour afficher les détails d'un quiz  -->
	<div class="modal fade" id="modalDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content" id="infosQuiz">
				<div class="modal-header">
					<div class="modal-title" id="exampleModalLabel"><b>Titre de quiz</b></div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="p-4">
						Questions : nombredequestions<br><br>
						Durée : unedurée<br><br>
						Description :<br>
						<p class="py-2 px-3">Lorem ipsum</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btnface-small" data-dismiss="modal" style="margin: auto;">Fermer</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include($path."/assets/views/footer.php"); ?>


	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


	<?php }?>

</body>


