<?php require_once ('connection.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Install</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css" media="screen" />
    <script src="../assets/js/jquery-1.10.1.min.js"></script>
    <script src="../assets/js/strophe.min.js"></script>
	<script type="text/x-javascript">
//------------------------------------------Strophe functions for openfire
//------------wRep Class
var wRep = {
	connection: null,
	host: 'inspiron', //subdomain.domain.com
	xmppServer: "http://localhost:7070/http-bind/XMPP", //---http://www.domain.com/XMPP
	
	log: function(msg) {
	$('span.xmpp-status').empty().append(msg);
	},
	
	connect_status: function(status) {
		if (status === Strophe.Status.CONNECTED) {
			wRep.log('Disconnected');
			$(document).trigger('connected');
		} else if (status === Strophe.Status.DISCONNECTED) {
			wRep.log('Disconnected');
		} else
            wRep.log("Error Status: "+ status);
	}
};//------------wRep Class

// ready function
(function($){
$(document).on('submit', '#install', function(event){
	event.preventDefault();
	wRep.connection = new Strophe.Connection(wRep.xmppServer);
	wRep.connection.connect($('#username').val() +'@'+ wRep.host, $('#pass').val(), wRep.connect_status);
	});

	$(document).on('connected', function(){
		// publish node of allRepVisits
		var allRepVisits_Set = $iq({type: 'set', to: 'pubsub.'+ wRep.host, id: 'setAndConfigureNodeForallRepsVisits'})
		.c('pubsub', {xmlns: 'http://jabber.org/protocol/pubsub'})
		.c('create', {node: 'allRepsVisits'}).up()
		.c('configure')
		.c('x', {xmlns: 'jabber:x:data', type: 'submit'})
		.c('field', {var: 'pubsub#title'})
		.c('value').t('allRepsVisits').up().up()
		.c('field', {var: 'pubsub#description'})
		.c('value').t('Active Visits of all WebReps').up().up()
		.c('field', {var: 'pubsub#node_type'})
		.c('value').t('leaf').up().up()
		.c('field', {var: 'pubsub#subscribe'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#deliver_payloads'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#notify_config'})
		.c('value').t('0').up().up()
		.c('field', {var: 'pubsub#notify_delete'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#notify_retract'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#presence_based_delivery'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#access_model'})
		.c('value').t('open').up().up()
		.c('field', {var: 'pubsub#language'})
		.c('value').t('NUMBERS').up().up()
		.c('field', {var: 'pubsub#send_item_subscribe'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#persist_items'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#max_items'})
		.c('value').t('-1')
		.tree();
		wRep.connection.sendIQ(allRepVisits_Set);
		
		// publish webVisitors node
		var webVisitors_set = $iq({type: 'set', to: 'pubsub.'+ wRep.host, id: 'setAndConfigureNodeWebVisitors'})
		.c('pubsub', {xmlns: 'http://jabber.org/protocol/pubsub'})
		.c('create', {node: 'webVisitors'}).up()
		.c('configure')
		.c('x', {xmlns: 'jabber:x:data', type: 'submit'})
		.c('field', {var: 'pubsub#title'})
		.c('value').t('webVisitors').up().up()
		.c('field', {var: 'pubsub#description'})
		.c('value').t('Has Script Sttings, all agents and Service Status etc ').up().up()
		.c('field', {var: 'pubsub#node_type'})
		.c('value').t('leaf').up().up()
		.c('field', {var: 'pubsub#subscribe'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#deliver_payloads'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#notify_config'})
		.c('value').t('0').up().up()
		.c('field', {var: 'pubsub#notify_delete'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#notify_retract'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#presence_based_delivery'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#access_model'})
		.c('value').t('open').up().up()
		.c('field', {var: 'pubsub#language'})
		.c('value').t('Variables').up().up()
		.c('field', {var: 'pubsub#send_item_subscribe'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#persist_items'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#max_items'})
		.c('value').t('-1')
		.tree();
		wRep.connection.sendIQ(webVisitors_set);
		
		// publish visitorQueues
		var visitorQueues_set = $iq({type: 'set', to: 'pubsub.'+ wRep.host, id: 'setAndConfigureNodeVisitorQueues'})
		.c('pubsub', {xmlns: 'http://jabber.org/protocol/pubsub'})
		.c('create', {node: 'visitorQueues'}).up()
		.c('configure')
		.c('x', {xmlns: 'jabber:x:data', type: 'submit'})
		.c('field', {var: 'pubsub#title'})
		.c('value').t('visitorQueues').up().up()
		.c('field', {var: 'pubsub#description'})
		.c('value').t('Each REPGROUP’s active queues').up().up()
		.c('field', {var: 'pubsub#node_type'})
		.c('value').t('leaf').up().up()
		.c('field', {var: 'pubsub#subscribe'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#deliver_payloads'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#notify_config'})
		.c('value').t('0').up().up()
		.c('field', {var: 'pubsub#notify_delete'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#notify_retract'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#presence_based_delivery'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#access_model'})
		.c('value').t('open').up().up()
		.c('field', {var: 'pubsub#language'})
		.c('value').t('Queues').up().up()
		.c('field', {var: 'pubsub#send_item_subscribe'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#persist_items'})
		.c('value').t('1').up().up()
		.c('field', {var: 'pubsub#max_items'})
		.c('value').t('-1')
		.tree();
		wRep.connection.sendIQ(visitorQueues_set);
		
		wRep.log('Sucessfull');
	});

})(jQuery);

</script>
</head>

<body>
<?php
mysql_query("CREATE TABLE IF NOT EXISTS ofRoles (username VARCHAR (64), role TINYINT)") or die(mysql_error());
mysql_query("CREATE TABLE IF NOT EXISTS ofChat (chatId int(11) NOT NULL, chatText text NOT NULL)") or die (mysql_error());
mysql_query("CREATE TABLE IF NOT EXISTS ofIPblock (ip varchar(50) NOT NULL UNIQUE)") or die (mysql_error());
mysql_query("CREATE TABLE IF NOT EXISTS ofChatDetail (
  chatId int(11) NOT NULL AUTO_INCREMENT,
  agentName varchar(255) NOT NULL,
  workgroup varchar(100) NOT NULL,
  type varchar(50) NOT NULL,
  name varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  phone varchar(50) NOT NULL,
  ip varchar(50) NOT NULL,
  department varchar(100) NOT NULL,
  date char(15) NOT NULL,
  PRIMARY KEY(chatId))") or die (mysql_error());
  
  mysql_query("INSERT INTO ofGroup (groupName, description) VALUES ('twr', 'Agent chat group')");
  mysql_query("INSERT INTO ofRoles (username, role) VALUES ('admin', '0')");
?>
<form id="install">
<label>Username</label><input type="text" id="username" value="" /><br/>
<label>Password</label><input type="password" id="pass" value="" /><br/>
<label>&nbsp;</label><input type="submit" value="Install"><br/>
<label>&nbsp;</label><span class="xmpp-status"></span>
</form>
</body>
</html>