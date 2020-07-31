
<!-- Page Header -->
<div class="content-header">
	<div class="container-fluid">
	  <div class="row mb-2">
	    <div class="col-sm-6">
	      <h1 class="m-0 text-dark">Home</h1>
	    </div><!-- /.col -->
	    <div class="col-sm-6">
	      <!-- <ol class="breadcrumb float-sm-right">
	        <li class="breadcrumb-item"><a href="#">Home</a></li>
	        <li class="breadcrumb-item active">Dashboard v1</li>
	      </ol> -->
	    </div>
	  </div>
	</div>
</div>


<section class="content">
	<div class="container-fluid">
		<div class="row">
			<?php /*
			<div class="col-md-6">
				<div class="card card-default">
					
					<!-- Card Header -->
					<!-- <div class="card-header">
						<h3 class="card-title">Productions</h3>
					</div> -->

					<!--Card Body-->
					<div class="card-body">
						<!-- SEARCH FORM -->
					    <form role="form">
			                <div class="form-group">
			                    <div class="input-group">
			                    	<input type="text" class="form-control" id="" placeholder="Search..">
			                    	
			                    	<div class="input-group-append">
				                    	<button type="submit" class="btn btn-default">
				                    		<i class="fas fa-search"></i>
				                    	</button>
			                    	</div>
			                    </div>
			                 </div>
			            </form>

			            <div class="load-result">
			            	
			            </div>
					</div>

					<!-- Card Footer -->
					<!-- <div class="card-footer"> </div> -->

				</div>
			</div> */?>
			<div class="col-md-12">
				<div class="card card-default">
					<div class="card-body">
						<!-- <h4>coming soon..</h4> -->
						<div>
							<h4>TypeScript</h4>
							<p>A powerfull extention to javascript. Follow the link to know more.</p>
							<p><a href="https://www.typescriptlang.org/docs/home.html" target="blank">View Documentation</a></p>
						</div>
						

						<p>Video Tutorial: <a href="https://www.youtube.com/watch?v=BwuLxPH8IDs" target="blank">https://www.youtube.com/watch?v=BwuLxPH8IDs</a></p>
					</div>
				</div>
			</div>

			<div class="col-md-12">
				<div class="card card-default">
					<div class="card-body">
						<!-- <h4>coming soon..</h4> -->
						<div>
							<h4>The Date Problem in PHP</h4>
							<p>Be aware of dates in the <b>m/d/y</b> or <b>d-m-y</b> formats; if the separator is a slash (/), then the American m/d/y is assumed. If the separator is a dash (-) or a dot (.), then the European d-m-y format is assumed.</p>
						</div>
						<div>
							<h4>Solution</h4>
							<b>Replace '/' with '-'</b>
							<pre style="background-color: grey; color:white;"><code>$var = '20/04/2012';
$date = str_replace('/', '-', $var);
echo date('Y-m-d', strtotime($date));</code></pre>
						</div>
						
						<p>Click for more Info: <a href="https://stackoverflow.com/questions/10306999/php-convert-date-format-dd-mm-yyyy-yyyy-mm-dd" target="blank">https://stackoverflow.com/questions/10306999/php-convert-date-format-dd-mm-yyyy-yyyy-mm-dd</a></p>
					</div>
				</div>
			</div>

			<div class="col-md-12">
				<div class="card card-default">
					<div class="card-body">
						<!-- <h4>coming soon..</h4> -->
						<div>
							<h4>UI Design</h4>
							<p>The “UI” in UI design stands for “user interface.” The user interface is the graphical layout of an application. It consists of the buttons users click on, the text they read, the images, sliders, text entry fields, and all the rest of the items the user interacts with. This includes screen layout, transitions, interface animations and every single micro-interaction. Any sort of visual element, interaction, or animation must all be designed.</p>
						</div>
						<div>
							<h4>UX Design</h4>
							<p>“UX” stands for “user experience.” A user’s experience of the app is determined by how they interact with it. Is the experience smooth and intuitive or clunky and confusing? Does navigating the app feel logical or does it feel arbitrary? Does interacting with the app give people the sense that they’re efficiently accomplishing the tasks they set out to achieve or does it feel like a struggle? User experience is determined by how easy or difficult it is to interact with the user interface elements that the UI designers have created.</p>
						</div>

						<p>Click for more Info: <a href="https://uxplanet.org/what-is-ui-vs-ux-design-and-the-difference-d9113f6612de" target="blank">https://uxplanet.org/what-is-ui-vs-ux-design-and-the-difference-d9113f6612de</a></p>
					</div>
				</div>
			</div>

			<div class="col-md-12">
				<div class="card card-default">
					<div class="card-body">
						<!-- <h4>coming soon..</h4> -->
						<div>
							<h4>PHP Pagination</h4>
							<p><b>NumRec</b> = No. of Reocrds <br/>
							   <b>RPP</b> = Records per page  <br/>
							<b>Total Pages</b> = <b>NumRec</b>/<b>RPP</b> <br/>
							<b>Start Point</b> = <b>(PageNo * RRP) - RPP</b> If PageNo > 1 else <b>Start Point = 0</b>;
							<br/>
							e.g: <b>SELECT id FROM `table` LIMIT Start, RRP;</b>
							</p>
						</div>
						

						<p>Click for video demo: <a href="https://www.youtube.com/watch?v=35imHB54djM" target="blank">https://www.youtube.com/watch?v=35imHB54djM</a></p>
					</div>
				</div>
			</div>

			

		</div>
	</div>
</section>