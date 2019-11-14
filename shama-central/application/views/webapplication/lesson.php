<!-- <?php  header("Access-Control-Allow-Origin: *"); ?>
 -->

<div class="container-fluid text-center pt-3 lessons"  ng-controller="lesson_ctrl as controller"> 
    <div class="modal fade" id="myModal">
      <div class="modal-dialog" role="document" style="height: 100%">
        <div class="modal-content" style="height: 90%">
          <div class="modal-header" ng-hide="breakoff">

            <a  ng-if="type == 'g' || mode == 2 ||  mode == 3" ng-click="changepage()" href="#!lessons/{{subjectarr.subjectid}}/{{subjectarr.subjectname}}" ng-if="mode == 1"  class="btn btn-primary btn-circle-info-popup">
                    <span class="icon-reply" aria-hidden="true"></span>
                </a>
             <h5 class="d-inline modal-title" >
                <span ng-if="lessonobj.currentlesson.name">{{lessonobj.currentlesson.name}}</span>
                <span ng-if="!lessonobj.currentlesson.name">No title provided</span>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body"  style="height: 70%">
            <!-- <div class="videocontainer" ng-hide="lessonobj.currentlesson.type != 'Game'"  style="height: 100%">
                <iframe src="{{ lessonobj.currentlesson.content }}"  frameborder="0" style="overflow:hidden;overflow-x:hidden;overflow-y:hidden;height:100%;width:100%;position:absolute;top:0px;left:0px;right:0px;bottom:0px" height="100%" width="100%"></iframe>
            </div> -->
            <div class="videocontainer" ng-hide="lessonobj.currentlesson.type != 'Image'">
                <img src="{{lessonobj.currentlesson.content}}" class="img-fluid">
            </div>
            <div class="videocontainer" ng-hide="lessonobj.currentlesson.type != 'Document'">
                <a href="{{lessonobj.currentlesson.content}}">
                    <span class="icon-doc-text-inv doc-lesson" aria-hidden="true"></span>
                </a>
            </div>
            <div class="col-sm" ng-hide="lessonobj.currentlesson.type != 'Video'">
                <div class="video-container" id="video-container"></div>
            </div>
          </div>
          <div class="modal-footer">
            
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  	<div class="row content">
    	<div class="col-sm ">
            <div class="row">
                <div class="col-sm text-left title-row pt-3" >
                   <!--  <a href="#!subjects" ng-if="mode == 2"  class="btn btn-light btn-circle-info">
                        <span class="icon-reply" aria-hidden="true"></span>
                    </a> -->
                    <a href="#!attendance/{{sessionobj.classinfo.classid}}/{{sessionobj.classinfo.sectionid}}/{{sessionobj.classinfo.mode}}/{{sessionobj.classinfo.classname}}/{{sessionobj.classinfo.sectionname}}" ng-if="mode == 1"  class="btn btn-light btn-circle-info">
                        <span class="icon-reply" aria-hidden="true"></span>
                    </a>
                    <a ng-if="type == 'g' || mode == 2 ||  mode == 3" href="#!lessons/{{subjectarr.subjectid}}/{{subjectarr.subjectname}}" ng-if="mode == 1"  class="btn btn-light btn-circle-info">
                        <span class="icon-reply" aria-hidden="true"></span>
                    </a>
                    <h3 class="d-inline" ng-hide="!breakoff">
                        <span ng-if="lessonobj.currentlesson.name">{{lessonobj.currentlesson.name}}</span>
                        <span ng-if="!lessonobj.currentlesson.name">No title provided</span>
                    </h3>
                    <!-- <button ng-click="showlessonlist()" ng-hide="sessionobj.classinfo.mode != 1" class="text-right float-right text-white d-inline-block view-lesson-button">
                        <h4>View Lessons</h4>
                    </button> -->
                </div>
            </div>
			<!-- Container --> 
			<div class="row" >
                <div class="loading" ng-hide="loading == false">
                    Loading&#8230;
                </div>
                <div ng-hide="true" class="col-sm-1 text-center my-auto">
                    <button ng-disabled="first_lesson == lessonobj.currentlesson.id" class="btn btn-circle btn-xl"  ng-click="previousstudentlesson()">
                        <span class="icon-left-big" aria-hidden="true"></span>
                    </button>
                </div>
				<div class="col-sm pt-3 text-center lesson-container">
                    <div class="row" >
                        <div class="col-sm">
                            <div class="videocontainer" ng-hide="breakoff">
                                <h3 class="no-class text-white text-center" ng-if="lesson_message">{{lesson_message}}</h3>
                            </div>
                            <div class="message" ng-if="message == null">{{message}}</div>
                            <div class="col-sm-10 text-center  my-auto lesson-column lesson-list-container text-center" style="margin: 0 auto;">
                                <div class="my-auto mode-card">
                                    <div class="card sahke-div d-inline-block m-2"  ng-repeat="l in nextlcassinfo" ng-class="{'lesson-shake': l.bliking == true}"  ng-if="l.type == 'Image' || l.type == 'Video' || l.type == 'Document' || l.type == 'Text'">
                                        <div class="card-body"  ng-if= "l.type == 'Image'">
                                            <a href="#!lesson/{{l.id}}"   >
                                                 <div class="play-button">
                                                    <img src="images/backimage.png" width="100%" class="rounded"/>
                                                     <div class="lesson-image d-inline"  style="background:url({{l.content}}) no-repeat;"></div>
                                                </div>
                                               
                                                <div class="card-block">
                                                    <h5 class="card-title text-center mt-2">{{l.name | limitTo:20}}</h5>
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
                                                    <h5 class="card-title text-center mt-2">{{l.name | limitTo:20}}</h5>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="card-body " ng-class="{'readed': l.lesson_readed == true,'disabled': l.disabled == true}" ng-if= "l.type == 'Video'">
                                            <button ng-click="startvideo(l)">
                                                <div class="play-button">
                                                    <img src="{{l.poster}}" width="100%" style="border: 1px solid silver;" class="rounded"/>
                                                </div>
                                                <div class="card-block">
                                                    <h5 class="card-title text-center mt-2">{{l.name | limitTo:20}}</h5>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div ng-hide="true" class="col-sm-1 text-center my-auto lesson-column">
                     <button ng-disabled="readstatus == lessonobj.currentlesson.id" class="btn btn-circle btn-xl"  ng-click="nextstudentlesson()">
                        <span class="icon-right-big" aria-hidden="true"></span>
                    </button>
                </div>
			</div>
    	</div>
  	</div>
</div>
