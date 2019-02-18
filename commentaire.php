<?php
session_start();

include 'infosconnect.php';
include 'database.php';

//envoyer le commentaire dans la bdd
$idquiz = $_GET['idquiz'];
if (isset($_POST['add']) && $_POST['add'] == 'Ajouter') {

		$commentaire = str_replace("'", "\'", $_POST['commentaire']);
	
		$sth = $bdd->prepare("INSERT INTO commentaires (commentaire, users_idusers, quiz_idquiz) VALUES ('".$commentaire."', '".$_SESSION['iduser']."', '".$idquiz."')");
		$sth->execute();
		}
//prévenir le user que son commentaire est envoyé
//lui donner le choix de où il veut aller après
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<p>Votre commentaire a bien été enregistré!</p>
<?php
	if($_SESSION['Loger']) {$retour = './mesquiz.php';}
	else if ($_SESSION['Admin']) {$retour = './Admin/mesquiz.php';}
	echo '<a href="'.$retour.'">Retour aux quiz</a>';
	if($_SESSION['Loger']) {$accueil = './homepage.php';}
	else if ($_SESSION['Admin']) {$accueil = './Admin/homepage_admin.php';}
	echo '<a href="'.$accueil.'">Retour à l\'accueil</a>';
?>
</body>
</html>