<?php
include 'infosconnect.php';


include 'database.php';

// Si tout va bien, on peut continuer


// On récupère tout le contenu de la table apprenant



// On créer les fonctions pour les boutons

//if(isset($_POST['submit'])){
//$choix=$_POST['choix'];
//$query=mysqli_prepare($bdd, "INSERT INTO `questions`(`userans`) VALUES (?)");
//mysqli_stmt_bind_param($query,'s',$choix);
//$result=mysqli_stmt_execute($query);

if(isset($_POST['submit']))
{

  $choix=htmlspecialchars($_POST['choix']);
  $sql = $bdd->prepare("UPDATE questions
SET userans = '$choix'
WHERE idquestions = 1;");
  $sql->execute();

}

if(isset($_POST['check'])){
$sql2 = $bdd->query("SELECT bonnerep, userans FROM questions");
$compare = $sql2->fetch();
  if($compare['bonnerep']==$compare['userans']){

      echo 'bonne réponse';
  }
  else{
    echo 'mauvaise réponse';
  }

}

$reponse = $bdd->query('SELECT * FROM questions');
// On affiche chaque entrée une à une

while ($donnees = $reponse->fetch())

{

?>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
	<div>
<div>
  <p> Question :
    <?php echo $donnees['question']; ?>
  </p>
  <p> Réponse 1 :
    <?php echo $donnees['reponse1']; ?>
  </p>
  <p> Réponse 2 :
    <?php echo $donnees['reponse2']; ?>
  </p>
  <p> Réponse 3 :
    <?php echo $donnees['reponse3']; ?>
  </p>
  <p> Réponse 4 :
    <?php echo $donnees['reponse4']; ?>
  </p>
  <p> Bonne réponse :
    <?php echo $donnees['bonnerep']; ?>
  </p>
  <p> Ta réponse :
    <?php echo $donnees['userans']; ?>
  </p>
</div>

<form action="" method="post">
<table align="center">
<tr>
<td><?php echo $donnees['question']; ?></td>

</tr>
<tr>
<td></td>
<td><input type="radio" name="choix" value="<?php echo $donnees['reponse1']; ?>"><?php echo $donnees['reponse1']; ?></td>
</tr>
<tr>
<td></td>
<td><input type="radio" name="choix" value="<?php echo $donnees['reponse2']; ?>"><?php echo $donnees['reponse2']; ?></td>
</tr>
<tr>
<td></td>
<td><input type="radio" name="choix" value="<?php echo $donnees['reponse3']; ?>"><?php echo $donnees['reponse3']; ?></td>
</tr>
<tr>
<td></td>
<td><input type="radio" name="choix" value="<?php echo $donnees['reponse4']; ?>"><?php echo $donnees['reponse4']; ?></td>
</tr>
<tr>
<td><input type="submit" name="submit" value="submit"></td>
<td><input type="submit" name="check" value="check result"></td>
</tr>

</table>
</form>

</div>
</body>
<?php

}


$reponse->closeCursor(); // Termine le traitement de la requête


?>
