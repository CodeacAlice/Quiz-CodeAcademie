<?php
require_once '../../database.php';

$idtag = intval($_GET['t']);
$idquiz = intval($_GET['q']);

$sth = $bdd->prepare("SELECT * FROM tags WHERE idtags = '".$idtag."'");
$sth->execute();
$row = $sth->fetch(PDO::FETCH_ASSOC);
		echo '<p>Voulez-vous vraiment supprimer définitivement le tag '.$row['nom'].' ?</p>
					<form action="tags.php?idquiz='.$idquiz.'" method="post">
						<p style="display:none">id : <input type="text" name="idSupp" required value="'.$idtag.'"></p>
						<input type="submit" name="delete" value="Oui" class="btnface-small">
						<button type="button" class="btnface-small" data-dismiss="modal" style="margin: auto;">Non</button>
					</form>';

?>