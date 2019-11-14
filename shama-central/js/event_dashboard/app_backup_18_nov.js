var app = angular.module('ftcinsight',[]);
app.controller('dashboard', function($scope,videodashboard,$interval) {
	var urllist = {
		department:'api/getVideoDepartments/format/json',
		videosource:'api/getVideoSourceList/format/json',
		videoevent:'api/getVideoEvents/format/json',
		saverecordingviewed:'api/saveViewedVideo/format/json',
		eventtype:'api/getMotionType/format/json',
		storelist:'api/getStores/format/json',
		savefeednum:'savefeednum',
		eventvideo:'api/getEventVideo/format/json',
		getstreams:'api/streamlist/format/json',
		previewstreamurl:'api/previewstream/format/json',
		updatepreviewstreamurl:'api/changepreview/format/json',
		connectpreviewstreamurl:'api/connectpreview/format/json',
	}
	
	var videoAddress = {
		videoIpAddress : 'rtmp://ftc.zinwebs.com:1935/live/',
		alias:'rec/rec',
		userid:''
	}

	var previewvideoAddress = {
		videoIpAddress : 'rtmp://ftc.zinwebs.com:1935/live/',
		userid:''
	}

	var storedata ={
		storenum:'all'
	}

	var eventlist = {
		eventid: ''
	}

	$scope.videostatus = 'Unviewed';
	$scope.videostatusvalue = 0 ;
	$scope.storelist = [];
	$scope.cameralists  = [];
	var vevent = '';
	$scope.viewedtab = 'Unviewed';
	$scope.currentplay = [];
	$scope.eventplayerlist = [];
	var vdata = '';
	$scope.event_loader = true;
	$scope.eventlist = [];
	$scope.store_text = 'All';
	$scope.store_value = 'All Stores';
	$scope.ustore_text = uselect;
	$scope.device_name = 'All Cameras';
	$scope.device_id = 'All';
	$scope.event_motion_value = 'All';
	$scope.event_motion_type = 'All';
	getLastSevenDaysEvents();
	var currentevent = {
		eventid:''
	};
	$scope.currentplayableitem = '';
	$scope.is_current_feed_playing = 0;
	$scope.is_current_playing = true;
	var previeweventlist = {
		previewoutputurl:'',
		inputurl:'',
		camname:'',
		is_recorded:'',
		audit:''
	};
	
	function getLastSevenDaysEvents()
	{
		var bdate = new Date();
       	var edate = new Date();
       	bdate.setDate(bdate.getDate()-10);
       	var startdate = bdate.getMonth() + 1 + "/"+bdate.getDate() + "/" + bdate.getFullYear();
       	var starttime = bdate.getHours() + ":"+bdate.getMinutes() + ":" + bdate.getSeconds();
       	var enddate = edate.getMonth() + 1 + "/"+edate.getDate() + "/" + edate.getFullYear();
       	var endtime = edate.getHours()  + ":"+edate.getMinutes() + ":" + edate.getSeconds();
       	var seventtime = startdate+" "+starttime;
		var eeventtime = enddate+" "+endtime;
		eventDates ={
			eventstart :seventtime,
			eventend :eeventtime
		}

		eventDates ={
			eventstart :seventtime,
			eventend :eeventtime
		}

		vevent ={
			eventstart :seventtime,
			eventend :eeventtime
		}
		
	}

	setAlramEventWidgetDateTime(eventDates.eventstart,eventDates.eventend);
	function setAlramEventWidgetDateTime(startdate,enddate) {
		$("#event-widget-start-date-text").text(startdate);
		$("#event-widget-end-date-text").text(enddate);
	}
	$scope.inputdate = eventDates.eventstart+" - "+eventDates.eventend;
	setAlramEventWidgetFilterDate(eventDates.eventstart,eventDates.eventend);
	function setAlramEventWidgetFilterDate(startdate,enddate)
	{
		$('input[name="widgetAlarmInputFromDate"]').daterangepicker({ 
			showDropdowns: true,
			timePicker: true,
			timePicker24Hour: true,
			startDate: startdate,
        	endDate: enddate,
        	linkedCalendars: false,
	        locale: {
	            format: 'MM/DD/YYYY h:mm'
	        }
		});
	}

	viewedsetAlramEventWidgetDateTime(vevent.eventstart,vevent.eventend);
	function viewedsetAlramEventWidgetDateTime(startdate,enddate) {
		$("#vevent-widget-start-date-text").text(startdate);
		$("#vevent-widget-end-date-text").text(enddate);
	}
	$scope.vinputdate = vevent.eventstart+" - "+vevent.eventend;
	viewedsetAlramEventWidgetFilterDate(vevent.eventstart,vevent.eventend);
	function viewedsetAlramEventWidgetFilterDate(startdate,enddate)
	{
		$('input[name="viewedwidgetAlarmInputFromDate"]').daterangepicker({ 
			showDropdowns: true,
			timePicker: true,
			timePicker24Hour: true,
			startDate: startdate,
        	endDate: enddate,
        	linkedCalendars: false,
	        locale: {
	            format: 'MM/DD/YYYY h:mm'
	        }
		});
	}

	/*
	 * ---------------------------------------------------------
	 *   Set option
	 * ---------------------------------------------------------
	 */
	function getAlramEventWidgetFilterDate() {
		var inputstartdate = $("#widgetAlarmInputFromDate").val();
		var splitdate = inputstartdate.split(' - ');
		var bdate = new Date(splitdate[0])
       	var edate = new Date(splitdate[1])
       	var startdate = bdate.getMonth() + 1 + "/"+bdate.getDate() + "/" + bdate.getFullYear();
       	var starttime = bdate.getHours() + ":"+bdate.getMinutes() + ":" + bdate.getSeconds();
       	var enddate = edate.getMonth() + 1 + "/"+edate.getDate() + "/" + edate.getFullYear();
       	var endtime = edate.getHours()  + ":"+edate.getMinutes() + ":" + edate.getSeconds();
       	var seventtime = startdate+" "+starttime;
		var eeventtime = enddate+" "+endtime;
		eventDates ={
			eventstart :seventtime,
			eventend :eeventtime
		}
		$(document).find(".widget-date-picker-container").hide();
	 	$("#alarm_event_date_widget").show();
	}

	/*
	 * ---------------------------------------------------------
	 *   Set option
	 * ---------------------------------------------------------
	 */
	function viewedgetAlramEventWidgetFilterDate() {
		var inputstartdate = $("#viewedwidgetAlarmInputFromDate").val();
		var splitdate = inputstartdate.split(' - ');
		var bdate = new Date(splitdate[0])
       	var edate = new Date(splitdate[1])
       	var startdate = bdate.getMonth() + 1 + "/"+bdate.getDate() + "/" + bdate.getFullYear();
       	var starttime = bdate.getHours() + ":"+bdate.getMinutes() + ":" + bdate.getSeconds();
       	var enddate = edate.getMonth() + 1 + "/"+edate.getDate() + "/" + edate.getFullYear();
       	var endtime = edate.getHours()  + ":"+edate.getMinutes() + ":" + edate.getSeconds();
       	var seventtime = startdate+" "+starttime;
		var eeventtime = enddate+" "+endtime;
		vevent ={
			eventstart :seventtime,
			eventend :eeventtime
		}
		$(document).find(".vwidget-date-picker-container").hide();
	 	$("#valarm_event_date_widget").show();
	}

	vdata =  eventInputs(eventDates.eventstart,eventDates.eventend,$scope.event_motion_value);

	function eventInputs(fromdate,enddate,event_type)
	{
		var eventInputs = {
			storenum:($scope.ustore_text != '' ? $scope.ustore_text : $scope.store_text),
			video_motion_type:event_type,
			device:$scope.device_id,
			fromdate:fromdate,
			enddate:enddate,
			viewed:$scope.videostatusvalue
		}
		return eventInputs;
	}

	function counttime(current)
	{
		var current_play = $interval(function () {
			if(current == 5){
				play_video();
				$interval.cancel(current_play);
			}
			current++;
		}, 2000);
	}

	$scope.storefilter = function(store,storename)
	{
		$scope.store_text = store;
		$scope.store_value = storename;
		vdata =  eventInputs(eventDates.eventstart,eventDates.eventend,$scope.event_motion_value);
		loadeventscall();
		counttime(5)
	}

	$scope.devicefilter = function(deviceid,device_name)
	{
		$scope.device_id = deviceid;
		$scope.device_name = (device_name =='All' ? 'All Cameras' : device_name);
		vdata =  eventInputs(eventDates.eventstart,eventDates.eventend,$scope.event_motion_value);
		
		loadeventscall();
		counttime(5)
	}

	$scope.changecamera = function(deviceid,device_name)
	{
		$scope.device_id = deviceid;
		$scope.device_name = (device_name =='All' ? 'All Cameras' : device_name);
		vdata =  eventInputs(eventDates.eventstart,eventDates.eventend,$scope.event_motion_value);
		
		loadeventscall();
		counttime(5)
	}

	$('#motion_events').on("select2:select", function(e) { 
    	vdata =  eventInputs(eventDates.eventstart,eventDates.eventend,$(this).val());
		loadeventscall();
		counttime(5)
	});

	$scope.datefilter = function()
	{
		getAlramEventWidgetFilterDate();
		setAlramEventWidgetDateTime(eventDates.eventstart,eventDates.eventend);
		$scope.inputdate = eventDates.eventstart+" - "+eventDates.eventend;
		setAlramEventWidgetFilterDate(eventDates.eventstart,eventDates.eventend);
		vdata =  eventInputs(eventDates.eventstart,eventDates.eventend,$scope.event_motion_value);
		loadeventscall();
	}

	/*
	 * ---------------------------------------------------------
	 *   Get store name
	 * ---------------------------------------------------------
	 */
	function getStoreName(storenumber)
	{
		var storeLength = $scope.storelist.length - 1;
		for (var i = storeLength; i >= 0; i--) {
			if(parseInt($scope.storelist[i].storenum) === parseInt(storenumber)){
				return $scope.storelist[i].name;
			}
		}
	}

	function renderdata(element,popluatedata){
		switch(element){
			
			case 'storelist':
				var lastrow = popluatedata[popluatedata.length - 1].id;
				var storeLength = popluatedata.length - 1;
				for (var i = storeLength; i >= 0; i--) {
					var temp = {
							storenum:popluatedata[i].storenum.trim(),
							name:popluatedata[i].name.trim(),
						}
					$scope.storelist.push(temp);
				}	

				break;
			case 'department':
				$scope.departments = popluatedata.cam_data;
				break;
			case 'videosource':
				$scope.device_source_list = popluatedata;
				$scope.event_loader = false;
				break;
			case 'event_option':
				 $scope.event_option = popluatedata.cam_data;
				break;
			case 'evetlist':
				if(popluatedata.cam_data.length != 0){
					$scope.eventlist = [];
					$scope.currentplay = [];
					$("#no-evnet").hide();
					previeweventlist = popluatedata.cam_data;
					$("#eventspiner").show();
					var lastrow = popluatedata.cam_data[popluatedata.cam_data.length - 1].id;
					$scope.lastid = lastrow;
					var eventLength = popluatedata.cam_data.length - 1;
					for (var i = 0; i <= eventLength; i++) {	
						
				 		playlistid = 1 ;//createplaylist(videoLink);
				 		var temp = {
							id:popluatedata.cam_data[i].id,
							dev_title:popluatedata.cam_data[i].dev_title.trim(),
							name:getStoreName(popluatedata.cam_data[i].location),
							location:popluatedata.cam_data[i].location,
							etype:popluatedata.cam_data[i].etype.trim(),
							dev_time:popluatedata.cam_data[i].dev_time.trim(),
							dlsaving:popluatedata.cam_data[i].dlsaving,
							starttime:popluatedata.cam_data[i].starttime.trim(),
							value:popluatedata.cam_data[i].value,
							status:popluatedata.cam_data[i].status,
							playbackurl:decodeURIComponent(popluatedata.cam_data[i].playbackurl),
							playlistid:playlistid,
							recorded:popluatedata.cam_data[i].recorded,
							downloadurl:popluatedata.cam_data[i].dwURL,
							audit:popluatedata.cam_data[i].audit
						}
						
						$scope.eventlist.push(temp);
						$scope.currentplay.push(temp);	
					}
					$scope.currentplayableitem = 0;

					eventlist.eventid = $scope.eventlist[0].id;

					previeweventlist.is_recorded = $scope.eventlist[0].recorded;
					previeweventlist.previewoutputurl = $scope.eventlist[0].playbackurl;
					previeweventlist.camname = $scope.eventlist[0].dev_title;
					previeweventlist.audit = $scope.eventlist[0].audit;
					currentevent.eventid = $scope.eventlist[0].id;
					$("#spinloader").hide();
				}
				else{
					$scope.lastid = '';
					$scope.eventlist = [];
					stop_player();
					$("#no-evnet").show();
					$("#spinloader").hide();
				}	
				break;
		
			case 'eventsaved':
				break;
			case 'event_player_option':
				break;
		}
	}

	function play_video(){
		if(previeweventlist.is_recorded == true){
			stop_player();
			preview_status(eventlist.eventid,'loading');
			jwplayer_autoload(previeweventlist.previewoutputurl)
			
		}else{
			getStreamList()	
		}
	}

	function departmentcall(){
		videodashboard.departmentlist(urllist.department)
		.then(
			function(responsedata){
				renderdata('department',responsedata)
			}
		)
	}


	function storecall(){
		videodashboard.departmentlist(urllist.storelist,storedata)
		.then(
			function(responsedata){
				renderdata('storelist',responsedata)
			}
		)
	}

	function videosourcecall(){
		videodashboard.videosourcelist(urllist.videosource,({'storenum':''}))
		.then(
			function(responsedata){
				renderdata('videosource',responsedata)
			}
		)
	}

	function loadeventscall()
	{
		$("#spinloader").show();
		videodashboard.videoeventlist(urllist.videoevent,vdata)
		.then(
			function(responsedata){
				renderdata('evetlist',responsedata);
			}
		)
	}


	/*
	 * ---------------------------------------------------------
	 *   Send link to jwplayer object
	 * ---------------------------------------------------------
	 */
 	function autoplayevent(){
 		$(".recorded_player_loader").show();	
		videoLink = videoAddress.videoIpAddress+videoAddress.alias+current_user+'.stream';
		jwplayer_autoload(videoLink);
	}

	/*
	 * ---------------------------------------------------------
	 *   Change status
	 * ---------------------------------------------------------
	 */
	function preview_status(eid,estatus)
	{
		if(estatus == 'loading'){
			$("#tr_"+eid).addClass('selected-row');
			var currentrow = $(".recorded-events-placeholder").find('tr.selected-row');
			currentrow.find("td#eventstatus").text("Loading")
			$("#c_video_"+eid).attr('data-attr',1);
		}
		else if(estatus == 'playing'){
			var currentrow = $(".recorded-events-placeholder").find('tr.selected-row');
			currentrow.find("td#eventstatus").text("Unviewed")
			currentrow.find("td a span#current_playing").addClass("icon-play")
			currentrow.find("td a span#current_playing").removeClass("icon-pause")
			$("#c_video_"+eid).attr('data-attr',0);
		  	currentrow.removeClass('selected-row')
		}
		else if(estatus == 'pause'){
			var currentrow = $(".recorded-events-placeholder").find('tr.selected-row');
			currentrow.find("td#eventstatus").text("Viewed")
			currentrow.find("td a span#current_playing").addClass("icon-play")
			currentrow.find("td a span#current_playing").removeClass("icon-pause")
			currentrow.removeClass('selected-row')
			$("#c_video_"+eid).attr('data-attr',0);
		}
		else if(estatus == 'viewed'){
			var currentrow = $(".recorded-events-placeholder").find('tr.selected-row');
			currentrow.find("td#eventstatus").text("Viewed")
			currentrow.find("td a span#current_playing").addClass("icon-play")
			currentrow.find("td a span#current_playing").removeClass("icon-pause")
			currentrow.removeClass('selected-row')
			$("#c_video_"+eid).attr('data-attr',0);
		}
	}

	/*
	 * ---------------------------------------------------------
	 *   Init jwplayer object
	 * ---------------------------------------------------------
	 */
	$scope.is_video_played = 0 ;
	function jwplayer_autoload(eventsourcelink)
	{
		console.log(eventsourcelink)
		var playerInstance = jwplayer("event-player");
		playerInstance.setup({
    		file: eventsourcelink,
    		width: '100%',
    		height:400,
    		title: "Recorded event",
    		mediaid: '123456',
  			autostart: true,
      		controls: true,
      		preload:true,
		});
		
		//baig code
		playerInstance.on('error', function() {
		  	$(".recorded_player_loader").show();
	 		theTimeout = setTimeout(function(){
 				if($scope.is_video_played < 6){
 					jwplayer_autoload(eventsourcelink);
 				}
 				else{
 					$scope.is_video_played = 0 ;
 					$scope.move_to_next();
 				}
 				$scope.is_video_played++;
			},3000);
		});

		playerInstance.on('play', function() {
			
	  		$(".recorded_player_loader").hide();
	  	 	var currentrow = $(".recorded-events-placeholder").find('tr.selected-row');
			currentrow.find("td#eventstatus").text("Playing")
			currentrow.find("td a span#current_playing").removeClass("icon-play")
			currentrow.find("td a span#current_playing").addClass("icon-pause")
	   		if(previeweventlist.is_recorded == false){
	   			$scope.countdown();
	   		}
		});

		playerInstance.onBuffer(function(){});
		playerInstance.on('complete', function(){
			saverecordingviewedcall();
			$scope.move_to_next();
		});
	}

	function stop_player()
	{
		var playerInstance = jwplayer("event-player");
		playerInstance.stop();
		$(".recorded_player_loader").hide();
	}

	/*
	 * ---------------------------------------------------------
	 *   Get stream list
	 * ---------------------------------------------------------
	 */
	function getStreamList()
	{
		try{
			videodashboard.getstreamlist(urllist.getstreams)
			.then(
				function(responsedata){
					var previewfound = getItemFound(responsedata.streamFiles);
					if(previewfound == true){
						updatePreviewStream(previeweventlist.previewoutputurl,previeweventlist.camname)
					}
					else{
						addPreviewStream();
					}
				}
			)
		}
		catch(ex){}
	}

	function getItemFound(responsedata){
		
		var isitemfound = false;
		angular.forEach(responsedata, function(value, key) {
			var pre_split = value.id;
			pre_split = pre_split.split('_');
			if(pre_split[0] == 'preview'){
				previewvideoAddress.userid = value.id;
				isitemfound = true;
			}
		});
		return isitemfound;
	}

	/*
	 * ---------------------------------------------------------
	 *   Add preview stream to db
	 * ---------------------------------------------------------
	 */
	function addPreviewStream()
	{
		try{
			videodashboard.previewstream(urllist.previewstreamurl)
			.then(function(responsedata){
			})
		}
		catch(ex){}
	}
	
	/*
	 * ---------------------------------------------------------
	 *   Update preview
	 * ---------------------------------------------------------
	 */
	function updatePreviewStream(previewoutputurl,camname)
	{
		try{
			previewoutputurl = previewoutputurl.split('?');
			videodashboard.previewupdate(urllist.updatepreviewstreamurl,({'first_part':previewoutputurl[0],'second_part':previewoutputurl[1]}))
			.then(function(responsedata){
			})
			connectPreviewStream(camname);
		}

		catch(ex){}
	}

	/*
	 * ---------------------------------------------------------
	 *   Connect preview
	 * ---------------------------------------------------------
	 */
	function connectPreviewStream(inputurl,camname)
	{
		try{
			videodashboard.previewconnect(urllist.connectpreviewstreamurl)
			.then(function(responsedata){
				
				if(eventlist.eventid != ''){
					var playersource = previewvideoAddress.videoIpAddress+previewvideoAddress.userid+".stream";
					preview_status(eventlist.eventid,'loading');
					jwplayer_autoload(playersource)
				}else{
					var playerInstance = jwplayer("event-player");
					playerInstance.stop();
				}
				
			})
		}
		catch(ex){}
	}

	  
	/*
	 * ---------------------------------------------------------
	 *   Save viewed recording
	 * ---------------------------------------------------------
	 */
	$scope.current_savefailed = 0;
	function saverecordingviewedcall()
	{
		var data = ({'eventid':eventlist.eventid})
		videodashboard.saverecordingviewed(urllist.saverecordingviewed,data)
		.then(
			function(responsedata){
				try{
					if(response.message= true){
						$scope.current_savefailed = 0;
						renderdata('eventsaved',responsedata)
					}
				}
				catch(ex){}
			}
		)
	}

	/*
	 * ---------------------------------------------------------
	 *   
	 * ---------------------------------------------------------
	 */
	function eventtypecall()
	{
		videodashboard.eventtype(urllist.eventtype)
		.then(
			function(responsedata){
				renderdata('event_option',responsedata)
			}
		)
	}

	/*
	 * ---------------------------------------------------------
	 *   Load more events
	 * ---------------------------------------------------------
	 */
	$scope.loadmore = function(nextvalue)
	{
		$scope.evenid = nextvalue;
		vdata =  eventInputs(eventDates.eventstart,eventDates.eventend);
		loadeventscall();
		return false;
	}
	
	/*
	 * ---------------------------------------------------------
	 *   Play selected video
	 * ---------------------------------------------------------
	 */
	$scope.playselectedrecording = function(selectedrecording)
	{
		$("#spinloader").removeClass('hide');
		for (var i = $scope.currentplay.length - 1; i >= 0; i--) {
	  		console.log(selectedrecording)
	  		if ($scope.currentplay[i].id == selectedrecording) {
	  			preview_status(eventlist.eventid,"playing")
	  			$scope.currentplayableitem = i;
				eventlist.eventid = $scope.currentplay[i].id;
				previeweventlist.previewoutputurl = $scope.currentplay[i].playbackurl;
				previeweventlist.camname = $scope.currentplay[i].dev_title;
				previeweventlist.is_recorded = $scope.currentplay[i].recorded;
				play_video();
				$("#spinloader").addClass('hide');
	        }
	  	};
	}

	$scope.videoaction = function(vid){
		var attr = $("#c_video_"+vid).attr('data-attr');
		if(attr == 1){
			preview_status(vid,'pause')
			stop_player();
			$scope.is_current_playing =false;
		}
		else{
			for (var i = $scope.currentplay.length - 1; i >= 0; i--) {
		  		if ($scope.currentplay[i].id == vid) {
		  			$scope.currentplayableitem = i;
		  			preview_status(eventlist.eventid,'playing')
					eventlist.eventid = $scope.currentplay[i].id;
					previeweventlist.previewoutputurl = $scope.currentplay[i].playbackurl;
					previeweventlist.camname = $scope.currentplay[i].dev_title;
					previeweventlist.is_recorded = $scope.currentplay[i].recorded;
					play_video();
					$scope.is_current_playing = true;
		        }
		  	};
		}
	}

	$scope.viewedload = function(statusvalue){
		$scope.videostatus = 'Unviewed'
		if(statusvalue == 'all'){
			$scope.videostatus = 'All'
		}
		else if(statusvalue == 1){
			$scope.videostatus = 'Viewed'
		}
		$scope.videostatusvalue = statusvalue;
		vdata =  eventInputs(eventDates.eventstart,eventDates.eventend);
		loadeventscall();
	}
	
	$scope.cameraselected = function(camnumber,videoplayernum){
		var videodata ={
			usercamer:camnumber,
			widgetnum:videoplayernum
		}
		videodashboard.savefeednum(urllist.savefeednum,videodata)
		.then(
			function(responsedata){
				
			}
		)
	}

	$scope.sourcefilter = function(sorucevalue)
	{
		videodashboard.videosourcelist(urllist.videosource,({'inputStore':sorucevalue}))
		.then(
			function(responsedata){
				renderdata('videosource',responsedata)
			}
		)
	}

	/*
	 * ---------------------------------------------------------
	 *   Recording module
	 * ---------------------------------------------------------
	 */
	function getEventVideo()
	{
		videodashboard.geteventvideo(urllist.eventvideo,eventlist)
		.then(
			function(responsedata){
				renderdata('event_player_option',responsedata)
			}
		)
	}

	/*
	 * ---------------------------------------------------------
	 *   Get month
	 * ---------------------------------------------------------
	 */
	function conventRecordDate(inputdate)
	{
		var bdate = new Date(inputdate);
		var getCurrentMonth = bdate.getMonth()+1;
		return bdate.getFullYear()+""+getCurrentMonth+""+bdate.getDate();
	}

	/*
	 * ---------------------------------------------------------
	 *   Next day
	 * ---------------------------------------------------------
	 */
	function getNextDay(inputdate,inputdays){
		var bdate = new Date(inputdate)
		bdate.setDate(bdate.getDate() + inputdays);
		return bdate.getMonth() + 1 + "/"+bdate.getDate() + "/" + bdate.getFullYear();
	}

	/*
	 * ---------------------------------------------------------
	 *   Add a minite
	 * ---------------------------------------------------------
	 */
	function getNextMint(t,tinterver)
	{
		var d = new XDate(t);
		d.addMinutes(tinterver);
	    return d.toString("hhmmss");
	}

	function findCurrentRecording(array, key, eid){ 
		
		for (var i = array.length - 1; i >= 0; i--) {
	  		if (array[i].id == eid) {
		   		currentevent.eventid = array[i].id;
		   		preview_status(array[i].id,"Playing")
		   		saverecordingviewedcall();
		   		$(".recorded_player_loader").show();
	        }
	  	};
	}

	$scope.move_to_next = function()
	{
		try{

			var current_video = $scope.currentplayableitem;
			var attr = $("#c_video_"+eventlist.eventid).attr('data-attr');
			console.log(attr,$scope.is_current_playing)
     		if(attr == 1 && $scope.is_current_playing == true){
     			//findCurrentRecording($scope.currentplay, 'id', eventlist.eventid);
     			$("#c_video_"+eventlist.eventid).attr('data-attr',0);
     			preview_status(eventlist.eventid,'viewed')
				var current_video = parseInt($scope.currentplayableitem) + 1;
	     		$scope.currentplayableitem = current_video;
				eventlist.eventid = $scope.eventlist[current_video].id;
				previeweventlist.previewoutputurl = $scope.eventlist[current_video].playbackurl;
				previeweventlist.camname = $scope.eventlist[current_video].dev_title;
				previeweventlist.is_recorded = $scope.eventlist[current_video].recorded;
				play_video()
     		}
		}
		catch(ex){}
	}

	$scope.countdown=function() {
    	var seconds = 120;
	    function tick() {
	        seconds -= 10;
	     	if( seconds > 0 && $scope.is_current_playing == true) {
	            setTimeout(tick, 10000);
	        }
	        else{
	        	try {
		     		$scope.move_to_next();        			 	
	    		}
	 			catch (ex) {}
	 		}        
    	}
    	tick();
	}
	

	$scope.reloadme = function(){
		var current_video = $scope.currentplayableitem;
		$scope.currentplayableitem = current_video++;
		eventlist.eventid = $scope.eventlist[current_video++].id;
		getEventVideo();
	}


	/*
	 * ---------------------------------------------------------
	 *   Show date picker
	 * ---------------------------------------------------------
	 */
	$("#alarm_event_date_widget").click(function(){
		$(this).hide();
		$(document).find(".widget-date-picker-container").show("slow");
		return false;
	});

	/*
	 * ---------------------------------------------------------
	 *   Hide date picker
	 * ---------------------------------------------------------
	 */
	$("#alarm_event_date_cancel").click(function(){
		$(document).find(".widget-date-picker-container").hide("slow");
		$("#alarm_event_date_widget").show();
		return false;
	});

	/*
	 * ---------------------------------------------------------
	 *   Get current time
	 * ---------------------------------------------------------
	 */
	function getMint(t)
	{
		var d = new XDate(t);
	    return d.toString("hhmmss");
	}

	loadAll();
	function loadAll(){
		storecall();
		departmentcall();
		videosourcecall();	
		loadeventscall();
		eventtypecall();
		// var current = 0;
		// var current_play = $interval(function () {
		// 	if(current == 5){
		// 		play_video();
		// 		$interval.cancel(current_play);
		// 	}
		// 	current++;
		// }, 2000);
		
	}
});

