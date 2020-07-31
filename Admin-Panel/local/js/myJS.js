//LOCAL JS FUNCTIONS--------------------

//Function to Load Page.
function LoadPage(load_url){
  //to hide the topNav list-group menu.
  $(".topNav .list-group").hide(); 

  $.ajax({
    url: load_url,
    type:'POST',
    // data:'action=fav',
    dataType:'html',
    success: function(response){
      $("#load-page").html(response);
    }
  });
}

//Function to load a particular section in a page.
function LoadSect(recData){
  $.ajax({
    url: recData.load_url,
    type:'POST',
    dataType:'html',
    success: function(response){
      $(recData.dest_sect).html(response);
      //$("#myname").val(recData.myname);
    }
  });
}

//Function to set Cookie.
function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

//Function to get Cookie.
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

//Function to get Cookie.
function checkCookie() {
  // var currPage = getCookie("currPage");
  // if(currPage != ""){
  //   //alert(currPage);
  //   if (currPage == "ABOUT") {
  //     LoadPage("about.php");
  //     MakeActive("#ABOUT");
  //     $(".pg-head").html("ABOUT");
  //   } 
  //   else if (currPage == "PROJECTS") {
  //       LoadPage("projects.php");
  //       MakeActive("#PROJECTS");
  //       $(".pg-head").html("PROJECTS");
  //   }
  //   else if (currPage == "EXPERIENCE") {
  //       LoadPage("experience.php");
  //       MakeActive("#EXPERIENCE");
  //       $(".pg-head").html("EXPERIENCE");
  //   }
  //   else if (currPage == "EDUCATION") {
  //       LoadPage("education.php");
  //       MakeActive("#EDUCATION");
  //       $(".pg-head").html("EDUCATION");
  //   }
  //   else if (currPage == "SKILL SET") {
  //       LoadPage("skill_set.php");
  //       MakeActive("#SKILL-SET");
  //       $(".pg-head").html("SKILL SET");
  //   }
  //   else if (currPage == "INTERESTS") {
  //       LoadPage("interests.php");
  //       MakeActive("#INTERESTS");
  //       $(".pg-head").html("INTERESTS");
  //   }
  // }
  // else{
  //   LoadPage("about.php");
  //   MakeActive("#ABOUT");
  //   $(".pg-head").html("ABOUT");
  // }
}

//Restricting Blank Space as first char.
// function RestSpace(field_id){  
// 	$(field_id).keyup(function(){
// 		var f_value = $(field_id).val();
// 		if(f_value[0] === ' '){
// 			$(field_id).val('');
// 			return false;
// 		}
// 	});
// }

// Convert select to array with values.
// function SelectArray(select){ //serealizeSelects(select) 
//     var array = [];
//     select.each(function(){ array.push($(this).val()) });
//     return array;
// }

//ADMIN LTE JS FUNCTIONS-----------------
$(function(){
	//Initialize Select2 Elements
	// $(".select2").select2()

	//Initialize Select2 Elements
	// $(".select2bs4").select2({
	//   theme: "bootstrap4"
	// })

	//Datemask dd/mm/yyyy
	//$("#datemask").inputmask("dd/mm/yyyy", { "placeholder": "dd/mm/yyyy" })

	//Datemask2 mm/dd/yyyy
	//$("#datemask2").inputmask("mm/dd/yyyy", { "placeholder": "mm/dd/yyyy" })

	//Money Euro
	//$("[data-mask]").inputmask()

	//Date range picker
	//$("#reservation").daterangepicker()

	//Date range picker with time picker
	// $("#reservationtime").daterangepicker({
	//   timePicker: true,
	//   timePickerIncrement: 30,
	//   locale: {
	//     format: "MM/DD/YYYY hh:mm A"
	//   }
	// })

	//Date range as a button
	// $("#daterange-btn").daterangepicker(
	//   {
	//     ranges   : {
	//       "Today"       : [moment(), moment()],
	//       "Yesterday"   : [moment().subtract(1, "days"), moment().subtract(1, 'days')],
	//       "Last 7 Days" : [moment().subtract(6, "days"), moment()],
	//       "Last 30 Days": [moment().subtract(29, "days"), moment()],
	//       "This Month"  : [moment().startOf("month"), moment().endOf("month")],
	//       "Last Month"  : [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
	//     },
	//     startDate: moment().subtract(29, "days"),
	//     endDate  : moment()
	//   },
	//   function (start, end) {
	//     $("#reportrange span").html(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"))
	//   }
	// )

	//Timepicker
	// $("#timepicker").datetimepicker({
	//   format: "LT"
	// })

	//Bootstrap Duallistbox
	//$(".duallistbox").bootstrapDualListbox()

	//Colorpicker
	//$(".my-colorpicker1").colorpicker()

	//color picker with addon
	//$(".my-colorpicker2").colorpicker()

	// $(".my-colorpicker2").on("colorpickerChange", function(event) {
	//   $(".my-colorpicker2 .fa-square").css("color", event.color.toString());
	// });

	// $("input[data-bootstrap-switch]").each(function(){
	//   $(this).bootstrapSwitch("state", $(this).prop("checked"));
	// });
})


//////////////////////MODAL JS FUNCTIONS/////////////////
// Get the modal
// var modal = document.getElementById("myModal");

// // Get the button that opens the modal
// var btn = document.getElementById("myBtn");

// // Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close")[0];

// // When the user clicks on the button, open the modal
// btn.onclick = function() {
//   modal.style.display = "block";
// }

// // When the user clicks on <span> (x), close the modal
// span.onclick = function() {
//   modal.style.display = "none";
// }

// // When the user clicks anywhere outside of the modal, close it
// window.onclick = function(event) {
//   if (event.target == modal) {
//     modal.style.display = "none";
//   }
// }
//////////////////////END////////////////////////////////
