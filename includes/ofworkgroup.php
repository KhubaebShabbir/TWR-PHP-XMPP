<?php require_once 'global.inc.php'; ?>

<ul class="content-options">
    <li class="total"></li>
    <li><a id="add-domain" class="edit" href="includes/ofworkgroup-add.html" title="Add Domain"><img src="assets/img/add-agent.png" alt="Add Domain" /></a></li>
    <li><a id="groups-reload" class="reload" href="includes/ofworkgroup.php" title="Reload"><img src="assets/img/refresh.png" alt="Reload" /></a></li>
</ul>
<div class="tab-content-full">
<h2>Domains</h2>
<?php
$query=mysql_query("SELECT * FROM ofRoles WHERE role = 9") or die(mysql_error());
$totalrows = mysql_num_rows($query);
	echo "<script type=\"text/javascript\">
			$('li.total:visible').html('Total Domains: ".$totalrows."');
		</script>";
?>
  <table id="wglist" class="table-list">
    <thead>
    <th class="orange">Domain</th>
      <th class="orange">Agents</th>
<?php if($_SESSION["role"] != 1) { ?>
      <th class="deepY">Canned</th>
      <th class="deepY">Departments</th>
      <th class="green">Info</th>
      <th class="green">Script</th>
      <th class="blue">Status</th>
<?php } ?>
      <th class="blue">Active Queues</th>
<?php if($_SESSION["role"] != 1) ?>
      <th class="purple">Edit</th>
      <th class="red">Delete</th>
        </thead>
<?php
while($row=mysql_fetch_array($query)){
	$a=$row['username'];
	
	echo '<tr class='. $a .'><td><a target="_blank" href="http://'.$a.'">'.$a.'</a></td>';
	echo '<td class="text-center"><a class="edit" href="includes/ofworkgroup-user-add.html"><img src="assets/img/agents.png" alt="Agents" /></a></td>';
	if($_SESSION["role"] != 1) {
	echo '<td class="text-center"><a class="edit" href="includes/ofworkgroup-canned.html"><img src="assets/img/canned.png" alt="Canned" /></a></td>';
	echo '<td class="text-center"><a class="edit" href="includes/ofworkgroup-depts.html"><img src="assets/img/department.png" alt="Departments" /></a></td>';
	echo '<td class="text-center"><a class="edit" href="includes/ofworkgroup-script.html"><img src="assets/img/info.png" alt="Info"></a></td>';
	echo '<td class="text-center"><a class="edit" href="includes/ofworkgroup-script.html"><img src="assets/img/settings.png" alt="Settings"></a></td>';
	echo '<td class="text-center"><a class="edit" href="includes/ofworkgroup-status.html"><img src="assets/img/status.png" alt="Service Service"></a></td>';
	}
	echo '<td class="text-center"><a class="edit" href="includes/ofworkgroup-queue.html"><img src="assets/img/queue.png" alt="Queues"></a></td>';
	if($_SESSION["role"] != 1) {
	echo '<td class="text-center"><a class="edit" href="includes/ofworkgroup-edit.php?id='.$a.'"><img src="assets/img/edit.png" alt="Edit"></a></td>';
	echo '<td class="text-center"><a class="delete" href="includes/ofworkgroup-delete.php?id='.$a.'"><img src="assets/img/delete.png" alt="Delete"></a></tr>';
	}
};
?>
  </table>
</div>