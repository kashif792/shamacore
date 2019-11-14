<div class="container-fluid text-center pt-3  attendance"  ng-controller="attendance_ctrl">  
	<div id="overlay"></div>  
  	<div class="row">
    	<div class="col-sm">
			<div class="row">
			    <div class="col-sm text-left title-row">
			      <span>
			        <a href="#!{{backbutton}}"  class="btn btn-light btn-circle-info">
			          <span class="icon-reply" aria-hidden="true"></span>
			        </a>
			        <h3 class="d-inline">Attendance - {{classname}} ({{sectionname}})</h3>
			      </span>
			    </div>
			</div>
			
			<!-- Container --> 
			<div class="row pt-5" >
				<div class="loading" ng-hide="loading == false">
            Loading&#8230;
        </div>
				<div class="col-sm-2 text-center my-auto"></div>
				<div class="col-sm-8 student-list-container">
					<div class="row student-row" ng-repeat="s in students" ng-if="s" ng-switch on="$index % 2" ng-if="$index >= offset && $index <= limit">
						<div class="col-sm-5 m-2 student-item "  ng-switch-when="0">
							<label checkbox="s.studentpresent">
								 <div ng-if="s.profile_link" style="background: url({{s.profile_link}}) no-repeat; float: left; height: 50px;width: 50px;background-size: cover;border-radius: 50%;display: inline-block;" class="student-item-image">
								 </div>
								 <div ng-if="!s.profile_link" style="background: url(images/img_avatar.png) no-repeat; float: left; height: 50px;width: 50px;background-size: cover;border-radius: 50%;display: inline-block;" class="student-item-image">
								 </div>
									
								<div class="student-detail">
									<h5 class="d-inline text-right student-item-name mr-5">{{s.student_name}}</h5>
									<input type="checkbox" name="inputstudent" ng-change="checkstudents()" ng-model="s.studentpresent">
								</div>
							</label>
							
						</div>
						<div class="col-sm-5 m-2 student-item"   ng-if="students[$index+1]" ng-switch-when="0">
							<span ng-show="students[$index+1]">
								<label checkbox="students[$index+1].studentpresent">
									 <div ng-if="students[$index+1].profile_link" style="background: url({{students[$index+1].profile_link}}) no-repeat; float: left; height: 50px;width: 50px;background-size: cover;border-radius: 50%;display: inline-block;" class="student-item-image">
								 </div>
								 <div ng-if="!students[$index+1].profile_link" style="background: url(images/img_avatar.png) no-repeat; float: left; height: 50px;width: 50px;background-size: cover;border-radius: 50%;display: inline-block;" class="student-item-image">
								 </div>

								<div class="student-detail">
									<h5 class="d-inline text-right student-item-name mr-5">{{students[$index+1].student_name}}</h5>
									<input type="checkbox" name="inputstudent" ng-change="checkstudents()" ng-model="students[$index+1].studentpresent">
								</div>
								</label>
							</span>
						</div>
					</div>
					<div class="row text-white text-center" ng-if="!students">
						<h1 style="margin: 0 auto;"> <span class="icon-attention text-warning" aria-hidden="true"></span> No student found</h1>
					</div>
					
				</div>
				<div class="col-sm-2 text-center my-auto">
					<!-- <button class="btn btn-circle btn-xl" ng-disabled="offset >= studentlist.length" ng-click="next()">
						<span class="icon-right-big" aria-hidden="true"></span>
					</button> -->
					<!-- <button ng-if="mode == 2"  class="btn btn-circle btn-xl"  ng-click="savestudent()">
						<span class="icon-right-big" aria-hidden="true"></span>
					</button> -->
					<button  ng-hide="studentlist.length == 0"  class="btn btn-circle btn-xl" ng-disabled="nextdisable" ng-click="savestudent()">
						<span class="icon-right-big" aria-hidden="true"></span>
					</button>
					<!-- <a ng-if="mode == 1"  href="#!lesson/{{classid}}/{{sectionid}}"  class="btn btn-danger btn-circle btn-xl">
						<span class="icon-right-big icon-go " aria-hidden="true"></span>
					</a> -->
				</div>
			</div>
    	</div>
  	</div>
</div>
