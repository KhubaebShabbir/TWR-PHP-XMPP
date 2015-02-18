// JavaScript Document
var global_hostwRep = '';
var global_workgroupwRep = '';
var global_autopopwRep = ;
var global_timewRep = *1000;
var global_dragwRep = ;

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
loadfile('http://localhost/client-chat/js/wRep.js', 'js')