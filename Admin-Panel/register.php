<?php include('../function/function.php');
    CheckAdminLogin();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Wespedia | Admin Register</title>
  <link rel="shortcut icon" type="image/png" href="../images/in_design/Mario.png">

  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="#"><b>Admin Register</b></a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <!-- <p class="login-box-msg">Register a new membership</p> -->

      <form action="#" method="post">
        <div class="input-group mb-3">
          <input type="text" name="fullName" id="fullName" class="form-control" placeholder="Full name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" name="email" id="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" id="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <span style="color:red; font-size:12px;" id="psswdErr"></span>
        <span style="color:green; font-size:12px;" id="psswdSucc"></span>
        <div class="input-group mb-3">
          <input type="password" name="rePassword" id="rePassword" class="form-control" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
         
          <div class="col-4">
            <a href="#" id="register" class="btn btn-primary btn-block">Register</a>
          </div>
          
        </div>
      </form>

      <a href="login.php" class="text-center">I already have a membership</a>
    </div>
    
  </div>
</div>


<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>

<script>
$(document).ready(function(){
  var regFlag = 0;
  $("#rePassword, #password").keyup(function(){
    var psswd = $("#password").val();
    var rePsswd = $("#rePassword").val();
    if(rePsswd === psswd){
      regFlag = 1;
      $("#psswdErr").html("");
      $("#psswdSucc").html("*password match.");
    }
    else{
      regFlag = 0;
      $("#psswdSucc").html("");
      $("#psswdErr").html("*password do not match !");
    }
  });

  $("#register").click(function(){
    // alert("register");
    var fullName = $("#fullName").val();
    var email = $("#email").val();
    var psswd = $("#password").val();
    var action = 'register';
    
    if(fullName != '' || email != '' || psswd != ''){
      if(regFlag == 1){
        $.ajax({
          url: 'api.php',
          type: 'POST',
          data: 'fullName='+fullName+'&email='+email+'&password='+psswd+'&action='+action,
          dataType: 'JSON',
          encoding: true,
          success: function(response){
                      if(response.success == 1){
                         alert(response.msg);
                         location.reload();
                      }else{
                         alert(response.msg);
                      }
                   }
        });
      }
    }
    else{
      alert("Please enter your detail.");
    }

    
  });
});  
</script>