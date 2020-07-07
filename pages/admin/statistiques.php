<?php session_start(); $path = "../.."; ?>
<!doctype html>
<html lang="fr">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="../../assets/css/stylesheet.css">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<!-- FontAwesome CSS -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<title>[Code Academie] Promo #3 - Statistiques</title>	

	<script type="text/javascript">
		// Fonction qui envoie une requête pour ajouter un quiz à l'utilisateur, puis recharge la page
		function addQuiz(iduser, idquiz) {
			if (iduser == 0 || idquiz == 0) {
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
		        		location.reload();
		        	}
		        };
		        xmlhttp.open("GET","../../assets/php/addQuizToUser.php?user="+iduser+"&quiz="+idquiz,true);
		        xmlhttp.send();
		    }
		}
		// Fonction qui affiche les détails des stats pour un quiz
		function showDetails(iduser, idquiz) {
			if (iduser == 0 || idquiz == 0) {
				document.getElementById("detQuiz").innerHTML = "";
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
		        		document.getElementById("detQuiz").innerHTML = this.responseText;
		        		$('#modalDetails').modal('show');
		        	}
		        };
		        xmlhttp.open("GET","../../assets/php/showDetailsScores.php?user="+iduser+"&quiz="+idquiz,true);
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

	<a href="homepage.php" class="btn btn-info">Retour à l'accueil</a>
	<a href="users.php" class="btn btn-info">Retour à la liste</a>

	<?php
	// Code pour aller chercher le nom de l'utilisateur
	$getuser = $bdd->prepare("SELECT * FROM users WHERE idusers = '".$_GET['user']."'");
    $getuser->execute();
    $infosuser = $getuser->fetch(PDO::FETCH_ASSOC);
    ?>
    <h2>
    	Statistiques de l'utilisateur 
    	<?=$infosuser['prenom']?> 
    	<span style="text-transform: uppercase;"><?=$infosuser['nom']?></span>
    </h2>



	<?php
	// Code pour aller chercher le nombre de questions totales et réussies
	$getquest = $bdd->prepare("SELECT COUNT(numero) FROM questions, users_has_quiz
								WHERE users_idusers = '".$_GET['user']."'
								AND quiz_done = 1
								AND questions.quiz_idquiz = users_has_quiz.quiz_idquiz");
    $getquest->execute();
    $nbquest = $getquest->fetch(PDO::FETCH_ASSOC);

    $getquestr = $bdd->prepare("SELECT COUNT(*) FROM scores WHERE users_idusers = '".$_GET['user']."' AND correct = 1");
    $getquestr->execute();
    $nbquestr = $getquestr->fetch(PDO::FETCH_ASSOC);
    ?>
    <h3>Questions réussies : <?=$nbquestr['COUNT(*)']?> / <?=$nbquest['COUNT(numero)']?></h3>

    <h3>Quiz attribués : <button class="btn btn-info" data-toggle="modal" data-target="#modalQ">Modifier</button></h3>

    <?php
	// Code pour aller chercher les quiz de l'utilisateur
	$gettheirquiz = $bdd->prepare("SELECT titre, quiz_done, idquiz FROM quiz, users_has_quiz
									WHERE users_has_quiz.quiz_idquiz = quiz.idquiz
									AND users_has_quiz.users_idusers = '".$_GET['user']."'
									ORDER BY quiz.titre");
    $gettheirquiz->execute();
    $theirquiz = $gettheirquiz->fetchAll();
    if($gettheirquiz->rowCount()) {
		foreach($theirquiz as $rowq){
			?><p><?=$rowq['titre']?>
			<?php if ($rowq['quiz_done']==1) {
				?> (fait) <button class="btn btn-info" onclick="showDetails(<?=$_GET['user']?>, <?=$rowq['idquiz']?>)" >Détails</button>
			<?php ;}
			?></p><?php
		}
	}
	else {echo "Cet utilisateur n'a pas encore de quiz.";}
    ?>


    <h3>Scores par tags</h3>
    <!-- Code pour afficher les scores par catégories. Oh ça va être drôle à faire -->
    <?php
    	$gettags = $bdd->prepare("SELECT * FROM tags");
	    $gettags->execute();
	    $tags = $gettags->fetchAll();
	    if($gettags->rowCount()) {
			foreach($tags as $rowtag){
				// Compter le total de questions
				$totq = $bdd->prepare("SELECT COUNT(questions.numero) FROM questions, users_has_quiz, tags_has_questions
											WHERE questions.quiz_idquiz = users_has_quiz.quiz_idquiz
											AND tags_has_questions.questions_idquestions = questions.idquestions
											AND users_has_quiz.quiz_done = 1
											AND users_has_quiz.users_idusers = ".$_GET['user']."
											AND tags_has_questions.tags_idtags = ".$rowtag['idtags'].";
					");
			    $totq->execute();
			    $nbqut = $totq->fetch(PDO::FETCH_ASSOC);

			    // Compter les questions réussies
			    $reuq = $bdd->prepare("SELECT COUNT(scores.correct) FROM scores, tags_has_questions
										WHERE scores.questions_idquestions = tags_has_questions.questions_idquestions
										AND scores.correct = 1
										AND scores.users_idusers = ".$_GET['user']."
										AND tags_has_questions.tags_idtags = ".$rowtag['idtags'].";
					");
			    $reuq->execute();
			    $nbrt = $reuq->fetch(PDO::FETCH_ASSOC);

			    ?><p><?=$rowtag['nom']?> : <?=$nbrt['COUNT(scores.correct)']?> questions réussies sur <?=$nbqut['COUNT(questions.numero)']?> essayées.</p>
			<?php ;}
		}
		else {echo "<p>Il n'existe pas encore de tag.</p>";}
    ?>

    <!-- Modal pour rajouter des quiz à l'utilisateur -->
    <div class="modal fade" id="modalQ" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content" id="modifQuest">
				<div class="modal-header">
					<div class="modal-title" id="exampleModalLabel"><b>Quiz de l'utilisateur <?=$infosuser['prenom']?> <span style="text-transform: uppercase;"><?=$infosuser['nom']?></b></div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?php
						// Code pour afficher les quiz
						$getquiz = $bdd->prepare("SELECT * FROM quiz ORDER BY titre");
					    $getquiz->execute();
					    $infosquiz = $getquiz->fetchAll();
					    if($getquiz->rowCount()) {
							foreach($infosquiz as $row){
								// Vérifie si le quiz a déjà été attribué à l'utilisateur ou pas
								$hasquiz = $bdd->prepare("SELECT COUNT(*) FROM users_has_quiz WHERE users_idusers = '".$_GET['user']."' AND quiz_idquiz = '".$row['idquiz']."'");
								$hasquiz->execute();
								$hehasquiz = $hasquiz->fetch();
								?>
								<p><?=$row['titre']?>
								<?php if ($hehasquiz['COUNT(*)'] > 0) { ?> <button class="btn" disabled>Attribué</button>
								<?php ;} else {?> <button class="btn btn-info" onclick="addQuiz(<?=$_GET['user']?>,<?=$row['idquiz']?>)">Attribuer</button> <?php ;}
							;}
						}
						else {echo "Il n'y a pas encore de quiz, vous pouvez en créer en allant sur la page 'Mes quiz'.";}
					?>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal pour afficher les stats d'un utilisateur dans un quiz -->
    <div class="modal fade" id="modalDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content" id="detQuiz">
				<div class="modal-header">
					<div class="modal-title" id="exampleModalLabel"><b>Détails du quiz nom_quiz pour l'utilisateur <?=$infosuser['prenom']?> <span style="text-transform: uppercase;"><?=$infosuser['nom']?></b></div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Bonnes réponses : 2/4</p>
					<p>Question 1 : (vrai) Un.e inconnu.e</p>
					<p>Question 2 : (faux) mauvaise réponse</p>
					<div class="modal-footer">
						<button type="button" class="btn btn-info" data-dismiss="modal" style="margin: auto;">Fermer</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<?php } ?>
</body>
</html>