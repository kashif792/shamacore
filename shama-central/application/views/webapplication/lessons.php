
<div class="container-fluid text-center pt-3   lessons"  ng-controller="lessons_ctrl">
	<div class="row content">
    	<div class="col-sm ">
    		<div class="row">
			    <div class="col-sm text-left title-row pt-3">
			      <span>
			        <a href="#!subjects"  class="btn btn-light btn-circle-info">
			          <span class="icon-reply" aria-hidden="true"></span>
			        </a>
			        <h5 class="d-inline">{{params.subjectname}} Lessons</h5>
			      </span>
			    </div>
			</div>
			<!-- Container --> 
			<div class="row pt-3" >
                 <div class="loading" ng-hide="loading == false">
                    Loading&#8230;
                </div>
				<div class="col-1 text-center my-auto">
					 <button ng-disabled="offset == 0"  class="btn btn-circle btn-xl lessons-ctrl-btn"  ng-click="previouslessons()">
                        Back Lessons<br>
                        <span class="icon-left-big" aria-hidden="true"></span>
                    </button>
				</div>
				<div class="col-10 text-center  my-auto lesson-column lesson-list-container">
					<div class="my-auto mode-card">
      					<div class="card card__one sahke-div d-inline-block m-2"  ng-repeat="l in lessonlist" ng-class="{'lesson-shake': l.bliking == true}"  ng-if="l.type == 'Image' || l.type == 'Video' || l.type == 'Document' || l.type == 'Text' ; $index >= offset && $index <= current_page - 1">
                            <div class="card-body"  ng-class="{'readed': l.lesson_readed == true,'disabled': l.disabled == true}" ng-if= "l.type == 'Image'">
                                <a href="#!lesson/{{l.id}}"   >
                                     <div class="play-button">
                                        <img src="images/backimage.png" width="100%" class="rounded"/>
                                         <div class="lesson-image d-inline"  style="background:url({{l.content}}) no-repeat;"></div>
                                    </div>
                                   
                                    <div class="card-block">
                                        <h5 class="card-title text-center mt-2">{{l.name | limitTo:25}}</h5>
                                    </div>
                                </a>
                            </div>
        					<div class="card-body" ng-class="{'readed': l.lesson_readed == true,'disabled': l.disabled == true}" ng-if= "l.type == 'Document' || l.type=='Text'">
                                <a href="{{l.content}}" target="_blank" >
                                    <div class="play-button">
                                        <img src="images/backimage.png" width="100%" class="rounded"/>
                                        <span class="icon-doc-text-inv" aria-hidden="true"></span>
                                    </div>
                                    
                                    <div class="card-block">
                                        <h5 class="card-title text-center mt-2">{{l.name | limitTo:25}}</h5>
                                    </div>
                                </a>
        					</div>

        					<div class="card-body" ng-class="{'readed': l.lesson_readed == true,'disabled': l.disabled == true}" ng-if= "l.type == 'Video'">
                                <a href="#!lesson/{{l.id}}" >
                                    <div class="play-button">
                                        <img src="{{l.poster}}" width="100%" style="border: 1px solid silver;" class="rounded"/>
                                    </div>
                                    <div class="card-block">
                                        <h5 class="card-title text-center mt-2"  >{{l.notes | limitTo:25}}</h5>
                                        <h6 class="card-title text-center mt-2"  >{{l.read_date | perioddate}}</h6>
                                    </div>
                                </a>
        					</div>

                            <div class="card-body" ng-class="{'readed': l.lesson_readed == true,'disabled': l.disabled == true}" ng-if= "l.type == 'Game'">
                                <a data-type="Game" href="{{l.content}}" >
                                    <div class="play-button">
                                        <img src="{{l.poster}}" width="100%" style="border: 1px solid silver;" class="rounded"/>
                                    </div>
                                    <div class="card-block">
                                        <h5 class="card-title text-center mt-2"  >{{l.notes | limitTo:25}}</h5>
                                        <h6 class="card-title text-center mt-2"  >{{l.read_date | perioddate}}</h6>
                                    </div>
                                </a>
                            </div>
      					</div>
    				</div>


                    <div ng-if="lessonlist.length == 0">
                        <h1 class="text-white"> <span class="icon-attention text-warning " aria-hidden="true"></span> No lesson found</h1>
                    </div>
				</div>

				<div class="col-1 text-center my-auto lesson-column">
					<button ng-disabled="lessonlist.length <= current_page" class="btn btn-circle btn-xl lessons-ctrl-btn"  ng-click="nextlessons()">
                        Next Lessons<br>
                        <span class="icon-right-big" aria-hidden="true"></span>
                    </button>
				</div>
			</div>
    	</div>
  	</div>
</div>
<link href="http://vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
<script src="http://vjs.zencdn.net/4.12/video.js"></script>
