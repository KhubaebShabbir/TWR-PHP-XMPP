<?php require_once 'global.inc.php';

$wg=$_GET['id'];
$match=mysql_query("SELECT * FROM ofUser WHERE username='$wg'") or die(mysql_error());
while($row=mysql_fetch_array($match)){
	$a=$row['username'];
	$c=$row['email'];
	$d=$row['name'];	
};
?>
 
<h4 class="blue">Edit Domain</h4>
<form id="edit-domain-form" action="includes/ofworkgroup-edit-exe.php" method="post">
  <label>Domain</label>
  <input type="text" name="x" value="<?php echo $a ?>" disabled="disabled" />
  <br />
  <label>Email</label>
  <input type="text" value="<?php echo $c ?>" name="y" />
  <br />
  <label>Name</label>
  <input type="text" value="<?php echo $d ?>" name="a" />
  <br />
  <label>&nbsp;</label>
  <input type="submit" name="submit" value="Add" />
  <br />
  <label>&nbsp;</label>
  <span class="error"></span>
</form>