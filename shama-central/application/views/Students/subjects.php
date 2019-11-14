<!-- Container --> 
<div ng-controller="subject_ctrl">
    <div class="loading" ng-hide="loading == false">
        Loading&#8230;
    </div>
    <div class="dshbrdicon">
        <div class="innericon container"> 
              <div class="col-sm text-left top_back">
                    <span>
                    <a href="#!/"  class="btn btn-light btn-circle-info">
                      <span class="icon-reply" aria-hidden="true"></span>
                    </a>
                    <h5 class="d-inline home"> Home</h5>
                  </span>
            </div>
            <div class="row">
                <div class="col-1 text-center my-auto" ng-hide="limit>=8">
                     <button ng-disabled="offset == 0"  class="btn btn-circle btn-xl lessons-ctrl-btn"  ng-click="previouslessons()">
                        Back<br>
                        <span class="icon-left-big" aria-hidden="true"></span>
                    </button>
                </div>

                <div class="col-10  my-auto  text-center" ng-class="limit >= 8 ? 'col-12':'col-10'">
                    <div class="card card__one sahke-div d-inline-block m-3" ng-repeat="s in subjects" ng-if=" $index >= offset && $index <= current_page - 1">
                        <div class="card-body">
                            <a href="#!lessons/{{s.subject_id}}/{{s.subject_name}}">
                                <img  class="img-thumbnail " src="{{s.subject_image}}" alt="Card image cap">
                                <div class="card-block text-center">
                                    <h4 class="card-title pt-3 text-center">{{s.subject_name}}</h4>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-1 text-center my-auto lesson-column" ng-hide="limit>=8">
                    <button ng-disabled="subjects.length <= current_page" class="btn btn-circle btn-xl lessons-ctrl-btn"  ng-click="nextlessons()">
                        Next<br>
                        <span class="icon-right-big" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

