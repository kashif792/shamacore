<!-- Container --> 
<div ng-controller="subject_ctrl" class="subject">
    <div class="row">
        <div class="col-sm text-left title-row pt-3">
            <span>
                <a ng-if="type =='t'" href="#!attendance/{{classid}}/{{sectionid}}/{{mode}}/{{classname}}/{{sectionname}}"  class="btn btn-light btn-circle-info">
                    <span class="icon-reply" aria-hidden="true"></span>
                </a>
                 <a ng-if="type =='g'" href="#!"  class="btn btn-light btn-circle-info">
                    <span class="icon-reply" aria-hidden="true"></span>
                </a>
                <h5 class="d-inline">Timetable-free is enabled</h5>
            </span>
        </div>
    </div>
    <div class="row pt-5" >
        <div class="loading" ng-hide="loading == false">
            Loading&#8230;
        </div>
        <div class="col-sm  my-auto mode-card text-center">
            <div class="card card__one sahke-div d-inline-block m-3" ng-repeat="s in subjects">
                <div class="card-body">
                    <a href="#!lessons/{{s.subject_id}}/{{s.subject_name}}">
                        <img style="border: 1px solid silver;" class="card-img-top" src="{{s.subject_image}}" alt="Card image cap">
                        <div class="card-block text-center">
                            <h4 class="card-title pt-3 text-center">{{s.subject_name}}</h4>
                        </div>
                    </a>
                </div>
            </div>
            <div ng-hide="subjects.length != 0"><h1 class="text-white">No subject found</h1></div>
        </div>
    </div>
</div>
