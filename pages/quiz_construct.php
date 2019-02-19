<?php

include '../infosconnect.php';
include '../database.php';

if(!isset($_SESSION['Admin']) && !isset($_SESSION['Loger'])){
    header('location:deconnexion.php');
  }

// Récupérer le numéro du quiz et le numéro de la question
$idquiz = $_GET['idquiz'];
$nbquest = $_GET['nq'];
$nbnext = $nbquest +1;

// Si on est à la première question, indiquer que le quiz est fait dans la bdd
if (isset($_SESSION['Loger']) && $nbquest == 1) {
	$upd = $bdd->prepare("UPDATE users_has_quiz SET quiz_done = 1 
		WHERE users_idusers = '".$_SESSION['iduser']."' AND quiz_idquiz = '".$idquiz."'");
    $upd->execute();
}

// Chercher la question à afficher
$sth = $bdd->prepare("SELECT * FROM questions
	WHERE quiz_idquiz = '".$idquiz."'
	AND numero = '".$nbquest."'");
$sth->execute();
$result = $sth->fetch();

// Si une question a été répondue
if (isset($_POST['submit']) && $_POST['submit'] == 'submit') {
	$nbprev = $nbquest -1;
	if (isset($_POST['check_list'])) {
		$answe = $_POST['check_list'];
		$answer = implode(', ', $answe);
	}
	else {$answer = '';}
	

	$searchgoodans = $bdd->prepare("SELECT * FROM questions
		WHERE quiz_idquiz = '".$idquiz."'
		AND numero = '".$nbprev."'");
	$searchgoodans->execute();
	$resultans = $searchgoodans->fetch();
	$correctans = $resultans['bonnerep'];

	// Si on est admin, afficher si bonne ou mauvaise réponse
	if (isset($_SESSION['Admin'])) {
		if ($answer == $correctans) {echo 'Exact !';}
		else {echo 'Erreur, la bonne réponse était '.$correctans;}
	}
	// Sinon, on n'afficher rien et on enregistre le score
	else if (isset($_SESSION['Loger'])) {
		if ($answer == $correctans) {$itscorrect = 1;}
		else {$itscorrect = 0;}
		$addscore = $bdd->prepare("INSERT INTO scores (userans,	temps, users_idusers, questions_idquestions, questions_quiz_idquiz, correct)
			VALUES ('".str_replace("'", "\'", $answer)."', '0', '".$_SESSION['iduser']."', '".$resultans['idquestions']."', '".$idquiz."', '".$itscorrect."')");
		$addscore->execute();
	}
}

// Vérifier si on est à la fin du quiz ou non
$countquest = $bdd->prepare("SELECT COUNT(*) FROM questions WHERE quiz_idquiz = '".$idquiz."'");
$countquest->execute();
$rescount = $countquest->fetch(PDO::FETCH_ASSOC);
$totquest = $rescount['COUNT(*)'];

// Si oui, afficher fin et lien de retour
if ($nbquest > $totquest) {
	if(isset($_SESSION['Loger'])) {$retour = './mesquiz.php';}
	else if (isset($_SESSION['Admin'])) {$retour = './Admin/mesquiz.php';}
	echo '<p>Le quiz est terminé !</p>
  <form action="commentaire.php?idquiz='.$idquiz.'" method="post">
  <p>Laissez un commentaire <br><textarea rows="2" name="commentaire" required></textarea></p>
  <input type="submit" name="add" value="Ajouter" class="btn btn-info">
  </form>
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
