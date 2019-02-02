<?php
require_once '../../../database.php';

$idtag = intval($_GET['q']);
$sth = $bdd->prepare("SELECT * FROM tags WHERE idtags = '".$idtag."'");
$sth->execute();
$row = $sth->fetch(PDO::FETCH_ASSOC);
		echo '<div class="modal-header">
					<div class="modal-title" id="exampleModalLabel"><b>Modifier le tag '.$row['nom'].'</b></div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="tags.php" method="post">
						<p style="display:none">id : <input type="text" name="id" required value="'.$idtag.'"></p>
						<p>Nom : <input type="text" name="nom" required maxlength="45" value="'.$row['nom'].'"></p>
						<input type="submit" name="update" value="Modifier" class="btn btn-info">
					</form>
				</div>';

?>