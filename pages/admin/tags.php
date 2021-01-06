<?php 
  session_start(); 
  $path = "../.."; $titlepage = "Liste des tags";

  require_once $path.'/database.php';
  if(!isset($_SESSION['Admin'])){
    header('location:../deconnexion.php');
  }
  else {

    include($path."/assets/views/head.php"); 
  
?>
<!-- CSS additionnel -->
<link rel="stylesheet" type="text/css" href="../../assets/css/tags.css">

<!-- Code JavaScript pour modifier et supprimer un tag -->
<script type="text/javascript">
	function modifTag(idtag, idquiz) {
		if (idtag == 0) {
			document.getElementById("modifTag").innerHTML = "";
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
					document.getElementById("modifTag").innerHTML = this.responseText;
					$('#modalModif').modal('show');
				}
			};
			xmlhttp.open("GET","../../assets/php/modifTag.php?t="+idtag+"&q="+idquiz,true);
			xmlhttp.send();
		}
	}
	
	function deleteTag(idtag, idquiz) {
		if (idtag == 0) {
			document.getElementById("supprTag").innerHTML = "";
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
					document.getElementById("supprTag").innerHTML = this.responseText;
					$('#modalDelete').modal('show');
				}
			};
			xmlhttp.open("GET","../../assets/php/supprTag.php?t="+idtag+"&q="+idquiz,true);
			xmlhttp.send();
		}
	}
</script>


<!-- Modal pour ajouter un tag -->
<div class="modal fade" id="modalAjout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title" id="exampleModalLabel"><b>Ajouter un tag</b></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php echo '<form action="tags.php?idquiz='.$_GET["idquiz"].'" method="post">'; ?>
					<p>Nom : <input type="text" name="nom" required maxlength="45"></p>
					<input type="submit" name="add" value="Ajouter" class="btnface">
				</form>
			</div>
		</div>
	</div>
</div>
<?php
// Code pour ajouter un tag
if (isset($_POST['add']) && $_POST['add'] == 'Ajouter') {

	$nom = str_replace("'", "\'", $_POST['nom']);

	$sth = $bdd->prepare("INSERT INTO tags (nom) VALUES ('".$nom."')");
	$sth->execute();
}
?>

<!-- Modal pour modifier un tag -->
<div class="modal fade" id="modalModif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" id="modifTag">
			<div class="modal-header">
				<div class="modal-title" id="exampleModalLabel"><b>Modifier le tag nom_tag</b></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php echo '<form action="tags.php?idquiz='.$_GET["idquiz"].'" method="post">'; ?>
					<p style="display:none">id : <input type="text" name="id" required value="0"></p>
					<p>Nom : <input type="text" name="nom" required maxlength="45" value="nom_tag"></p>
					<input type="submit" name="update" value="Modifier" class="btnface-small">
				</form>
			</div>
		</div>
	</div>
</div>
<?php
// Code pour modifier un tag
if (isset($_POST['update']) && $_POST['update'] == 'Modifier') {

	$id = $_POST['id'];
	$nom = str_replace("'", "\'", $_POST['nom']);

	$sth = $bdd->prepare("UPDATE tags SET nom = '".$nom."' WHERE idtags = '".$id."';");
	$sth->execute();
}
?>

<!-- Modal pour supprimer un tag -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title" id="exampleModalLabel"><b>ATTENTION</b></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="supprTag">
				<p>Voulez-vous vraiment supprimer définitivement le tag nom_tag ?</p>
				<?php echo '<form action="tags.php?idquiz='.$_GET["idquiz"].'" method="post">'; ?>
					<p style="display:none">id : <input type="text" name="idSupp" required value="0"></p>
					<input type="submit" name="delete" value="Oui" class="btnface-small">
					<button type="button" class="btnface-small" data-dismiss="modal" style="margin: auto;">Non</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
// Code pour supprimer un tag
if (isset($_POST['delete']) && $_POST['delete'] == 'Oui') {

	$id = $_POST['idSupp'];

	$sth = $bdd->prepare("DELETE FROM tags_has_questions WHERE tags_idtags = '".$id."';
		DELETE FROM tags WHERE idtags = '".$id."';");
	$sth->execute();
}
?>




<section>
	<h2>Liste des tags et présence dans le quiz « <?php 
		// Code pour afficher le nom du quiz
		$sth = $bdd->prepare("SELECT * FROM quiz WHERE idquiz ='".$_GET["idquiz"]."'");
		$sth->execute();
		$result = $sth->fetch();
		echo $result['titre'];
		?> » :
	</h2>
	<?php
		// Code pour afficher tous les tags ainsi que les questions associées
		$sth = $bdd->prepare('SELECT * FROM tags ORDER BY nom');
		$sth->execute();
		$result = $sth->fetchAll();
		if($sth->rowCount()) {
			foreach($result as $row){
				$sth2 = $bdd->prepare("SELECT questions.numero FROM tags, tags_has_questions, questions
					WHERE tags.idtags = tags_has_questions.tags_idtags
					AND tags_has_questions.questions_idquestions = questions.idquestions
					AND questions.quiz_idquiz = '".$_GET["idquiz"]."'
					AND tags.idtags = '".$row['idtags']."';");
				$sth2->execute();
				$result2 = $sth2->fetchAll();

				if($sth2->rowCount()) {
					$check = '<i class="far fa-check-circle"></i> ';
					$quests = '<span>Questions concernées : ';
					foreach($result2 as $row2){
						$quests .= $row2['numero'].' ';
					}
					$quests .= '</span>';
				}
				else {$check = ''; $quests = '';}
				?>

				<div class="tag_name">
					<div class="tag_example">
						<div>
							<?php echo $check.$row['nom']; ?>
						</div>
						<?= $quests ?>
						<div>
							<button class="btnface-small" onclick="modifTag(<?=$row['idtags']?>, <?=$_GET['idquiz']?>)">Modifier</button>
							<button class="btnface-small" onclick="deleteTag(<?=$row['idtags']?>, <?=$_GET['idquiz']?>)">
								<?php include($path."/assets/img/trash-alt-solid.svg"); ?>
							</button>
						</div>
					</div>
				</div>
			<?php }
		}
		else {echo "Il n'y a pas encore de tag.";}
	?>
	

	<div class="my-5"><button data-toggle="modal" data-target="#modalAjout">Ajouter un tag</button></div>
	<a class="btnface-small" href="mesquiz.php">Retour aux quiz</a>
</section>

<?php include($path."/assets/views/footer.php"); ?>

</body>
</html>
<?php } ?>
