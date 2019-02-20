<?php
require_once '../../database.php';

$id = intval($_GET['q']);

$sth = $bdd->prepare("SELECT * FROM quiz WHERE idquiz = '".$id."'");
$sth->execute();
$row = $sth->fetch(PDO::FETCH_ASSOC);
		echo '<div class="modal-header">
					<div class="modal-title" id="exampleModalLabel"><b>Modifier le quiz '.$row['titre'].'</b></div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="mesquiz.php" method="post">
						<p style="display:none;">id : <input type="text" name="id" required value="'.$row['idquiz'].'"></p>
						<p>Titre : <input type="text" name="titre" required maxlength="50" value="'.$row['titre'].'"></p>
						<p>Durée : <input type="text" name="duree" required maxlength="45" value="'.$row['duree'].'"></p>
						<p>Description : <textarea rows="2" name="description" required maxlength="255">'.$row['description'].'</textarea></p>
						<input type="submit" name="update" value="Modifier" class="btn btn-info">
					</form>
				</div>';

?>