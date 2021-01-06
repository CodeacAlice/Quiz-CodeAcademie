<?php 
session_start(); 
$path = "../.."; $titlepage = "Liste des quiz";

require_once $path.'/database.php';
if(!isset($_SESSION['Loger'])){
	header('location:../deconnexion.php');
}
else {

	include($path."/assets/views/head.php"); 
?>

	<!-- Code JavaScript pour afficher les détails d'un quiz -->
	<script type="text/javascript">
		function showDetails(idQuiz) {
			if (idQuiz == 0) {
				document.getElementById("infosQuiz").innerHTML = "";
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
		        		document.getElementById("infosQuiz").innerHTML = this.responseText;
		        		$('#modalDetails').modal('show');
		        	}
		        };
		        xmlhttp.open("GET","../../assets/php/showDetailsQuiz.php?q="+idQuiz,true);
		        xmlhttp.send();
		    }
		}
	</script>




	<section>

		<h2>Liste des quiz</h2>

		<div id="listedesquiz">

			<?php
			$sth = $bdd->prepare('SELECT quiz.*, quiz_done FROM quiz
				Inner Join users_has_quiz On quiz.idquiz = users_has_quiz.quiz_idquiz
				Inner Join users ON users.idusers = users_has_quiz.users_idusers
				Where users.idusers = '.$_SESSION['iduser'].'
				ORDER BY titre');

			$sth->execute();
			$result = $sth->fetchAll();
			if($sth->rowCount()) {
				foreach($result as $row){ ?>
					<p>
						<?=$row['titre']?> 
						<button class="btnface-small" onclick="showDetails(<?=$row['idquiz']?>)">Détails</button>
						<?php if ($row['quiz_done']) {?>
							<button class="btnface-small" disabled>Fini</button>
						<?php ;} else {?>
							<a href="../quiz_test.php?idquiz=<?=$row['idquiz']?>&nq=1" class="btnface-small">Faire le quiz</a>
						<?php ;} ?>
					</p>
				<?php }
			}
			else {echo "Vous n'avez pas encore de quiz.";}
			?>

		</div>
	</section>


	<!-- Modal pour afficher les détails d'un quiz -->
	<div class="modal fade" id="modalDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content" id="infosQuiz">
				<div class="modal-header">
					<div class="modal-title" id="exampleModalLabel"><b>Titre de quiz</b></div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="p-4">
						Questions : nombredequestions<br><br>
						Durée : unedurée<br><br>
						Description :<br>
						<p class="py-2 px-3">Lorem ipsum</p>
					</div>
					<div class="modal-footer">
						<button class="btnface-small" data-dismiss="modal" style="margin: auto;">Fermer</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include($path."/assets/views/footer.php"); ?>



</body>
</html>
<?php } ?>
