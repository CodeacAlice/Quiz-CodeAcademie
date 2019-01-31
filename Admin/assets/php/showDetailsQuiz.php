<?php
require_once '../../../database.php';

$q = intval($_GET['q']);
//$mysqli->select_db("ajax_demo");
$sth = $bdd->prepare('SELECT * FROM quiz ORDER BY titre');
		$sth->execute();
		$result = $sth->fetchAll();
		if($sth->rowCount()) {
			foreach($result as $row){
				echo 'test';
			}
		}

//mysqli_close($con);
?>