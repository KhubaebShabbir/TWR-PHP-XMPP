<?php require_once 'global.inc.php'; 

$domain_query=mysql_query("SELECT * FROM ofProperty WHERE name = 'maxCanned'");
while($domain=mysql_fetch_array($domain_query)){
	$max_canned=$domain['propValue'];
};
?>

<script type="text/javascript">
	var userCanned_get = $iq({type:'get'}).c('query', {xmlns:'jabber:iq:private'}).c('userCanned').tree();
	wRep.connection.sendIQ(userCanned_get, wRep.on_private);
</script>
<div class="tab-content-full last">
<span id="max-canned"><?php echo $max_canned; ?></span>
<h2>Canned Messages</h2>
<div id="repCanned-view">
</div>
<div id="repCanned-xml">
</div>
</div>