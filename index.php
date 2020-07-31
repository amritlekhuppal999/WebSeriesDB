<?php include("function/function.php");?>
<!DOCTYPE html>
<html>
<head>
	<title>WebSeriesDB</title>

	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- BOOTSTARP CSS -->
	<link rel="stylesheet" href="bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />

	<!--custom/Local CSS-->
	<link rel="stylesheet" href="local/css/custom_css.css" />

	<!--Font Awesome-->
	<link rel="stylesheet" href="fontawesome/css/all.css" />

	<!--JQUERY-->
	<script type="text/javascript" src="local/js/jquery.min.js"></script>

	<!-- Popper JS -->
	<script type="text/javascript" src="local/popper_js/popper.min.js"></script>

	<!--Google Fonts-->
	<link href="https://fonts.googleapis.com/css?family=Baloo+Tammudu|Carter+One|Notable|Solway|Patua+One|Stint+Ultra+Expanded&display=swap" rel="stylesheet">	

	<!-- BOOTSTARP JS -->
	<script src="bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>
<body>

	<div class="">

		

	</div>
</body>
</html>

<script>
$(document).ready(function(){
	checkCookie();
	
	$("#ABOUT, #about").click(function(){
		MakeActive("#ABOUT");
		LoadPage("about.php");
		setCookie("currPage", "ABOUT", "1");
		$(".pg-head").html("ABOUT");
	});
	
});

function MakeActive(curr_this){
	$(".content").removeClass("cont-active");
	$(curr_this).addClass("cont-active");
}

function LoadPage(load_url){
	$(".topNav .list-group").hide(); //to hide the topNav list-group menu.

	$.ajax({
		url: load_url,
		type:'POST',
		// data:'action=fav',
		dataType:'html',
		success: function(response){
			$("#load-page").html(response);
			// history.pushState(null, null, e.attr(cur_url)); 
		}
	});
}

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function checkCookie() {
  var currPage = getCookie("currPage");
  if(currPage != ""){
  	//alert(currPage);
  	if (currPage == "ABOUT") {
	    LoadPage("about.php");
	    MakeActive("#ABOUT");
	    $(".pg-head").html("ABOUT");
	} 
	else if (currPage == "PROJECTS") {
	    LoadPage("projects.php");
	    MakeActive("#PROJECTS");
	    $(".pg-head").html("PROJECTS");
	}
	
  }
  
}


function rTab(){
	$(".topNav .list-group").toggle();
}
</script>

