<?php require_once 'global.inc.php';

$deleteID=$_GET['id'];
$d_query=mysql_query("DELETE FROM ofRoles WHERE username='$deleteID'") or die (mysql_error());

if($d_query){
	mysql_query("DELETE FROM ofUser WHERE username='$deleteID'") or die (mysql_error());
	?>

<script type="text/javascript">
	// Delete script file
	wRep.connection.sendIQ($iq({'type':'set','to':'pubsub.'+ wRep.host}).c('pubsub',{'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('delete', {'node':'<?php echo $deleteID; ?>-visits'}).tree());
	wRep.connection.sendIQ($iq({'type':'set','to':'pubsub.'+ wRep.host}).c('pubsub',{'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('delete', {'node':'<?php echo $deleteID; ?>-repGroup'}).tree());
	
	wRep.connection.sendIQ($iq({'type':'set','to':'pubsub.'+ wRep.host}).c('pubsub',{'xmlns':'http://jabber.org/protocol/pubsub'}).c('retract', {'node':'webVisitors'}).c('item', {id:'<?php echo $deleteID; ?>-status'}).tree());
	wRep.connection.sendIQ($iq({'type':'set','to':'pubsub.'+ wRep.host}).c('pubsub',{'xmlns':'http://jabber.org/protocol/pubsub'}).c('retract', {'node':'webVisitors'}).c('item', {id:'<?php echo $deleteID; ?>-allReps'}).tree());
	wRep.connection.sendIQ($iq({'type':'set','to':'pubsub.'+ wRep.host}).c('pubsub',{'xmlns':'http://jabber.org/protocol/pubsub'}).c('retract', {'node':'webVisitors'}).c('item', {id:'<?php echo $deleteID; ?>-script'}).tree());
	wRep.connection.sendIQ($iq({'type':'set','to':'pubsub.'+ wRep.host}).c('pubsub',{'xmlns':'http://jabber.org/protocol/pubsub'}).c('retract', {'node':'visitorQueues'}).c('item', {id:'<?php echo $deleteID; ?>-active'}).tree());
</script>

<?php
};
?>