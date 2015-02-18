//---calculate and set heights	for elements function
function sizeElem(){
	$('ul.main-nav, div.push-page').outerHeight($(window).height());
	$('ul.tab-content > li').outerHeight($(window).height() - $('div.header').outerHeight() + 1);
	$('div.tab-content-top, #chat-area').outerHeight($('ul.tab-content > li').height()/3 * 2 - 10);
	$('#chat-area div.chat-messages').outerHeight($('#chat-area').height() - $('input.chat-input').height() - 25);
	$('div.tab-content-bottom').outerHeight($('ul.tab-content > li').height()/3);
	$('div.tab-content-tab').outerHeight($('ul.tab-content > li').height()/3 - 23);
	$('div.tab-content-full').outerHeight($('ul.tab-content > li').height());
}
//--- function to check if element exsist
jQuery.fn.exists = function(){return this.length > 0;}

//------------------------------------------window Resize function
//---set Heights on window resize
$(window).resize(function(){
	sizeElem();
});

//------------------------------------------window load function
$(window).load(function(){
	$('#left-menu li span:contains("Notifications")').click();
	$('#left-menu li').fadeIn();
});

//------------------------------------------jQuery Document ready function
$(function(){
//---Set heights for elements
sizeElem();

////---ajax loading image
$(document).ajaxStart(function(){
    $("#ajaxLoading").show();
}).ajaxStop(function(){
    $("#ajaxLoading").hide();
});

//---ajax cache
$.ajaxSetup ({
    cache: false,
	async: false,
});

//---main nav hover function
$('#left-menu > li').hover(function(){
		$(this).children('ul').stop().slideDown(100).end().find('span').show();
},function(){
		$(this).children('ul').stop().slideUp(100).end().find('span').hide();
});

//---main nav click function
$(document).on('click', '#left-menu li:not(:first) a', function(event){
	event.preventDefault();
	
	Stopwatch1.Timer.toggle();
	var $tabTime = $('#stopwatchTabs').text();
	var $tabTimeparse = $tabTime.split(':');
	// minutes are worth 60 seconds
	var $tabMinutes = (+$tabTimeparse[0])*60 + (+$tabTimeparse[1]);
	var $activeTab = $('ul.tab-title li.active').text();
	var $tabClass = $activeTab.replace(/ /g, "-");
	
	if($('ul.viewTotals li.'+ $tabClass).length === 0){
		$('ul.viewTotals').append("<li class='"+ $tabClass+"'>"+ $tabMinutes +"</li>");
	} else {
		$('ul.viewTotals li.'+ $tabClass).text(parseInt($('ul.viewTotals li.'+ $tabClass).text()) + $tabMinutes)	
	}
	Stopwatch1.resetStopwatch();
	Stopwatch1.Timer.toggle();
	
	// iq to set current tab
	 var viewIQ = "<iq type='set' to='pubsub."+ wRep.host +"'>"+
	  "<pubsub xmlns='http://jabber.org/protocol/pubsub'>"+
		"<publish node='"+ wRep.jid_to_name(wRep.connection.jid) +"-repStats'>"+
		  "<item id='repView'><repview>"+ $(this).text() +
		  "</repview></item></publish></pubsub></iq>";
	var view_xml = wRep.text_to_xml(viewIQ);
	wRep.connection.sendIQ(view_xml);
	
	// iq to set tabstotals time	
	$('#tabsxml').empty();
	traverseHTML($('#tabsxml'), $('div.tabsTimeParent').children().first())

	 var viewTotalsIQ = "<iq type='set' to='pubsub."+ wRep.host +"'>"+
	  "<pubsub xmlns='http://jabber.org/protocol/pubsub'>"+
		"<publish node='"+ wRep.jid_to_name(wRep.connection.jid) +"-repStats'>"+
		  "<item id='viewTotals'>"+ $('#tabsxml').html() +
		  "</item></publish></pubsub></iq>";
	
	var $compareText = $(this).children('span').text();
	var $fileUrl = $(this).attr('href');
	var $itemIndex = $('ul.tab-title li').length;
	var $matchedClone = $('ul.tab-title li').filter(function() {
		return $(this).text() == $compareText;
	})
	if($matchedClone.text() == $compareText){
		$('ul.tab-title li').removeClass('active');
		$($matchedClone).addClass('active').fadeOut('fast').fadeIn('fast');
		$('ul.tab-content > li').hide();
		$('ul.tab-content > li:eq('+ $matchedClone.index() +')').show();
		sizeElem();
	} else {
		$('ul.tab-title li').removeClass('active');
		$('ul.tab-title').append("<li class='active'><a href=''>"+ $compareText +"</a><img src='assets/img/close.png' /></li>");
		$('ul.tab-content > li').hide();
		$('ul.tab-content').append("<li class='tab-content'></li>");
		$('ul.tab-content > li:last').show();
		//---trigger tablLoad 
		$(document).trigger('tabLoad', {fileUrl: $fileUrl, itemIndex: $itemIndex, tabText: $compareText});
		sizeElem();
	}
});

$('ul.tab-title').on('click', 'li > a', function(event){
	event.preventDefault();
	
	Stopwatch1.Timer.toggle();
	var $tabTime = $('#stopwatchTabs').text();
	var $tabTimeparse = $tabTime.split(':');
	// minutes are worth 60 seconds.
	var $tabMinutes = (+$tabTimeparse[0])*60 + (+$tabTimeparse[1]);
	var $activeTab = $('ul.tab-title li.active').text();
	var $tabClass = $activeTab.replace(/ /g, "-");
	
	var $indexValue = $(this).parent('li').index();
	$('ul.tab-title li').removeClass('active');
	$(this).parent('li').addClass('active');
	$('ul.tab-content > li').hide();
	$('ul.tab-content > li:eq('+ $indexValue +')').show();
	sizeElem();
	
	if($('ul.viewTotals li.'+ $tabClass).length === 0){
		$('ul.viewTotals').append("<li class='"+ $tabClass+"'>"+ $tabMinutes +"</li>");
	} else {
		$('ul.viewTotals li.'+ $tabClass).text(parseInt($('ul.viewTotals li.'+ $tabClass).text()) + $tabMinutes)	
	}
	Stopwatch1.resetStopwatch();
	Stopwatch1.Timer.toggle();
	
	// iq to set current tab
	 var viewIQ = "<iq type='set' to='pubsub."+ wRep.host +"'>"+
	  "<pubsub xmlns='http://jabber.org/protocol/pubsub'>"+
		"<publish node='"+ wRep.jid_to_name(wRep.connection.jid) +"-repStats'>"+
		  "<item id='repView'><repview>"+ $(this).text() +
		  "</repview></item></publish></pubsub></iq>";
		 
	var view_xml = wRep.text_to_xml(viewIQ);
	wRep.connection.sendIQ(view_xml);

	// iq to set tabstotals time	
	$('#tabsxml').empty();
	traverseHTML($('#tabsxml'), $('div.tabsTimeParent').children().first())

	 var viewTotalsIQ = "<iq type='set' to='pubsub."+ wRep.host +"'>"+
	  "<pubsub xmlns='http://jabber.org/protocol/pubsub'>"+
		"<publish node='"+ wRep.jid_to_name(wRep.connection.jid) +"-repStats'>"+
		  "<item id='viewTotals'>"+ $('#tabsxml').html() +
		  "</item></publish></pubsub></iq>";
		 
	var viewTotals_xml = wRep.text_to_xml(viewTotalsIQ);
	wRep.connection.sendIQ(viewTotals_xml);
});

$('ul.tab-title').on('click', 'li > img', function(e){
	var $indexValue = $(this).parent('li').index();
	var $activeTab = $('ul.tab-title li.active').text();
	var $thisTab = $(this).parent('li').text();
	if($thisTab == 'Monitoring'){
		$('#payloads-view').appendTo('#payloadParent');
		$('ul.tab-content > li:eq('+ $indexValue +')').remove(); 
	} else {
		$('ul.tab-content > li:eq('+ $indexValue +')').remove();
	}
	if($(this).parent('li').hasClass('active')){
		Stopwatch1.Timer.toggle();
		var $tabTime = $('#stopwatchTabs').text();
		var $tabTimeparse = $tabTime.split(':');
		// minutes are worth 60 seconds
		var $tabMinutes = (+$tabTimeparse[0])*60 + (+$tabTimeparse[1]);
		var $tabClass = $activeTab.replace(/ /g, "-");
		
		if($('ul.viewTotals li.'+ $tabClass).length === 0){
			$('ul.viewTotals').append("<li class='"+ $tabClass+"'>"+ $tabMinutes +"</li>");
		} else {
			$('ul.viewTotals li.'+ $tabClass).text(parseInt($('ul.viewTotals li.'+ $tabClass).text()) + $tabMinutes)	
		}
		Stopwatch1.resetStopwatch();
		Stopwatch1.Timer.toggle();
		
		// iq to set current tab
		 var viewIQ = "<iq type='set' to='pubsub."+ wRep.host +"'>"+
		  "<pubsub xmlns='http://jabber.org/protocol/pubsub'>"+
			"<publish node='"+ wRep.jid_to_name(wRep.connection.jid) +"-repStats'>"+
			  "<item id='repView'><repview>"+ $('ul.tab-title li:first').text() +
			  "</repview></item></publish></pubsub></iq>";
		var view_xml = wRep.text_to_xml(viewIQ);
		wRep.connection.sendIQ(view_xml);
		
		// iq to set tabstotals time	
		$('#tabsxml').empty();
		traverseHTML($('#tabsxml'), $('div.tabsTimeParent').children().first())
	
		 var viewTotalsIQ = "<iq type='set' to='pubsub."+ wRep.host +"'>"+
		  "<pubsub xmlns='http://jabber.org/protocol/pubsub'>"+
			"<publish node='"+ wRep.jid_to_name(wRep.connection.jid) +"-repStats'>"+
			  "<item id='viewTotals'>"+ $('#tabsxml').html() +
			  "</item></publish></pubsub></iq>";
		
		$(this).parent('li').remove();
		$('ul.tab-title li:first').addClass('active');
		$('ul.tab-content > li:first').show();
	}
	$(this).parent('li').remove();
	sizeElem();
});

$(document).on('click', 'span.close', function(){
	$("#results").empty();
	$('div.push-page').animate({width: '0%'}).hide();
});

$(document).on('click', 'span.user-btn', function(){
	if($('div.user-bar').is(':hidden')){
		$(this).css('background-image', 'url(assets/img/arrow-up.png)');
	} else {
		$(this).css('background-image', 'url(assets/img/arrow-down.png)');
	}
	$('div.user-bar').slideToggle(100);
});

$(document).on('click', '#userbar-close', function(){
	if($('div.user-bar').is(':hidden')){
		$('div.user-bar').slideDown(100);
	} else {
		$('div.user-bar').slideUp(100);
	}
});

$(document).on('click', '#presStatus li', function(){
	Stopwatch2.Timer.toggle();
	var $statusTime = $('#stopwatchPres').text();
	var $statusTimeparse = $statusTime.split(':');
	// minutes are worth 60 seconds.
	var $statusMins = (+$statusTimeparse[0])*60 + (+$statusTimeparse[1]);
	var $presClass = $(this).attr('class');
	var $activePres = $('#presence').attr('alt');
	
	if($presClass == 'online'){
		if($('ul.presTotals li.'+ $activePres).length === 0){
			$('ul.presTotals').append("<li class='"+ $activePres +"'>"+ $statusMins +"</li>");
		} else {
			$('ul.presTotals li.'+ $activePres).text(parseInt($('ul.presTotals li.'+ $activePres).text()) + $statusMins)
		}
		wRep.connection.send($pres(), $('#presence').attr({src: 'assets/img/available.png', alt:'online'}));
	} else if($presClass == 'break'){
		if($('ul.presTotals li.'+ $activePres).length === 0){
			$('ul.presTotals').append("<li class='"+ $activePres +"'>"+ $statusMins +"</li>");
		} else {
			$('ul.presTotals li.'+ $activePres).text(parseInt($('ul.presTotals li.'+ $activePres).text()) + $statusMins)
		}
		wRep.connection.send($pres().c('show').t('away').up().c('status').t('Break'), $('#presence').attr({src: 'assets/img/break.png', alt:'break'}));
		wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host}).c('pubsub', {xmlns:'http://jabber.org/protocol/pubsub'}).c('retract', {node:'allRepsVisits'}).c('item', {id:Strophe.getNodeFromJid(wRep.connection.jid)}).tree());
		if($('#jidActive-btn').length === 0){
			$('div.user-panel-bottom').append('<span id="jidActive-btn" class="btn">Activa Chats</span>');
		}
	} else if($presClass == 'meeting'){
		if($('ul.presTotals li.'+ $activePres).length === 0){
			$('ul.presTotals').append("<li class='"+ $activePres +"'>"+ $statusMins +"</li>");
		} else {
			$('ul.presTotals li.'+ $activePres).text(parseInt($('ul.presTotals li.'+ $activePres).text()) + $statusMins)
		}
	wRep.connection.send($pres().c('show').t('away').up().c('status').t('Meeting'), $('#presence').attr({src: 'assets/img/break.png', alt:'meeting'}));
		wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host}).c('pubsub', {xmlns:'http://jabber.org/protocol/pubsub'}).c('retract', {node:'allRepsVisits'}).c('item', {id:Strophe.getNodeFromJid(wRep.connection.jid)}).tree());
		if($('#jidActive-btn').length === 0){
			$('div.user-panel-bottom').append('<span id="jidActive-btn" class="btn">Activa Chats</span>');
		}
	} else if($presClass == 'lunch'){
		if($('ul.presTotals li.'+ $activePres).length === 0){
			$('ul.presTotals').append("<li class='"+ $activePres +"'>"+ $statusMins +"</li>");
		} else {
			$('ul.presTotals li.'+ $activePres).text((parseInt($('ul.presTotals li.'+ $activePres).text()) + $statusMins)/60)
		}
	wRep.connection.send($pres().c('show').t('away').up().c('status').t('Lunch'), $('#presence').attr({src: 'assets/img/break.png', alt:'lunch'}));
		wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host}).c('pubsub', {xmlns:'http://jabber.org/protocol/pubsub'}).c('retract', {node:'allRepsVisits'}).c('item', {id:Strophe.getNodeFromJid(wRep.connection.jid)}).tree());
		if($('#jidActive-btn').length === 0){
			$('div.user-panel-bottom').append('<span id="jidActive-btn" class="btn">Activa Chats</span>');
		}
	}
	Stopwatch2.resetStopwatch();
	Stopwatch2.Timer.toggle();
	
	// iq to set current presence
	 var presIQ = "<iq type='set' to='pubsub."+ wRep.host +"'>"+
	  "<pubsub xmlns='http://jabber.org/protocol/pubsub'>"+
		"<publish node='"+ wRep.jid_to_name(wRep.connection.jid) +"-repStats'>"+
		  "<item id='repPres'><reppres>"+ $presClass +
		  "</reppres></item></publish></pubsub></iq>";
		 
	var pres_xml = wRep.text_to_xml(presIQ);
	wRep.connection.sendIQ(pres_xml);
	
	// iq to set tabstotals time
	$('#presxml').empty();
	traverseHTML($('#presxml'), $('div.statusTimeParent').children().first())
	 var presTotalsIQ = "<iq type='set' to='pubsub."+ wRep.host +"'>"+
	  "<pubsub xmlns='http://jabber.org/protocol/pubsub'>"+
		"<publish node='"+ wRep.jid_to_name(wRep.connection.jid) +"-repStats'>"+
		  "<item id='presTotals'>"+ $('#presxml').html() +
		  "</item></publish></pubsub></iq>";
		 
	var presTotals_xml = wRep.text_to_xml(presTotalsIQ);
	wRep.connection.sendIQ(presTotals_xml);
});

