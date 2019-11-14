<!-- Container --> 
<div ng-controller="lessons_ctrl">
    <div class="loading" ng-hide="loading == false">
        Loading&#8230;
    </div>
    <div class="dshbrdicon">
        <div class="lesson_grid container">
            <div class="col-sm text-left lesson_back">
                <span>
                    <a href="#!subjects"  class="btn btn-light btn-circle-info">
                      <span class="icon-reply" aria-hidden="true"></span>
                    </a>
                    <h5 class="d-inline">{{params.subjectname}} Lessons</h5>
                </span>
            </div>
            <div class="row">
                <div class="col-1 text-center my-auto" ng-hide="lessonlist.length == 0 ||  offset == 0 ">
                     <button ng-disabled="offset == 0"  class="btn btn-circle btn-xl lessons-ctrl-btn"  ng-click="previouslessons()">
                        Back<br>
                        <span class="icon-left-big" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="my-auto  text-center" ng-class="offset == 0 ? 'col-11' : 'col-10'">
                    <div class="my-auto mode-card">
                        <div class="card card__one sahke-div d-inline-block m-2"  ng-repeat="l in lessonlist" ng-class="{'lesson-shake': l.bliking == true}"  ng-if="l.type == 'Video' ; $index >= offset && $index <= current_page - 1">
                            <div class="card-body"  ng-if= "l.type == 'Video'">
                                <a href="#!lesson/{{l.id}}" >
                                    <div class="play-button">
                                        <img src="{{l.poster}}"  class="img-thumbnail rounded"/>
                                    </div>
                                    <div class="card-block">
                                        <h5 class="card-title text-center mt-2"  >{{l.name | limitTo:20}}</h5>
                                        <h6 class="card-title text-center mt-2"  >{{l.read_date | perioddate}}</h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <label ng-hide="lessonlist.length > 0" class="text-center">No lessons found</label>
                    </div>
                </div>
                <div class="col-1 text-center my-auto lesson-column" ng-hide="lessonlist.length == 0 || lessonlist.length <= current_page">
                    <button ng-disabled="lessonlist.length <= current_page" class="btn btn-circle btn-xl lessons-ctrl-btn"  ng-click="nextlessons()">
                        Next<br>
                        <span class="icon-right-big" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
