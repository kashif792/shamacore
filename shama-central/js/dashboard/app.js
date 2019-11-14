var app = angular.module('invantage',[]);
app.controller('dashboard', function($scope,$interval,$http) {

	var urllist = {
		updatepreviewstreamurl:'api/changepreview/format/json',
		connectpreviewstreamurl:'api/connectpreview/format/json',
		cameradetail:'api/getSingleVideoCamInfo/format/json',
		videosource:'api/getCameraSourceList/format/json',
		defaulcamtlist:'getdefaultcamlist',
		adddefaultlist:'adddefaultcamlist',
		setstreamquality:'setstreamquality',
		getstreams:'api/streamlist/format/json',
		addstream:'api/addstream/format/json',
		updatestream:'api/updatestream/format/json',
		connectstream:'api/connectstream/format/json',
		previewstreamurl:'api/previewstream/format/json',
		savecameralimit:'savecameralimit',
		disconnectcamera:'api/disableStream/format/json',
	}
	$scope.cameralist = [];
	$scope.get_default_wo_list = [];
	$scope.get_default_local_list = [];
	$scope.default_quality  = 2;
	$scope.is_preview = false;
	var videoAddress = {
		videoIpAddress : 'rtmp://ftc.zinwebs.com:1935/live/',
		camerafeedurl:''
	}
	$scope.current_camera_source =  [] 
	$scope.first_time = false;
	$scope.count_iter = 0;
	var inputCameraList ;
	$scope.countfailedtry = 0;
	video_limit = parseInt(video_limit);

	/*
	 * ---------------------------------------------------------
	 *   load camera sources list
	 * ---------------------------------------------------------
	 */
	cameraSoruces('','')
	function cameraSoruces(storename,playernum)
	{
		ajaxType = "GET";
        var camdata = ({'inputStore':storename});
       	httprequest(ajaxType,urllist.videosource,camdata).then(
       		function(response){
       			try{
       				if(response.message != false){
       					$scope.cameralist = response;
   						checksourceresource(playernum)
       				}
       				else{
						$("#spinloader_"+playernum).hide();
       					$("#video-camera-list_"+playernum).html("<span class='no-record'>No camera sources found</spna>")
       				}
       			}
       			catch(ex)
       			{}
       		}
       	)
	}

	/*
	 * ---------------------------------------------------------
	 *   load default camera list
	 * ---------------------------------------------------------
	 */

	function checksourceresource(playernum)
	{
		if($scope.get_default_local_list.length == 0)
		{
			defaultCameraSoruces(playernum);
		}
		else{
			getDefaultWoList(playernum)
		}
	}

	function reloaddefaultlist()
	{
		ajaxType = "GET";
        var camdata = '';
       	httprequest(ajaxType,urllist.defaulcamtlist,camdata).then(
       		function(response){
       			try{
       				if (response.default_list_messages == true) {
   						$scope.get_default_local_list = [];
       					$scope.get_default_local_list = response;
       				}
       			}
       			catch(ex){}
       		}
       	)
	}

	function defaultCameraSoruces(playernum)
	{
		ajaxType = "GET";
        var camdata = '';
       	httprequest(ajaxType,urllist.defaulcamtlist,camdata).then(
       		function(response){
       			try{
       				if (response.default_list_messages == false) {
   						var temp = {
								name: $scope.cameralist[0].title,
								location:$scope.cameralist[0].location,
								quality : $scope.default_quality,
								vsource: 'l',
								url:$scope.cameralist[0].rtsp_input_url
						}
						$scope.current_camera_source.push(temp);

       					renderlist($scope.cameralist,$scope.cameralist[0].title,'default0_'+current_user,1,$scope.cameralist[0].title)
       					addDefaultList();
       				}else{
       					$scope.get_default_local_list = response;
       					getDefaultWoList(playernum);
       				}
       			}
       			catch(ex)
       			{}
       		}
       	)
	}

	/*
	 * ---------------------------------------------------------
	 *   If already cameras not added. Add to local
	 * ---------------------------------------------------------
	 */
	function addDefaultList()
	{
		try{	
			$("#event_loader_0").show();
			for (var i = 0; i <= 3; i++) {
				var is_active = 0 ;
				if(i == 0){
					is_active = 1;
				}
				 var camdata = ({
					'camname':$scope.cameralist[i].title.trim(),
					'playernum':i,
					'outputurl':$scope.cameralist[i].rtsp_input_url.trim(),
					'inputurl':"",
					'location':$scope.cameralist[i].location.trim(),
					'is_active':is_active,
				});

		       	httprequest(ajaxType,urllist.adddefaultlist,camdata).then(
		       		function(response){
		       			try{
		       				$scope.first_time = true;
		       				addStream(response.message,$scope.cameralist[0].rtsp_input_url,0)
		       				var temp = {
									name: $scope.cameralist[i].title.trim(),
									location:$scope.cameralist[i].location.trim(),
									quality : $scope.default_quality,
									vsource: 'l',
									url:$scope.cameralist[i].rtsp_input_url
							}
							$scope.current_camera_source.push(temp);
		       			}
		       			catch(ex)
		       			{}
		       		}
		       	)
			};

		}
		catch(ex){}
	}

	function getDefaultWoList(playernum)
	{
		try{
			if($scope.get_default_wo_list.length == 0){
				getWoList(playernum);
			}
			else{
				source_iterate($scope.get_default_wo_list,playernum);
			}
		}
		catch(ex){}
	}

	function getWoList(playernum)
	{
		try{
			var camdata = '';
			httprequest(ajaxType,urllist.getstreams,camdata).then(
	       		function(response){
	       			try{

	       				$scope.get_default_wo_list = response.streamFiles
	       				source_iterate(response.streamFiles,playernum)
	       			}
	       			catch(ex)
	       			{}
	       		}
	       	)
		}
		catch(ex){}
	}

	function source_iterate(sourcelist,playernum)
	{
		try{
			var videoplayernum = 0;
			angular.forEach(sourcelist, function(value, key) {
				var alreadyfound = getItemFound(value.id,'')
				if(alreadyfound != false){
					$scope.is_preview = false;
					inputCameraList = "video-camera-list_"+videoplayernum;
					var outputurl = '';
					var current_iteration = videoplayernum + 1;
					var temp = {
						name: alreadyfound.name,
						location: alreadyfound.location,
						quality : alreadyfound.quality,
						vsource: 'l',
						url:alreadyfound.w_url
					}
					$scope.current_camera_source.push(temp);
					if(playernum != '' && playernum == parseInt(alreadyfound.cam_player)){
						var cur = parseInt(playernum) + 1
						inputCameraList = "video-camera-list_"+parseInt(playernum);
						output_url = split_quality(alreadyfound.w_url,alreadyfound.quality)
						$(".stream_"+videoplayernum+" span#stream-text").text("Quality "+alreadyfound.quality);
						renderlist($scope.cameralist,alreadyfound.name,alreadyfound.url_name,cur,alreadyfound.name)
					}
					else if(playernum == '') {
						$("#event_loader_"+videoplayernum).show();
						output_url = split_quality(alreadyfound.w_url,alreadyfound.quality)
						$(".stream_"+videoplayernum+" span#stream-text").text("Quality "+alreadyfound.quality);
						renderlist($scope.cameralist,alreadyfound.name,alreadyfound.url_name,current_iteration,alreadyfound.name)
						updateStream(alreadyfound.url_name,output_url,videoplayernum)
						videoplayernum++;
					}
				}
				
			});
		}
		catch(ex){}
	}

	/*
	 * ---------------------------------------------------------
	 *   Search id from wowza list
	 * ---------------------------------------------------------
	 */
	function getItemFound(itemsearch,typesearch){
		var isitemfound = false;
		var temp = {}
		angular.forEach($scope.get_default_local_list, function(value, key) {
			switch(typesearch){
				case 'changequality':
					if(value.cam_player == itemsearch && value.cam_status == 'a'){
						temp = {
							cin : value.cin,
							name : value.name,
							w_url : value.wowza_url,
							url_name : value.cam_url_name,
							p_url :value.video_player_url,
							location:value.location,
							cam_player :value.cam_player,
							cam_status :value.cam_status,
							quality :value.quality
						}
						isitemfound = temp;
					}
					break;
				default:
					if(value.cam_url_name == itemsearch && value.cam_status == 'a'){
						temp = {
							name : value.name,
							url_name : value.cam_url_name,
							w_url : value.wowza_url,
							location:value.location,
							quality :value.quality,
							cam_player :value.cam_player,
						}
						isitemfound = temp;
					}
					if(value.cam_url_name == itemsearch && value.cam_status == 'i')
					{
						disconnectStream(itemsearch)
					}
			}
			
		});
		return isitemfound;
	}

	/*
	 * ---------------------------------------------------------
	 *   Search preview item
	 * ---------------------------------------------------------
	 */
	function getPreviewItem(itemlist)
	{
		var isitemfound = false;
		var temp = {}
		angular.forEach(itemlist, function(value, key) {
			var findelement = value.id.split("_");
			if(findelement[0] == 'preview'){
				temp = {
					name : value.id,
				}
				isitemfound = temp;
			}
		});
		return isitemfound;
	}

	function getResourceList(checkitem)
	{
		var isitemfound = false;
		var findelement = checkitem.id.split("_");
		if(findelement[1] == current_user){
			isitemfound = true;
		}
		return isitemfound;
	}


	/*
	 * ---------------------------------------------------------
	 *   add stream
	 * ---------------------------------------------------------
	 */
	function addStream(cam_url_name,wowza_url,playernum)
	{
		try{
			var camdata = ({'cam_name':cam_url_name});
			httprequest(ajaxType,urllist.addstream,camdata).then(
	       		function(response){
	       			try{
	       				if($scope.first_time == true && $scope.count_iter == 0){
	       					updateStream(cam_url_name,wowza_url,playernum)
	       				}
	       				
	       				if($scope.first_time == false){
	       					updateStream(cam_url_name,wowza_url,playernum)
	       				}
       					$scope.count_iter++
	       			}
	       			catch(ex)
	       			{}
	       		}
	       	)
		}
		catch(ex){}
	
	}

	/*
	 * ---------------------------------------------------------
	 *   Update stream
	 * ---------------------------------------------------------
	 */
	function updateStream(cam_url_name,wowza_url,palyernum)
	{
		try{
		
			var camdata = ({'cam_name':cam_url_name,'outputurl':wowza_url});
			httprequest(ajaxType,urllist.updatestream,camdata).then(
	       		function(response){
	       			try{
       					connectStream(cam_url_name,palyernum)
	       			}
	       			catch(ex)
	       			{}
	       		}
	       	)
		}
		catch(ex){}
	}

	/*
	 * ---------------------------------------------------------
	 *   Connect stream
	 * ---------------------------------------------------------
	 */
	function connectStream(cam_url_name,current_iteration)
	{
		try{
			var camdata = ({'cam_name':cam_url_name});
			httprequest(ajaxType,urllist.connectstream,camdata).then(
	       		function(response){
	       			try{
	       				videoAddress.camerafeedurl = cam_url_name;
						var camerasourcelink = videoAddress.videoIpAddress+videoAddress.camerafeedurl+'.stream';
        			 	$("#cur_cam_"+current_iteration).text($scope.current_camera_source[current_iteration].name+" / "+$scope.current_camera_source[current_iteration].location);
						$(".vf_"+current_iteration+" span#option-text").text($scope.current_camera_source[current_iteration].name);
					 	//$(".stream_"+current_iteration+" span#stream-text").text("Quality "+$scope.current_camera_source[current_iteration].quality);
					 	setup_player(camerasourcelink,current_iteration,$scope.current_camera_source[current_iteration])
	       			}
	       			catch(ex)
	       			{}
	       		}
	       	)
		}
		catch(ex){}
	}

	/*
	 * ---------------------------------------------------------
	 *   Add preview stream to db
	 * ---------------------------------------------------------
	 */
	function addPreviewStream()
	{
		try{
			var camdata = '';
			httprequest(ajaxType,urllist.previewstreamurl,camdata).then(
	       		function(response){})
		}
		catch(ex){}
	}
	
	/*
	 * ---------------------------------------------------------
	 *   Update preview
	 * ---------------------------------------------------------
	 */
	function updatePreviewStream(previewoutputurl,playernum,camuname)
	{
		try{
			var camdata = ({'outputurl':previewoutputurl,'page_home':'home','cam_name':camuname});
			httprequest(ajaxType,urllist.updatepreviewstreamurl,camdata).then(
	       		function(response){
	       			try{
	       				connectPreviewStream(playernum,camuname)
	       			}
	       			catch(ex)
	       			{}
	       		}
	       	)
		}

		catch(ex){}
	}

	/*
	 * ---------------------------------------------------------
	 *   Connect preview
	 * ---------------------------------------------------------
	 */
	function connectPreviewStream(playernum,camuname)
	{
		try{
			var camdata = ({'page_home':'home','cam_name':camuname});
			httprequest(ajaxType,urllist.connectpreviewstreamurl,camdata).then(
	       		function(response){
	       			try{
	       				playernum = playernum - 1;
	       				videoAddress.camerafeedurl = response.message;
						var camerasourcelink = videoAddress.videoIpAddress+videoAddress.camerafeedurl+'.stream';
	       				setup_player(camerasourcelink,playernum,camuname)
	       			}
	       			catch(ex)
	       			{
	       				connectPreviewStream(playernum,camuname)
	       			}
	       		}
	       	)
		}
		catch(ex){}
	}

 	/*
     * ---------------------------------------------------------
     *   Disconnect screen
     * ---------------------------------------------------------
     */
    function disconnectStream(streamname)
    {
    	try{
    		var camdata = ({'cam_name':streamname});
    	 	httprequest(ajaxType,urllist.disconnectcamera,camdata).then(
	       		function(response){
	       			
	       		}
	       	)
		}
		catch(ex){}
    }

	/*
     * ---------------------------------------------------------
     *  Change default camera
     * ---------------------------------------------------------
     */
	$(document).on('click','.cameraselected',function(){
		try{
			var playernum = $(this).attr('data-player');
			var camname = $(this).attr('data-camname');
			var output_url = $(this).attr('data-outputurl');
			var inputurl = $(this).attr('data-inputurl');
			var location = $(this).attr('data-location');
			var camuname = $(this).attr('data-camuname');
			$(this).parent().parent().parent().find('tr.selected-row').removeClass('selected-row');
			$(this).parent().parent().addClass('selected-row');
			$(this).prop('checked',true);
			$scope.is_preview = false;
			var previewplayer = playernum ;
			previewplayer = previewplayer - 1;
			$("#cur_cam_"+previewplayer).text(camname+" / "+location);
			$(".vf_"+previewplayer+" span#option-text").text(camname.trim());
		 	$("#current_player_"+previewplayer).removeClass('video');
		 	$scope.current_camera_source[previewplayer].vsource = 'l';
			output_url = split_quality(output_url,$scope.current_camera_source[previewplayer].quality)
			$(".stream_"+previewplayer+" span#stream-text").text("Quality "+$scope.current_camera_source[previewplayer].quality);
			$scope.current_camera_source[previewplayer].url = output_url;
		 	senddata(camname,playernum,output_url,location,camuname);
		}
		catch(ex){
			$(".user-message").show();
	    	$(".message-text").text("found issue in camera source.try diffrent camera").fadeOut(10000);
		}
	});
	
	function senddata(name,playernum,output_url,location,camuname){
		try{
			var camdata = ({
				'camname':name,
				'playernum':playernum - 1,
				'outputurl':output_url,
				'inputurl':'',
				'location':location,
				'is_active':1,
			});
			httprequest(ajaxType,urllist.adddefaultlist,camdata).then(
	       		function(response){
	       			try{
	       				updatePreviewStream(output_url,playernum,camuname)
	       			}
	       			catch(ex){}
	       		}
	       	)
		}
		catch(ex){}
	}

    /*
     * ---------------------------------------------------------
     *  Preview video feed
     * ---------------------------------------------------------
     */
	$(document).on('click','.video-cam-item',function(){
		$(this).parent().parent().find('tr.selected-row').removeClass('selected-row');
		$(this).parent().addClass('selected-row');
		var playernum = $(this).attr('data-preview-player');
		var camname = $(this).attr('data-preview-camname');
		var output_url = $(this).attr('data-preview-outputurl');
		var inputurl = $(this).attr('data-preview-inputurl');
		var location = $(this).attr('data-preview-location');
		var camuname = $(this).attr('data-preview-camuname');
		$scope.is_preview = true;
		var previewplayer = playernum ;
		previewplayer = previewplayer - 1;
		$("#cur_cam_"+previewplayer).text(camname+" / "+location);
		$(".vf_"+previewplayer+" span#option-text").text(camname.trim());
	 	$("#current_player_"+previewplayer).removeClass('video');
	 	$scope.current_camera_source[previewplayer].vsource = 'p';
	 	output_url = split_quality(output_url,$scope.current_camera_source[previewplayer].quality)
		$(".stream_"+previewplayer+" span#stream-text").text("Quality "+$scope.current_camera_source[previewplayer].quality);
		$scope.current_camera_source[previewplayer].url = output_url;
	 	updatePreviewStream(output_url,playernum,camuname)
		return true;
	});
	
	function split_quality(qualityurl,quality)
	{
		var output_url = qualityurl.split('streamindex=');
		output_url = output_url[0]+'streamindex='+quality;
		return output_url;
	}

	/*
	 * ---------------------------------------------------------
	 *   Change stream quality
	 * ---------------------------------------------------------
	 */
	$scope.changequality = function(quality,playernum)
	{
		try{
			reloaddefaultlist();
			var result = getItemFound(playernum,'changequality')
			var output_url = '';
			if($scope.current_camera_source[playernum].vsource == 'l' && result != false){
				if($scope.current_camera_source[playernum].vsource == 'l'){
					output_url = split_quality($scope.current_camera_source[playernum].url,quality)
				}
			}
			 else{
			 	output_url = split_quality($scope.current_camera_source[playernum].url,quality)
			 }
			
			$("#current_player_"+playernum).removeClass('video');
		 	var curpalyer = playernum ;
		 	playernum = playernum + 1;
		  	$scope.current_camera_source[curpalyer].quality = quality;
	 	 	var camdata = ({'quality':quality,'qualityrow':result.cin});
	 	 	$(".stream_"+curpalyer+" span#stream-text").text("Quality "+$scope.current_camera_source[curpalyer].quality);
	 	 	updatePreviewStream(output_url,playernum,result.url_name)
	 		if($scope.current_camera_source[curpalyer].vsource == 'l'){
	 			httprequest(ajaxType,urllist.setstreamquality,camdata).then(function(response){
	       			try{}
	       			catch(ex){}
	       		})
	 		}
			
		}
		catch(ex){}
		
	}

	/*
     * ---------------------------------------------------------
     *   Save camera limit on dashboard
     * ---------------------------------------------------------
     */
    $(document).on('click','.camera_limit',function(){
    	 try{
    	 	var camdata = ({'cameralimit':$(this).attr('data-value')});
    	 	httprequest(ajaxType,urllist.savecameralimit,camdata).then(
	       		function(response){
	       			if(response.message == true){
						location.reload();
					}
					else{
						alert("Camera limit not saved.Try again.");
					}
	       		}
	       	)
		}
		catch(ex){} 	
    });

    /*
     * ---------------------------------------------------------
     *   Change store
     * ---------------------------------------------------------
     */
    $(document).on('change','.inputStore',function(){
    	var curr_player = $(this).attr('data-current-player');
    	$("#spinloader_"+curr_player).show();
    	var changestore = $("#inputStore_"+curr_player).val();
    	cameraSoruces(changestore,curr_player)
    })

	/*
	 * ---------------------------------------------------------
	 *   Ini player
	 * ---------------------------------------------------------
	 */
	function setup_player(sourcelink,playernum,name)
	{
		try{
			var playerInstance = jwplayer("video-"+playernum);
			playerInstance.setup({
	    		file: sourcelink,
	    		width: '100%',
	    		title: name,
	    		height:400,
	    		mediaid: '123456',
      			autostart: true,
	      		controls: true,
	      		preload:false,
	      		repeat:true
			});

			playerInstance.on('error', function() {
				$("#event_loader_"+playernum).show();
			  	theTimeout = setTimeout(function(){
			  		if($scope.countfailedtry < 5 ){
			  			setup_player(sourcelink,playernum,name);	
			  			$scope.countfailedtry++;
			  		}else{
			  			$("#event_loader_"+playernum).hide();
			  			playerInstance.stop();
			  			$("#camera-choice-"+playernum).prepend('<span class="no-camera-found">This camera is not playable</span>')
			  		}
				},5000);
			 
			});

			playerInstance.on('play', function() {
  				$("#camera-choice-"+playernum+" .no-camera-found").remove();
  				$("#event_loader_"+playernum).hide();
			});

		}
		catch(ex){

		}
	}

	/*
	 * ---------------------------------------------------------
	 *   Populate table
	 * ---------------------------------------------------------
	 */
	function renderlist(response,camerasource,cuname,videoplayernum,previewlink)
	{
		try{
			if(response != null)
			{
				$("#"+inputCameraList).html('');
				var cont_str = '';
				var videoCamLenght= response.length - 1;
				for (var i = 0; i <= videoCamLenght; i++) {
					var findid = response[i].title;
				  	if(findid == camerasource){
					  	cont_str += '<tr class="row selected-row" id="tr_'+i+'">';
					  	cont_str += '<td data-view="'+response[i].output_url+'">';
					  	cont_str += '<input title="Default Selected" type="radio" class="cameraselected" data-camname="'+response[i].title+'" data-camuname= "'+cuname+'" data-player="'+videoplayernum+'" data-video_player_url="'+response[i].rtsp_input_url.trim()+'" data-inputurl="'+response[i].output_url.trim()+'" data-location="'+response[i].location.trim()+'" name="setVideoFeed_'+videoplayernum+'" checked="checked">';
					  	cont_str += '</td>';
				  	}
				  	else{
				  		
					  	cont_str += '<tr class="row" id="tr_'+i+'">';
					  	cont_str += '<td data-view="'+response[i].output_url+'">';
					  	cont_str += '<input title="Click to set as default" type="radio" class="cameraselected" data-camname="'+response[i].title+'" data-camuname= "'+cuname+'" data-player="'+videoplayernum+'" data-outputurl="'+response[i].rtsp_input_url+'" data-inputurl="'+response[i].output_url+'" data-location="'+response[i].location+'" name="setVideoFeed_'+videoplayernum+'">';
					  	cont_str += '</td>';

				  	}
					cont_str += '<td class="video-cam-item" data-preview-camname="'+response[i].title+'" data-preview-player="'+videoplayernum+'" data-preview-outputurl="'+response[i].rtsp_input_url+'" data-preview-inputurl="'+response[i].output_url+'" data-preview-location="'+response[i].location+'" data-preview-camuname= "'+cuname+'"  data-view="'+response[i].output_url+'">'+response[i].title+'</td>';
					cont_str += '<td class="video-cam-item" data-preview-camname="'+response[i].title+'" data-preview-player="'+videoplayernum+'" data-preview-outputurl="'+response[i].rtsp_input_url+'" data-preview-inputurl="'+response[i].output_url+'" data-preview-location="'+response[i].location+'" data-preview-camuname= "'+cuname+'"   data-view="'+response[i].output_url+'">'+response[i].location+'</td>';
					cont_str += '<td class="video-cam-item" data-preview-camname="'+response[i].title+'" data-preview-player="'+videoplayernum+'" data-preview-outputurl="'+response[i].rtsp_input_url+'" data-preview-inputurl="'+response[i].output_url+'" data-preview-location="'+response[i].location+'" data-preview-camuname= "'+cuname+'"   data-view="'+response[i].output_url+'">'+response[i].department+'</td>';
					cont_str += '<td class="video-cam-item" data-preview-camname="'+response[i].title+'" data-preview-player="'+videoplayernum+'" data-preview-outputurl="'+response[i].rtsp_input_url+'" data-preview-inputurl="'+response[i].output_url+'" data-preview-location="'+response[i].location+'" data-preview-camuname= "'+cuname+'"    data-view="'+response[i].output_url+'"><a href="#" title="Click to play"><span class="icon-videocam"></span></a></td>';
					cont_str += '</tr>'
						
				}
				
				if(video_limit < 2){
		            var cur = parseInt(videoplayernum) - 1;
		            $("#reporttablebody-phase-two-"+cur).append(cont_str);
		      		$("#singlecamerdisplay-"+cur).show()
		      		$("#topcamsource-"+cur).hide()
		      		loaddatatable("table-body-phase-tow-"+videoplayernum);
				}
				else{
					var cur = parseInt(videoplayernum) - 1;
					$("#singlecamerdisplay-"+cur).hide()
					$("#"+inputCameraList).html(cont_str);
					$("#spinloader_"+cur).hide();
				}
				
			}
		}
		catch(ex){}
	}

	/**
 	 * ---------------------------------------------------------
     *   load table
     * ---------------------------------------------------------
     */
    function loaddatatable(tablename)
    {
        $('#'+tablename).DataTable( {
            responsive: true,
             "order": [[ 1, "asc"  ]],
               "columns": [
			    { "width": "2%" },
			    { "width": "35%" },
			    null,
			    null,
			    null
			  ],
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
     
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        });
                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    });
                });
            }
        });
    }

	function httprequest(method,url,data)
	{
		var request = $http({
			method:method,
			url:url,
			params:data,
			headers : {'Accept' : 'application/json'}
		});
		return (request.then(responseSuccess,responseFail))
	}

	function responseSuccess(response){
		
		return (response.data);
	}

	function responseFail(response){
		return (response.data);
	}
});