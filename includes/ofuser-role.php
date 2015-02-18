<?php require_once ('global.inc.php'); ?>
  
<option value='all'>All</option>
<?php
$query=mysql_query("SELECT * FROM ofRoles WHERE role != 9") or die(mysql_error());
while($row=mysql_fetch_array($query)){
	$a=$row['username'];
	$b=$row['role'];
	echo "<option value='jidrole-".$b."'>".$a."</option>";
}; ?>
