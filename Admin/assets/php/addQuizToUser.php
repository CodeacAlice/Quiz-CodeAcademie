<?php
require_once '../../../database.php';

$iduser = intval($_GET['user']);
$idquiz = intval($_GET['quiz']);

$sth = $bdd->prepare("INSERT INTO users_has_quiz (users_idusers, quiz_idquiz, quiz_done) 
	VALUES ('".$iduser."', '".$idquiz."', 0)");
$sth->execute();