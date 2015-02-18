<?php require_once 'global.inc.php';

$group=$_GET['id'];
$match=mysql_query("SELECT * FROM ofGroup WHERE groupName='$group'") or die(mysql_error());
while($row=mysql_fetch_array($match)){
	$a=$row['groupName'];
	$b=$row['description'];
};
?>

<h4 class="blue">Edit Group</h4>
<form id="add-group" class="submit-form" action="includes/ofgroup-edit-exe.php" method="post">
	<label>Domain Name</label>
    <input type="text" name="x" value="<?php echo $a ?>" />
    <br />
    <label>Description</label>
    <textarea name="a"><?php echo $b ?></textarea>
    <br />
    <label>&nbsp;</label>
    <input type="submit" value="Update" name="submit" />
    <br />
    <label>&nbsp;</label>
    <span class="error"></span>
</form>