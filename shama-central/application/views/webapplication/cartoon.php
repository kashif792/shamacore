<div class="container-fluid text-center pt-3"  ng-controller="cartoon_ctrl">
    <div class="modal fade" id="myModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="d-inline modal-title" >
                        <span ng-if="lessonobj.currentlesson.name">{{selectedcartoon.title}}</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-sm">
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
                <div class="col-sm text-left title-row pt-3">
                    <span>
                        <a href="#!subjects"  class="btn btn-light btn-circle-info">
                          <span class="icon-reply" aria-hidden="true"></span>
                        </a>
                        <h5 class="d-inline">Cartoons</h5>
                    </span>
                </div>
            </div>
            <!-- Container --> 
            <div class="row pt-3" >
                 <div class="loading" ng-hide="loading == false">
                    Loading&#8230;
                </div>
                <!-- <div class="col-12 text-center  my-auto lesson-column lesson-list-container">
                    <div class="my-auto mode-card">
                        <div class="card card__one sahke-div d-inline-block m-2"  ng-repeat="l in todaycartoons">
                            <a href="javascript:void(0);" ng-click="playcartoon(l)">
                                <div class="play-button">
                                    <img src="{{l.poster}}" width="100%" style="border: 1px solid silver;" class="rounded"/>
                                </div>
                                <div class="card-body">
                                    <div class="card-block">
                                        <h5 class="card-title text-center mt-2"  >{{l.title | limitTo:25}}</h5>
                                        <h6 class="card-title text-center mt-2"  >{{l.view_date | perioddate}}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>
<link href="http://vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
<script src="http://vjs.zencdn.net/4.12/video.js"></script>
