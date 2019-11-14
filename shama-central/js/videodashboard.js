/*
 * ---------------------------------------------------------
 *   Init values
 * ---------------------------------------------------------
 */
var videoCamlist = [];
var departmentlist = '';

var defaultcamlist = '';
var screenid = '';
var source ;
var camlist = '';
var formitem ;
var inputdepartmentname ;
var inputCameraList ;
var videoplayernum ;
var inputEventList ;
var videoPlaying = new Array() ;
var eventDates = '';
var eventLoader = '';
var videoLink = '';
var camdefaultlist = [];
var recordedeventslist = new Array();
var videoAddress = {
	videoIpAddress : '',
	alias:'',
	videotime:'&STIME=',
	startdate:'',
	starttime:'',
	enddate:'',
	endtime:''
}
var vevent = {
	startdate:'',
	enddate:''
};


$(document).ready(function(){
	
	var counter=1;
	var txt="";
	var cont_str = '';
	
	var videoData = jQuery('#videoFormFilter_0').serializeArray();
	
	var current_player = 1 ;
	
	/*
	 * ---------------------------------------------------------
	 *   Find length
	 * ---------------------------------------------------------
	 */
	function sourcesLenght(list){
		return list.length;
	}
	
	//getVideoCamList(videoData);
	function getVideoCamList(videoData)
	{
		urlpath = "api/getVideoSourceList/format/json";
        ajaxType = "GET";
        //ajaxfunc(urlpath,videoData,loadVideoCamReponseFailureHandler,loadVideoCamReponseHandler); 	

      
		urlpath = "api/getVideoScreenList/format/json";
        ajaxType = "GET";
        ajaxfunc(urlpath,'',loadScreenFailure,loadScreenSuccess); 	
	}

	function loadScreenFailure(){}
	function loadScreenSuccess(response){
		if(response != null)
		{
			screenid = response[0].id ;
			defaultcamlist = response[0].selected_cams ;
		}
	}
	
	function loadVideoCamReponseFailureHandler()
	{
		$("#"+inputCameraList).html('');
		camlist = "" ;
		var cont_str = "<tr><td colspan='5'>No record found</td></tr>";
		$("#"+inputCameraList).html(cont_str);
	}

	function loadVideoCamReponseHandler(response)
	{
		if(response != null)
		{
			camlist = response ;
		}
	}

	/*
	 * ---------------------------------------------------------
	 *   Set default cameras sources
	 * ---------------------------------------------------------
	 */
	//createVideoObj();
	
	/*
	 * ---------------------------------------------------------
	 *   Init values
	 * ---------------------------------------------------------
	 */
	function createVideoObj()
	{
		var listLenght = sourcesLenght(defaultcamlist) -1;
		
		for (var i = 0 ; i<= video_limit; i++) {
			try{
				if(defaultcamlist[i].dev_title.trim() != null){
					initVideoObj(defaultcamlist[i].output_url.trim(),defaultcamlist[i].dev_title.trim(),i);
				 	$("#cur_cam_"+i).text(defaultcamlist[i].dev_title.trim()+" / "+defaultcamlist[i].location);
					$(".vf_"+i+" span#option-text").text(defaultcamlist[i].dev_title.trim());
				 	$("#current_player_"+i).removeClass('video');
				 	inputdepartmentname ="inputDepartment";
				 	formitem = "videoFormFilter_"+i;
				}
			}
			catch(message){}
		}

		for (var i = 0 ; i <= video_limit; i++) {
			videoplayernum = i +1 ;
		 	inputCameraList = "video-camera-list_"+i;
		 	try{
		 		renderCamlist(defaultcamlist[i].id)
		 	}
		 	catch(ex){
		 		renderCamlist('')
		 	}	 	
		}
	}

	/*
	 * ---------------------------------------------------------
	 *   Render camera list on each player
	 * ---------------------------------------------------------
	 */
	function renderCamlist(cid){
		
		if(camlist != null && camlist.message != false)
		{
			$("#"+inputCameraList).html('');

			var cont_str = '';
			var videoCamLenght= camlist.length - 1;
			var serial = 1 ;
			for (var i = 0; i <= videoCamLenght; i++) {
				var temp ={
					name:camlist[i].dev_title.trim(),
					location:camlist[i].location.trim(),
					department:camlist[i].department.trim(),
					source:camlist[i].output_url.trim()
				}
				videoCamlist.push(temp);
				var findid = camlist[i].id;
				if(findid == cid){
					cont_str += '<tr class="row selected-row" id="tr_'+i+'">';
					cont_str += '<td data-view="'+camlist[i].output_url.trim()+'">';
					cont_str += '<input title="Default Selected" type="radio" data-view="'+camlist[i].output_url.trim()+'" class="cameraselected" data-cam = "'+camlist[i].id+'" data-cam-name = "'+camlist[i].dev_title.trim()+'" value="'+camlist[i].id+'" data-player="'+videoplayernum+'" name="setVideoFeed_'+videoplayernum+'" id="setVideoFeed_'+i+'" checked="checked">';
					cont_str += '<input type="hidden" value="'+screenid+'"  name="screenid" id="screenid">';
					cont_str += '</td>';
				}
				else{
					cont_str += '<tr class="row" id="tr_'+i+'">';
					cont_str += '<td data-view="'+camlist[i].output_url.trim()+'">';
					cont_str += '<input title="Click to set as default" type="radio" data-view="'+camlist[i].output_url.trim()+'" class="cameraselected" data-cam = "'+camlist[i].id+'" data-cam-name = "'+camlist[i].dev_title.trim()+'" value="'+camlist[i].id+'" data-player="'+videoplayernum+'" name="setVideoFeed_'+videoplayernum+'" id="setVideoFeed_'+i+'">';
					cont_str += '<input type="hidden" value="'+screenid+'"  name="screenid" id="screenid">';
					cont_str += '</td>';
				}
				
				
				cont_str += '<td class="video-cam-item"  data-view="'+camlist[i].output_url.trim()+'">'+camlist[i].dev_title.trim()+'</td>';
				cont_str += '<td class="video-cam-item"  data-view="'+camlist[i].output_url.trim()+'">'+camlist[i].location.trim()+'</td>';
				cont_str += '<td class="video-cam-item"  data-view="'+camlist[i].output_url.trim()+'">'+camlist[i].dev_type.trim()+'</td>';
				cont_str += '<td class="video-cam-item"  data-view="'+camlist[i].output_url.trim()+'"><a href="#" title="Click to play"><span class="icon-videocam"></span></a></td>';
				cont_str += '</tr>'
				serial++;
			}

			$("#"+inputCameraList).html(cont_str);
		}
	}
	
	/*
	 * ---------------------------------------------------------
	 *   Setup player
	 * ---------------------------------------------------------
	 */
	function initVideoObj(camsource,name,playernum)
	{
		//console.log("i am here");
		try{
			var playerInstance = jwplayer("video-"+playernum);
			playerInstance.setup({
	    		file: camsource,
	    		width: '100%',
	    		title: name,
	    		mediaid: '123456',
      			autostart: true,
	      		controls: true,
	      		preload:false,
	      		repeat:true
			});

			if(video_limit < 1){
				playerInstance.aspectratio = "19:16";
			}

			if(video_limit < 2){
				playerInstance.aspectratio = "16:14";
			}
		}
		catch(ex){

		}
	}

	/*
     * ---------------------------------------------------------
     *   Save camera limit on dashboard
     * ---------------------------------------------------------
     */
 //    $(document).on('click','.camera_limit',function(){
 //    	urlpath = "savecameralimit";
 //        ajaxType = "GET";
 //        var cameraLimitData = ({'cameralimit':$(this).attr('data-value')});
 //        ajaxfunc(urlpath,cameraLimitData,savecameralimitfaliure,savecameralimitsuccess); 	
 //    });
	
	// function savecameralimitfaliure()
	// {
	// 	alert("Camera limit not saved.Try again.");
	// }
	// function savecameralimitsuccess(response)
	// {
	// 	if (response.message == true){
	// 		location.reload();
	// 	}
	// }


	
	function findCurrentRecording(player, camera){ 
		var camerafound = false;
		for (var i = camlist.length - 1; i >= 0; i--) {
			if (camlist[i].id == camera) {
	  			camerafound = true ;
	  	  	}
		};
	  	return camerafound;
	}
	
	/*
     * ---------------------------------------------------------
     *  Render data on store click
     * ---------------------------------------------------------
     */

	// $(document).on('change','#inputStore',function(){
	// 	var videoData = jQuery('#videoFormFilter_'+current_player).serializeArray();
	// 	inputCameraList = "video-camera-list_"+current_player;
	// 	$("#avideo-camera-list_"+current_player).remove();
	// 	$("#video-camera-list_"+current_player).show();
	// 	getVideoCamList(videoData);
	// 	renderCamlist(camlist)
	// });

	/*
     * ---------------------------------------------------------
     *  Render data on department click
     * ---------------------------------------------------------
     */

	$(document).on('change','#inputDepartment',function(){
		var videoData = jQuery('#videoFormFilter_'+current_player).serializeArray();
		inputCameraList = "video-camera-list_"+current_player;
		$("#avideo-camera-list_"+current_player).remove();
		$("#video-camera-list_"+current_player).show();

		getVideoCamList(videoData);
		renderCamlist(camlist)
	});

	$("#inputFloor").on('change',function(){
		var videoData = jQuery('#videoFormFilter').serializeArray();
		inputCameraList = "video-camera-list_"+current_player;
		getVideoCamList(videoData);
	});

	/*
     * ---------------------------------------------------------
     *  Change video feed on click
     * ---------------------------------------------------------
     */
	$(document).on('click','.video-cam-item1',function(){
		var getSoruce = $(this).attr('data-view').trim();
		var source  ;
		$(this).parent().parent().find('tr.selected-row').removeClass('selected-row');
		$(this).parent().addClass('selected-row');
		var videoCamlistContainer = camlist.length - 1;
		for (var i = videoCamlistContainer; i >= 0; i--) {
			if(camlist[i].output_url.trim() == getSoruce){
				source = setVideoCamSource(camlist[i].camid,camlist[i].dev_title.trim(),camlist[i].location.trim(),camlist[i].department.trim(),camlist[i].output_url.trim());					
				setVideoPalyer(camlist[i].camid,camlist[i].dev_title.trim(),camlist[i].location.trim(),camlist[i].department.trim(),camlist[i].output_url.trim(),current_player,true);
				inputEventList = "event_placeholder_"+current_player;
				eventLoader ="event_loader_"+current_player;
				$(".vf_"+current_player+" span#option-text").text(camlist[i].dev_title);
				initVideoObj(camlist[i].output_url.trim(),camlist[i].dev_title.trim(),current_player);
			}
		}
		
		return true;
	});

	/*
     * ---------------------------------------------------------
     *  Change default camera
     * ---------------------------------------------------------
     */
	$(document).on('click','.cameraselected1',function(){
		var camnumer = $(this).attr('data-cam');
		var playernum = $(this).attr('data-player');
		var camname = $(this).attr('data-cam-name');
		var output_url = $(this).attr('data-view');
		$(this).parent().parent().parent().find('tr.selected-row').removeClass('selected-row');
		$(this).parent().parent().addClass('selected-row');
		$(this).prop('checked',true);
		ajaxType = "GET";
  		//urlpath = "api/saveSelectedCameraOption/format/json";
     	//var dataString = ({'camnumer':camnumer,'playernum':playernum,'screenid':$("#screenid").val()});
     	var dataString = ({'camname':camname,'playernum':playernum,'output_url':output_url});
     	ajaxfunc(urlpath,dataString,defaultCamSaveFailed,defaultCamSaveSuccess);
     	var getSoruce = $(this).attr('data-view').trim();
     	var videoCamlistContainer = camlist.length - 1;
		for (var i = videoCamlistContainer; i >= 0; i--) {
			if(camlist[i].output_url.trim() == getSoruce){
				source = setVideoCamSource(camlist[i].camid,camlist[i].dev_title.trim(),camlist[i].location.trim(),camlist[i].department.trim(),camlist[i].output_url.trim());					
				setVideoPalyer(camlist[i].camid,camlist[i].dev_title.trim(),camlist[i].location.trim(),camlist[i].department.trim(),camlist[i].output_url.trim(),current_player,true);
				$("#cur_cam_"+i).text(camlist[i].dev_title+" / "+camlist[i].location);
				$(".vf_"+current_player+" span#option-text").text(camlist[i].dev_title);
				initVideoObj(camlist[i].output_url.trim(),camlist[i].dev_title.trim(),current_player);
			}
		}
	});
	

	function defaultCamSaveFailed(){}
	function defaultCamSaveSuccess(response){}
	
	$(".video-feed-fomr-container").click(function(){
		return false;
	});

	/*
	 * ---------------------------------------------------------
	 *   Set option
	 * ---------------------------------------------------------
	 */
	$(document).on('click','.menu-option-click',function(){
		if($(this).attr('id') == 'vs'){
			current_player = $(this).attr('data-view');
		}
		if($(this).attr('id') == 'vc'){
			current_player = $(this).attr('data-cam');
		}
	});

	/*
	 * ---------------------------------------------------------
	 *   Get last seven day events (currently it is thirty)
	 * ---------------------------------------------------------
	 */
	
	function dateformat (dateinput) {
	    var d = new XDate(dateinput);
	    return d.toString("M/d/yy h(:mm)TT")
	}
	
	function getNextMint(t)
	{
		var d = new XDate(t);
		d.addMinutes(1);
	    return d.toString("hhmmss");
	}

	function getMint(t)
	{
		var d = new XDate(t);
	    return d.toString("hhmmss");
	}
});
	
	