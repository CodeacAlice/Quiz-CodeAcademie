<?php
include 'infosconnect.php';
include 'database.php';

$numero = 1 ;
// On créer les fonctions pour les boutons

if(isset($_POST['submit']))
{
  $choix=htmlspecialchars($_POST['choix']);
  $sql = $bdd->prepare("UPDATE questions
    SET userans = '$choix'
    WHERE nowques = num_question
    ;");
  $sql->execute();
  $sql2 = $bdd->query("SELECT bonnerep, userans
    FROM questions
    WHERE num_question = nowques;
  ");
  $compare = $sql2->fetch();
    if($compare['bonnerep']===$compare['userans']){
        echo 'bonne réponse';
    }
    else{
        echo 'mauvaise réponse';
      }

}


if(isset($_POST['next']))
{
$numero++;
$sql = $bdd->prepare("UPDATE questions
  SET nowques = nowques + 1
  ;");
$sql->execute();

}



?>
<h2>Choisissez un quiz.</h2>
<form action="" method="post">
<td>
  <input type="text" name="numquiz">
  <input type="submit" name="envoie" value="envoie">
</td>
</form>
<?php

if(isset($_POST['envoie'])){

$idquiz = htmlspecialchars($_POST['numquiz']);
echo $idquiz;
$monquiz = $bdd->prepare("UPDATE quiz
SET userquiz = 1
WHERE idquiz = '$idquiz';");

$pasmonquiz = $bdd->prepare("UPDATE quiz
SET userquiz = 0
WHERE NOT idquiz ='$idquiz';");

$monquiz->execute();
$pasmonquiz->execute();
}

$reponse = $bdd->query('SELECT * FROM questions INNER JOIN quiz ON questions.quiz_idquiz = quiz.idquiz Where userquiz = 1 AND num_question = nowques; ');


// On affiche chaque entrée une à une

while ($donnees = $reponse->fetch())

{

?>

<div>
  <p>idquiz:
    <?php echo $donnees['quiz_idquiz']; ?>
  </p>
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
<td><input type="submit" name="next" value="next"></td>
</tr>

</table>
</form>

<?php


}


$reponse->closeCursor(); // Termine le traitement de la requête


?>
