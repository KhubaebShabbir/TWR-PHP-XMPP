<?php require_once 'global.inc.php';
$user=$_GET['id'];
$match=mysql_query("SELECT * FROM ofUser WHERE username='$user'") or die(mysql_error());
while($row=mysql_fetch_array($match)){
	$a=$row['username'];
	$c=$row['email'];
	$d=$row['name'];
	$f=$row['creationDate']/1000;
	$fDate=date("F, d Y H:i A", $f);
	
	$r_match=mysql_query("SELECT * FROM ofRoles WHERE username='$user'") or die(mysql_error());
	while($r_row=mysql_fetch_array($r_match)){
		$role=$r_row['role'];
	};
	
};
?>

<h4 class="blue">Edit User</h4>
<form id="edit-user" class="edit-form" action="includes/ofuser-edit-exe.php" method="post">
  <label>username</label>
  <input type="text" name="x" value="<?php echo $a ?>" disabled="disabled" />
  <br />
  <label>Email</label>
  <input type="text" name="y" value="<?php echo $c ?>" />
  <br />
  <label>Full Name</label>
  <input type="text" name="a" value="<?php echo $d ?>" />
  <br />
  <?php if(($role!=9)) { ?>
  <label>Account Type</label>
  AdminRep <input type="radio" name="role" <?php echo ($role==0)?'checked':'' ?> value="0" />
  SuperRep <input type="radio" name="role" <?php echo ($role==1)?'checked':'' ?> value="1" />
  DeployRep <input type="radio" name="role" <?php echo ($role==3)?'checked':'' ?> value="3" />
  WebRep <input type="radio" name="role" <?php echo ($role==4)?'checked':'' ?> value="4" />
  <br />
  <?php }; ?>
  <label>&nbsp;</label>
  <input type="submit" name="submit" value="Submit" />
  <br />
  <label>&nbsp;</label>
  <span class="error"></span>
</form>