//--- show/hide monintoring details
$(document).on('click', 'div.chats', function(){
	var eleid = $(this).closest('li').attr('id');
	$('div.ribbon, div.viewtotals, div.prestotals').not('li#'+ eleid +' div.ribbon').hide();
	if($('li#'+ eleid +' div.ribbon').is(':visible')){
		$('li#'+ eleid +' div.ribbon').hide();
	} else {
		$('li#'+ eleid +' div.ribbon').show();
	}
});
$(document).on('click', 'div.repview', function(){
	var eleid = $(this).closest('li').attr('id');
	$('div.ribbon, div.viewtotals, div.prestotals').not('li#'+ eleid +' div.viewtotals').hide();
	if($('li#'+ eleid +' div.viewtotals').is(':visible')){
		$('li#'+ eleid +' div.viewtotals').hide();
	} else {
		$('li#'+ eleid +' div.viewtotals').show();
	}
});
$(document).on('click', 'div.reppres', function(){
	var eleid = $(this).closest('li').attr('id');
	$('div.ribbon, div.viewtotals, div.prestotals').not('li#'+ eleid +' div.prestotals').hide();
	if($('li#'+ eleid +' div.prestotals').is(':visible')){
		$('li#'+ eleid +' div.prestotals').hide();
	} else {
		$('li#'+ eleid +' div.prestotals').show();
	}
});

