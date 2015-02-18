<?php require_once ('global.inc.php');

$a = $_SESSION['user'];
$b = $_POST['id'];

$Query=mysql_query("SELECT * FROM ofIPblock WHERE ip = '$a'") or die(mysql_error());
$compare_ip = mysql_num_rows($Query);
if($compare_ip == 0){
	$query = mysql_query("INSERT INTO ofIPblock (username, ip) VALUES ('$a', '$b')") or die(mysql_error());
} else {
	$query = mysql_query("DELETE * FROM ofIPblock WHERE ip = '$a'") or die(mysql_error());
}
?>