<?php
require_once '../../database.php';

$iduser = intval($_GET['user']);
$idquiz = intval($_GET['quiz']);

// Récupérer les nom et prénom de l'utilisateur
$getuser = $bdd->prepare("SELECT nom, prenom FROM users WHERE idusers = '".$iduser."'");
$getuser->execute();
$infosuser = $getuser->fetch(PDO::FETCH_ASSOC);

// Récupérer le nom du quiz
$getquiz = $bdd->prepare("SELECT titre FROM quiz WHERE idquiz = '".$idquiz."'");
$getquiz->execute();
$infosquiz = $getquiz->fetch(PDO::FETCH_ASSOC);

// Compter les questions du quiz
$countquest = $bdd->prepare("SELECT COUNT(*) FROM questions WHERE quiz_idquiz = '".$idquiz."'");
$countquest->execute();
$nbquest = $countquest->fetch(PDO::FETCH_ASSOC);

// Compter les réponses correctes
$countquestr = $bdd->prepare("SELECT COUNT(*) FROM scores WHERE users_idusers = '".$iduser."' AND questions_quiz_idquiz = '".$idquiz."' AND correct = 1");
$countquestr->execute();
$nbquestr = $countquestr->fetch(PDO::FETCH_ASSOC);
?>

<div class="modal-header">
	<div class="modal-title" id="exampleModalLabel"><b>Détails du quiz <?=$infosquiz['titre']?> pour l'utilisateur <?=$infosuser['prenom']?> <span style="text-transform: uppercase;"><?=$infosuser['nom']?></span></b></div>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
	<p>Bonnes réponses : <?=$nbquestr['COUNT(*)']?> / <?=$nbquest['COUNT(*)']?></p>
	<?php // Afficher les questions du quiz, et les scores
	$getquest = $bdd->prepare("SELECT idquestions, numero, question FROM questions, users_has_quiz
								WHERE users_has_quiz.quiz_idquiz = questions.quiz_idquiz
								AND users_has_quiz.users_idusers = '".$_GET['user']."'
								AND questions.quiz_idquiz = '".$idquiz."'
								ORDER BY numero");
    $getquest->execute();
    $thequestion = $getquest->fetchAll();
    if($getquest->rowCount()) {
		foreach($thequestion as $quest){
			$getscore = $bdd->prepare("SELECT * FROM scores 
									WHERE questions_idquestions = '".$quest['idquestions']."'
									AND users_idusers = '".$_GET['user']."'");
			$getscore->execute();
			$score = $getscore->fetch(PDO::FETCH_ASSOC);
			if ($score['correct']) {$correct = '(vrai)';}
				else {$correct = '(faux)';}
	?>
	<p>Question <?=$quest['numero']?> : <?=$quest['question']?></p>
	<p>Réponse : <?=$score['userans']?> <?=$correct?></p>
	<?php
		}
	}
	?>
	<?php
	$getcomment = $bdd->prepare("SELECT * FROM commentaires WHERE commentaires.users_idusers = '".$_GET['user']."' AND commentaires.quiz_idquiz = '".$idquiz."'");
			$getcomment->execute();
			$commentaire = $getcomment->fetch(PDO::FETCH_ASSOC);
	?>
	<p>Commentaire :</p>
		<p><?=$commentaire['commentaire']?></p>
	<div class="modal-footer">
		<button type="button" class="btn btn-info" data-dismiss="modal" style="margin: auto;">Fermer</button>
	</div>
</div>