//--- click Hide monitoring details
$(document).on('click', 'div.ribbon, div.viewtotals, div.prestotals', function(){
	$(this).hide();
});

//--- on click filters
$(document).on('click', '#content-filters > span', function(event){
	if(event.target != this) return;
		$(this).next('form').slideToggle(100);
});

//--- unmailed Form
$(document).on('click', '#unmailed li', function(event){
	if(event.target != this) return;
	$('#unmailed li').children().hide();

	if($(this).hasClass('active')){
		$(this).removeAttr('class');
	} else {
		$(this).siblings('li').removeAttr('class');
		$(this).addClass('active');
		$(this).children().show();
	}
});

//-- load, show/hide depts on Department select click
$(document).on('click', 'span.depts-chzn', function(){
	var jid = $(this).closest('li').attr('id');
	var $ele = ('#'+ jid +' div.unmailed-workgroup-depts');

	if ($($ele).is(':hidden')) {
		$($ele).show();
		$('#depts-arrow').show();
		if($($ele).children().length === 0){
		var $getID = wRep.id_to_jid(jid);
		var rgDepts_get = $iq({type:"get", to:"pubsub."+ wRep.host})
			.c('pubsub', {xmlns:"http://jabber.org/protocol/pubsub"})
				.c('items', {'node':$getID+'-repGroup'})
					.c('item', {'id':'rgDepts'}).tree();
		wRep.connection.sendIQ(rgDepts_get, wRep.on_wgDepts);
		}
	} else {
		$($ele).hide();
		$('#depts-arrow').hide();
	}
});


//--- append each Department to, cc, bcc to text fields
$(document).on('click', 'div.unmailed-workgroup-depts div.title', function () {
	var $eleid = $(this).closest('li').attr('id');
	var $ele = $(this);
	var $eleval = $('#'+ $eleid +' form input[name="selected-depts"]');
	$eleval.val($eleval.val() + $(this).text() +',');
	
	$($($ele).next('div').children()).each(function() {
		var $eleClass = $(this).attr('class');
		var $eleText = $(this).text();
		var $textField = $('#'+ $eleid + ' form input[name="'+ $eleClass +'"]');
		$($textField).val($($textField).val() + $eleText);
    });
	$(this).next('div').remove().end().remove();
});

//--- append all to, cc, bcc to text fields
$(document).on('click', 'div.unmailed-workgroup-depts div.emails > div', function () {
	var $ele = $(this).attr('class');
	var $eleText = $(this).text();
	var $eleid = $(this).closest('li').attr('id');
	var $textField = $('#'+ $eleid + ' form input[name="'+ $ele +'"]');
	$($textField).val($($textField).val() + $eleText);
	$(this).remove();
});

//--- tabs
$('ul.tabs-div > li:first').show();
$(document).on('click', 'ul.tabs li', function(event){
	event.preventDefault();
	var $indexValue = $(this).index();
	$('ul.tabs li').removeClass('tab-active');
	$(this).addClass('tab-active');
	$('ul.tabs-div > li').hide();
	$('ul.tabs-div > li:eq('+ $indexValue +')').show();
	sizeElem();
});

//-- view Chat History
$(document).on('click', '#viewHstry', function(){
	if($('#brwsrinfo li').is(':visible')) {
		var data_string = $('#brwsrinfo li:visible').children('span').text();
		$.ajax({
			cache: false,
			type: "POST",
			url: 'includes/oftranscript-view.php',
			data: {id: data_string},
			success: function(data){
				$('#viewHstry').next('div').html(data);
			},error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.responseText);
			}
		});
	} else {
		$('#viewHstry').next('div').html('Select chat text input then click History to view chat history');
	}
	return false;
});


//--- inhouse chat img btn
$(document).on('click', '#thewebresp-chat', function(){
	$('div.inhouse-chat').toggle();
	$(this).toggleClass('thewebreps-active')
});

//---Chat canned folders slide
$(document).on('click', '#chat-user-canned div.title, #chat-workgroup-canned div.title, div.hstry-date', function(event){
	if(event.target != this) return;
		$(this).next('div').slideToggle('fast');
});

//--- reload user canned on chat panel
$(document).on('click', '#reload-canned', function(){
	var userCanned_get = $iq({type:'get'}).c('query', {xmlns:'jabber:iq:private'}).c('userCanned').tree();
	wRep.connection.sendIQ(userCanned_get, wRep.on_private);	
});

//--- inline form to add and update canned and push
$(document).on('click', '#repCanned-view div, #repGroupCanned-view div', function(event){
	$('body').append('<div id="overlay"></div>');
	
	var $ele = event.target;
	var $formHeight;
	
	$($ele).attr('id', 'inlineEdit');
	if($($ele).hasClass('title')){
		var $inlineForm = "<div id='inlineForm-wrap'><img id='inlineForm-close' src='assets/img/closeBtn.png'/><div id='inlineForm-content'><span id='inlineForm-addFolder'>Add Folder</span><span id='inlineForm-addMsg'>Add Message</span><img id='inlineForm-edit' src='assets/img/edit.png' /><img id='inlineForm-delete' src='assets/img/delete.png' /><form id='inlineForm'></form></div><div class='arrowWhite'></div></div>";
		$('body').append($inlineForm);
		$formHeight = $('#inlineForm-wrap').outerHeight();
		$('#inlineForm-wrap').css({'left': ($($ele).offset().left-(30))+'px', 'top': $($ele).offset().top-($formHeight-5)+'px'});
	} else {
		var $inlineForm = "<div id='inlineForm-wrap'><img id='inlineForm-close' src='assets/img/closeBtn.png'/><div id='inlineForm-content'><img id='inlineForm-edit' src='assets/img/edit.png' /><img id='inlineForm-delete' src='assets/img/delete.png' /><form id='inlineForm'></form></div><div class='arrowWhite'></div></div>";
		$('body').append($inlineForm);
		$formHeight = $('#inlineForm-wrap').outerHeight();
		$('#inlineForm-wrap').css({'left': ($($ele).offset().left-(30))+'px', 'top': $($ele).offset().top-($formHeight-5)+'px'});
	}

	$(document).on('click', '#inlineForm-edit', function(){
		$('#inlineForm').empty().append("<input type='text' class='narrow' id='inlineForm-field' value='"+ $($ele).text() +"' /><input type='submit' class='narrow' id='inlineSubmit-edit' value='Update' />");
		$formHeight = $('#inlineForm-wrap').outerHeight();
		$('#inlineForm-wrap').css({'left': ($($ele).offset().left-(30))+'px', 'top': $($ele).offset().top-($formHeight-5)+'px'});
		return false;
	});
	
	$(document).on('click', '#inlineForm-addFolder', function(){
		$('#inlineForm').empty().append("<input type='text' class='narrow' id='inlineForm-field' value='' /><input type='submit' class='narrow' id='inlineSubmit-addFolder' value='Add' />");
		$formHeight = $('#inlineForm-wrap').outerHeight();
		$('#inlineForm-wrap').css({'left': ($($ele).offset().left-(30))+'px', 'top': $($ele).offset().top-($formHeight-5)+'px'});
		return false;
	});
	
	$(document).on('click', '#inlineForm-addMsg', function(){
		max_canned = Number($('#max-canned').text());
		if($('#repCanned-view div').find('div.canned, div.push').length >= max_canned) {
			alert('You reach your maximum number(50) of allowed messages');	
		} else {
			$('#inlineForm').empty().append("Canned <input type='radio' name='msgType' value='canned' checked='checked' />Push <input type='radio' name='msgType' value='push' /><input type='text' class='narrow' id='inlineForm-field' value='' /><input type='submit' class='narrow' id='inlineSubmit-addMsg' value='Add' />");
			$formHeight = $('#inlineForm-wrap').outerHeight();
			$('#inlineForm-wrap').css({'left': ($($ele).offset().left-(30))+'px', 'top': $($ele).offset().top-($formHeight-5)+'px'});
		return false;
		}
	});
	return false;
});

