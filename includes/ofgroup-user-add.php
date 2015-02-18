<?php require_once 'global.inc.php';
$id=$_GET['id'];
?>
<script type="text/javascript">
	$.get('includes/ofuser-list.php', function(data){
		$( "select.select-mulitple" ).html(data);
	});
	
	var $getID = $('#results').attr('class');
	var repGroupallReps_get = $iq({type:'get', to:'pubsub.'+ wRep.host, id:'readallRepsxml'}).c('pubsub', {xmlns:'http://jabber.org/protocol/pubsub'}).c('items', {node:'webVisitors'}).c('item', {id: $getID +'-allReps'}).tree();
	wRep.connection.sendIQ(repGroupallReps_get, wRep.on_pubsub);
	$('h4').prepend($getID);
</script>

<h4 class="green"><?php echo $id; ?> Agents</h4>
<form id="add-groupUser" action="includes/ofgroup-user-add-exe.php" method="post">
  <input type="hidden" value="<?php echo $id; ?>" name="domain" />
  <label>Agents</label>
  <select class="select-mulitple" name="selectname[]" multiple="multiple">
  </select>
  <br />
  <label>&nbsp;</label>
  <input type="submit" value="Add" name="submit" />
  <br />
  <label>&nbsp;</label>
  <span class="error"></span>
</form>
<table id="group-users" class="table-list">
  <thead>
  <th class="gray">Agent</th>
    <th class="gray">Remove</th>
      </thead>
    <?php
	$query2 = mysql_query("SELECT * FROM ofGroupUser WHERE groupName = '$id' ");
	while ($lumsum=mysql_fetch_array($query2)){
		$q=$lumsum['username'];
		echo '<tr><td>' .$q. '</td>';
		echo '<td class="text-center"><a class="delete" href="includes/ofgroup-user-delete.php?id='.$q.'&&uid='.$id.'"><img src="assets/img/delete.png" alt="Delete"></a></td></tr>';
	}
?>
</table>
