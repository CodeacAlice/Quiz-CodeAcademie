<?php
session_start();

include 'infosconnect.php';
include 'database.php';

if(!$_SESSION['Admin'] && !$_SESSION['Loger']){
    header('location:../index.php');
  }

// Récupérer le numéro du quiz et le numéro de la question
$idquiz = $_GET['idquiz'];
$nbquest = $_GET['nq'];
$nbnext = $nbquest +1;

// Chercher la question à afficher
$sth = $bdd->prepare("SELECT * FROM questions
	WHERE quiz_idquiz = '".$idquiz."'
	AND numero = '".$nbquest."'");
$sth->execute();
$result = $sth->fetch();

// Si une question a été répondue
if (isset($_POST['submit']) && $_POST['submit'] == 'submit') {
	$nbprev = $nbquest -1;
	$answe = $_POST['check_list'];
  $answer = implode(', ', $answe);


	$searchgoodans = $bdd->prepare("SELECT * FROM questions
		WHERE quiz_idquiz = '".$idquiz."'
		AND numero = '".$nbprev."'");
	$searchgoodans->execute();
	$resultans = $searchgoodans->fetch();
	$correctans = $resultans['bonnerep'];

	// Afficher si bonne ou mauvaise réponse TODO : enlever
	if ($answer == $correctans) {
		echo 'Exact !';
		$itscorrect = 1;
	}
	else {
		echo 'Erreur, la bonne réponse était '.$correctans;
		$itscorrect = 0;
	}
	// Envoyer à la table score
	$addscore = $bdd->prepare("INSERT INTO scores (userans,	temps, users_idusers, questions_idquestions, questions_quiz_idquiz, correct)
		VALUES ('".str_replace("'", "\'", $answer)."', '0', '".$_SESSION['iduser']."', '".$resultans['idquestions']."', '".$idquiz."', '".$itscorrect."')");
	$addscore->execute();
}

// Vérifier si on est à la fin du quiz ou non
$countquest = $bdd->prepare("SELECT COUNT(*) FROM questions WHERE quiz_idquiz = '".$idquiz."'");
$countquest->execute();
$rescount = $countquest->fetch(PDO::FETCH_ASSOC);
$totquest = $rescount['COUNT(*)'];

// Si oui, afficher fin et lien de retour
if ($nbquest > $totquest) {
	if($_SESSION['Loger']) {$retour = './mesquiz.php';}
	else if ($_SESSION['Admin']) {$retour = './Admin/mesquiz.php';}
	echo '<p>Le quiz est terminé !</p>
	<a class="btn btn-info" href="'.$retour.'">Retour aux quiz</a>';
}
// Sinon, afficher la question et les réponses
else {
	echo '
<form action="quiz_test.php?idquiz='.$idquiz.'&nq='.$nbnext.'" method="post">
	<table align="center">
		<tr>
			<td>'.$result['question'].'</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="checkbox" name="check_list[]" value="'.$result['reponse1'].'">'.$result['reponse1'].'</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="checkbox" name="check_list[]" value="'.$result['reponse2'].'">'.$result['reponse2'].'</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="checkbox" name="check_list[]" value="'.$result['reponse3'].'">'.$result['reponse3'].'</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="checkbox" name="check_list[]" value="'.$result['reponse4'].'">'.$result['reponse4'].'</td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="submit"></td>
		</tr>

	</table>
</form>';
}

?>
