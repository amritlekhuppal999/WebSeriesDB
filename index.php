<?php include("function/function.php");?>
<!DOCTYPE html>
<html>
<head>
	<title>MyProfile</title>

	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- BOOTSTARP CSS -->
	<link rel="stylesheet" href="bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />

	<link rel="stylesheet" href="local/css/custom_css.css" /> <!--custom/Local CSS-->
	<link rel="stylesheet" href="fontawesome/css/all.css" />	<!--Font Awesome-->
	<script type="text/javascript" src="local/js/jquery.min.js"></script>	<!--JQUERY-->
	<script type="text/javascript" src="local/popper_js/popper.min.js"></script>	<!-- Popper JS -->

	<!--Google Fonts-->
	<link href="https://fonts.googleapis.com/css?family=Baloo+Tammudu|Carter+One|Notable|Solway|Patua+One|Stint+Ultra+Expanded&display=swap" rel="stylesheet">	

	<!-- BOOTSTARP JS -->
	<script src="bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>
<body>

	<div class="">

		<!-- <div class="jumbotron">
			<div class="name-card">
				<div class="profile-DP-detail">
					<h1>Amrit Lekh Uppal</h1>
					<b>Developer</b>
					<b>/ Coder</b> <br />
					<b>B.E Computer Science</b>
				</div>
				
			</div>
		</div> -->

		<div class="lower-sec"> 
			<div class="row">

				<!-- profile-DP -->
				<div class="col-sm-3">
					<div class="card text-center">
					  <!-- <img class="card-img-top" src="images/in_design/DP.jpg" alt="Profile Pic" style="border:10px solid #ffffff;"> -->
					  <img class="profile-DP " src="images/in_design/DP.jpg" id="myimg">
					  <div class="card-body">
					    <?php 
					    	$cont = Content();
					    	foreach($cont as $key=> $value){ ?>
					    		<p class="card-text content" data-cont="<?php echo $value;?>" 
					    			id="<?php if($value == 'SKILL SET'){echo 'SKILL-SET';}
					    					  else{echo $value;}?>">
						    		<?php echo $value;?> </p>
						<?php }?>
					  </div>
					</div>

					<!--Social Icons-->
					<div class="card text-center">
						<div class="card-body">
							<div class="social-icons">
					  			<!-- <a href="https://www.linkedin.com/in/amrit-lekh-uppal-579b5b179" target="0_blank" style="color:#bdbdbd;"><i class="fab fa-linkedin-in"></i></a>
					  			<a href="https://www.facebook.com/ambition.storm" target="0_blank" style="color:#bdbdbd;"><i class="fab fa-facebook"></i></a>
						  		<a href="https://www.instagram.com/amrit_lekh_uppal/" target="0_blank" style="color:#bdbdbd;"><i class="fab fa-instagram"></i></a>
						  		<a href="#" target="0_blank" style="color:#bdbdbd;"><i class="fab fa-twitter"></i></a> -->

						  		<i class="fab fa-linkedin-in"></i>
						  		<i class="fab fa-facebook"></i>
						  		<i class="fab fa-instagram"></i>
						  		<i class="fab fa-twitter"></i>
						  	</div>
						</div>
					</div>
					<!--Contact Info-->
					<div class="card text-center">
						<div class="card-body">
							<div class="contact-no">
								<i class="fab fa-whatsapp"></i>
					  			<b>7777777777</b>
					  		</div>
						</div>
					</div>
					
				</div>

				<div class="col-sm-9" id="load-page">

					<h1>Loading...</h1>

				</div>
			</div>
		</div>

	</div>
</body>
</html>

<script>
$(document).ready(function(){
	checkCookie();
	
	$("#ABOUT").click(function(){
		MakeActive("#ABOUT");
		LoadPage("about.php");
		setCookie("currPage", "ABOUT", "1");
	});
	$("#PROJECTS").click(function(){
		MakeActive("#PROJECTS");
		LoadPage("projects.php");
		setCookie("currPage", "PROJECTS", "1");
	});
	$("#EXPERIENCE").click(function(){
		MakeActive("#EXPERIENCE");
		LoadPage("experience.php");
		setCookie("currPage", "EXPERIENCE", "1");
	});
	$("#EDUCATION").click(function(){
		MakeActive("#EDUCATION");
		LoadPage("education.php");
		setCookie("currPage", "EDUCATION", "1");
	});
	$("#SKILL-SET").click(function(){
		MakeActive("#SKILL-SET");
		LoadPage("skill_set.php");
		setCookie("currPage", "SKILL SET", "1");
	});
	$("#INTERESTS").click(function(){
		MakeActive("#INTERESTS");
		LoadPage("interests.php");
		setCookie("currPage", "INTERESTS", "1");
	});	
});

$(".contact-no").click(function(){
	//alert("7829741963");
	//window.location.href = "https://wa.me/7777777777";
});

function MakeActive(curr_this){
	$(".content").removeClass("cont-active");
	$(curr_this).addClass("cont-active");
}

function LoadPage(load_url){

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
	} 
	else if (currPage == "PROJECTS") {
	    LoadPage("projects.php");
	    MakeActive("#PROJECTS");
	}
	else if (currPage == "EXPERIENCE") {
	    LoadPage("experience.php");
	    MakeActive("#EXPERIENCE");
	}
	else if (currPage == "EDUCATION") {
	    LoadPage("education.php");
	    MakeActive("#EDUCATION");
	}
	else if (currPage == "SKILL SET") {
	    LoadPage("skill_set.php");
	    MakeActive("#SKILL-SET");
	}
	else if (currPage == "INTERESTS") {
	    LoadPage("interests.php");
	    MakeActive("#INTERESTS");
	}
  }
  else{
  	LoadPage("about.php");
	MakeActive("#ABOUT");
  }
}

</script>