//--- submit inline addFolder form
$(document).on('click', '#inlineSubmit-addFolder', function(event){
	event.preventDefault();

	var $ele = $('div#inlineEdit');
	var $newText = $('#inlineForm-field').val();
	if($newText != '') {
		$($ele).parent().append("<div class='folder'><div class='title'>"+ $newText +"</div><div class='msgs'></div></div>");
		$('#inlineForm-wrap').remove();
		$('div#inlineEdit').removeAttr('id');
		$('#repCanned-xml').empty();
		$('#repGroupCanned-xml').empty();
		$('#overlay').remove();
		if($('#repCanned-view:visible').length > 0){
			traverseHTML($('#repCanned-xml'), $('#repCanned-view').children().first());
			$(document).trigger('repCanned_set');
		} else if($('#repGroupCanned-view:visible').length > 0) {
			traverseHTML($('#repGroupCanned-xml'), $('#repGroupCanned-view').children().first());
			$(document).trigger('repGroupCanned_set');		
		}
	} else {
		$('#inlineForm-field').css('borderColor', '#ff9900');
	}
	return false;
});

//--- submit inline addMsg form
$(document).on('click', '#inlineSubmit-addMsg', function(event){
	event.preventDefault();

	var $ele = $('div#inlineEdit');
	var $newText = $('#inlineForm-field').val();
	if($newText != ''){
		var $type = $('input[name=msgType]:checked', '#inlineForm').val();
		$($ele).next().append("<div class='"+ $type +"'>"+ $newText +"</div>");
		$('#inlineForm-wrap').remove();
		$('div#inlineEdit').removeAttr('id');
		$('#repCanned-xml').empty();
		$('#repGroupCanned-xml').empty();
		$('#overlay').remove();
		if($('#repCanned-view:visible').length > 0){
			traverseHTML($('#repCanned-xml'), $('#repCanned-view').children().first());
			$(document).trigger('repCanned_set');	
		} else if($('#repGroupCanned-view:visible').length > 0) {
			traverseHTML($('#repGroupCanned-xml'), $('#repGroupCanned-view').children().first());
			$(document).trigger('repGroupCanned_set');		
		}
	} else {
		$('#inlineForm-field').css('borderColor', '#ff9900');
	}
	return false;
});

$(document).on('repCanned_set', function(){
	var repCanned_set = "<iq type='set'><query xmlns='jabber:iq:private'>"+ 
	$('#repCanned-xml').html() +"</query></iq>";
	 
	var repCanned_xml = wRep.text_to_xml(repCanned_set);
	wRep.connection.sendIQ(repCanned_xml);
});

$(document).on('repGroupCanned_set', function(){
	var $getID = $('#results').attr('class');
	var repGroupCanned_set = "<iq type='set' to='pubsub."+ wRep.host +"'><pubsub xmlns='http://jabber.org/protocol/pubsub'><publish node='"+ $getID +"-repGroup'><item id='rgCanned'>"+ $('#repGroupCanned-xml').html() +"</item></publish></pubsub></iq>";
	 
	var repGroupCanned_xml = wRep.text_to_xml(repGroupCanned_set)
	wRep.connection.sendIQ(repGroupCanned_xml);
});

//--- inline form to add and update workgroup depatrments
$(document).on('click', '#repGroupDepts-view div', function(event){
	$('body').append('<div id="overlay"></div>');

	var $ele = event.target;
	var $formHeight;
	
	$($ele).attr('id', 'inlineEdit');
	if($($ele).hasClass('title')){
		var $inlineForm = "<div id='inlineForm-wrap'><img id='inlineForm-close' src='assets/img/closeBtn.png'/><div id='inlineForm-content'><span id='inlineForm-addDepartment'>Add Department</span><span id='inlineForm-addEmail'>Add Email</span><img id='inlineForm-edit' src='assets/img/edit.png' /><img id='inlineForm-delete' src='assets/img/delete.png' /><form id='inlineForm'></form></div><div class='arrowWhite'></div></div>";
		$('body').append($inlineForm);
		$formHeight = $('#inlineForm-wrap').outerHeight();
		$('#inlineForm-wrap').css({'left': ($($ele).offset().left-(0))+'px', 'top': $($ele).offset().top-($formHeight-5)+'px'});
	} else {
		var $inlineForm = "<div id='inlineForm-wrap'><img id='inlineForm-close' src='assets/img/closeBtn.png'/><div id='inlineForm-content'><img id='inlineForm-edit' src='assets/img/edit.png' /><img id='inlineForm-delete' src='assets/img/delete.png' /><form id='inlineForm'></form></div><div class='arrowWhite'></div></div>";
		$('body').append($inlineForm);
		$formHeight = $('#inlineForm-wrap').outerHeight();
		$('#inlineForm-wrap').css({'left': ($($ele).offset().left-(0))+'px', 'top': $($ele).offset().top-($formHeight-5)+'px'});
	}

	$(document).on('click', '#inlineForm-edit', function(){
		$('#inlineForm').empty().append("<input type='text' id='inlineForm-field' value='"+ $($ele).text() +"' /><input type='submit' id='inlineSubmit-edit' value='Update' />");
		$formHeight = $('#inlineForm-wrap').outerHeight();
		$('#inlineForm-wrap').css({'left': ($($ele).offset().left-(0))+'px', 'top': $($ele).offset().top-($formHeight-5)+'px'});
		return false;
	});
	
	$(document).on('click', '#inlineForm-addDepartment', function(){
		$('#inlineForm').empty().append("<input type='text' class='narrow' id='inlineForm-field' value='' /><input type='submit' class='narrow' id='inlineSubmit-addDepartment' value='Add' />");
		$formHeight = $('#inlineForm-wrap').outerHeight();
		$('#inlineForm-wrap').css({'left': ($($ele).offset().left-(0))+'px', 'top': $($ele).offset().top-($formHeight-5)+'px'});
		return false;
	});
	
	$(document).on('click', '#inlineForm-addEmail', function(){
		$('#inlineForm').empty().append("To <input type='radio' name='msgType' value='to' checked='checked' />Cc <input type='radio' name='msgType' value='cc' />Bcc <input type='radio' name='msgType' value='bcc' /><input type='text' class='narrow' id='inlineForm-field' value='' /><input type='submit' class='narrow' id='inlineSubmit-addEmail' value='Add' />");
		$formHeight = $('#inlineForm-wrap').outerHeight();
		$('#inlineForm-wrap').css({'left': ($($ele).offset().left-(0))+'px', 'top': $($ele).offset().top-($formHeight-5)+'px'});
		return false;
	});
	return false;
});

//--- submit inline addDepartment form
$(document).on('click', '#inlineSubmit-addDepartment', function(event){
	event.preventDefault();

	var $ele = $('div#inlineEdit');
	var $newText = $('#inlineForm-field').val();
	if($newText != '') {
		$($ele).parent().append("<div class='department'><div class='title'>"+ $newText +"</div><div class='emails'></div></div>");
		$('#inlineForm-wrap').remove();
		$('div#inlineEdit').removeAttr('id');
		$('#repGroupDepts-xml').empty();
		$('#overlay').remove();
		if($('#repGroupDepts-view:visible').length > 0) {
			traverseHTML($('#repGroupDepts-xml'), $('#repGroupDepts-view').children().first());
			$(document).trigger('repGroupDepts_set');		
		}
	} else {
		$('#inlineForm-field').css('borderColor', '#ff9900');
	}
	return false;
});

//--- submit inline addEmail form
$(document).on('click', '#inlineSubmit-addEmail', function(event){
	event.preventDefault();

	var $ele = $('div#inlineEdit');
	var $newText = $('#inlineForm-field').val();
	var atpos=$newText.indexOf("@");
	var dotpos=$newText.lastIndexOf(".");
	if($newText == null || $newText == '') {
		$('#inlineForm-field').css('borderColor', '#ff9900');
	} else if (atpos<1 || dotpos<atpos+2 || dotpos+2>=$newText.length) {
		$('#inlineForm-field').css('borderColor', '#ff9900');
	} else {
		var $type = $('input[name=msgType]:checked', '#inlineForm').val();
		$($ele).next().append("<div class='"+ $type +"'>"+ $newText +"</div>");
		$('#inlineForm-wrap').remove();
		$('div#inlineEdit').removeAttr('id');
		$('#repGroupDepts-xml').empty();
		$('#overlay').remove();
		if($('#repGroupDepts-view:visible').length > 0) {
			traverseHTML($('#repGroupDepts-xml'), $('#repGroupDepts-view').children().first());
			$(document).trigger('repGroupDepts_set');		
		}
	}
	return false;
});

