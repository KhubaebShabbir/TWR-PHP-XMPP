<?php require_once 'global.inc.php';

$query=mysql_query("SELECT * FROM ofProperty WHERE name = 'maxCanned'") or die(mysql_error());
while($x=mysql_fetch_array($query)) {
	$a = $x['propValue'];
}
?>

<div class="tab-content-full">
  <h2>System Settings</h2>
  <hr/>
  <form id="settings-form" action="includes/ofsettings-exe.php" method="post">
    <label>Allowed Canned</label>
    <input type="text" name="a" value="<?php echo $a; ?>" />
    <br />
    <label>&nbsp;</label>
    <input type="submit" name="update" value="Update" />
    <br />
    <label>&nbsp;</label>
    <span class="error"></span>
  </form>
</div>
