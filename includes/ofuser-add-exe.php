<?php require_once 'global.inc.php';

$_a = mysql_real_escape_string($_POST["x"]);
$_b = mysql_real_escape_string($_POST["z"]);
$_c = $_POST["role"];

$domain_query=mysql_query("SELECT * FROM ofProperty WHERE name = 'xmpp.domain'")or die (mysql_error());
while($domain=mysql_fetch_array($domain_query)){
	$domain_name=$domain['propValue'];
};
$_compare_username = mysql_query("SELECT * FROM ofRoles WHERE username = '$_a'") or die (mysql_error());
	
if(mysql_num_rows($_compare_username)){ // compare Username
	echo "USER ".$_a ." alreay exist";
} else {
	mysql_query("INSERT INTO ofRoles (username, role) VALUES ('$_a', '$_c')") or die(mysql_error());
	mysql_query( "INSERT INTO ofGroupUser (groupName, username) VALUES ('thewebreps', '$_a')") or die(mysql_error());
		if ($_c == 0){
		$conf_jids=mysql_query("SELECT * FROM ofMucServiceProp WHERE name = 'sysadmin.jid'")or die(mysql_error());
		if(mysql_num_rows($conf_jids)){
			$jids_row=mysql_fetch_array($conf_jids);
			$jids=$jids_row['propValue'];
		
			$jids_add=$jids.','.$_a.'@'.$domain_name;
			mysql_query("update ofMucServiceProp SET propValue = '$jids_add' WHERE name = 'sysadmin.jid'")or die(mysql_error());
		} else {
			mysql_query("INSERT INTO ofMucServiceProp (serviceID, name, propValue) VALUES ('1', 'sysadmin.jid', '$_a@$domain_name')")or die(mysql_error());		
		}
		?>
		<script type="text/javascript">
			// assigned jid admin as owner to allRepsVisits
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'ownallRepsVisits'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'allRepsVisits'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'owner'}).tree());
			
			// assigned jid admin as owner to webVisitors
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'ownwebVisitors'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'webVisitors'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'owner'}).tree());
			
			// assigned jid admin as owner to visitorQueues
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'ownvisitorQueues'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'visitorQueues'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'owner'}).tree());
		
			// assigned jid admin as subscribe to allRepsVisits
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'suballRepsVisits'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'allRepsVisits'}).c('subscription', {'jid':'<?php echo $_a; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
			
			// assigned jid admin as subscriber to webVisitors
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'subwebVisitors'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'webVisitors'}).c('subscription', {'jid':'<?php echo $_a; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
			
			// assigned jid admin as subscriber to visitorQueues
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'subvisitorQueues'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'visitorQueues'}).c('subscription', {'jid':'<?php echo $_a; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
        </script>
<?php
		$select_reps = mysql_query("SELECT * FROM ofRoles WHERE role < 9")or die (mysql_error());
		?>
		<script type="text/javascript">
<?php
		while($name_row = mysql_fetch_array($select_reps)){
			$reps = $name_row['username'];
		?>
			// assigned jid admin as owner to all webRep repStats
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'own<?php echo $reps; ?>-repStats'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'<?php echo $reps; ?>-repStats'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'owner'}).tree());
			
			// assigned jid admin as owner to all webRep assignedRGs
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'own<?php echo $reps; ?>-assignedRGs'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'<?php echo $reps; ?>-assignedRGs'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'owner'}).tree());
<?php
		}
		?>
		</script>
<?php
		$select_reps = mysql_query("SELECT * FROM ofRoles WHERE username != '$_a' AND role < 9")or die (mysql_error());
		?>
		<script type="text/javascript">
