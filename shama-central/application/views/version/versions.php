<?php 
// require_header 
require APPPATH.'views/__layout/header.php';

// require_top_navigation 
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation 
require APPPATH.'views/__layout/leftnavigation.php';
?>

<div id="delete_dialog" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this item?</p>
             </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" id="save" class="btn btn-default " value="save">Yes</button>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-10" ng-controller="version_ctrl">
	<?php
		// require_footer 
		require APPPATH.'views/__layout/filterlayout.php';
	?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<label>Version</label>
		</div>
		<div class="panel-body">
			<form class="" style="padding:5px;">
				<fieldset>
		            <div class="form-group">
		            	<div class="upper-row">
                			<label class="control-label"> Version <span class="required">*</span></label>
                		</div>
                		<div class="field-row">
                			<div class="left-column">
        				   		<input type="text"  name="inputVersion" id="inputVersion" ng-model="inputVersion">
		            		</div>
		            	</div>
		            </div>
		            <div class="form-group">
		            	<div class="upper-row">
                			<label class="control-label"> Description </label>
                		</div>
                		<div class="field-row">
                			<div class="left-column">
				   		     	<textarea name="inputDescription" rows="5"  id="inputDescription" ng-model="inputDescription"></textarea>
		            		</div>
		            	</div>
		            </div>
		            <div class="form-group">
		            	<div class="upper-row">
                			<label class="control-label"> File <span class="required">*</span></label>
                		</div>
                		<div class="field-row">
                			<div class="left-column">
				   		     	<input type="file"  name="inputFile" id="inputFile" ng-model="inputFile">
		            		</div>
		            	</div>
		            </div>
		            <div class="field-container">
                		<div class="field-row">
                			<button type="button" tabindex="9" ng-click="saveversion()" class="btn btn-default save-button">Save</button>
                		</div>
                	</div>
	            </fieldset>
	        </form>

		 	<table class="table table-striped table-hover" id="table-body-phase-tow" >
                <thead>
                    <tr>
                        <th>Version</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody id="reporttablebody-phase-two" class="report-body">
                	<tr ng-repeat="s in versionlist">
                        <td>{{s.version}}</td>
                        <td>{{s.description}}</td>
                        <td><input type="radio" name="inputVersionStatus" ng-model="inputVersionStatus" value="{{s.id}}" ng-click="setCurrentVersion(s.id)"></td>
                        <td>
                            <a href="javascript:void(0)" ng-click="editversion(s.id)" title="Edit" class="edit" version-data="{{s.id}}">
                                <span aria-hidden="true" class="glyphicon glyphicon-pencil"></span>
                            </a>
                            <a href="javascript:void(0)" ng-click="removeversion(s.id)" title="Delete"  class="del" version-data="{{s.id}}">
                                <span aria-hidden="true" class="glyphicon glyphicon-remove"></span>
                            </a>    
                        </td>
                    </tr>
                </tbody>
            </table>      
		</div>
	</div>
</div>

<?php
// require_footer 
require APPPATH.'views/__layout/footer.php';
?>
<script type="text/javascript">
	var app = angular.module('invantage', []);
	app.controller('version_ctrl', function($scope, $window, $http, $document, $timeout,$interval,$compile){
		$scope.inputversionid = 0;

		var urllist = {
			getversions:"getversions",
			addversion:"saveversion",
			changeversion:"changeversion",
			removeversion:"removeversion",
		}
		// Save version
		$scope.saveversion = function()
		{
			var size, ext ;
		 	var reg = new RegExp(/^[0-9 .]{3,50}$/);
         	if(reg.test($scope.inputVersion) == false){
                jQuery("#inputVersion").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputVersion").css("border", "1px solid #C9C9C9");                                 
            }
            var data = new FormData();
	 		var files = $('input[type="file"]').get(0).files;
            file = files[0];
            if(file){
    		  	size = file.size;
	            ext = file.name.toLowerCase().trim();
	            ext = ext.substring(ext.lastIndexOf('.') + 1); 
	            ext = ext.toLowerCase();
	            var validExt = ["apk","png"];
	           	if($.inArray(ext,validExt) == -1){
	                message("Please must upload text file","show");
	                return false;
	            }
	            else{
	                message("","hide");
	            }
	            $.each($("#inputFile")[0].files,function(key,value){
	                data.append("appfile",value);
	            });
            }
           	
            data.append('<?php echo $this->security->get_csrf_token_name(); ?>','<?php echo $this->security->get_csrf_hash(); ?>');
            data.append('inputversion',$scope.inputVersion);
            data.append('inputdescription',$scope.inputDescription);
            data.append('inputversionid',$scope.inputversionid);
			
			$.ajax({
                url: urllist.addversion,
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                mimeType:"multipart/form-data",
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data) {
                	if(data.message == true)
                	{
               			$("#inputFile").val('')
               			$("#inputVersion").val('')
               			$("#inputDescription").val('')
               			viewversionlist()
                	}
                }
            });
            return false;		     
		}

		angular.element(function () {
			viewversionlist();
		});
		
		function viewversionlist()
		{
			try{
				httprequest(urllist.getversions,({})).then(function(response){
					if(response != null && response.length > 0)
					{
						$scope.versionlist = response;
						var cont_str = '';
						for (var i = 0; i < response.length; i++) {
							if(response[i].status == 'a'){
								$scope.inputVersionStatus = response[i].id	
							}
						}
					}
				});
			}
			catch(ex){}
			
		}

		$scope.editversion = function(versionid)
		{
			try{
				httprequest(urllist.getversions,({inputversionid:versionid})).then(function(response){
					if(response != null && response.length > 0)
					{
						$scope.inputversionid = response[0].id;
						$scope.inputVersion = response[0].version;
						$scope.inputDescription = response[0].description;
					}
				});
			}
			catch(ex){}
		}

		$scope.setCurrentVersion = function(versionid)
		{
			try{
        	 	$scope.inputVersionStatus = versionid
			 	var data = ({
                    inputsetcurrentversion:parseInt($scope.inputVersionStatus)
                })

                httppostrequest(urllist.changeversion,data).then(function(response){
                    if(response != null && response.message == true) 
                    {
                        message('Version set','show')

                    }
                    else{
                    	message('Version not set','show')
                    }
                });
			}
			catch(ex){}
		}

		  $scope.removeversion = function(sessionid)
        {
            $("#delete_dialog").modal('show');
            $scope.semesterid = sessionid
        }
        
        $(document).on('click','#save',function(){
            $("#delete_dialog").modal('hide');
            var data = ({
                inputversionid:$scope.semesterid
            })

           httprequest(urllist.removeversion,data).then(function(response){
                if(response != null)
                {
                   message('Version removed','show')
                   viewversionlist()
                   $scope.semesterid = 0
                }else{
            	 	message('Version not remove','show')
                 
                   $scope.semesterid = 0
                }
            });
        });

		 function httprequest(url,data)
        {
            var request = $http({
                method:'get',
                url:url,
                params:data,
                headers : {'Accept' : 'application/json'}
            });
            return (request.then(responseSuccess,responseFail))
        }

        function httppostrequest(url,data)
        {
            var request = $http({
                method:'POST',
                url:url,
                data:data,
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
</script>