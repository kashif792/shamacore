// Dashboard

var widgetUrlList = {
	st:"<?php echo $path_url; ?>api/getDashboardSalesReport/format/json",
	cu:"<?php echo $path_url; ?>api/getDashboardCustomerReport/format/json",
	py:"<?php echo $path_url; ?>api/getDashboardPayrollReport/format/json",
	gm:"<?php echo $path_url; ?>api/getDashboardGrossMarginReport/format/json",
	spc:"<?php echo $path_url; ?>api/getDashboardSalesPerCustomerReport/format/json",
	tt:"<?php echo $path_url; ?>api/getDashboardTenderTypesReport/format/json"
}

/*
 * ---------------------------------------------------------
 *   Change store name
 * ---------------------------------------------------------
 */
function changeStoreName (inputElement,storevalue) {
	$("#"+inputElement).text(storevalue);
}
/*
 * ---------------------------------------------------------
 *   Function populate data
 * ---------------------------------------------------------
 */
function populatedata (selectedwidget) {
	switch(selectedwidget){
    	case 'st':
    		urlpath = widgetUrlList.st;
    		changeStoreName ("sales-storenum",$(this).attr('data-view').trim());
    		ajaxfunc(urlpath,storenumdata,dashboardSalesFail,generalSalesResponse);
    		google.charts.setOnLoadCallback(drawSalesChart());
    	break;

    	case 'cu':
    		urlpath = widgetUrlList.cu;
    		changeStoreName ("customer-storenum",$(this).attr('data-view').trim());
    		ajaxfunc(urlpath,storenumdata,dashboardCustomerFail,getCustomerResponse);
			google.charts.setOnLoadCallback(drawCustomerChart());
		break;

    	case 'py':
    		urlpath = widgetUrlList.py;
    		changeStoreName ("payroll-storenum",$(this).attr('data-view').trim());
    		ajaxfunc(urlpath,storenumdata,dashboardPayrollFail,getPayrollResponse);
			google.charts.setOnLoadCallback(drawPayrollChart());
    	break;

    	case 'gm':
    		urlpath = widgetUrlList.gm;
    		changeStoreName ("gm-storenum",$(this).attr('data-view').trim());
    		ajaxfunc(urlpath,storenumdata,dashboardGMarginFail,getGrossMargin);
    		google.charts.setOnLoadCallback(drawGrossMarginChart());
    	break;

    	case 'spc':
    		urlpath = widgetUrlList.spc;
    		changeStoreName ("spc-storenum",$(this).attr('data-view').trim());
			ajaxfunc(urlpath,storenumdata,dashboardSPCustomerFail,getSalesPerPerson);
    		google.charts.setOnLoadCallback(drawSalesPerCustomerChart());
    	break;

    	case 'tt':
    		urlpath = widgetUrlList.tt;
    		changeStoreName ("tt-storenum",$(this).attr('data-view').trim());
			ajaxfunc(urlpath,storenumdata,dashboardTTypesFail,getTenderType);
    		google.charts.setOnLoadCallback(drawTenderTypesChart());
    	break;

    	case 'tf':
    		$("#tf").attr('data-view',$(this).attr('data-view').trim());
    		changeStoreName ("topfive-storenum",$(this).attr('data-view').trim());
			google.charts.setOnLoadCallback(topFiveDepartment($("#current-top-active").attr('data-view'),$(this).attr('data-view').trim(),$("#inputFromDate").val(),$("#inputToDate").val()));
    	break;
    }
}

/*
 * ---------------------------------------------------------
 *   Get data according to store filter
 * ---------------------------------------------------------
 */
$(document).on('click','#store_value',function(){
    var storenumdata = ({ 
			'storenum' : $(this).attr('data-view').trim(),
			'datefrom':reportdata.sdate,
			'dateto':reportdata.edate
    	}); 

	$(this).parent().parent().parent().find('span#user-selected-data-storenum-option').text($(this).attr('data-view').trim());
	var selectDataType = $(this).parent().parent().parent().find('a.widget-option-click').attr('id');				
   	$(this).parent().eq(11).find('div.widget-body div.loader-container').show();
    populatedata (selectDataType)
    $(this).parent().eq(11).find('div.widget-body div.loader-container').fadeOut();   
	$(document).find('div.widget-option-popup').hide();
	return false;
});
		
/*
 * ---------------------------------------------------------
 *   Get data according to date filter
 * ---------------------------------------------------------
 */	
$(document).on('submit','#user-date-form',function(){
	getFilterDate();
	setDateTime(reportdata.sdate,reportdata.edate);
	
	$(".date-picker-container").hide();
	$("#date").show();
	
	$(".loader-container").show();
	
	getDashboardSalesReport(); 
 	getDashboardCustomerReport();
 	getDashboardPayrollReport();
 	getDashboardGrossMarginReport();
 	getDashboardSalesPerPersonReport();
 	getDashboardTenderTypesReport();
		google.charts.setOnLoadCallback(drawSalesChart());
		google.charts.setOnLoadCallback(drawCustomerChart());
		google.charts.setOnLoadCallback(drawPayrollChart());
		google.charts.setOnLoadCallback(drawGrossMarginChart());
	 	google.charts.setOnLoadCallback(drawSalesPerCustomerChart());
	 	google.charts.setOnLoadCallback(drawTenderTypesChart());
		google.setOnLoadCallback(topFiveDepartment("Department","",reportdata.sdate,reportdata.edate));
		$(".loader-container").fadeOut();
		return false;
}) ;

$(document).on('submit','#widget-date-data',function(){
	getWidgetFilterDate();
	setWidgetDateTime(reportdata.wsdate,reportdata.wedate);
	
	$(".widget-date-picker-container").hide();
	$("#widget-date").show();
	var attrval = $("#current-top-active").attr('data-view').trim();
	$(this).parent().eq(11).find('div.widget-body div.loader-container').show();
 	google.setOnLoadCallback(topFiveDepartment(attrval,$("#tf").attr('data-view').trim(),reportdata.wsdate,reportdata.wedate));
  	$(this).parent().eq(11).find('div.widget-body div.loader-container').fadeOut();

	return false;
}) ;