$(document).on('repGroupDepts_set', function(){
	var $getID = $('#results').attr('class');
	var repGroupDepts_set = "<iq type='set' to='pubsub."+ wRep.host +"'><pubsub xmlns='http://jabber.org/protocol/pubsub'><publish node='"+ $getID +"-repGroup'><item id='rgDepts'>"+ $('#repGroupDepts-xml').html() +"</item></publish></pubsub></iq>";
	 
	var repGroupDepts_set_xml = wRep.text_to_xml(repGroupDepts_set)
	wRep.connection.sendIQ(repGroupDepts_set_xml);
});

//--- submit inline edit form
$(document).on('click', '#inlineSubmit-edit', function(event){
	event.preventDefault();

	var $ele = $('div#inlineEdit');
	var $newText = $('#inlineForm-field').val();
	if($newText != '') {
		$($ele).text($newText);
		$('#inlineForm-wrap').remove();
		$('div#inlineEdit').removeAttr('id');
		$('#repCanned-xml').empty();
		$('#repGroupCanned-xml').empty();
		$('#repGroupDepts-xml').empty();
		$('#overlay').remove();
		if($('#repCanned-view:visible').length > 0){
			traverseHTML($('#repCanned-xml'), $('#repCanned-view').children().first());
			$(document).trigger('repCanned_set');
		} else if($('#repGroupCanned-view:visible').length > 0) {
			traverseHTML($('#repGroupCanned-xml'), $('#repGroupCanned-view').children().first());
			$(document).trigger('repGroupCanned_set');
		} else if($('#repGroupDepts-view:visible').length > 0) {
			traverseHTML($('#repGroupDepts-xml'), $('#repGroupDepts-view').children().first());
			$(document).trigger('repGroupDepts_set');
		} else if($('#repGroupDepts-view:visible').length > 0) {
			traverseHTML($('#repGroupDepts-xml'), $('#repGroupDepts-view').children().first());
			$(document).trigger('repGroupDepts_set');
		}
	} else {
		$('#inlineForm-field').css('borderColor', '#ff9900');		
	}
	return false;
});

//--- Delete inline item
$(document).on('click', '#inlineForm-delete', function() {
	var $ele = $('#inlineEdit');
	if($($ele).parent('div').parent('div.depts').length) {
		alert('You can not delete this Department');
	} else if ($($ele).parent('div').parent('div.rgcanned').length) {
		alert('You can not delete this Folder');
	} else if ($($ele).parent('div').parent('div.usercanned').length) {
		alert('You can not delete this Folder');
	} else {
		var dialogConfirm = confirm("Are you sure you want to delete?");
		if (dialogConfirm == true) {
			if($($ele).hasClass('title')){
				$($ele).parent().remove();
			} else {
				$($ele).remove();
			}
			if($('#repCanned-view:visible').length > 0){
				traverseHTML($('#repCanned-xml'), $('#repCanned-view').children().first());
				$(document).trigger('repCanned_set');	
			} else if($('#repGroupCanned-view:visible').length > 0) {
				traverseHTML($('#repGroupCanned-xml'), $('#repGroupCanned-view').children().first());
				$(document).trigger('repGroupCanned_set');	
			} else if($('#repGroupDepts-view:visible').length > 0) {
				traverseHTML($('#repGroupDepts-xml'), $('#repGroupDepts-view').children().first());
				$(document).trigger('repGroupDepts_set');		
			}
		} else {
			return false;
		}
	}
	$('#inlineForm-wrap').remove();
	$('div#inlineEdit').removeAttr('id');
	$('#repCanned-xml').empty();
	$('#repGroupCanned-xml').empty();
	$('#repGroupCanned-xml').empty();
	$('#repGroupDepts-xml').empty();
	$('#overlay').remove();
});

//--- inlineForm prevent submit
$(document).on('submit', '#inlineForm', function(event){
	event.preventDefault();
});

//--- inlineForm close
$(document).on('click', '#inlineForm-close', function(){
	$('#inlineForm-wrap').remove();
	$('#inlineEdit').removeAttr('id');
	$('#overlay').remove();
});

//--- remove overly
$(document).on('click', '#overlay', function(){
	$('#inlineForm-wrap').remove();
	$('#inlineEdit').removeAttr('id');
	$(this).remove();
});

// font size increase and Decrease
$('#fontInc').click(function(){
	$('html').css('font-size', '1.125rem');
	sizeElem();
});

$('#fontDec').click(function(){
	$('html').css('font-size', '1rem');
	sizeElem();
});

// Select all in Select
$(document).on('click', 'select.select-mulitple option', function() {
	var list = $('select.select-mulitple option');
	var value = $(this).val();
	if(value == 'all' || value == ''){
		$(list).prop('selected', 'selected');
		$(this).removeProp('selected');
	}
});


//-----------Tool Tip
$(document).on({
	mouseenter: function(){
	if($(this).attr('title')) {
		var $tip = $(this).attr('title');
		$(this).attr('title', '');
		var $offSet = $(this).offset();
		$('body').prepend('<div id="tool-tip"><span class="tool-tip">'+$tip+'</span><div class="arrowDown"></div></div>');
		$('#tool-tip').fadeIn();
		var $tipHeight = $('#tool-tip').outerHeight();
		var $tipWidth = $('#tool-tip').outerWidth()/2;
		var $eleWidth = $(this).outerWidth()/2;
		$('#tool-tip').css({'left': ($offSet.left-($tipWidth-$eleWidth))+'px', 'top': $offSet.top-($tipHeight+5)+'px'});
	}
}, mouseleave: function(){
	if($('#tool-tip')) {
		var $title = $('#tool-tip').text();
		$('#tool-tip').remove();
		$(this).attr('title', $title);
	}
}
}, 'a');
$(document).on('click', 'a', function(){
	if($('#tool-tip')) {
		var $title = $('#tool-tip').text();
		$('#tool-tip').remove();
		$(this).attr('title', $title);
	}
});

});//------------------------------------------end Document ready function

//--- submit edit user form
$(document).on('submit', '#edit-user', function(){
	var $formID = $(this).attr('id');
	var $formUrl = $(this).attr('action');
 	ValidateForm($formID);
	if(ValidateForm($formID) == true) {
	var data_string = $(this).serialize();
	$('input[disabled]').each( function() {
		data_string = data_string + '&' + $(this).attr('name') + '=' + $(this).val();
	});
		$.ajax({
			cache: false,
			type: "POST",
			url: $formUrl,
			data: data_string,
			success: function(html){
				$('span.error').html(html);
				$('#user-reload').click();
			},error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.responseText);
			}
		});
	}
	return false;
});

//--- submit update Email form
$(document).on('submit', '#update-email', function(){
	var $formID = $(this).attr('id');
	var $formUrl = $(this).attr('action');
 	ValidateForm($formID);
	if(ValidateForm($formID) == true) {
	var data_string = $(this).serialize();
		$.ajax({
			cache: false,
			type: "POST",
			url: $formUrl,
			data: data_string,
			success: function(html){
				$('span.error').html(html);
			},error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.responseText);
			}
		});
	}
	return false;
});

