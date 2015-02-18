<?php require_once 'global.inc.php';

$a = mysql_real_escape_string($_POST['x']);

$_compare_user = mysql_query("SELECT * FROM ofRoles WHERE username = '$a'") or die (mysql_error());

if(mysql_num_rows($_compare_user)){ // compare Domain and username
	echo "Domain ". $a ." alreay exist";
} else {
	$role_query = mysql_query("INSERT INTO ofRoles (username, role) VALUES ('$a', '9')") or die(mysql_error());
	?>
    <script type="text/javascript">
		wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'<?php echo $a; ?>-visits'}).c('subscription', {'jid':'<?php echo $a; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
	</script>
<?php

	$select_owners = mysql_query("SELECT * FROM ofRoles WHERE role = 0 OR role = 2");
	while($name_row = mysql_fetch_array($select_owners)){
		$owners = $name_row['username'];
		?>
		<script type="text/javascript">
				wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'<?php echo $a; ?>-repGroup'})
				.c('affiliation', { 'jid':'<?php echo $owners; ?>@'+ wRep.host, 'affiliation':'owner'}).up().tree());
				
				wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'<?php echo $a; ?>-visits'})
				.c('affiliation', { 'jid':'<?php echo $owners; ?>@'+ wRep.host, 'affiliation':'owner'}).up().tree());
		</script>
	<?php
	}
	
	$select_subscribers = mysql_query("SELECT * FROM ofRoles WHERE role = 0 OR role = 1 OR role = 2");
	while($name_row = mysql_fetch_array($select_subscribers)){
		$subscribe = $name_row['username'];
		?>
		<script type="text/javascript">
					wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'<?php echo $a; ?>-repGroup'}).c('subscription', {'jid':'<?php echo $subscribe; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
		</script>
<?php
	}
	
	$select_subscribers = mysql_query("SELECT * FROM ofRoles WHERE role = 0 OR role = 1");
	while($name_row = mysql_fetch_array($select_subscribers)){
		$subscribe = $name_row['username'];
	?>
	<script type="text/javascript">
		wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'<?php echo $a; ?>-visits'}).c('subscription', {'jid':'<?php echo $subscribe; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
	</script>
    <?php
	}
};
?>