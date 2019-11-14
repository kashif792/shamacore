<!-- Container --> 
<div ng-controller="lesson_ctrl">
    <div class="loading" ng-hide="loading == false">
        Loading&#8230;
    </div>
    <div class="modal fade" id="myModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
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
                <div class="modal-body modal-body-video-bg">
                    <div class="col-sm" ng-hide="lessonobj.currentlesson.type != 'Video'">
                        <div class="video-container" id="video-container"></div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm  my-auto  text-center">
            <div class="my-auto mode-card">
                <div class="card sahke-div d-inline-block m-2"  ng-repeat="l in nextlcassinfo" ng-class="{'lesson-shake': l.bliking == true}"  ng-if="l.type == 'Image' || l.type == 'Video' || l.type == 'Document' || l.type == 'Text'">
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
