<?php require_once ('global.inc.php');

$id = $_POST["domain"];
$c = $_POST["selectname"];

for ($i = 0; $i < count($c); $i++) {
	$users = $c[$i];
	$query2=mysql_query("INSERT INTO ofGroupUser (groupName,username) VALUES ('$id','$users')") or die('Duplicate entry');
	if($query2){
		echo '<tr><td>' .$users. '</td><td class="text-center"><a class="delete" href="includes/ofgroup-user-delete.php?id='.$users.'&&uid='.$id.'"><img src="assets/img/delete.png" alt="Delete"></a></td></tr>';
	}
}
?>

