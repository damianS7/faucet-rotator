var showReportDiv = false;
var faucetsArray;
var posArray = 0;

function hideWindows() {
	if(showReportDiv) {
		showReport();
	}
}

function showReport(){
	if(showReportDiv == false) {
		$(".report").fadeIn();
		$("#id_faucet").val(faucetsArray[posArray]['id']);
		showReportDiv = true;
	} else {
		$(".report").fadeOut();	
		showReportDiv = false;
	}
}

function report() {
	var i = faucetsArray[posArray]['id'];
	var t = $("#title").val();
	var m = $("#message").val();
	$.ajax({ url: 'functions.php',
	data: {action: 'report_faucet', id: i, title: t, msg: m },
	type: 'post',

	success: function(json) {
		hideWindows();
		alertify.alert(json);
	}
	});
}

function setFaucet(url) {
	$("#frame").attr('src', url);
}

function loadFaucets(orderBy) {
	posArray = 0;
	$('.order-button').click( function() {
		$('.order-button-selected').removeClass("order-button-selected");
    	$(this).toggleClass("order-button-selected");
  	});

  	$.ajax({ url: 'functions.php',
	data: {action: 'get_faucets', orderby: orderBy},
	type: 'post',

	success: function(json) {
		faucetsArray = jQuery.parseJSON(json);
		$(".actual_faucet").text("1");
		$(".total_faucets").text(faucetsArray.length);
		updateInfo();	
		setFaucet(faucetsArray[0]['url']);
	}
	});
}

function updateInfo() {
	hideWindows();
	$(".actual_faucet").text(posArray+1);
	$(".faucet_name").text(faucetsArray[posArray]['faucet']);
	$(".faucet_votes").text(faucetsArray[posArray]['votes']);
}

function previous() {
	if(posArray > 0) {
		posArray--;
		updateInfo();	
		setFaucet(faucetsArray[posArray]['url']);
	}
}

function next() {
	if(posArray < faucetsArray.length-1) {
		posArray++;
		updateInfo();	
		setFaucet(faucetsArray[posArray]['url']);
	}
}

function vote(vote) {
	voteFaucetId(vote, faucetsArray[posArray]['id']);
}

function voteFaucetId(vote, id) {
	$.ajax({ url: 'functions.php',
		data: {action: 'vote_faucet', vote: vote, id: id},
		type: 'post',

		success: function(r) {
			alertify.alert(r);
		}
	});	
}
