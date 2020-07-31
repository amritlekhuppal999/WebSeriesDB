<?php 

//ASSIGN CAST {Actor, Director, Platform}
if($_POST["action"] == "asgn-cast"){
	$data = array();
	$data["msg"] = 'To assign cast';
	$retHtml = '
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-default">
					
					<!--Form Start-->
					<form enctype="multipart/form-data">

					<!-- Card Header -->
					<div class="card-header">
						<h3 class="card-title">Assign Cast</h3>
					</div>

		<!--Card Body-->
		<div class="card-body">
			<div class="row">
				
	<div class="col-md-12">
		<!-- <h4>Assign Cast</h4> -->
		<ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
			<li class="nav-item">
            	<a class="nav-link active" 
            	 id="custom-content-below-actors-tab" 
            	 data-toggle="pill" 
            	 href="#custom-content-below-actors" role="tab" 
            	 aria-controls="custom-content-below-actors" 
            	 aria-selected="true">Actors</a>
            </li>
            <li class="nav-item">
            	<a class="nav-link"
            	 id="custom-content-below-directors-tab" 
            	 data-toggle="pill" 
            	 href="#custom-content-below-directors" role="tab" 
            	 aria-controls="custom-content-below-directors" 
            	 aria-selected="false">Directors</a>
          	</li>
          	<li class="nav-item">
            	<a class="nav-link" 
            	 id="custom-content-below-platforms-tab" 
            	 data-toggle="pill" 
            	 href="#custom-content-below-platforms" role="tab" 
            	 aria-controls="custom-content-below-platforms"
            	 aria-selected="false">Platforms</a>
            </li>
		</ul> 

		<style>
			.ser-div{ max-height:200px; width: 97%; overflow-y: auto;
			  background-color:white; position: absolute; z-index: 1; }
		</style>

		<div class="tab-content" id="custom-content-below-tabContent">
			<!-- ACTORS --> 
			<div class="tab-pane fade show active" id="custom-content-below-actors" role="tabpanel" aria-labelledby="custom-content-below-actors-tab">
     			  
     			<br /> 
     			<form enctype="multipart/form-data">
	     			<div class="row">
	     				<div class="col-md-6">
	     					<input class="form-control" type="text" name="act-ser" id="act-ser" placeholder="Search Actor">
	     					<div class="ser-div" id="act-load">
	     						
	     					</div>
	     				</div> 
	     				<!-- <div class="col-md-6">
	     					<button class="btn btn-primary">Submit</button>
	     				</div> -->
	     			</div>
		     	</form>
	     	</div>

	     	<!-- DIRECTORS --> 
  			<div class="tab-pane fade" id="custom-content-below-directors" role="tabpanel" aria-labelledby="custom-content-below-directors-tab">
     			
     			<br /> 
     			<form enctype="multipart/form-data">
	     			<div class="row">
	     				<div class="col-md-6">
	     					<input class="form-control" type="text" name="dirct-ser" id="dirct-ser" placeholder="Search Director">
	     					<div class="ser-div" id="dirct-load">
	     						
	     					</div>
	     				</div> 
	     				<!-- <div class="col-md-6">
	     					<button class="btn btn-primary">Submit</button>
	     				</div> -->
	     			</div>
		     	</form>
  			</div>

  			<!-- PLATFORMS -->
  			<div class="tab-pane fade" id="custom-content-below-platforms" role="tabpanel" aria-labelledby="custom-content-below-platforms-tab">
     			
     			<br /> 
     			<form enctype="multipart/form-data">
	     			<div class="row">
	     				<div class="col-md-6">
	     					<input class="form-control" type="text" name="plat-ser" id="plat-ser" placeholder="Search Platform">
	     					<div class="ser-div" id="plat-load">
	     						
	     					</div>
	     				</div> 
	     				<!-- <div class="col-md-6">
	     					<button class="btn btn-primary">Submit</button>
	     				</div> -->
	     			</div>
		     	</form>
  			</div>
		</div>
	</div>
			</div>
		</div>

						<!-- Card Footer -->
						<div class="card-footer">
						  <a id="submit" class="btn btn-default">Submit</a>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>

	<script>
		$("#act-ser").keyup(function(){
			LoadCast($(this).val(), "list-actors", "#act-load");
		});
		$("#dirct-ser").keyup(function(){
			//LoadCast($(this).val(), "list-director", "#dirct-load");
		});
		$("#plat-ser").keyup(function(){
			//LoadCast($(this).val(), "list-platform", "#plat-load");
		});

		//Search Result List for Actor/Director/Platform.//
		function LoadCast(ser_key, action, retPos){
			if(ser_key == ""){
				return false;
			}
			var formData = { search: ser_key, action: action };
			$.ajax({
				url: "api.php",
				type: "POST",
				data: formData,
				dataType: "JSON",
				encryption: true,
				success: function(response){
							//alert(response.msg);
							$(retPos).html(response.dat);
					}
			});
		}
	</script>
	';
	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//Load actor list
else if($_POST['action'] == 'list-actors'){
	$data = array();
	//$data["msg"] = $_POST["search"];
	$key = $_POST["search"];
	$retHtml = '';
	record_set('getAct','SELECT id, name, actor_img FROM `actor_list` WHERE name LIKE "'.$key.'%" LIMIT 5');
	if($totalRows_getAct){
		while($rowData = mysqli_fetch_assoc($getAct)){ 

			$retHtml .= ' <style>
				.info-box:hover{ cursor: pointer;
					background-color:rgb(247, 247, 247);
				}
			</style>

			<ul class="list-group">
				<div class="info-box list-group-item">
	              <span class="info-box-icon bg-info">';
	              	if(file_exists($rowData["actor_img"])){
	              		$retHtml .= '<img height="70px" width="70px" src="'.$rowData["actor_img"].'">';
	              	}else{
	              		$retHtml .= '<i class="far fa-image"></i>';
	              	}
	              $retHtml .='</span>

	              <div class="info-box-content">
	                <span class="info-box-text " data-id="'.$rowData["id"].'" data-img="'.$rowData["actor_img"].'" data-name="'.$rowData["name"].'"><h3>'.$rowData["name"].'</h3></span>
	                <!--<span class="info-box-number">1,410</span>-->
	              </div>
	            </div>
			</ul>
			';
		}
	}
	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}
?>

