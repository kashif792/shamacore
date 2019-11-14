<!-- Container --> 
<div ng-controller="activites_ctrl" ng-init="loading=true">

    <div class="loading" ng-hide="loading == false">
        Loading&#8230;
    </div>
    <div class="modal fade" id="myModal">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header" ng-hide="breakoff">

                    <h5 class="d-inline modal-title" >

                       <span ng-if="activitesobj.title">{{activitesobj.title}}</span>

                        <span ng-if="!activitesobj.title">No title provided</span>

                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-1 text-center my-auto" ng-hide="currentactivityindex == 0 ">

                             <button  class="btn btn-circle btn-xl lessons-ctrl-btn"  ng-click="previousactivity()">

                                Back<br>

                                <span class="icon-left-big" aria-hidden="true"></span>

                            </button>

                        </div>

                        <div class="my-auto  text-center" ng-class="currentactivityindex == 0 ? 'col-12' : 'col-11'">

                            <div class="video-container" id="video-container" ng-hide="true" ng-hide="currentactivity.type != 'v'"></div>

                            <div ng-hide="currentactivity.type != 'g'" ng-include="currentactivity.link"></div>

                            <div ng-hide="currentactivity.type != 'i'">

                                <img src="{{currentactivity.link}}" alt="currentactivity.file_name">

                            </div>

                        </div> 

                        <div class="col-1 text-center my-auto lesson-column" ng-hide="(playlist.length -1) == currentactivityindex">

                            <button class="btn btn-circle btn-xl lessons-ctrl-btn"  ng-click="nextlactivity()">

                                Next<br>

                                <span class="icon-right-big" aria-hidden="true"></span>

                            </button>

                        </div>

                    </div>

                </div>

                <div class="modal-footer hide">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>

            </div>

        </div>

    </div>

</div>