<?php
		while($name_row = mysql_fetch_array($select_reps)){
			$allreps = $name_row['username'];
		?>
			// assigned jid admins subscriber to all repStats
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'sub<?php echo $allreps; ?>-repStats'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'<?php echo $allreps; ?>-repStats'}).c('subscription', {'jid':'<?php echo $_a ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
		
			// assigned jid admin subscriber to all assignedRGs
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'sub<?php echo $allreps; ?>-assignedRGs'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'<?php echo $allreps; ?>-assignedRGs'}).c('subscription', {'jid':'<?php echo $_a; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
<?php
		}
		?>
		</script>
<?php
		$select_groups = mysql_query("SELECT * FROM ofRoles WHERE role = 9")or die (mysql_error());
		?>
		<script type="text/javascript">
<?php
		while($name_row = mysql_fetch_array($select_groups)){
			$groups = $name_row['username'];
		?>
			// assigned jid admin as owner to repGroup repGroup
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'own<?php echo $groups; ?>-repGroup'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'<?php echo $groups; ?>-repGroup'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'owner'}).tree());
			
			// assigned jid admin as owner to all repGroup visits
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'own<?php echo $groups; ?>-visits'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'<?php echo $groups; ?>-visits'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'owner'}).tree());
			
			// assigned jid admin as subscriber to repGroup repGroup
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'sub<?php $groups; ?>-repGroup'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'<?php echo $groups; ?>-repGroup'}).c('subscription', {'jid':'<?php echo $_a; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
			
			// assigned jid admin as subsriber to all repGroup visits
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'sub<?php $groups; ?>-visits'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'<?php echo $groups; ?>-visits'}).c('subscription', {'jid':'<?php echo $_a; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
		
<?php
		}
		?>
		</script>
<?php
	} else if($_c == 1){
		$conf_jids=mysql_query("SELECT * FROM ofMucServiceProp WHERE name = 'sysadmin.jid'")or die (mysql_error());
		$jids_row=mysql_fetch_array($conf_jids);
		$jids=$jids_row['propValue'];
	
		$jids_add=$jids.','.$_a.'@'.$domain_name;
		$dd=mysql_query("update ofMucServiceProp SET propValue = '$jids_add' WHERE name = 'sysadmin.jid'")or die (mysql_error());
		?>
		<script type="text/javascript">
			// assigned jid superRep as publisher to jid repStats
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'pub<?php echo $_a; ?>-repStats'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'<?php echo $_a; ?>-repStats'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'publisher'}).tree());

			// assigned jid superRep as publisher to allRepsVisits
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'puballRepsVisits'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'allRepsVisits'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'publisher'}).tree());
			
			// assigned jid superRep as publisher to webVisitors
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'pubwebVisitors'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'webVisitors'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'publisher'}).tree());
			
			// assigned jid superRep as publisher to visitorQueues
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'pubvisitorQueues'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'visitorQueues'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'publisher'}).tree());
		
			// assigned jid superRep as subscriber to allRepsVisits
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'suballRepsVisits'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'allRepsVisits'}).c('subscription', {'jid':'<?php echo $_a; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
			
			// assigned jid superRep as subscriber to webVisitors
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'subwebVisitors'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'webVisitors'}).c('subscription', {'jid':'<?php echo $_a; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
			
			// assigned jid superRep as subscriber to visitorQueues
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'subvisitorQueues'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'visitorQueues'}).c('subscription', {'jid':'<?php echo $_a; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
		</script>
<?php
		$select_reps = mysql_query("SELECT * FROM ofRoles WHERE role < 9")or die (mysql_error());
		?>
        <script type="text/javascript">
<?php
		while($name_row = mysql_fetch_array($select_reps)){
			$reps = $name_row['username'];
		?>
			// assigned jid superRep as publisher to all webRep assignedRGs
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'pub<?php echo $reps; ?>-assignedRGs'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'<?php echo $reps; ?>-assignedRGs'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'publisher'}).tree());
<?php
		}
		?>
		</script>
<?php
		$select_reps = mysql_query("SELECT * FROM ofRoles WHERE username != '$_a' AND role < 9")or die (mysql_error());
		?>
		<script type="text/javascript">
<?php
		while($name_row = mysql_fetch_array($select_reps)){
			$allreps = $name_row['username'];
		?>
			// assigned jid superRep subscriber to all repStats
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'sub<?php echo $allreps; ?>-repStats'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'<?php echo $allreps; ?>-repStats'}).c('subscription', {'jid':'<?php echo $_a; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
		
			// assigned jid superRep subscriber to all assignedRGs
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'sub<?php echo $allreps; ?>-assignedRGs'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'<?php echo $allreps; ?>-assignedRGs'}).c('subscription', {'jid':'<?php echo $_a; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
<?php
		}
		?>
		</script>
<?php
		$select_groups = mysql_query("SELECT * FROM ofRoles WHERE role = 9")or die (mysql_error());
		?>
		<script type="text/javascript">
<?php
		while($name_row = mysql_fetch_array($select_groups)){
			$groups = $name_row['username'];
		?>
			// assigned jid superRep as subscriber to all repGroup repGroup
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'sub<?php $groups; ?>-repGroup'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'<?php echo $groups; ?>-repGroup'}).c('subscription', {'jid':'<?php echo $_a; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
			
			// assigned jid superRep as subsriber to all repGroup visits
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'sub<?php $groups; ?>-visits'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'<?php echo $groups; ?>-visits'}).c('subscription', {'jid':'<?php echo $_a; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
<?php
		}
		?>
		</script>
<?php
	} else if($_c == 2){
		?>
		<script type="text/javascript">
			// assigned jid deployRep as owner to allRepsVisits
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'ownallRepsVisits'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'allRepsVisits'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'owner'}).tree());
			
			// assigned jid deployRep as owner to webVisitors
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'ownwebVisitors'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'webVisitors'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'owner'}).tree());
			
			// assigned jid deployRep as owner to visitorQueues
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'ownvisitorQueues'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'visitorQueues'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'owner'}).tree());
			
			// assigned jid deployRep as subscriber to webVisitors
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'subwebVisitors'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'webVisitors'}).c('subscription', {'jid':'<?php echo $_a; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
			
			// assigned jid deployRep as subscriber to visitorQueues
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'subvisitorQueues'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'visitorQueues'}).c('subscription', {'jid':'<?php echo $_a; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
        </script>
<?php
		$select_reps = mysql_query("SELECT * FROM ofRoles")or die (mysql_error());
		?>
		<script type="text/javascript">
<?php
		while($name_row = mysql_fetch_array($select_reps)){
			$reps = $name_row['username'];
		?>

			// assigned jid deployRep as owner to all webRep repStats
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'own<?php echo $reps; ?>-repStats'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'<?php echo $reps; ?>-repStats'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'owner'}).tree());
			
			// assigned jid deployRep as owner to all webRep assignedRGs
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'own<?php echo $reps; ?>-assignedRGs'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'<?php echo $reps; ?>-assignedRGs'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'owner'}).tree());

