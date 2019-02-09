<?php
include 'infosconnect.php';
include 'database.php';

$idquiz = $_GET['idquiz'];
$nbquest = $_GET['nq'];
$nbnext = $nbquest +1;


$sth = $bdd->prepare("SELECT * FROM questions 
	WHERE quiz_idquiz = '".$idquiz."' 
	AND numero = '".$nbquest."'");
$sth->execute();
$result = $sth->fetch();

if (isset($_POST['submit']) && $_POST['submit'] == 'submit') {
	$nbprev = $nbquest -1;
	$answer = $_POST['choix'];


	$searchgoodans = $bdd->prepare("SELECT * FROM questions 
		WHERE quiz_idquiz = '".$idquiz."' 
		AND numero = '".$nbprev."'");
	$searchgoodans->execute();
	$resultans = $searchgoodans->fetch();
	$correctans = $resultans['bonnerep'];

	if ($answer == $correctans) {
		echo 'Exact !';
		$itscorrect = 1;
	}
	else {
		echo 'Erreur, la bonne réponse était '.$correctans;
		$itscorrect = 0;
	}
	$addscore = $bdd->prepare("INSERT INTO scores (userans,	temps, users_idusers, questions_idquestions, questions_quiz_idquiz, correct)
		VALUES ('".str_replace("'", "\'", $answer)."', '0', '".$_SESSION['iduser']."', '".$resultans['idquestions']."', '".$idquiz."', '".$itscorrect."')");
	$addscore->execute();
}


$countquest = $bdd->prepare("SELECT COUNT(*) FROM questions WHERE quiz_idquiz = '".$idquiz."'");
$countquest->execute();
$rescount = $countquest->fetch(PDO::FETCH_ASSOC);
$totquest = $rescount['COUNT(*)'];

if ($nbquest > $totquest) {
	echo '<p>Le quiz est terminé !</p>
	<a class="btn btn-info" href="./Admin/mesquiz.php">Retour aux quiz</a>';
}
else {
	echo '
<form action="quiz_test.php?idquiz='.$idquiz.'&nq='.$nbnext.'" method="post">
	<table align="center">
		<tr>
			<td>'.$result['question'].'</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="radio" name="choix" value="'.$result['reponse1'].'">'.$result['reponse1'].'</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="radio" name="choix" value="'.$result['reponse2'].'">'.$result['reponse2'].'</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="radio" name="choix" value="'.$result['reponse3'].'">'.$result['reponse3'].'</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="radio" name="choix" value="'.$result['reponse4'].'">'.$result['reponse4'].'</td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="submit"></td>
		</tr>

	</table>
</form>';
}

?>