  
    app.controller('schCtrl',['$scope','$myUtils', schCtrl]);

    function schCtrl($scope, $myUtils) {

        $scope.isPrincipal = false;
        $scope.isTeacher = false;
        $scope.isAdmin = false;

        if(!$myUtils.checkUserAuthenticated()){
            console.log('User not authenticated!');
            return;
        }
        
        //console.log('User ' + $myUtils.userId + ' authenticated!');

        $scope.baseUrl = '<?php echo base_url() ?>'

        $scope.user_id = $myUtils.getUserId();
        $scope.name = $myUtils.getUserName();
        $scope.email = $myUtils.getUserEmail();
        $scope.roles = $myUtils.getUserRoles();
        $scope.school_id = $myUtils.getDefaultSchoolId();
        $scope.session_id = $myUtils.getDefaultSessionId();

        if($myUtils.getUserProfileImage()){
            $scope.profileImage = $myUtils.getUserProfileImage();
        }

        if($myUtils.getUserProfileThumb()){
            $scope.profileThumb = $myUtils.getUserProfileThumb();
        }
        
        $scope.roles = $myUtils.getUserRoles();
        
        $scope.schoolName = '';
        if($myUtils.getUserLocations().length){
            $scope.schoolName = $myUtils.getUserLocations()[0].schoolname;
        }

        $scope.type = $myUtils.getUserType();

        $scope.role_id = $myUtils.getUserDefaultRoleId();

        $scope.isPrincipal = $myUtils.isPrincipal();
        $scope.isTeacher = $myUtils.isTeacher();
        $scope.isAdmin = $myUtils.isAdmin();

        $scope.shama_api_path = $('#shama_api_path').val();


  	function setsessiondate() {
  		$('#sessiondate').daterangepicker({
  			"autoApply": true,
  			"showDropdowns": true,
  			"startDate": $scope.startdate,
  			"endDate": $scope.enddate,
  			"minDate": $scope.startdate
  		});
  	}

  	/**
  	 * ---------------------------------------------------------
  	 *   load table
  	 * ---------------------------------------------------------
  	 */
  	function loaddatatable() {
  		$('#table-body-phase-tow').DataTable({
  			responsive: true,
  			"order": [
  				[0, "asc"]
  			],
  		});
  	}

  	var urllist = {
            getclasslist:$scope.shama_api_path+'classes',
            getsemesterdata:$scope.shama_api_path+'default_semester',
            getschedular:$scope.shama_api_path+'lesson_sets',
            //getschedular:$scope.shama_api_path+'semester_lesson_plan',
  		      saveschedular:$scope.shama_api_path+'lesson_sets'
  	}

  	angular.element(function() {
  		getclasslist()

  	});

  	function getclasslist() {

                var data = ({
                    school_id:$scope.school_id,
                    session_id:$scope.session_id,
                    user_id:$scope.user_id
                })

  		$myUtils.httprequest(urllist.getclasslist, data).then(function(response) {
  			if (response != null && response.length > 0) {
  				$scope.classlist = response
  				$scope.select_class = response[0]
  				getSemesterData();
  			}
  		});
  	}

  	function getSemesterData() {
  		try {

                var data = ({
                    school_id:$scope.school_id,
                    session_id:$scope.session_id,
                    user_id:$scope.user_id
                })

  			$myUtils.httprequest(urllist.getsemesterdata, data).then(function(response) {
  				if (response.length > 0 && response != null) {
  					$scope.semesterlist = response;

            var found = 0;
            for (var i = 0; i < response.length; i++) {
                if(response[i].status == 'a')
                {
                     $scope.inputSemester = response[i];
                     var found = 1;
                }
            }

            if(!found){
  					 $scope.inputSemester = response[0];
            }
  					getschedular()
  				} else {
  					$scope.semesterlist = [];
  				}
  			})
  		} catch (ex) {}
  	}

  	$scope.changeclass = function() {
  		getschedular()
  	}

  	$scope.changesemester = function() {
  		getschedular()
  	}

  	$scope.schedular = []

  	function getschedular() {
  		try {
  			var data = ({
                    user_id:$scope.user_id,
                    school_id:$scope.school_id,
                    session_id:$scope.session_id,
                    class_id:$scope.select_class.id,
                    semester_id:$scope.inputSemester.id
  			})
        message('','hide')
  			$myUtils.httprequest(urllist.getschedular, data).then(function(response) {

  				var appstr = '';

  				if (response.length > 0 && response != null) {

  					$scope.schedular = response

  					setId = '';
            setNum = 0;
            for (var i = 0; i < response.length; i++) {
              
              var lesson = response[i];
  						var subjectarray = [];

              if(setId != lesson.set_id){
                
                if(appstr.length>0){
                  appstr += '</ol></li>'
                }
                setNum++;
                appstr += '<li id="' + lesson.set_id +'" data-group-id="' + lesson.set_id + '" data-changed="false" ><div>';
                appstr += ('Set #' + setNum);
                appstr += '</div><ol>';
              }

              setId = lesson.set_id;

                
  							var lessondetail = [];

  								var icon = '<i class="fa fa-picture-o" aria-hidden="true"></i>';

  								if (lesson.type == 'Video') {
  									var icon = '<i class="fa fa-video-camera" aria-hidden="true"></i>';
  								}

  								if (lesson.type == 'Text') {
  									var icon = '<i class="fa fa-file-text-o" aria-hidden="true"></i>';
  								}

  								if (lesson.type == 'Document') {
  									var icon = '<i class="fa fa-file-word-o" aria-hidden="true"></i>';
  								}

  								if (lesson.type == 'Application') {
  									var icon = '<i class="fa fa-tablet" aria-hidden="true"></i>';
  								}

  								appstr += '<li id="menuItem_' + i + '" data-view-id="menuItem_' + i + '" data-position-id="'+lesson.preference+'" data-changed=false data-lesson-id="' + lesson.id + '" data-set-id="' + lesson.set_id + '"><div>' + icon + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + lesson.topic + ' &nbsp;&nbsp;(' + lesson.subject_name + ')' + '</div></li>';
  						
  					}

            if(appstr.length>0){
              appstr += '</ol></li>'
            }

  					$(".sortable").html('')
  					$(".sortable").html(appstr)
            document.getElementById("btnReload").disabled = false;
  					createlist()
  				} else {
            document.getElementById("btnReload").disabled = true;
            $(".sortable").html('')
            $(".sortable").html(appstr)
            message('No lesson found','show')
  					
  				}
  			})

  		} catch (ex) {}
  	}


  	function createlist() {

      var ns = $('ol.sortable').nestedSortable({
                forcePlaceholderSize: true,
                handle: 'div',
                helper: 'clone',
                items: 'li',
                opacity: .6,
                placeholder: 'placeholder',
                revert: 250,
                tabSize: 25,
                tolerance: 'pointer',
                toleranceElement: '> div',
                maxLevels: 4,
                isTree: true,
                expandOnHover: 700,
                startCollapsed: false,
                isAllowed: function (placeholder, placeholderParent, currentItem) 
                { 
                  //console.log(placeholder, placeholderParent, currentItem);
                  return true; 
                },
                update: function ( event, ui ) 
                {
                  console.log(ui);
                  //console.log(ui.item[0].dataset);
                  if(ui.item.length>0){
                    if(ui.item[0].dataset.viewId != null){
                      $('#'+ui.item[0].dataset.viewId).attr("data-changed", true);
                    }else if(ui.item[0].dataset.groupId != null){
                      $('#'+ui.item[0].dataset.groupId).attr("data-changed", true);
                    }
                  }
                  //console.log(ui.item[0]);
                },
  			// custom classes
  			branchClass: "mjs-nestedSortable-branch",
  			collapsedClass: "mjs-nestedSortable-collapsed",
  			disableNestingClass: "mjs-nestedSortable-no-nesting",
  			errorClass: "mjs-nestedSortable-error",
  			expandedClass: "mjs-nestedSortable-expanded",
  			hoveringClass: "mjs-nestedSortable-hovering",
  			leafClass: "mjs-nestedSortable-leaf",
  			disabledClass: "mjs-nestedSortable-disabled"
  		});
    }

  	function findlesson(lessonname, iindex, kindex) {
  		for (var i = iindex; i < $scope.schedular.length; i++) {
  			for (var k = kindex; k < $scope.schedular[i].lesson.length; k++) {
  				for (var l = 0; l < $scope.schedular[i].lesson[k].lessondetail.length; l++) {
  					if (lessonname == $scope.schedular[i].lesson[k].lessondetail[l].name) {
  						return $scope.schedular[i].lesson[k].lessondetail[l].name
  					}
  				}
  			}
  		}
  	}

  	function findsubject(subjectname, inx) {
  		for (var i = inx; i < $scope.schedular.length; i++) {
  			for (var k = 0; k < $scope.schedular[i].lesson.length; k++) {
  				if (subjectname == $scope.schedular[i].lesson[k].subject) {
  					return $scope.schedular[i].lesson[k].subid
  				}
  			}
  		}
  	}

  	$scope.saveschedular = function() {
  		var $this = $("#btnReload");
  		$this.button('loading');

  		var finallist = []
      var position = 1;
      var new_set_id = 0;
      var group_changed;

  		$("ol.sortable li").each(function() {
  			var schedularlist = []
          var lesson_id = $(this).attr('data-lesson-id');
          var set_id = $(this).attr('data-set-id');
          var group_id = $(this).attr('data-group-id');
          var changed = $(this).attr('data-changed');

          if(null != group_id){
            new_set_id = group_id;
            group_changed = changed;
          }

          //console.log(new_set_id, lesson_id, group_changed, changed);
          if(null != lesson_id && null != set_id){

            //if(changed == 'true' || group_changed == 'true'){
        			var temp = {
                lesson_id: lesson_id,
                set_id: set_id,
                new_set_id: new_set_id,
        				preference: position,
        			}
        			finallist.push(temp)
            //}

            position++;
          }
  		})

  		var data = ({
  			class_id: $scope.select_class.id,
  			semester_id: $scope.inputSemester.id,
        session_id: $scope.session_id,
        user_id: $scope.user_id,
  			data: finallist
  		})
  		message("", 'hide');
  		$myUtils.httppostrequest(urllist.saveschedular, data).then(function(response) {
  			if (response.message == true && response != null && response != undefined) {
  				message("Records saved", 'show');
  				$this.button('reset');
  			} else {
  				message("Records not saved", 'show');
  				$this.button('reset');
  			}
  		});

  	}
  }