<?php
		}
		?>
		</script>
<?php
		$select_groups = mysql_query("SELECT * FROM ofRoles WHERE role = 9")or die (mysql_error());
		?>
		<script type="text/javascript">
<?php
		while($name_row = mysql_fetch_array($select_groups)){
			$groups = $name_row['username'];
		?>
			// assigned jid deployRep as owner to all repGroup repGroup
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'own<?php echo $groups; ?>-repGroup'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'<?php echo $groups; ?>-repGroup'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'owner'}).tree());
			
			// assigned jid deployRep as owner to all repGroup visits
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'own<?php echo $groups; ?>-visits'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'<?php echo $groups; ?>-visits'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'owner'}).tree());
			
			// assigned jid deployRep as subscriber to all repGroup repGroup
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'sub<?php $groups; ?>-repGroup'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'<?php echo $groups; ?>-repGroup'}).c('subscription', {'jid':'<?php echo $_a; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
<?php
		}
		?>
		</script>
<?php
	} else if($_c == 3) {
		?>
		<script type="text/javascript">
			// assigned jid as publisher to jid repStats
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'pub<?php echo $_a; ?>-repStats'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'<?php echo $_a; ?>-repStats'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'publisher'}).tree());

			// assigned jid doplyRep and reps as subscriber to jid assignedRgs
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'sub<?php echo $_a; ?>-assignedRGs'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'<?php echo $_a; ?>-assignedRGs'}).c('subscription', {'jid':'<?php echo $_a; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
			
			// assigned jid as publisher to allRepsVisits
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'pub<?php echo $_a; ?>allRepsVisits'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'allRepsVisits'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'publisher'}).tree());
        
        </script>
        
<?php
	}
	
	$select_owners = mysql_query("SELECT * FROM ofRoles WHERE role = 0 OR role = 2")or die (mysql_error());
	?>
	<script type="text/javascript">
<?php
	while($name_row = mysql_fetch_array($select_owners)){
		$owners = $name_row['username'];
		?>
		// assigned all admins and doplyRep as owner to repStats
		wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'own<?php echo $owners; ?>-repStats'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'<?php echo $_a; ?>-repStats'}).c('affiliation', { 'jid':'<?php echo $owners; ?>@'+ wRep.host, 'affiliation':'owner'}).tree());
			
		// assigned all admins and doplyRep as owner to assignedRgs
		wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'own<?php echo $owners; ?>-assignedRGs'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'<?php echo $_a; ?>-assignedRGs'}).c('affiliation', { 'jid':'<?php echo $owners; ?>@'+ wRep.host, 'affiliation':'owner'}).tree());
<?php
	}
	?>
	</script>
<?php
	
	$select_subscribers = mysql_query("SELECT * FROM ofRoles WHERE role <= 1")or die (mysql_error());
	?>
	<script type="text/javascript">
<?php
	while($name_row = mysql_fetch_array($select_subscribers)){
		$subscribe = $name_row['username'];
		?>
			// assigned jid subscriber to jid repStats
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'sub<?php echo $_a; ?>-repStats'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'<?php echo $_a; ?>-repStats'}).c('subscription', {'jid':'<?php echo $subscribe; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
		
			// assigned jid subscriber to jid assignedRGs
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'sub<?php echo $_a; ?>-assignedRGs'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node':'<?php echo $_a; ?>-assignedRGs'}).c('subscription', {'jid':'<?php echo $subscribe; ?>@'+ wRep.host, 'subscription':'subscribed'}).tree());
<?php
	}
	?>
	// assigned jid superRep as publisher to jid repStats
	wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, id:'pubipAdress'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':'ipAddress'}).c('affiliation', { 'jid':'<?php echo $_a; ?>@'+ wRep.host, 'affiliation':'publisher'}).tree());
	</script>
<?php
};
?>