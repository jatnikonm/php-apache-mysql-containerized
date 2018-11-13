var x = 1;

function cekMail(){
    $.ajax({
        url: "Share/MainAlertCheck.php?option=mail",
        cache: false,
        success: function(msg){
			displayMail(msg)
        }
    });
    var waktu = setTimeout("cekMail()",15000);
}

function cekDelete(){
    $.ajax({
        url: "Share/MainAlertCheck.php?option=fileDel",
        cache: false,
        success: function(msg){
			displayDel(msg)
        }
    });
    var waktu = setTimeout("cekDelete()",17000);
}

function cekOnline(){
    $.ajax({
        url: "Share/MainAlertCheck.php?option=userOnline",
        cache: false,
        success: function(msg){
			displayOnline(msg)
        }
    });
    var waktu = setTimeout("cekOnline()",17000);
}

$(document).ready(function(){
	originalTitle = document.title;
	startChatSession();

	$([window, document]).blur(function(){
		windowFocus = false;
	}).focus(function(){
		windowFocus = true;
		document.title = originalTitle;
	});
	
	cekMail();
	cekOnline();
	cekDelete();
});

function displayMail(val){
	document.getElementById("pnlMail").style.display = val;
}

function displayDel(val){
	document.getElementById("pnlAlertDelete").style.display = val;
}

function displayOnline(val){
	document.getElementById("listOnline").innerHTML = val;
}