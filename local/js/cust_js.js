
function deleteCookie(cname){
	document.cookie = cname+"=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
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

function checkCookie(cname) {
  var tabs = getCookie(cname);
  if (tabs == "home") {
    LoadPages("home.php");
	MakeActive("#home");
  } 
  else if (tabs == "trend") {
    LoadPages("trending.php");
	MakeActive("#trend");
  }
  else if (tabs == "pop_acc") {
    LoadPages("pop_acc.php");
	MakeActive("#pop_acc");
  }
  else if (tabs == "fav") {
    LoadPages("favorite.php");
	MakeActive("#fav");
  }

  else if (tabs == "user-profile") {
    LoadPages("user-profile.php");
  }
  else if (tabs == "setting") {
    LoadPages("setting.php");
  }
  else if (tabs == "bookmark") {
    LoadPages("bookmark.php");
  }
  else {
    LoadPages("home.php");
	MakeActive("#home");
	setCookie('nav-tabs','home','1');
  }
}