//--- submit repGroup script form
$(document).on('submit', '#domain-script-form', function(event){
	event.preventDefault();
	var $getID = $('#results').attr('class');
	var $formID = $(this).attr('id');
	var $formUrl = $(this).attr('action');
	var $x = $('input[name=intiate]:checked', '#'+ $formID).val();
	var $y = document.forms[$formID]['dealyTime'].value;
	var $z = $('input[name=draggable]:checked', '#'+ $formID).val();
 	ValidateForm($formID);
	if(ValidateForm($formID) == true) {
		var rgScript_set = $iq({'type':'set','to':'pubsub.'+ wRep.host}).c('pubsub',{'xmlns':'http://jabber.org/protocol/pubsub'}).c('publish',{'node':'webVisitors'}).c('item',{'id':$getID +'-script'}).c('script').c('intiate').t($x).up().c('dealytime').t($y).up().c('draggable').t($z).tree();
		wRep.connection.sendIQ(rgScript_set);
		
		$('#repGroupScript-view').empty();
		var rgScript_get = $iq({type:"get", to:"pubsub."+ wRep.host}).c('pubsub', {xmlns:"http://jabber.org/protocol/pubsub"}).c('items', {'node':'webVisitors'}).c('item', {'id':$getID +'-script'}).tree();
		wRep.connection.sendIQ(rgScript_get, wRep.on_pubsub);
		
		var data_string = $(this).serialize();
		$.ajax({
			cache: false,
			type: "POST",
			url: $formUrl,
			data: data_string,
			success: function(html){
				$('span.error').html(html);
			},error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.responseText);
			}
		});
		
	}
	return false;
});

//--- submit repGroup status form
$(document).on('submit', '#domain-status', function(event){
	event.preventDefault();
	var $getID = $('#results').attr('class');
	var $formID = $(this).attr('id');
	var $x = $('input[name=status]:checked', '#'+ $formID).val();
	var $y = document.forms[$formID]['descp'].value;
	var $date = document.forms[$formID]['date'].value;
	var $name = wRep.jid_to_name(wRep.connection.jid);
 	ValidateForm($formID);
	if(ValidateForm($formID) == true){
		var domainStatus_set = $iq({'type':'set','to':'pubsub.'+ wRep.host}).c('pubsub',{'xmlns':'http://jabber.org/protocol/pubsub'}).c('publish',{'node':'webVisitors'}).c('item',{'id':$getID +'-status'}).c('details').c('status').t($x).up().c('jid').t($name).up().c('date').t($date).up().c('comment').t($y).tree();
		wRep.connection.sendIQ(domainStatus_set, function(){
		
		$('#repGroupStatus-view').empty();
		var repGroupstatus_get = $iq({type:'get', to:'pubsub.'+ wRep.host, id:'repGroup'+ $getID +'Status'}).c('pubsub', {xmlns:'http://jabber.org/protocol/pubsub'}).c('items', {node:'webVisitors'}).c('item', {id:$getID +'-status'}).tree();
			wRep.connection.sendIQ(repGroupstatus_get, wRep.on_pubsub);	
		});
		
	}
	return false;
});

//--- submit add repGroupUser form
$(document).on('submit', '#add-repGroupUser', function(event){
	event.preventDefault();
	var $formID = $(this).attr('id');
	var $formUrl = $(this).attr('action');
	var repGroupName = $('#results').attr('class');
	var repQueue = 	$('#'+ $formID +' input[name=queue]:checked').val();

 	ValidateForm($formID);
	if(ValidateForm($formID) == true) {
		$('#'+ $formID +' select.select-mulitple option:selected').each(function() {
			$('#repGroupUsers-view div.'+ repQueue).append('<div class='+$(this).val()+'>'+$(this).text()+'</div>');
		
			wRep.connection.sendIQ($iq({'type':'set','to':'pubsub.'+ wRep.host}).c('pubsub',{'xmlns':'http://jabber.org/protocol/pubsub'}).c('publish', {'node':$(this).text() +'-assignedRGs'}).c('item',{'id':repGroupName}).c('title').tree());
			
			if($(this).val() == 'jidrole-3'){
				wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, 'id':'sub'+ repGroupName +'-repGroup'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node': repGroupName +'-repGroup'}).c('subscription', {'jid':$(this).text() +'@'+ wRep.host, 'subscription':'subscribed'}).tree());
			} else if($(this).val() == 'jidrole-1' || $(this).val() == 'jidrole-3')
				wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, 'id':'pub'+ repGroupName +'-visits'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':repGroupName +'-visits'}).c('affiliation', { 'jid':$(this).text() +'@'+ wRep.host, 'affiliation':'publisher'}).up().tree());
		});
		
		// iq to set repGroupUsers
		$('#repGroupuserxml').empty();
		traverseHTML($('#repGroupuserxml'), $('#repGroupUsers-view').children().first());
	
		var reGroupuser_set = "<iq type='set' to='pubsub."+ wRep.host +"'>"+
			  "<pubsub xmlns='http://jabber.org/protocol/pubsub'><publish node='webVisitors'>"+
				  "<item id='"+ repGroupName +"-allReps'>"+ $('#repGroupuserxml').html() +
				  "</item></publish></pubsub></iq>";
		var reGroupuser_xml = wRep.text_to_xml(reGroupuser_set);
		wRep.connection.sendIQ(reGroupuser_xml);
		
		$('select.select-mulitple').empty().load('includes/ofuser-role.php', assigendJid);
	}
	return false;
});

//--- submit add groupUser form
$(document).on('submit', '#add-groupUser', function(){
	var $formID = $(this).attr('id');
	var $formUrl = $(this).attr('action');
 	ValidateForm($formID);
	if(ValidateForm($formID) == true) {
		var data_string = $(this).serialize();
		$.ajax({
			cache: false,
			type: "POST",
			url: $formUrl,
			data: data_string,
			success: function(data){
				if(data == 'Duplicate entry'){
					$('span.error').html(data);
				} else {
					$('#group-users').append(data);
					$('span.error').html('Agent added sucessfully');
					$('#groups-reload').click();
				}
			},error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.responseText);
			}
		});
	}
	return false;
});

//--- submit Settings Form
$(document).on('submit', '#settings-form', function(event){
	event.preventDefault();

	var $formID = $(this).attr('id');
	var $formUrl = $(this).attr('action');
 	ValidateForm($formID);
	if(ValidateForm($formID) == true) {
		var data_string = $(this).serialize();
		$.ajax({
			cache: false,
			type: "POST",
			url: $formUrl,
			data: data_string,
			success: function(html){
				$('span.error').html(html);
			},error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.responseText);
			}
		});
	}
	return false;
});
//--- submit Class.submit-form form
$(document).on('submit', 'form.submit-form', function(event){
	event.preventDefault();

	var $formID = $(this).attr('id');
	var $formUrl = $(this).attr('action');
 	ValidateForm($formID);
	if(ValidateForm($formID) == true) {
		var data_string = $(this).serialize();
		$('input[disabled]').each( function() {
			data_string = data_string + '&' + $(this).attr('name') + '=' + $(this).val();
		});
		$.ajax({
			cache: false,
			type: "POST",
			url: $formUrl,
			data: data_string,
			success: function(html){
				$('span.error').html(html);
				$('a.reload:visible').click();
			},error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.responseText);
			}
		});
	}
	return false;
});

//---function form validation
function ValidateForm(eleFormID) {
   var success = true;
   var regExp = /[A-Z]/;
	if($(document.forms[eleFormID]['x']).exists()){
		var $x = document.forms[eleFormID]['x'];
		if($x.value == null || $x.value == ''){
			$($x).focus();
			$($x).css({'border':'1px solid #ff9900'});
			$('span.error').html('Please provied Username');
			return false;
			success = false;
		} else if($x.value.match(regExp)){
			$($x).focus();
			$($x).css({'border':'1px solid #ff9900'});
			$('span.error').html('Use lowercase characters for Username');
			return false;
			success = false;
		}
	}
	if($(document.forms[eleFormID]['y']).exists()){
		var $y = document.forms[eleFormID]['y'];
		var atpos=$y.value.indexOf("@");
		var dotpos=$y.value.lastIndexOf(".");
		if($y.value == null || $y.value == ''){
			$($y).focus();
			$($y).css({'border':'1px solid #ff9900'});
			$('span.error').html('Please provide Email');
			return false;
			success = false;
		} else if (atpos<1 || dotpos<atpos+2 || dotpos+2>=$y.length){
			$($y).focus();
			$($y).css({'border':'1px solid #ff9900'});
			$('span.error').html('Not valid Email');
			return false;
			success = false;
		}
	}
	if($(document.forms[eleFormID]['z']).exists()){
		var $z = document.forms[eleFormID]['z'];
		if($z.value == null || $z.value == ''){
			$($z).focus();
			$($z).css({'border':'1px solid #ff9900'});
			$('span.error').html('Please provide Password');
			return false;
			success = false;
		}
	}
	if($(document.forms[eleFormID]['zz']).exists()){
		var $zz = document.forms[eleFormID]['zz'];
		if($zz.value == null || $zz.value == '' || $zz.value !== $z.value){
			$($zz).focus();
			$($zz).css({'border':'1px solid #ff9900'});
			$('span.error').html('Password do not match');
			return false;
			success = false;
		}
	}
	if($(document.forms[eleFormID]['znew']).exists()){
		var $znew = document.forms[eleFormID]['znew'];
		if($znew.value == null || $znew.value == ''){
			$($znew).focus();
			$($znew).css({'border':'1px solid #ff9900'});
			$('span.error').html('Please provide new Password');
			return false;
			success = false;
		}
	}
	if(success = true){
    	$("#"+ eleFormID +" input, #"+ eleFormID +" input[disabled], #"+ eleFormID +" textarea").each(function(){
            if($(this).val() == null || $(this).val() == ''){
                $(this).css({'border':'1px solid #ff9900'});
				$('span.error').html('Please fill the required field(s)');
                success = false;
            }
    	});
	}
    return success;
}

