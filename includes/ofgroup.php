<?php require_once 'global.inc.php'; ?>

<ul class="content-options">
    <li class="total"></li>
    <li><a class="edit" href="includes/ofgroup-add.php" title="Add Domain"><img src="assets/img/add-agent.png" alt="Add Domain" /></a></li>
    <li><a id="groups-reload" class="reload" href="includes/ofgroup.php" title="Reload"><img src="assets/img/refresh.png" alt="Reload" /></a></li>
</ul>
<div class="tab-content-full">
  <h2>Groups List</h2>
<?php
$query=mysql_query("SELECT * FROM ofGroup WHERE groupName != 'thewebreps'") or die(mysql_error());
$totalrows = mysql_num_rows($query);
	echo "<script type=\"text/javascript\">
		$(function(){
			$('li.total:visible').html('Total Groups: ".$totalrows."')
		})
		</script>";
?>
  <table id="group-users" class="table-list">
    <thead>
    <th class="red">Group</th>
      <th class="orange">Description</th>
      <th class="green">Agents</th>
      <th class="purple">Edit</th>
      <th class="red">Delete</th>
        </thead>
<?php
while($row=mysql_fetch_array($query)){
	$a=$row['groupName'];
	$c=$row['description'];
	
	$queryR=mysql_query("SELECT * FROM ofGroupUser WHERE groupName = '$a'");
	$y=mysql_num_rows($queryR);
	
	echo '<tr><td>'.$a.'</td>';
	echo '<td>'.$c.'</td>';
	echo '<td>'.$y.' <a class="edit" href="includes/ofgroup-user-add.php?id='.$a.'"> Edit</a></td>';
	echo '<td class="text-center"><a class="edit" href ="includes/ofgroup-edit.php?id='.$a.'"><img src="assets/img/edit.png" alt="Edit"></a></td>';
	echo '<td class="text-center"><a class="delete" href ="includes/ofgroup-delete.php?id='.$a.'"><img src="assets/img/delete.png" alt="Delete"></a></tr>';
};
?>
  </table>
</div>