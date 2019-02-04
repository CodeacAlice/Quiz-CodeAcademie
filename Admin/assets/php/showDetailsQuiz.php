<?php
require_once '../../../database.php';

$q = intval($_GET['q']);
$sth = $bdd->prepare("SELECT * FROM quiz WHERE idquiz = '".$q."'");
$sth->execute();
$row = $sth->fetch(PDO::FETCH_ASSOC);


$sth2 = $bdd->prepare("SELECT COUNT(*) FROM questions WHERE quiz_idquiz = '".$q."'");
$sth2->execute();
$row2 = $sth2->fetch(PDO::FETCH_ASSOC);

		echo '<div class="modal-header">
		<div class="modal-title" id="exampleModalLabel"><b>'.$row['titre'].'</b></div>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
		</div>
		<div class="modal-body">
		<div class="p-4">
		Questions : '.$row2['COUNT(*)'].'<br><br>
		Durée : '.$row['duree'].'<br><br>
		Description :<br>
		<p class="py-2 px-3">'.$row['description'].'</p>
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-info" data-dismiss="modal" style="margin: auto;">Fermer</button>
		</div>
		</div>';

?>