$(document).on('keydown', 'input[type="text"], input[type="password"], textarea', function(){
	$(this).css({'border': '1px solid #ddd'});
	$('span.error').empty();
});
$(document).on('click', '#cancel', function(){
 	$("#mini-form").empty();
});

//----- trigger events
$(document).on('click', 'a.reload', function(event){
	event.preventDefault();
	$fileUrl = $(this).attr('href');
	$contentDiv = $(this).closest('ul').parent('li');
	$(document).trigger('Reload', {fileUrl: $fileUrl, contentDiv: $contentDiv});
});

//--- 
$(document).on('submit', '#transcripts-form', function(event) {
	event.preventDefault();
	var $contentDiv = $(this).closest('ul').parent('li');
	var $formUrl = $(this).attr('action');

	var data_string = $(this).serialize();
	$.ajax({
		cache: false,
		type: "POST",
		url: $formUrl,
		data: data_string,
		success: function(html){
			$($contentDiv).empty().append(html);
			sizeElem();
   		}
	});
	return false;
});

$(document).on('click', 'a.edit', function(event){
	event.preventDefault();
	if($(this).closest('tr').length > 0){
		var $eleClass = $(this).closest('tr').attr('class');
	}
	$fileUrl = $(this).attr('href');
	$("#mini-form").empty(); //remove user panel form
	$("#results").empty();
	$('div.push-page').animate({width: '38%'}).show();
	if($eleClass){
		$(document).trigger('Edit', {fileUrl: $fileUrl, eleClass: $eleClass});
	} else {
		$(document).trigger('Edit', {fileUrl: $fileUrl});
	}
});

$(document).on('click', 'a.delete', function(event){
	event.preventDefault();
	var $element = $('li.total:visible');
	var $fileUrl = $(this).attr('href');
	var dialogConfirm = confirm("Are you sure?");
	if (dialogConfirm == true) {
		$(this).closest('tr').fadeOut('slow', function(){$(this).remove();});
		$(document).trigger('Delete', {fileUrl: $fileUrl, element: $element});
	} else {
		return false;	
	}
});

$(document).on('click', 'a.user-chngs', function(event){
	event.preventDefault();
	var $fileUrl = $(this).attr('href');
	$('#user-panel-pass').attr('href', 'javascript:retun false');
	$("#mini-form").empty();
	$(document).trigger('user-chngs', {fileUrl: $fileUrl});
});

// function Load tab content
$(document).on('tabLoad', function(e, data){
	$("ul.tab-content > li:eq("+ data.itemIndex +")").load(data.fileUrl, function(){
		if(data.tabText == 'Monitoring'){
			$('#payloads-view').appendTo('#payloadTab');
		}
		sizeElem();
	});
});

// function Reload
$(document).on('Reload', function(e, data){
	$.ajax({
		cache: false,
		type: "POST",
		url: data.fileUrl,
		success: function(html){
			$(data.contentDiv).empty().append(html);
			sizeElem();
   		}
	});
});

// function Edit Form
$(document).on('Edit', function(e, data){
	$("#results").attr('class', data.eleClass).load(data.fileUrl, sizeElem);
});

// function Delete Form
$(document).on('Delete', function(e, data){
	$.ajax({
		cache: false,
		type: "POST",
		url: data.fileUrl,
		success: function(html){
			$('li.total').html(html);
			if($('#groups-reload').is(':visible')){
				$('#groups-reload').click();
			}
			if($('#user-reload').is(':visible')){
				$('#user-reload').click();
			}
   		}
	});
});

// function user-emil/password change Form
$(document).on('user-chngs', function(e, data){
	$.ajax({
		type: "POST",
		url: data.fileUrl,
		cache: false,
		success: function(html){
     		$("#mini-form").prepend(html);
			$('#user-panel-email').attr('href', 'includes/ofuser-email.php');
			$('#user-panel-pass').attr('href', 'includes/ofuser-pass.php');
   		}
	});
});

$(document).on('click', '#ribbon li', function(){
	$(this).removeClass('new-chat');
	var $eItem = $(this).attr('id');
	var $class = $(this).attr('class');
	if(!$(this).hasClass('active')){
		if($('#ribbon li.active').length == 4) {
				alert('Maximum (4) chat windows are open');
		} else {
			$('#brwsrinfo > li').hide();
			$('#chat-area > li').removeClass('last');
			$(this).removeClass();
			$(this).addClass('active');
			$('#chat-area > li#chat-'+ $eItem).show().children('input').focus();
			$('#chat-area > li:visible:last').addClass('last');
			$('#brwsrinfo > li#brwsrinfo-'+ $eItem).show();
			sizeElem();
		}
	} else if($class) {
		$(this).removeClass();
		$('#chat-area > li#chat-'+ $eItem).hide();
		$('#brwsrinfo > li#brwsrinfo-'+ $eItem).hide();
	}
});

//--- chat window restore
$(document).on('click', 'img.chat-restore', function(){
	var $room_data = $(this).parent('li').data('jid');
	var $subelm = Strophe.getNodeFromJid($room_data);
	$(this).parent('li').hide();
	$('#ribbon li#'+ $subelm).removeClass('active');
});

//--- chat window block
$(document).on('click', 'img.chat-block', function(event){
	event.preventDefault();
	var room_data = $(this).parent('li').data('jid');
	var $subelm = Strophe.getNodeFromJid(room_data);
	var ip = $('#brwsrinfo-'+ $subelm).children('span').text();

	// Destory room
	wRep.connection.send($msg({to: room_data, type: 'groupchat'}).c('body').t('IP Banned'));
	wRep.connection.send($iq({to: room_data, type: 'set'}).c('query', {xmlns: "http://jabber.org/protocol/muc#owner"}).c('destroy').tree());

	$.ajax({
		cache: false,
		type: "POST",
		url: 'includes/ofipblock.php',
		data: {'id': ip},
		success: function(html){
			$('#chat-'+ $subelm).fadeOut(1000, function(){
				$(this).remove();
				$('#brwsrinfo-'+ $subelm).remove();
				$('#ribbon li#'+ $subelm).remove();
			});
		},error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.responseText);
		}
	});
});

//--- chat window restore
$(document).on('click', 'img.chat-transfer', function(){
	var content = "<div id='transfer-wrapper'><br/><span id='transfer-reset' class='btn'>Cancel</span><span id='tranfer-btn' class='btn'>Transfer<span></div>";
	$(this).parent('li').append(content);
	$('#roster-area').prependTo('#transfer-wrapper');
});

//--- chat transfer
$(document).on('click', '#tranfer-btn', function(){
	var jid = $('#roster-area > option:selected').text();
	var room_data = $(this).closest('li').data('jid');
	if(jid.length > 0 && jid != 'Select'){
		wRep.connection.send($msg({to: room_data, from: wRep.connection.jid}).c('x', {xmlns:'http://jabber.org/protocol/muc#user'}).c('invite', {to:jid}).c('reason').t('Join room').tree());
		$(this).closest('li').fadeOut('slow',function(){
			$('#roster-area').prependTo('div.rosterParent');
			$(this).remove();
			$('#ribbon li#'+ Strophe.getNodeFromJid(room_data)).remove();
			$('#brwsrinfo-'+ Strophe.getNodeFromJid(room_data)).remove();
			wRep.connection.send($pres({to: room_data +"/"+ wRep.nickname, type: 'unavailable'})
			.c('x', {xmlns: "http://jabber.org/protocol/muc"}).tree());
			wRep.umailedLength();
		});
	}
});
//--- chat transfer reset
$(document).on('click', '#transfer-reset', function(){
	$('#roster-area').prependTo('div.rosterParent');
	$(this).parent('div').remove();
});

