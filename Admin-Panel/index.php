<?php include('../function/function.php');
    IndexAdminLogin();
    $userName = $_SESSION["user_name"];
    $userImg = $_SESSION['user_img'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>WESPEDIA | AdminPanel</title>
  <link rel="shortcut icon" type="image/png" href="../images/in_design/Mario.png">

  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Local css -->
  <link rel="stylesheet" type="text/css" href="../local/css/custom_css.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->

  <!-- daterange picker -->
  <!-- <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css"> -->

  <!-- iCheck for checkboxes and radio inputs -->
  <!-- <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css"> -->

  <!-- Bootstrap Color Picker -->
  <!-- <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css"> -->
  
  <!-- Bootstrap4 Duallistbox -->
  <!-- <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css"> -->

  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>
<!-- date("Y-m-d", strtotime($_POST["releaseDate"])), -->
<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">

    <!--Navbar-->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <!-- <li class="nav-item d-none d-sm-inline-block">
          <a href="index3.html" class="nav-link">Home</a>
        </li> -->
        <!-- <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contact</a>
        </li> -->
      </ul>

      <!-- User Profile -->
      
      <!-- SEARCH FORM -->
      <!-- <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
          <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form> -->

      <ul class="navbar-nav ml-auto">
        
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <!-- <i class="fas fa-th-large"></i> -->
            <?php if(file_exists($userImg)){ ?>
              <img src="<?php echo $userImg;?>" class="nav-img elevation-2" />
            <?php }else{?> 
              <img src="../images/in_design/DP.jpg" class="nav-img elevation-2" />
            <?php }?>
            
            <span class=""><?php echo $userName;?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <a href="#" id="view-profile" class="dropdown-item">View Profile</a>
            <div class="dropdown-divider"></div>
            <a href="logout.php" class="dropdown-item">Logout</a>
          </div>
        </li>
        
      </ul>

    </nav>

    <!-- Main Sidebar Container --> <!-- <aside></aside> -->
    <div class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link" id="goHome">
        <img src="../images/in_design/ChainChomp.png" alt="..." class="brand-image img-circle elevation-3"
             style="opacity: .8" />
        <span class="brand-text font-weight-light">Wespedia Admin</span>
      </a>

      <div class="sidebar">
        
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

              <!-- Series List -->
              <li class="nav-item has-treeview"> <!-- menu-open -->
                <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-video"></i>
                  <p> WEB SERIES <i class="right fas fa-angle-left"></i></p>
                </a>
                
                <ul class="nav nav-treeview">
                  <!--View-->
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="view-series">
                      <i class="nav-icon fa fa-eye"></i>
                      <p>View</p>
                    </a>
                  </li>

                  <!-- Add -->
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="add-series">
                      <i class="nav-icon fa fa-plus"></i>
                      <p>Add</p>
                    </a>
                  </li>
                </ul>
              </li>

              <!-- Seasons -->
              <li class="nav-item has-treeview"> <!-- menu-open -->
                <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-film"></i>
                  <p>SEASONS<i class="right fas fa-angle-left"></i></p>
                </a>

                <ul class="nav nav-treeview">
                  <!--View-->
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="view-seasons">
                      <i class="nav-icon fa fa-eye"></i>
                      <p>View</p>
                    </a>
                  </li>

                  <!-- Add -->
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="add-seasons">
                      <i class="nav-icon fa fa-plus"></i>
                      <p>Add</p>
                    </a>
                  </li>

                  <!-- Modify -->
                  <!-- <li class="nav-item">
                    <a href="#" class="nav-link" id="modify-director">
                      <i class="nav-icon fa fa-pen"></i>
                      <p>Modify</p>
                    </a>
                  </li> -->
                </ul>
              </li>

              <!-- Episode -->
              <li class="nav-item has-treeview"> <!-- menu-open -->
                <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-film"></i>
                  <p>EPISODE<i class="right fas fa-angle-left"></i></p>
                </a>

                <ul class="nav nav-treeview">
                  <!--View-->
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="view-episode">
                      <i class="nav-icon fa fa-eye"></i>
                      <p>View</p>
                    </a>
                  </li>

                  <!-- Add -->
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="add-episode">
                      <i class="nav-icon fa fa-plus"></i>
                      <p>Add</p>
                    </a>
                  </li>

                  <!-- Modify -->
                  <!-- <li class="nav-item">
                    <a href="#" class="nav-link" id="modify-episode">
                      <i class="nav-icon fa fa-pen"></i>
                      <p>Modify</p>
                    </a>
                  </li> -->
                </ul>
              </li>

              <!-- Actors -->
              <li class="nav-item has-treeview"> <!-- menu-open -->
                <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-star"></i>
                  <p>ACTORS<i class="right fas fa-angle-left"></i></p>
                </a>

                <ul class="nav nav-treeview">
                  <!--View-->
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="view-actors">
                      <i class="nav-icon fa fa-eye"></i>
                      <p>View</p>
                    </a>
                  </li>

                  <!-- Add -->
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="add-actors">
                      <i class="nav-icon fa fa-plus"></i>
                      <p>Add</p>
                    </a>
                  </li>
                </ul>
              </li>

              <!-- Directors -->
              <li class="nav-item has-treeview"> <!-- menu-open -->
                <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-film"></i>
                  <p>DIRECTORS<i class="right fas fa-angle-left"></i></p>
                </a>

                <ul class="nav nav-treeview">
                  <!--View-->
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="view-director">
                      <i class="nav-icon fa fa-eye"></i>
                      <p>View</p>
                    </a>
                  </li>

                  <!-- Add -->
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="add-director">
                      <i class="nav-icon fa fa-plus"></i>
                      <p>Add</p>
                    </a>
                  </li>

                </ul>
              </li>
              
              <!-- Producers -->
              <li class="nav-item has-treeview"> <!-- menu-open -->
                <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-industry"></i>
                  <p>PRODUCERS<i class="right fas fa-angle-left"></i></p>
                </a>

                <ul class="nav nav-treeview">
                  <!--View-->
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="view-producers">
                      <i class="nav-icon fa fa-eye"></i>
                      <p>View</p>
                    </a>
                  </li>

                  <!-- Add -->
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="add-producers">
                      <i class="nav-icon fa fa-plus"></i>
                      <p>Add</p>
                    </a>
                  </li>

                </ul>
              </li>

              <!-- Writers -->
              <li class="nav-item has-treeview"> <!-- menu-open -->
                <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-pencil-alt"></i>
                  <p>WRITERS<i class="right fas fa-angle-left"></i></p>
                </a>

                <ul class="nav nav-treeview">
                  <!--View-->
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="view-writer">
                      <i class="nav-icon fa fa-eye"></i>
                      <p>View</p>
                    </a>
                  </li>

                  <!-- Add -->
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="add-writer">
                      <i class="nav-icon fa fa-plus"></i>
                      <p>Add</p>
                    </a>
                  </li>
                </ul>
              </li>

              <!-- Platform -->
              <li class="nav-item has-treeview"> <!-- menu-open -->
                <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-play"></i>
                  <p>PLATFORMS<i class="right fas fa-angle-left"></i></p>
                </a>

                <ul class="nav nav-treeview">
                  <!--View-->
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="view-platforms">
                      <i class="nav-icon fa fa-eye"></i>
                      <p>View</p>
                    </a>
                  </li>

                  <!-- Add -->
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="add-platforms">
                      <i class="nav-icon fa fa-plus"></i>
                      <p>Add</p>
                    </a>
                  </li>

                </ul>
              </li>

              <!-- Social Account -->
              <li class="nav-item has-treeview"> <!-- menu-open -->
                <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-mobile"></i>
                  <p>SOCIAL ACCOUNT <i class="right fas fa-angle-left"></i></p>
                </a>

                <ul class="nav nav-treeview">
                  <!--View-->
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="view-social">
                      <i class="nav-icon fa fa-eye"></i>
                      <p>View</p>
                    </a>
                  </li>

                  <!-- Add -->
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="add-social">
                      <i class="nav-icon fa fa-plus"></i>
                      <p>Add</p>
                    </a>
                  </li>

                </ul>
              </li>

            <?php if($_SESSION['master_admin'] ==1){?>
              <!-- User/Admin -->
              <li class="nav-item has-treeview"> <!-- menu-open -->
                <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-user"></i>
                  <p>MANAGE ADMIN <i class="right fas fa-angle-left"></i></p>
                </a>

                <ul class="nav nav-treeview">
                  <!--View-->
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="view-admin">
                      <i class="nav-icon fa fa-eye"></i>
                      <p>View</p>
                    </a>
                  </li>

                  <!-- Add -->
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="add-admin">
                      <i class="nav-icon fa fa-plus"></i>
                      <p>Add</p>
                    </a>
                  </li>

                </ul>
              </li>
            <?php }?>
              
          </ul>
        </nav>

      </div>

    </div>

    <!-- Load Page Here -->
    <div class="content-wrapper" id="load-page">
      <h1 class="container-fluid">Loading...</h1>
    </div>

    <footer class="main-footer">
      <strong>Copyright &copy; 2020 <a href="#">Wespedia</a>.</strong> All rights reserved.
      <!-- <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1
      </div> -->
    </footer>
  </div>


  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>

  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- DataTables -->
  <script src="plugins/datatables/jquery.dataTables.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

  <!-- Select2 -->
  <script src="plugins/select2/js/select2.full.min.js"></script>

  <!-- Bootstrap4 Duallistbox -->
  <!-- <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script> -->

  <!-- InputMask -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>


  <!-- date-range-picker -->
  <!--<script src="plugins/daterangepicker/daterangepicker.js"></script> -->

  <!-- bootstrap color picker -->
  <!-- <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script> -->

  <!-- Tempusdominus Bootstrap 4 -->
  <!-- <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script> -->

  <!-- Bootstrap Switch -->
  <script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>

  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- Page script -->

</body>

</html>

<script src="local/js/myJS.js">
  //Loads Local JS file.
</script>

<script>

$(document).ready(function(){

  LoadPage("view-series.php");
  //LoadPage("view-admin.php");
  $("#goHome").click(function(){
    LoadPage("home.php");    
  });
  
  $("#add-series").click(function(){
    LoadPage("add-series.php");
    //alert("view-series");
  });
  $("#view-series").click(function(){
    LoadPage("view-series.php");
    //alert("view-series");
  });
  $("#add-seasons").click(function(){
    LoadPage("add-season.php");
    //alert("view-seasons");
  });
  $("#view-seasons").click(function(){
    LoadPage("view-season.php");
    //alert("view-seasons");
  });
  $("#add-episode").click(function(){
    LoadPage("add-episode.php");
    //alert("view-seasons");
  });
  $("#view-episode").click(function(){
    LoadPage("view-episode.php");
    //alert("view-seasons");
  });

  $("#add-actors").click(function(){
    LoadPage("add-actors.php");
    //alert("view-actors");
  });
  $("#view-actors").click(function(){ 
    LoadPage("view-actors.php");
    //alert("view-actors");
  });
  $("#add-director").click(function(){
    LoadPage("add-dirct.php");
    //alert("view-director");
  });
  $("#view-director").click(function(){
    LoadPage("view-dirct.php");
    //alert("view-director");
  });

  $("#add-producers").click(function(){
    LoadPage("add-producer.php");
    //alert("add-producer");
  });
  $("#view-producers").click(function(){
    LoadPage("view-producer.php");
    //alert("view-producer");
  });

  $("#add-writer").click(function(){
    LoadPage("add-writer.php");
    //alert("add-writer");
  });
  $("#view-writer").click(function(){
    LoadPage("view-writer.php");
    //alert("view-writer");
  });

  $("#add-platforms").click(function(){
    LoadPage("add-platform.php");
    //alert("view-platforms");
  });
  $("#view-platforms").click(function(){
    LoadPage("view-platform.php");
    //alert("view-platforms");
  });

  $("#add-admin").click(function(){
    LoadPage("add-admin.php");
    //alert("view-admin");
  });
  $("#view-admin").click(function(){
    LoadPage("view-admin.php");
    //alert("view-admin");
  });

  $("#add-social").click(function(){
    LoadPage("add-social.php");
    //alert("add-social");
  });
  $("#view-social").click(function(){
    LoadPage("view-social.php");
    //alert("view-social");
  });

  $("#view-profile").click(function(){
    LoadPage("view-profile.php");
    //alert("view-profile");
  });
});

</script>

<script>
  //Call the respective function in the page where its component 
  //is needed.

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
</script>

