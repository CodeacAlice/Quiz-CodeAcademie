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

	<title>[Code Academie] Promo #3 - Liste des questions</title>

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="../../assets/css/questions.css">

	<script type="text/javascript">
		function modifQuest(idquest, idquiz) {
			if (idquest == 0) {
				document.getElementById("modifQuest").innerHTML = "";
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
		        		document.getElementById("modifQuest").innerHTML = this.responseText;
		        		$('#modalModif').modal('show');
		        	}
		        };
		        xmlhttp.open("GET","../../assets/php/modifQuest.php?que="+idquest+"&qui="+idquiz,true);
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

	<header>
		<div class="banner">
			<span clabonnerepss="code_ac">
				<img src="../../assets/images/Logo-code-academie.jpg" alt="Logo de la Code Académie" style="width:30%;">
			</span>
			<span class="face">
				<img src="../../assets/images/RENNES_PNG.png" alt="Logo de FACE Rennes" style="width:35%;">
			</span>
		</div>
	</header>

	<!-- Ajouter une question -->
	<div class="modal fade" id="modalAjout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="modal-title" id="exampleModalLabel"><b>Ajouter une question</b></div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form <?php echo 'action="questions.php?idquiz='.$_GET["idquiz"].'"'; ?> method="post">
						<p>Question : <input type="text" name="quest" maxlength="255"></p>
						<p>Réponse 1 : <input type="text" name="rep1" required maxlength="255"></p>
						<p>Réponse 2 : <input type="text" name="rep2" required maxlength="255"></p>
						<p>Réponse 3 : <input type="text" name="rep3" required maxlength="255"></p>
						<p>Réponse 4 : <input type="text" name="rep4" required maxlength="255"></p>
						<p>Bonne réponse : <input type="checkbox" name="bonnerep[]" value="1">1
							<input type="checkbox" name="bonnerep[]" value="2">2
							<input type="checkbox" name="bonnerep[]" value="3">3
							<input type="checkbox" name="bonnerep[]" value="4">4</p>
						<p>Tags :
							<?php
							$sth = $bdd->prepare("SELECT * FROM tags ORDER BY nom");
							$sth->execute();
							$result = $sth->fetchAll();
							if($sth->rowCount()) {
								foreach($result as $row){
									echo '#'.$row['nom'].' <input type="checkbox" name="tags[]" value="'.$row['idtags'].'"><br>';
								}
							}
							else {echo "Il n'existe pas encore de tag.";}
							?>
						</p>
						<input type="submit" name="add" value="Ajouter" class="btn btn-info">
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php

	// Code pour ajouter une question
	if (isset($_POST['add']) && $_POST['add'] == 'Ajouter') {
		$bonn = $_POST['bonnerep'];
		$bonnerp1 = [];
		for ($i=0; $i<count($bonn); $i++){
			array_push($bonnerp1, $_POST['rep'.$bonn[$i]]);
		}
	  $bonnerp = implode(', ',$bonnerp1);
		// Requête envoyée à la table 'questions'
		$quest = str_replace("'", "\'", $_POST['quest']);
		$rep1 = str_replace("'", "\'", $_POST['rep1']);
		$rep2 = str_replace("'", "\'", $_POST['rep2']);
		$rep3 = str_replace("'", "\'", $_POST['rep3']);
		$rep4 = str_replace("'", "\'", $_POST['rep4']);
		$bon = str_replace("'", "\'", $bonnerp);

		$doesthequestexist = $bdd->prepare("SELECT COUNT(*) FROM questions
											WHERE question = '".$quest."' and quiz_idquiz = '".$_GET["idquiz"]."'");
		$doesthequestexist->execute();
		$questalreadyexists = $doesthequestexist->fetch();
		if ($questalreadyexists['COUNT(*)'] == 0) {

			$searchmax = $bdd->prepare("SELECT MAX(numero) FROM questions WHERE quiz_idquiz = '".$_GET["idquiz"]."'");
			$searchmax->execute();
			$max = $searchmax->fetch();
			$num = $max['MAX(numero)']+1;

			$addquest = $bdd->prepare("INSERT INTO questions (question, reponse1, reponse2, reponse3, reponse4,
				bonnerep, quiz_idquiz, numero)
				VALUES ('".$quest."', '".$rep1."', '".$rep2."', '".$rep3."', '".$rep4."',
				'".$bon."', '".$_GET["idquiz"]."', '".$num."')");
			$addquest->execute();

			// Requête envoyée à la table 'tags_has_questions'
			$aretheretags = $bdd->prepare("SELECT COUNT(*) FROM tags");
			$aretheretags->execute();
			$nbtags = $aretheretags->fetch();

			//if ($nbtags['COUNT(*)'] > 0) {
			if (isset($_POST['tags'])) {
				$tags = $_POST['tags'];
				for ($i = 0; $i < count($tags); $i++) {
					$searchid = $bdd->prepare("SELECT MAX(idquestions) FROM questions");
					$searchid->execute();
					$maxid = $searchid->fetch();
					$newid = $maxid['MAX(idquestions)'];

					$addtag = $bdd->prepare("INSERT INTO tags_has_questions (tags_idtags, questions_idquestions, questions_quiz_idquiz)
						VALUES ('".$tags[$i]."', '".$newid."', '".$_GET["idquiz"]."')");
					$addtag->execute();
				}
			}
		}
	}
	?>

	<!-- Modifier une question -->
	<div class="modal fade" id="modalModif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content" id="modifQuest">
				<div class="modal-header">
					<div class="modal-title" id="exampleModalLabel"><b>Modifier la question n°0</b></div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form <?php echo 'action="questions.php?idquiz='.$_GET["idquiz"].'"'; ?> method="post">
						<p style="display:none">id : <input type="text" name="id" required value="0"></p>
						<p>Question : <input type="text" name="quest" required maxlength="255"></p>
						<p>Réponse 1 : <input type="text" name="rep1" required maxlength="255"></p>
						<p>Réponse 2 : <input type="text" name="rep2" required maxlength="255"></p>
						<p>Réponse 3 : <input type="text" name="rep3" required maxlength="255"></p>
						<p>Réponse 4 : <input type="text" name="rep4" required maxlength="255"></p>
						<p>Bonne réponse : <input type="checkbox" name="bonnerep[]" value="1">1
							<input type="checkbox" name="bonnerep[]" value="2">2
							<input type="checkbox" name="bonnerep[]" value="3">3
							<input type="checkbox" name="bonnerep[]" value="4">4
						</p>
						<p>Tags :
							<?php
							$sth = $bdd->prepare("SELECT * FROM tags ORDER BY nom");
							$sth->execute();
							$result = $sth->fetchAll();
							if($sth->rowCount()) {
								foreach($result as $row){
									echo '#'.$row['nom'].' <input type="checkbox" name="tags[]" value="'.$row['idtags'].'"><br>';
								}
							}
							else {echo "Il n'existe pas encore de tag.";}
							?>
						</p>
						<input type="submit" name="update" value="Modifier" class="btn btn-info">
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
	// Code pour modifier une question
	if (isset($_POST['update']) && $_POST['update'] == 'Modifier') {
		$bonn = $_POST['bonnerep'];
		$bonnerp1 = [];
		for ($i=0; $i<count($bonn); $i++){
			array_push($bonnerp1, $_POST['rep'.$bonn[$i]]);
		}
	  $bonnerp = implode(', ',$bonnerp1);
		// Requête envoyée à la table 'questions'
		$id = $_POST['id'];
		$quest = str_replace("'", "\'", $_POST['quest']);
		$rep1 = str_replace("'", "\'", $_POST['rep1']);
		$rep2 = str_replace("'", "\'", $_POST['rep2']);
		$rep3 = str_replace("'", "\'", $_POST['rep3']);
		$rep4 = str_replace("'", "\'", $_POST['rep4']);
		$bon = str_replace("'", "\'", $bonnerp);

		$upquest = $bdd->prepare("UPDATE questions
			SET question = '".$quest."', reponse1 = '".$rep1."', reponse2 = '".$rep2."', reponse3 = '".$rep3."', reponse4 = '".$rep4."', bonnerep = '".$bon."'
			WHERE idquestions = '".$id."';");
		$upquest->execute();

		// Requêtes envoyées à la table 'tags_has_questions'
		if (isset($_POST['tags'])) {
			$tagschecked = $_POST['tags'];
			$searchtags = $bdd->prepare("SELECT * FROM tags");
			$searchtags->execute();
			$restags = $searchtags->fetchAll();
			if($searchtags->rowCount()) {
				foreach($restags as $atag){
					$ithasthetag = $bdd->prepare("SELECT * FROM tags_has_questions
						WHERE tags_idtags = '".$atag['idtags']."' AND questions_idquestions = '".$id."' ");
					$ithasthetag->execute();
					if ($ithasthetag->rowCount()) {
						if (!in_array($atag['idtags'], $tagschecked)) {
							$delete = $bdd->prepare("DELETE FROM tags_has_questions
								WHERE tags_idtags = '".$atag['idtags']."' AND questions_idquestions = '".$id."' ");
							$delete->execute();
						}
					}
					else {
						if (in_array($atag['idtags'], $tagschecked)) {
							$insert = $bdd->prepare("INSERT INTO tags_has_questions (tags_idtags, questions_idquestions, questions_quiz_idquiz)
								VALUES ('".$atag['idtags']."', '".$id."', '".$_GET["idquiz"]."')");
							$insert->execute();
						}
					}
				}
			}
		}
		else {
			$delete = $bdd->prepare("DELETE FROM tags_has_questions
				WHERE questions_idquestions = '".$id."' ");
			$delete->execute();
		}
	}
	?>


	<h2>Liste des questions du quiz "
		<?php
		// Code pour afficher le nom du quiz
		$sth = $bdd->prepare("SELECT * FROM quiz WHERE idquiz ='".$_GET["idquiz"]."'");
		$sth->execute();
		$result = $sth->fetch();
		echo $result['titre'];
		?>" :
	</h2>
	<a class="modif" href="mesquiz.php">Retour à la liste des quiz</a>

	<section class="page">
		<div class="bienvenue">
			<?php
					// Code pour afficher tous les tags ainsi que les questions associées
			$sth = $bdd->prepare("SELECT * FROM questions WHERE quiz_idquiz = '".$_GET["idquiz"]."' ORDER BY numero");
			$sth->execute();
			$result = $sth->fetchAll();
			if($sth->rowCount()) {
				foreach($result as $row){
					echo '
					<div class="question">
					<p><b>Question n°'.$row['numero'].' : '.$row['question'].'</b></p>
					</div>
					<div class="question_list">
					<ul>
					<li class="first_choice">'.$row['reponse1'].'</li>
					<li class="second_choice">'.$row['reponse2'].'</li>
					<li class="third_choice">'.$row['reponse3'].'</li>
					<li class="fourth_choice">'.$row['reponse4'].'</li>
					</ul>
					</div>';
					echo '
					<div class="tags">
					<p>Tags : ';


					$sth2 = $bdd->prepare("SELECT tags.nom FROM tags, tags_has_questions
						WHERE tags.idtags = tags_has_questions.tags_idtags
						AND tags_has_questions.questions_idquestions = '".$row['idquestions']."'
						ORDER BY tags.nom;");
					$sth2->execute();
					$result2 = $sth2->fetchAll();
					if($sth2->rowCount()) {
						foreach($result2 as $row2){echo '#'.$row2['nom'].' ';}
					}
					else {echo "Cette question n'a pas encore de tag.";}
					echo '</p>
					<button class="modif" onclick="modifQuest('.$row['idquestions'].', '.$_GET["idquiz"].')">modifier</button>
					</div>';
				}
			}
			else {echo "Ce quiz n'a pas encore de question.";}
			?>
		</div>
		<div>
			<button class="add" data-toggle="modal" data-target="#modalAjout">Ajouter une question</button>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<?php }?>
</body>
</html>
