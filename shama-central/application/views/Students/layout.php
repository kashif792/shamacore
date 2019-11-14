<!DOCTYPE html>
<html lang="en" ng-app="invantage">
<head>
    <title>Student Portal</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="<?php echo base_url();?>css/bootstrap_4.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url();?>css/student_portal.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/fontello.css">
    <link href="<?php echo base_url(); ?>css/ng-tags-input.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/tags.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/ng-tags-input.bootstrap.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>js/angular-1.6.4.min.js"></script>
    <script src="<?php echo base_url(); ?>js/angular-animate.1.6.4.min.js"></script>
    <script src="<?php echo base_url(); ?>js/angular-route.js"></script>
    <script src="<?php echo base_url(); ?>js/angular-cookies.js"></script>
    <script src="<?php echo base_url(); ?>js/ngStorage.min.js"></script>
    
    
</head>
<body ng-init="loading=false">
    <!-- <div class="loading" ng-hide="loading == true">
        Loading&#8230;
    </div> -->
    <div class="theSun"></div>
  <div class="cloud c1"></div>
  <div class="cloud c2"></div>

    <div class="container-fluid text-center  pt-3  attendance"> 
        <div class="brds"></div>  ​

        <div class="row content">
            <div class="col-sm">
                <!-- Upper row-->
                <div class="row clearfix">
                    <div class="col-sm">
                        <div class="profile-container" ng-controller="footer_ctrl">
                            <div class="upper-bar-left"></div>
                            <div class="bottom-bar-left"></div>
                            <div class="upper-bar-right"></div>
                            <div class="bottom-bar-right"></div>
                            <div class="upper-bar"></div>

                            <div class="studentimage-container-upper-layer" >

                               <!--  <a  href="javascript:void(0)" onclick="showDiv()" > -->
                                    <div class="student-image" onclick="showDiv()" style="background: url({{sessionobj.studentinfo.image}}) no-repeat; background-size: cover;"></div>
                                    <div class="student-name pt-1">{{sessionobj.studentinfo.name}}</div>
                                    <div class="student-name pt-1"></div>
                               <!--  </a> -->
                                <div class="student_profile_new" id="student_info" style="display:none;" >
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <p class="profile_head">Student Profile </p>
                                        </div>
                                        <div class="col-sm-3">
                                            <button class="prof-close_std" type="button" id="hide_div" ng-click="clos_std_profile">&times;</button>
                                        </div>
                                    </div>
                                    
                              <!--       <h4>
                                        {{sessionobj.studentinfo.name}}
                                    </h4> -->
                                    <!-- <p>{{sessionobj.studentinfo.class}}</p>
                                    <div>
                                    <a href="javascript:void(0)" class="text-white" ng-controller="footer_ctrl" ng-click="logout()">Logout</a>
                 -->                <!-- </div> -->
                            <div class="row info">
                                <div class="col-sm">
                                    <ul class="std_info_list text-left">
                                        <li>
                                            Class:  {{sessionobj.studentinfo.class}}
                                        </li>
                                        <li>
                                            Father Name:  {{sessionobj.studentinfo.name}}
                                        </li>
                                        <li>
                                            Location:  Lahore (Ittefaq Town)
                                        </li>
                                    </ul>
                                </div>
                            </div>
                             <div class="navbar-footer">
                                <div class="navbar-footer-content">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="<?php echo base_url() ; ?>profile#settings2" class="btn btn-default btn-sm">Change Password</a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="javascript:void(0)" class="text-blue btn btn-default btn-sm" ng-controller="footer_ctrl" ng-click="logout()" >Logout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                </div>

                                <script type="text/ng-template" id="myPopoverTemplate.html" class="new_lgt">
                                <div>
                                    
                                </div>
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm h-100"  ng-controller="message_ctrl as mess_ctrl" ng-hide="mess_ctrl.mess_ctrl.hide_chat_container = false">
                        <div class="chat_box">
                            <!-- recent messages -->
                            <div class="recent-messages" ng-hide="mess_ctrl.chatmode != 'recent'">
                                <div class="row recent p-2" >
                                    <div class="col-sm-6 text-left">
                                        <p class="text-left" style="font-size: 13px;"> Recent Messages </p>  
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <a href="javascript:void(0)" ng-click="mess_ctrl.newmessage()" class=""><p>New Message </p></a> 
                                    </div>
                                </div>
                                <!-- recent messages -->
                                <div class="row"  style="max-height: 22.8rem;overflow: auto; margin: 0px;">
                                    <div class="col-sm p-0">
                                        <div class="row recent_message_box chat_box_row" ng-repeat="(key, value) in mess_ctrl.recentmessages" id="recentmessages" >
                                            <div class="col-sm text-primary p-1">
                                                <div class="row chat_box_row subject-row">
                                                    <div class="col-2 img-rounded" style="background: url(http://192.168.1.2/invantage/wc/learninginvantage/v1.2/upload/profile/hussain_ali.png) no-repeat; min-height: 1rem;background-position: center center;border-radius: 50%; border: 1px solid silver;background-size: cover; width: 40px; height: 40px;"></div>
                                                    <div class="col-7  my-auto"> 
                                                         <a href="javascript:void(0);" ng-click="mess_ctrl.viewdetail(value)">
                                                        <div class="row-fluid recent_message">
                                                            <h6 class="text-left " style="font-weight: bold; font-size: 10px">{{value.name}}</h6>
                                                            <h6 class="text-left">{{value.messagelist[0].message}}</h6>
                                                          <!--   <h6 class="text-left recent_date">{{value.date}}</h6> -->
                                                        </div>
                                                        </a>
                                                    </div>
                                                     <div class="col-3 my-auto">
                                                        <h6 class="text-left recent_date">{{value.date}}</h6>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                        <div class="text-center my-auto bg-white" ng-hide="mess_ctrl.recentmessages.length == 0">No messages</div>
                                    </div>
                                </div>
                            </div>
                            <!-- recent messages -->
                            <!-- convesation detail -->
                            <div class="conversation" ng-hide="mess_ctrl.chatmode != 'convesation'">
                                <div class="row m-0 ">
                                    <div class="col-12">
                                         <div class="row close_window" > 
                                             <div class="col-sm text-left"> 
                                             <a href="javascript:void(0);" ng-click="mess_ctrl.singe_chat()"> <i class="fa fa-arrow-alt-circle-left back_message" aria-hidden="true"></i> </a> 
                                                <div class="col-5 img-sircle profile_message_photo" style="background: url(http://192.168.1.2/invantage/wc/learninginvantage/v1.2/upload/profile/hussain_ali.png) no-repeat; min-height: 1rem;background-position: center; border-radius: 50%; border: 1px solid; bottom: 10px; background-size: cover;height: 40px;width: 40px; ">
                                                    <h6 class="text-left sender_profile " style="font-weight: bold; font-size: 10px">Usman</h6>
                                                    <p class="sender_profile"> Online </p>
                                                </div>
                                            </div>
                                            <div class="col-sm text-right">  
                                                <button class="prof-close" type="button" ng-click="mess_ctrl.hide_chat()">&times;</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row chat_box_row user_icon_show">
                                            <div class="col-sm text-primary p-1">
                                                    <div class="col-1  text-left "> 
                                                    </div>
                                                     <div class="col-1 user_msg text-left "> 
                                                        <i class="fa fa-smile smiley_icon" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="col-1  text-left user_msg "> 
                                                        <i class="fa fa-video video_icon" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="col-1  text-left user_msg "> 
                                                        <i class="fa fa-camera camera_icon" aria-hidden="true"></i>
                                                    </div>
                                                    <!-- <div class="row chat_box_row button_text"> -->
                                                     <div class="col-6 user_msg"> 
                                                        <input type="text" placeholder="Aa" id="input_text" name="input_text" ng-model="messageobj.text">
                                                    </div> 
                                                    <div class="col-1 text-center send_icon user_msg"> 
                                                        <a href="javascript:void(0)" ng-click="mess_ctrl.sendtext(mess_ctrl.messageobj)">
                                                            <i class="fa fa-arrow-alt-circle-right" aria-hidden="true"></i>    
                                                        </a>
                                                    </div> 
                                                <!-- </div> -->
                                               <!--  <div class="row input_text chat_box_row">  
                                                    <div class="col-12 my-auto"> </div> 
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- convesation detail -->
                            <!-- new message detail -->
                            <div class="group-chat" ng-hide="mess_ctrl.chatmode != 'group'">
                                <div class="row m-0">
                                    <div class="col-12 " style="background-color: #fff;">
                                        <div class="row close_group_window p-2" > 
                                             <div class="col-sm-6 text-left">
                                                <h6 class="text-left" style="line-height: 23px;">New Message</h6>
                                            </div>
                                            <div class="col-sm-6 text-right">  
                                                <button class="prof-close-group" type="button" ng-click="mess_ctrl.singe_chat()">&times;</button>
                                            </div>
                                        </div>
                                        <div class="row  to-many-friend-row"  id="">
                                            <div class="col-sm text-left text-primary p-1">
                                                <div class="row">
                                                    <div class="col-2 text-center my-auto">
                                                         <h6 class="d-inline">To</h6>
                                                    </div>
                                                    <div class="col-10">
                                                        <tags-input ng-model="mess_ctrl.messageobj.friends" 
                                                            display-property="name" 
                                                            placeholder="Add a friend" 
                                                            replace-spaces-with-dashes="false"
                                                            template="friend-template"
                                                            min-tags="1"
                                                            max-tags="1"
                                                            class="d-inline">
                                                            <auto-complete source="mess_ctrl.loadFriends($query)"
                                                                 min-length="0"
                                                                 load-on-focus="true"
                                                                 load-on-empty="true"
                                                                 max-results-to-show="32"
                                                                 template="autocomplete-template"></auto-complete>
                                                        </tags-input>
                                                        <script type="text/ng-template" id="friend-template">
                                                            <div class="tag-template">
                                                                <div class="left-panel">
                                                                    <img ng-src="{{data.image}}"/>
                                                                </div>
                                                                <div class="right-panel">
                                                                    <span>({{data.fname}})</span>
                                                                    <a class="remove-button" ng-click="$removeTag()">&#10006;</a>
                                                                </div>
                                                            </div>
                                                        </script>
                                                    
                                                        <script type="text/ng-template" id="autocomplete-template">
                                                            <div class="autocomplete-template">
                                                                <div class="left-panel">
                                                                    <img ng-src="{{data.image}}" />
                                                                </div>
                                                                <div class="right-panel">
                                                                    <span>({{data.name}})</span>
                                                                </div>
                                                            </div>
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12" style="min-height: 16rem;max-height: 16rem;overflow: auto; background-color: #fff;">
                                         <div class="row chat_box_row subject-row" ng-repeat="(key, value) in mess_ctrl.conversation" id="single_user_detail" ng-hide="mess_ctrl.recentmessagemode">
                                            <div class="col-sm text-primary p-1">
                                                <div class="row chat_box_row" ng-hide="value.user_id == mess_ctrl.sessionobj.studentinfo.id && value.message != null">
                                                    <div class="col-12 text-left  my-auto"> 
                                                        <div class="col-2 img-rounded" style="background: url(http://192.168.1.2/invantage/wc/learninginvantage/v1.2/upload/profile/hussain_ali.png) no-repeat; min-height: 3rem;background-position: center;height: 40px;width: 40px;border-radius: 50%;background-size: cover;"></div>
                                                        <div class="row-fluid">
                                                            <h6 class="sender_name2">Usman</h6>
                                                            <h6 class="recevier_message2">{{value.message}}</h6>
                                                        </div>
                                                    </div>
                                                </div>                                    
                                                <div class="row chat_box_row" ng-hide="value.user_id != mess_ctrl.sessionobj.studentinfo.id && value.message != null">
                                                    <div class="col-12 text-right my-auto">
                                                        <p class="sender_date">8:58pm</p>
                                                        <h6 class="sender_message">{{value.message}}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-sm text-primary p-1 bg-light">
                                                 <a href="javascript:void(0)" ng-click="mess_ctrl.sendtext(mess_ctrl.messageobj)">
                                                    <div class="send-icon"> 
                                                        <i class="fa fa-arrow-alt-circle-right" aria-hidden="true"></i>
                                                    </div>   
                                                </a>
                                                <a href="#">
                                                    <div class="simely-icon"> 
                                                        <i class="fa fa-smile" aria-hidden="true"></i>
                                                    </div>   
                                                </a>
                                                <a href="#">
                                                    <div class="video-icon"> 
                                                        <i class="fa fa-video" aria-hidden="true"></i>
                                                    </div>   
                                                </a>
                                                <a href="#">
                                                    <div class="camera-icon"> 
                                                        <i class="fa fa-camera" aria-hidden="true"></i>
                                                    </div>   
                                                </a>
                                                <div class="chat-text-box chat-text-box-center text-left" ng-model="mess_ctrl.messageobj.text"  contenteditable="true" ng-keypress="mess_ctrl.checkIfEnterKeyWasPressed($event)"  spellcheck="true"  role="textbox" aria-multiline="false" data-placeholder="" medium-focused="true" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                        </div>
                        <div class="chat-notification-container" >
                            <div class="chat-upper-bar-left"></div>
                            <div class="chat-bottom-bar-left"></div>
                            <div class="chat-upper-bar-right"></div>
                            <div class="chat-bottom-bar-right"></div>
                            <div class="upper-bar"></div>
                             <div class="chat-container-upper-layer" ng-hide="mess_ctrl.hide_chat_container">
                                <a href="javascript:void(0)" ng-click="hide_chat()">
                                    <div class="student-image" style="background: url(./images/chat.png) no-repeat;height: 8rem;     background-size: contain; background-position: center center;"></div>
                                </a>
                            </div> 
                            <a href="javascript:void(0)" ng-clik="show_recent_message()">
                            <div class="bubble_message">
                                <p>6</p>   
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
                <img src="/invantage/wc/learninginvantage/v1.2/images/bg.png" class="bg-image img-fluid ">
                <img src="/invantage/wc/learninginvantage/v1updated/images/nrlogo.png" class="web_app_std_logo img-fluid">
                <!-- <div class="container"> -->
                    <div class="row">
                        <div class="col-sm content-wrapper" >
                            
                            <div class="content-container  col-sm">
                                <div ng-view></div>
                            </div>
                        </div>
                    </div>
                <!-- </div> -->
            </div>
        </div>
    </div>

<script src="<?php echo base_url(); ?>js/video.js"></script>
<script src="<?php echo base_url(); ?>js/student_portal.js"></script>
<script src="<?php echo base_url(); ?>js/angular-sanitize.min.js"></script>
<script src="<?php echo base_url(); ?>js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap_4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/moment-timezone.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jwplayer.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ui-bootstrap-tpls-3.0.3.min.js"></script>
<script>jwplayer.key="/JmQcOJTGP/OIWIzj4RXqX/gpB1mVD9Br1vyxg==";</script>
<script src="<?php echo base_url();?>js/ng-tags-input.js"></script>


</body>
</html>

