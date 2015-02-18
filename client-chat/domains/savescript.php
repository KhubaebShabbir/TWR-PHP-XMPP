<?php require_once '../../includes/global.inc.php';

$_a = $_POST['workgroup'];
$_b = $_POST['intiate'];
$_c = $_POST['dealyTime'];
$_d = $_POST['draggable'];

$my_file = $_a.'-wRep.js';
$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
$data = "// JavaScript Document
var global_hostwRep = '".$_SESSION['domain']."';
var global_workgroupwRep = '".$_a."';
var global_autopopwRep = ".$_b.";
var global_timewRep = ".$_c."*1000;
var global_dragwRep = ".$_d.";

function loadfile(filename, filetype, callback){
	if (filetype=='js'){ //if filename is a external JavaScript file
		var fileref=document.createElement('script')
		fileref.setAttribute('type','text/javascript')
		fileref.setAttribute('src', filename)
		fileref.onreadystatechange = callback;
		fileref.onload = callback;
	} else if (filetype=='css'){ //if filename is an external CSS file
		var fileref=document.createElement('link')
		fileref.setAttribute('rel', 'stylesheet')
		fileref.setAttribute('type', 'text/css')
		fileref.setAttribute('href', filename)
		fileref.onreadystatechange = callback;
		fileref.onload = callback;
	}
	if (typeof fileref!='undefined'){
		document.getElementsByTagName('head')[0].appendChild(fileref)
	}
}

loadfile('http://localhost/client-chat/wRep.css', 'css'),
loadfile('http://localhost/client-chat/js/strophe.min.js', 'js'),
loadfile('http://localhost/client-chat/js/wRep.js', 'js')";
fwrite($handle, $data);

if ($data){
	echo 'http://'.$_SERVER['HTTP_HOST'].'/client-chat/domains/'.$my_file;
}
?>
