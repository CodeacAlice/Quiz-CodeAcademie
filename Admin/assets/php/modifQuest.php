<?php
require_once '../../../database.php';

$idquest = intval($_GET['que']);
$idquiz = intval($_GET['qui']);

$sth = $bdd->prepare("SELECT * FROM questions WHERE idquestions = '".$idquest."'");
$sth->execute();
$row = $sth->fetch(PDO::FETCH_ASSOC);

echo '<div class="modal-header">
	<div class="modal-title" id="exampleModalLabel"><b>Modifier la question n°'.$row['numero'].'</b></div>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
	<form action="questions.php?idquiz='.$idquiz.'" method="post">
		<p style="display:none">id : <input type="text" name="id" required value="'.$row['idquestions'].'"></p>
		<p>Question : <input type="text" name="quest" required maxlength="255" value="'.$row['question'].'"></p>
		<p>Réponse 1 : <input type="text" name="rep1" required maxlength="255" value="'.$row['reponse1'].'"></p>
		<p>Réponse 2 : <input type="text" name="rep2" required maxlength="255" value="'.$row['reponse2'].'"></p>
		<p>Réponse 3 : <input type="text" name="rep3" required maxlength="255" value="'.$row['reponse3'].'"></p>
		<p>Réponse 4 : <input type="text" name="rep4" required maxlength="255" value="'.$row['reponse4'].'"></p>
		<p>Bonne réponse : ';

if ($row['bonnerep'] == $row['reponse1']) {
	echo '<input type="radio" name="bonnerep" required value="1" checked>1   
	<input type="radio" name="bonnerep" required value="2">2   
	<input type="radio" name="bonnerep" required value="3">3   
	<input type="radio" name="bonnerep" required value="4">4</p>';
}
elseif ($row['bonnerep'] == $row['reponse2']) {
	echo '<input type="radio" name="bonnerep" required value="1">1   
	<input type="radio" name="bonnerep" required value="2" checked>2   
	<input type="radio" name="bonnerep" required value="3">3   
	<input type="radio" name="bonnerep" required value="4">4</p>';
}
elseif ($row['bonnerep'] == $row['reponse3']) {
	echo '<input type="radio" name="bonnerep" required value="1">1   
	<input type="radio" name="bonnerep" required value="2">2   
	<input type="radio" name="bonnerep" required value="3" checked>3   
	<input type="radio" name="bonnerep" required value="4">4</p>';
}
else {
	echo '<input type="radio" name="bonnerep" required value="1">1   
	<input type="radio" name="bonnerep" required value="2">2   
	<input type="radio" name="bonnerep" required value="3">3   
	<input type="radio" name="bonnerep" required value="4" checked>4</p>';
}


echo '<p>Tags :' ;

$searchtags = $bdd->prepare("SELECT * FROM tags ORDER BY nom");
$searchtags->execute();
$resulttag = $searchtags->fetchAll();
if($searchtags->rowCount()) {
	foreach($resulttag as $rowtag){
		$check = '';
		$searchitstags = $bdd->prepare("SELECT * FROM tags_has_questions WHERE tags_idtags = '".$rowtag['idtags']."' AND questions_idquestions = '".$idquest."'");
		$searchitstags->execute();
		if($searchitstags->rowCount()) {
			$check = ' checked';
		}
		echo '#'.$rowtag['nom'].' <input type="checkbox" name="tags[]" value="'.$rowtag['idtags'].'"'.$check.'><br>';
	}
}
else {echo "Il n'existe pas encore de tag.";}

echo '</p>
<input type="submit" name="update" value="Modifier" class="btn btn-info">
</form>
</div>';

?>