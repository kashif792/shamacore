<!-- Container --> 

<div class="dash dashboard" ng-controller="index_ctrl" >
       
    <div class="dshbrdicon">
        <div class="index_icon container">
            <div class="row style_left">
                <div class="col-sm box1 text-right">
                    <div class="row">
                        <div class="col-sm ">
                            <a href="#!subjects">
                                <img src="./images/learn3.png" class="img-fluid first top_learn">
                                <img src="./images/new_learn.png" class="img-fluid second botom_learn">
                                   <h3 class="card-title text-white first new_learn cmn_hdg">Learn</h3>
                                   <h4 class="card-title text-white cls second new_slearn cmn_hdg">Learn</h4>
                            </a>
                        </div>
                        <div class="col-sm my-auto text-left">
                           <!--  <img src="/shamacentral/v1.1/images/video-icon.png" class="img-fluid text-left">
                            <h3 class="card-title text-white text-left">Learn</h3> -->
                            <main class="lesson-notifications">
                                <div class="row lsnstatus">
                                    <div class="col-sm">
                                        <div class="row lesson_bar r-{{$index}}" ng-repeat="(key, value) in studentsubjectstatus">
                                        <div class="col-2 col-sm-3 img-rounded imag_thumb" style="background: url({{value.subject_image}}) no-repeat; min-height: 2rem;background-position: right;"></div>
                                            <div class="col-10 col-sm-9 text-left my-auto">
                                                <h6>
                                                    <a href="#!lesson/{{value.id}}/t">
                                                    {{value.current_lesson | limitTo:10}} of {{value.total_lessons | limitTo:10}} lessons 
                                                    </a>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </main>
                        </div>
                    </div>
                </div>
                <div class="col-sm box1">
                    <div class="row">
                        <div class="col-sm text-left">
                            <img src="./images/noteebook.png" class="img-fluid pt-4 first">
                            <img src="./images/new_noteebook.png" class="img-fluid pt-4 second">
                            <h3 class="card-title text-white first cmn_hdg">Notebook</h3>
                            <h4 class="card-title text-white cls second new_snotebook cmn_hdg">Notebook</h4>
                        </div>
                   </div>
                </div>
            </div>
            <div class="row style_left">
                <div class="col-sm box2  ">
                    <a href="#!activities">
                        <div class="row">
                            <div class="col-sm text-right">
                                <img src="./images/funzone.png" class="img-fluid first top_funzone">
                                <img src="./images/new_funzone.png" class="img-fluid second bottom_fumzone">
                                <h3 class="card-title text-white first top_funzone cmn_hdg">Fun Zone</h3>
                                <h4 class="card-title text-white second cls new_fun bottom_fumzone new_sfunzone cmn_hdg">Fun Zone</h4>
                            </div>
                             <div class="col-sm my-auto text-left">
                               
                                
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm box2">
                    <div class="row">
                        <div class="col-sm text-left">
                            <img src="./images/task4.png" class="img-fluid first">
                            <img src="./images/new_task.png" class="img-fluid second">
                            <h3 class="card-title text-white first new_task cmn_hdg">Tasks</h3>
                            <h4 class="card-title text-white cls second new_stask cmn_hdg">Tasks</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </div>
</div>
