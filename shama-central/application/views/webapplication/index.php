<!-- Container --> 
<div ng-controller="index_ctrl">
	<div class="row mt-5" >
		<div class="col-sm text-left my-auto">

		</div>
		<div class="col-sm my-auto  mode-card">
			  <div class="loading" ng-hide="loading == false">
                    Loading&#8230;
                </div>
                <!-- <img src="/invantage/wc/learninginvantage/v1updated/images/nrlogo.png" class="web_app_logo"> -->
                	  				 	 		<!-- <svg viewBox="0 0 500 175">
											    <path id="curve" d="M73.2,148.6c4-6.1,65.5-96.8,178.6-95.6c111.3,1.2,170.8,90.3,175.1,97" />
											    <text width="500">
											      <textPath xlink:href="#curve">
											        WELCOME to NR SCHOOLS
											      </textPath>
											    </text>
											  </svg> -->
<h2 class="slogon_welcome"> Welcome to Shama Web </h2>
											  <ul class="slogon">

<!--											  	<li>Please select your grade, section, and time restricted mode</li>-->
<!--											  	<li>If there is no schedule then please select the timetabl-free mode</li>-->
<!--											  	<li>Central tracking of each student’s progress and grades-->
<!--</li>-->
											  </ul>
			<div class="card" style="margin: 0 auto;">

		 	 	<div class="card-body">


			  	<form name="classform" ng-submit="getclassform(classobj)">

				  	<div class="form-group">
				    	<label for="exampleInputEmail1" class="col-form-label float-left">Select grade</label>
				    	  <select class="form-control" id="class" ng-model="classobj.class" ng-options="item.grade for item in classlist track by item.id">
					    </select>
				  	</div>
				  	<div class="form-group" ng-hide="type == 'g'">
				    	<label for="exampleInputEmail1" class="col-form-label float-left">Select section</label>
				    	  <select class="form-control" id="class" ng-model="classobj.section"  ng-options="item.section_name for item in sectionlist track by item.id">
					    </select>
				  	</div>
				  	<div class="form-group" ng-hide="type == 'g'">
				    	<label for="exampleInputEmail1" class="col-form-label float-left">Select mode</label>
				    	  <select class="form-control" id="class" ng-model="classobj.mode"  ng-options="item.title for item in modes track by item.id">
					    </select>
				  	</div>
			  	</form>
			
			  </div>

			</div>

		</div>
		<div class="mycartoon_style">
			
		</div>
		<div class="col-sm text-left my-auto my-design">
			<a ng-if="type == 't'" href="#!attendance/{{classobj.class.id}}/{{classobj.section.id}}/{{classobj.mode.id}}/{{classobj.class.grade}}/{{classobj.section.section_name}}"  class="btn btn-danger btn-circle btn-xl">
				<span class="icon-right-big icon-go " aria-hidden="true"></span>
			</a>
			<a ng-if="type == 'g'" href="#!subjects/{{classobj.class.id}}/{{classobj.class.grade}}"  class="btn btn-danger btn-circle btn-xl">
				<span class="icon-right-big icon-go " aria-hidden="true"></span>
			</a>
		</div>
	</div>
	<div class="showhim"> <a href="#!cartoon"><img src="/invantage/wc/learninginvantage/v1.2/images/cartoon1.gif" class="web_app_cartoon"> </a><div class="showme"><h1>Activity of the Day</h1></div></div>
	 
		
</div>