app.service('videodashboard',function($http,$q){
	return({
		departmentlist:departmentlist,
		videosourcelist:videosourcelist,
		videoeventlist:videoeventlist,
		saverecordingviewed:saverecordingviewed,
		eventtype:eventtype,
		storelist:storelist,
		savefeednum:savefeednum,
		geteventvideo:geteventvideo,
		getstreamlist:getstreamlist,
		previewstream:previewstream,
		previewupdate:previewupdate,
		previewconnect:previewconnect
	})

	function departmentlist(url)
	{
		var request = $http({
			method:'get',
			url:url,
			headers : {'Accept' : 'application/json'}
		});
		return (request.then(responseSuccess,responseFail))
	}

	function videosourcelist(url,data)
	{
		var request = $http({
			method:'get',
			url:url,
			params:data,
			headers : {'Accept' : 'application/json'}
		});

		return (request.then(responseSuccess,responseFail))
	}
	
	function videoeventlist(url,data)
	{
		var request = $http({
			method:'get',
			url:url,
			params:data,
			headers : {'Accept' : 'application/json'}
		});

		return (request.then(responseSuccess,responseFail))
	}

	function saverecordingviewed(url,data)
	{
		var request = $http({
			method:'get',
			url:url,
			params:data,
			headers : {'Accept' : 'application/json'}
		});

		return (request.then(responseSuccess,responseFail))
	}

	function storelist(url,data)
	{
		var request = $http({
			method:'get',
			url:url,
			params:data,
			headers : {'Accept' : 'application/json'}
		});

		return (request.then(responseSuccess,responseFail))
	}

	function savefeednum(url,data)
	{
		var request = $http({
			method:'post',
			url:url,
			data:data,
			headers : {'Accept' : 'application/json'}
		});

		return (request.then(responseSuccess,responseFail))
	}

	function geteventvideo(url,data)
	{
		var request = $http({
			method:'get',
			url:url,
			params:data,
			headers : {'Accept' : 'application/json'}
		});

		return (request.then(responseSuccess,responseFail))
	}

	

	function eventtype(url)
	{
		var request = $http({
			method:'get',
			url:url,
			headers : {'Accept' : 'application/json'}
		});

		return (request.then(responseSuccess,responseFail))
	}

	function getstreamlist(url)
	{
		var request = $http({
			method:'get',
			url:url,
			headers : {'Accept' : 'application/json'}
		});

		return (request.then(responseSuccess,responseFail))
	}

	function previewstream(url)
	{
		var request = $http({
			method:'get',
			url:url,
			headers : {'Accept' : 'application/json'}
		});

		return (request.then(responseSuccess,responseFail))
	}

	function previewupdate(url,data)
	{
		var request = $http({
			method:'get',
			url:url,
			params:data,
			headers : {'Accept' : 'application/json'}
		});

		return (request.then(responseSuccess,responseFail))
	}

	function previewconnect(url)
	{
		var request = $http({
			method:'get',
			url:url,
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
})