//--- set chat email, name, contact
$(document).on('click', 'img.set-info', function(){
	var $eItem = $(this).parent('li').children('div.chat-info');
	var $eleid = $(this).attr('id');

  	var st = tSelector.getSelected();
  	if(st!=''){
		$($eItem).children('input[name="'+ $eleid +'"]').val(st);
		$(this).css({'border-bottom':'2px solid #2D92C1'});
	} else {
		$($eItem).children('input[name="'+ $eleid +'"]').val('');
		$(this).css({'border-bottom':'none'});
	}
});

//--- submit unmailedForms
$(document).on('submit', '#unmailed li form', function(event){
	event.preventDefault();
	var $eleid = $(this).closest('li').attr('id');

	$(this).children('textarea[name="transcript"]').val(wRep.addDate() +
	'\r\n--------------------------------------------------\r\n');

	$(this).children().each(function(index, element) {
		if($(element).is('label')){
			var $txtarea = $('#'+ $eleid +' form textarea[name="transcript"]');
			$txtarea.val($txtarea.val() + $(this).text() +': ');
			
		} else if($(element).is('input[type="text"]')) {
			var $txtarea = $('#'+ $eleid +' form textarea[name="transcript"]');
			$txtarea.val($txtarea.val() + $(this).val() +
			'\r\n--------------------------------------------------\r\n');
		}
		return index < 7;
    });

	$('#'+ $eleid +' div.chat-messages').children().each(function() {
		var $txtarea = $('#'+ $eleid +' form textarea[name="transcript"]');
		$txtarea.val($txtarea.val() + $(this).text() +
		'\r\n-\r\n');
	});
	var data_string = $(this).serialize();
	$.ajax({
		cache: false,
		type: "POST",
		url: 'includes/mail-form.php',
		data: data_string,
		success: function(html){
			$('span.error').html(html);
			$(this).slideDown(function(){ 
			$('#'+ $eleid).remove(); 
			//set unmailed in repunmailed
			var repRooms_set = "<iq type='set' to='pubsub."+ wRep.host +"'><pubsub xmlns='http://jabber.org/protocol/pubsub'><publish node='"+ Strophe.getNodeFromJid(wRep.connection.jid) +"-repStats'>"+"<item id='repUnmailed'><repunmailed>"+ $('#unmailed li').length +"</repunmailed></item></publish></pubsub></iq>";
			var repUnmailed_xml = wRep.text_to_xml(repRooms_set);
			wRep.connection.sendIQ(repUnmailed_xml);
			});
			wRep.umailedLength();
		},error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.responseText);
		}
	});
	return false;
});

//set-queues
$(document).on('submit', '#set-queues', function(event){
	event.preventDefault();

	var $queues_checked = document.forms['set-queues']['activeQueues'];
	$('div.queue').empty();
	$("#set-queues input:checkbox[name=activeQueues]:checked").each(function() {
        $('div.queue').append("<div class='active'>"+ $(this).val() +"</div>");
    });
	
	$('#activeQueues_xml').empty();
	traverseHTML($('#activeQueues_xml'), $('#repGroupQueue-view').children().first())
	var $getID = $('#results').attr('class');
	 var activeQueueIQ = "<iq type='set' to='pubsub."+ wRep.host +"'>"+
	  "<pubsub xmlns='http://jabber.org/protocol/pubsub'><publish node='visitorQueues'>"+
		  "<item id='"+ $getID +"-active'>"+ $('#activeQueues_xml').html() +"</item></publish></pubsub></iq>";
		 
	var activeQueue_xml = wRep.text_to_xml(activeQueueIQ);
	wRep.connection.sendIQ(activeQueue_xml);
	return false;
});

// --------- assigendJids functions
$(document).on('click', 'div[class^="jidrole"]', function(){
	var dialogConfirm = confirm("Are you sure you want to remove user?");
	if (dialogConfirm == true) {
		var $getID = $('#results').attr('class');
		var $jidrole = $(this).attr('class');
		var $jidname = $(this).text();
		$(this).remove();
		$('select.select-mulitple').empty().load('includes/ofuser-role.php', assigendJid);
	
		if($jidrole == 'jidrole-3'){		
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, 'id':'sub'+ $getID +'-repGroup'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('subscriptions', {'node': $getID +'-repGroup'}).c('subscription', {'jid':$jidname +'@'+ wRep.host, 'subscription':'unsubscribed'}).tree());
		} else if($jidrole == 'jidrole-1' || $jidrole == 'jidrole-3') {
			wRep.connection.sendIQ($iq({type:'set', to:'pubsub.'+ wRep.host, 'id':'pub'+ $getID +'-visits'}).c('pubsub', {'xmlns':'http://jabber.org/protocol/pubsub#owner'}).c('affiliations', {'node':$getID +'-visits'}).c('affiliation', { 'jid':$jidname +'@'+ wRep.host, 'affiliation':'none'}).up().tree());
		}
		
		wRep.connection.sendIQ($iq({'type':'set','to':'pubsub.'+ wRep.host}).c('pubsub',{'xmlns':'http://jabber.org/protocol/pubsub'}).c('retract', {'node':$jidname +'-assignedRGs'}).c('item',{'id':$getID}).tree());
		
		// iq to set repGroupUsers
		$('#repGroupuserxml').empty();
		traverseHTML($('#repGroupuserxml'), $('#repGroupUsers-view').children().first());
	
		var reGroupuser_set = "<iq type='set' to='pubsub."+ wRep.host +"'>"+
			  "<pubsub xmlns='http://jabber.org/protocol/pubsub'><publish node='webVisitors'>"+
				  "<item id='"+ $getID +"-allReps'>"+ $('#repGroupuserxml').html() +
				  "</item></publish></pubsub></iq>";
		var reGroupuser_xml = wRep.text_to_xml(reGroupuser_set);
		wRep.connection.sendIQ(reGroupuser_xml);
	}

});

//---assigendJids function
function assigendJid(){
	$("div[class^='jidrole']").each(function() {
		var $jid = ($(this).text()); 	
		$('select.select-mulitple > option').filter(function() {
			return $(this).text() == $jid;
		}).remove();
	});
}

//--- stopwatch for tabs
var Stopwatch1 = new (function() {
    var $stopwatch, // Stopwatch element on the page
        incrementTime = 70, // Timer speed in milliseconds
        currentTime = 0, // Current time in hundredths of a second
        updateTimer = function() {
            $stopwatch.html(formatTime(currentTime));
            currentTime += incrementTime / 10;
        },
        init = function() {
            $stopwatch = $('#stopwatchTabs');
            Stopwatch1.Timer = $.timer(updateTimer, incrementTime, true);
        };
    this.resetStopwatch = function() {
        currentTime = 0;
        this.Timer.stop().once();
    };
    $(init);
});
//--- stopwatch for jid presence
var Stopwatch2 = new (function() {
    var $stopwatch, // Stopwatch element on the page
        incrementTime = 70, // Timer speed in milliseconds
        currentTime = 0, // Current time in hundredths of a second
        updateTimer = function() {
            $stopwatch.html(formatTime(currentTime));
            currentTime += incrementTime / 10;
        },
        init = function() {
            $stopwatch = $('#stopwatchPres');
            Stopwatch2.Timer = $.timer(updateTimer, incrementTime, true);
        };
    this.resetStopwatch = function() {
        currentTime = 0;
        this.Timer.stop().once();
    };
    $(init);
});
//--- Stopwatch Common functions
function pad(number, length) {
    var str = '' + number;
    while (str.length < length) {str = '0' + str;}
    return str;
}
function formatTime(time) {
    var min = parseInt(time / 6000),
        sec = parseInt(time / 100) - (min * 60),
        hundredths = pad(time - (sec * 100) - (min * 6000), 2);
    return (min > 0 ? pad(min, 2) : "00") + ":" + pad(sec, 2); //+ ":" + hundredths;
}

//--- Higlighted text selector
var tSelector = {};
tSelector.getSelected = function(){
  var t = '';
  if(window.getSelection){
    t = window.getSelection();
  }else if(document.getSelection){
    t = document.getSelection();
  }else if(document.selection){
    t = document.tSelector.createRange().text;
  }
  return t;
}



