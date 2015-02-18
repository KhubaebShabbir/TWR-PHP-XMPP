<?php require_once 'global.inc.php';

$deleteID=$_GET['id'];
$r_match=mysql_query("DELETE FROM ofRoles WHERE username='$deleteID'") or die (mysql_error());
if($r_match) {
	mysql_query("DELETE FROM ofPrivate WHERE username='$deleteID'") or die (mysql_error());
	$u_match=mysql_query("DELETE FROM ofGroupUser WHERE username='$deleteID'") or die (mysql_error());
	$u_match=mysql_query("DELETE FROM ofUser WHERE username='$deleteID'") or die (mysql_error());
	if ($u_match){ ?>

<script type="text/javascript">
	wRep.connection.sendIQ($iq({'type':'set','to':'pubsub.'+ wRep.host}).c('pubsub',{'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('delete', {'node':'<?php echo $deleteID; ?>-repStats'}).tree());
	wRep.connection.sendIQ($iq({'type':'set','to':'pubsub.'+ wRep.host}).c('pubsub',{'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('delete', {'node':'<?php echo $deleteID; ?>-assignedRGs'}).tree());
</script>

<?php
		$query=mysql_query('SELECT * FROM ofUser') or die(mysql_error());
		$totalrows = mysql_num_rows($query);
		echo "Total Users: ".$totalrows;
	}
}
?>