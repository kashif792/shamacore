	var app = angular.module('invantage', ['googlechart','ngAnimate','objectTable','atomic-notify']);
app.config(['atomicNotifyProvider', function(atomicNotifyProvider){ 
     atomicNotifyProvider.setDefaultDelay(5000);
}])

app.controller('report', function($scope,report_details,$filter,atomicNotifyService,$timeout) {
	
	$scope.startdate = '9/10/2014' //getUrlVars()["startDate"]
	$scope.enddate = '9/10/2016' //getUrlVars()["endDate"]
	$scope.location = $scope.location ; //decodeURIComponent(getUrlVars()["report_location"]report_name = getUrlVreport_name"]
	var report_name = getUrlVars()["report_name"]; 	
	$scope.cobj = 'Table';
	$scope.report_text = '';
	$scope.creport = '';
	$scope.dates1 = { startDate: moment('2013-09-20'), endDate: moment('2013-09-25') };
	function reportdata()
	{
		$scope.reportdata ={
			dailysalesreport:{
				startdate: $scope.startdate,
				enddate: $scope.enddate,
				storenum: $scope.location,
			},
			tenderreport:{
				startdate: $scope.startdate,
				enddate: $scope.enddate,
				storenum: $scope.location,
			},
			departmentreport:{
				startdate: $scope.startdate,
				enddate: $scope.enddate,
				storenum: $scope.location,
			},
			stationreport:{
				startdate: $scope.startdate,
				enddate: $scope.enddate,
				storenum: $scope.location,
			},
			cashierreport:{
				startdate: $scope.startdate,
				enddate: $scope.enddate,
				storenum: $scope.location,
			},
			zerosalereport:{
				startdate: $scope.startdate,
				enddate: $scope.enddate,
				storenum: $scope.location,
			},
			negativebalancereport:{
				startdate: $scope.startdate,
				enddate: $scope.enddate,
				storenum: $scope.location,
			},
			inactivereport:{
				startdate: $scope.startdate,
				enddate: $scope.enddate,
				storenum: $scope.location,
			}
		}
	} 
	
	var urllist = {
		department:'api/department_list/format/json',
		category:'api/category_list/format/json',
		vendor:'api/vendorname_list/format/json',
		dailysalesreport:'api/sales_report/format/json',
		tenderreport:'api/tenders_report/format/json',
		departmentreport:'api/departments_specific_report/format/json',
		stationreport:'api/stations_report/format/json',
		cashierreport:'api/cashiers_report/format/json',
		zerosalereport:'api/zero_sales_report/format/json',
		negativebalancereport:'api/negative_balance_sales_report/format/json',
		inactivereport:'api/inactive_sales_report/format/json'
	}

	function consoutput(cout){
		console.log(cout)
	}

	function renderdata(element,popluatedata){
		$scope.ploader = true;
		switch(element){
			case 'departments':
				$scope.departments = popluatedata;
				break;
			case 'categoies':
				$scope.categoies = popluatedata;
				break;
			case 'vendors':
				$scope.vendors = popluatedata;
				break;
			case 'dsr':
				$scope.creport = 'dsr';
				$scope.inventory_disabled = true;
				$scope.report_text = "Daily Sales Report";
				dailysalesreportresponse(popluatedata)
				break;
			case 'dtr':
				$scope.creport = 'dtr';
				$scope.inventory_disabled = true;
				$scope.report_text = "Tender Report";
				createtable(popluatedata)
				createchart(popluatedata);
				break;
			case 'dpr':
				$scope.creport = 'dpr';
				$scope.inventory_disabled = true;
				$scope.report_text = "Department Report";
				createtable(popluatedata)
				createchart(popluatedata);
				break;
			case 'sr':
				$scope.creport = 'sr';
				$scope.inventory_disabled = true;
				$scope.report_text = "Station Report";
				createtable(popluatedata)
				createchart(popluatedata);
				break;
			case 'cr':
				$scope.creport = 'cr';
				$scope.inventory_disabled = true;
				$scope.report_text = "Cashier Report";
				createtable(popluatedata)
				createchart(popluatedata);
				break;
			case 'zsr':
				$scope.creport = 'zsr';
				$scope.inventory_disabled = false;
				$scope.report_text = "Zero Sales Report";
				createtable(popluatedata)
				break;
			case 'nbr':
				$scope.creport = 'nbr';
				$scope.inventory_disabled = false;
				$scope.report_text = "Negative Balance Inventory Report";
				createtable(popluatedata)
				break;
			case 'iar':
				$scope.creport = 'iar';
				$scope.inventory_disabled = false;
				$scope.report_text = "In-Active Inventory Items Report";
				createtable(popluatedata)
				break;
		}
		$scope.ploader = false;
	}

	$scope.change_chart = function(value){
		$scope.chart_type = value;
		var charobj = titleCase(value);
		$scope.cobj = charobj.replace(/\s+/g, '');
		if(report_name == 'dtr'){
			tenderreportcall();
		}

		if(report_name == 'dpr'){
			departmentreportcall();
		}

		if(report_name == 'sr'){
			stationreportcall();
		}

		if(report_name == 'cr'){
			cashierreportcall();
		}
	}

	function titleCase(str) {
   		var splitStr = str.toLowerCase().split(' ');
	   	for (var i = 0; i < splitStr.length; i++) {
	       splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
	   }
	   // Directly return the joined string
	   return splitStr.join(' '); 
	}


	$scope.showfilterdate = function(value)
	{
 		$scope.datefilter = value;
 	}

 	$scope.report_change = function(value)
 	{
 		report_name = value;
 		loadreport();
 	}

	$scope.report_store = function(value)
 	{
 		$scope.location = value;
 		loadreport();
 	}
 	
 	function dailysalesreportresponse(resulttable)
 	{
 		$scope.totalInvocie = $filter('currency')(resulttable[0].INVOICE,"");
 		$scope.totalTenders = $filter('currency')(resulttable[0].TENDER,"");
 		$scope.change = $filter('currency')(resulttable[0].MONBACK,"");
 		$scope.cashPayout = $filter('currency')(resulttable[0].PAYOUT,"");
 		$scope.customeraccountcash = $filter('currency')(resulttable[0].POACASH,"");
 		$scope.customeraccountcrdcard = $filter('currency')(resulttable[0].POACC,"");
 		$scope.customeraccountchecks = $filter('currency')(resulttable[0].POACHK,"");
 		$scope.customeraccountdiscount = $filter('currency')(resulttable[0].POADISC,"");
 		$scope.serviceTaxed = $filter('currency')(resulttable[0].SERVICE,"");
 		$scope.totalGoods = $filter('currency')(resulttable[0].TOTAL,"");
 		$scope.goodsTaxed = $filter('currency')(resulttable[0].GOODS,"");
 		$scope.goodsNotTaxed = $filter('currency')(resulttable[0].NOTAX,"");

 		$scope.service = $filter('currency')(resulttable[0].SERVICE,"");
 		$scope.serviceNotTaxed = $filter('currency')(resulttable[0].SNOTAX,"");
 		$scope.cogs = $filter('currency')(resulttable[0].COST,"");
 		$scope.subtotal = $filter('currency')(resulttable[0].SUBTOT,"");
 		$scope.shipping = $filter('currency')(resulttable[0].SHIPPING,"");

 		$scope.saleDiscount = $filter('currency')(resulttable[0].SALEDISC,"");
 		$scope.salesCash = $filter('currency')(resulttable[0].POACASH,"");
 		$scope.salesCheck = $filter('currency')(resulttable[0].PCHECK,"");
 		$scope.travelCheque = $filter('currency')(resulttable[0].TRAVCHCK,"");
 		$scope.creditcard1 = $filter('currency')(resulttable[0].CARDTYPE1,"");
 		$scope.coupons = $filter('currency')(resulttable[0].COUPONS,"");
 		$scope.debitcard = $filter('currency')(resulttable[0].CARDTYPE2,"");
 		$scope.goodsTaxes = $filter('currency')(resulttable[0].TAX1,"");
 		$scope.grandTotal = $filter('currency')(resulttable[0].GRANDTOT,"");
 		$scope.deposit = $filter('currency')(resulttable[0].DEPOSIT,"");
 		$scope.depositTotal = $filter('currency')(resulttable[0].DEPOSIT,"");
 		$scope.cods = $filter('currency')(resulttable[0].COD,"");
 		$scope.charges = $filter('currency')(resulttable[0].CHARGE,"");
 		
 		$scope.giftCard = $filter('currency')(resulttable[0].GIFTCERT,"");
 		$scope.soldCard = $filter('currency')(resulttable[0].SOLDCERT,"");
 		$scope.prepays = $filter('currency')(resulttable[0].PREPAY,"");
 		$scope.tax1 = $filter('currency')(resulttable[0].TAX1,"");
 		$scope.tax2 = $filter('currency')(resulttable[0].TAX2,"");
 		$scope.tax3 = $filter('currency')(resulttable[0].TAX3,"");
 		$scope.tax4 = $filter('currency')(resulttable[0].TAX4,"");
 		$scope.tax5 = $filter('currency')(resulttable[0].TAX5,"");
 		$scope.grandTotal = $filter('currency')(resulttable[0].GRANDTOT,"");
 		$scope.deposit = $filter('currency')(resulttable[0].DEPOSIT,"");
 		$scope.depositTotal = $filter('currency')(resulttable[0].DEPOSIT,"");
 		$scope.cods = $filter('currency')(resulttable[0].COD,"");
 		$scope.charges = $filter('currency')(resulttable[0].CHARGE,"");

 		$scope.serviceTax1 = $filter('currency')(resulttable[0].STAX1,"");
 		$scope.serviceTax2 = $filter('currency')(resulttable[0].STAX2,"");
 		$scope.serviceTax3 = $filter('currency')(resulttable[0].STAX3,"");
 		$scope.serviceTax4 = $filter('currency')(resulttable[0].STAX4,"");
 		$scope.serviceTax5 = $filter('currency')(resulttable[0].STAX5,"");
 		$scope.storeCredits = $filter('currency')(resulttable[0].STORECRDT,"");
 		
 		var totalAllSalesTax = parseFloat(resulttable[0].GIFTCERT)+parseFloat(resulttable[0].STORECRDT)+parseFloat(resulttable[0].PREPAY)+parseFloat(resulttable[0].DEPOSIT)+parseFloat(resulttable[0].SOLDCERT)+parseFloat(resulttable[0].TAX1)+parseFloat(resulttable[0].TAX2)+parseFloat(resulttable[0].TAX3)+parseFloat(resulttable[0].TAX4)+parseFloat(resulttable[0].TAX5)+parseFloat(resulttable[0].STAX1)+parseFloat(resulttable[0].STAX2)+parseFloat(resulttable[0].STAX3)+parseFloat(resulttable[0].STAX4)+parseFloat(resulttable[0].STAX5);
 		$scope.totalAllSalesTax = $filter('currency')(totalAllSalesTax,"");
 		$scope.grossProfit = $filter('currency')(resulttable[0].COST + resulttable[0].SERVICE ,"");
 		
 		var salesTotal = parseFloat(resulttable[0].SALEDISC) + parseFloat(resulttable[0].CASH) + parseFloat(resulttable[0].PCHECK)  + parseFloat(resulttable[0].COD) + parseFloat(resulttable[0].TRAVCHCK) + parseFloat(resulttable[0].CRDCARD1) + parseFloat(resulttable[0].CRDCARD2) + parseFloat(resulttable[0].CHARGE) + parseFloat(resulttable[0].COUPONS);

 		$scope.salesTotal = $filter('currency')(salesTotal,"");
 		$scope.despositCash = $filter('currency')(resulttable[0].DCASH,"");
 		$scope.depositCheck = $filter('currency')(resulttable[0].DCHECK,"");
 		$scope.depositCC = $filter('currency')(resulttable[0].DCC,"");
 		$scope.depositSaved = $filter('currency')(resulttable[0].DEPOSIT,"");

 		$scope.savedInvoices = $filter('currency')(resulttable[0].REGSTAT,"");
 		$scope.returnCash = $filter('currency')(resulttable[0].RCASH,"");
 		$scope.returnCheck = $filter('currency')(resulttable[0].RPCHECK,"");
 		$scope.returnStoreCredit = $filter('currency')(resulttable[0].RSTORECRD,"");
 		$scope.returnCharge = $filter('currency')(resulttable[0].RCHARGE,"");
 		$scope.returnCC = $filter('currency')(resulttable[0].RCRDCARD1,"");
 		$scope.returnCC2 = $filter('currency')(resulttable[0].RCRDCARD2,"");

 		$scope.returnTax1 = $filter('currency')(resulttable[0].RTAX1,"");
 		$scope.returnTax2 = $filter('currency')(resulttable[0].RTAX2,"");
 		$scope.returnTax3 = $filter('currency')(resulttable[0].RTAX3,"");
 		$scope.returnTax4 = $filter('currency')(resulttable[0].RTAX4,"");
 		$scope.returnTax5 = $filter('currency')(resulttable[0].RTAX5,"");
 		
 		var totalReturnTax = parseFloat(resulttable[0].RTAX1)+parseFloat(resulttable[0].RTAX2)+parseFloat(resulttable[0].RTAX3)+parseFloat(resulttable[0].RTAX4)+parseFloat(resulttable[0].RTAX5);
 		$scope.totalReturnTax = $filter('currency')(totalReturnTax,"");
 	}

 	function createtable(resulttable)
 	{
 		if(report_name == 'dtr'){
	 		$scope.tenderDataVariable = [];
 			for (var i = resulttable.length - 1; i >= 0; i--) {	
	 			var temp = {
	 				location:resulttable[i].storenum,
	 				cash:$filter('currency')(resulttable[i].CASH,"") ,
	 				cheque:$filter('currency')(resulttable[i].PCHECK,""),
	 				credit:$filter('currency')(resulttable[i].CRDCARD1 + resulttable[i].CRDCARD2,""),
	 				coupons:$filter('currency')(resulttable[i].COUPONS,""),
	 				giftcert:resulttable[i].GIFTCERT,
	 				avgsale:$filter('currency')(resulttable[i].TOTAL / resulttable[i].INVOICE,""),
	 				avgitem:$filter('currency')(resulttable[i].INTOTAL / resulttable[i].INQTY,"")
	 			}
	 			$scope.tenderDataVariable.push(temp);
 			}
 		}	
		if(report_name == 'dpr'){
			$scope.departmentDataVariable = [];
			for (var i = resulttable.length - 1; i >= 0; i--) {	
	 			var temp = {
	 				depart:resulttable[i].depart,
	 				sales:$filter('currency')(resulttable[i].sales,"") ,
	 				qty:$filter('currency')(resulttable[i].qty,""),
	 				avg:$filter('currency')(resulttable[i].sales / resulttable[i].qty,""),
	 				profit:$filter('currency')(resulttable[i].sales / resulttable[i].cost,"")
	 			}
	 			$scope.departmentDataVariable.push(temp);
 			}
 		}	
		if(report_name == 'sr'){
			$scope.stationDataVariable = [];

			for (var i = resulttable.length - 1; i >= 0; i--) {	
	 			var temp = {
	 				location:resulttable[i].storenum,
	 				station:resulttable[i].sname,
	 				total:$filter('currency')(resulttable[i].TOTAL,"") ,
	 				tax:$filter('currency')(resulttable[i].TAX1,""),
	 				netsales:$filter('currency')(resulttable[i].TOTAL / resulttable[i].TAX1,"",4)
	 			}
	 			$scope.stationDataVariable.push(temp);
 			}
 		}
 		if(report_name == 'cr'){
			$scope.cashierDataVariable = [];
			for (var i = resulttable.length - 1; i >= 0; i--) {	
	 			var temp = {
	 				location:resulttable[i].storenum,
	 				cashier:resulttable[i].name,
	 				total:$filter('currency')(resulttable[i].totalsales,"") ,
	 				tax:$filter('currency')(resulttable[i].taxcollected,""),
	 				netsales:$filter('currency')(resulttable[i].totalsales / resulttable[i].taxcollected,"",4)
	 			}
	 			$scope.cashierDataVariable.push(temp);
 			}
 		}
 		if(report_name == 'zsr'){
			$scope.zerosalesDataVariable = [];
			for (var i = resulttable.length - 1; i >= 0; i--) {	
	 			var temp = {
	 				itemid:resulttable[i].PRODID,
	 				desc:resulttable[i].DESCRIPT,
	 				vendor:resulttable[i].VENDOR,
	 				cost:$filter('currency')(resulttable[i].COST,""),
	 				qtyonhand:$filter('currency')(resulttable[i].QTYONHAND,""),
	 				sold:$filter('currency')(resulttable[i].SOLD,"")
	 			}
	 			$scope.zerosalesDataVariable.push(temp);
 			}
 		}
 		if(report_name == 'nbr'){
			$scope.negativebalancesalesDataVariable = [];
			for (var i = resulttable.length - 1; i >= 0; i--) {	
	 			var temp = {
	 				itemid:resulttable[i].PRODID,
	 				desc:resulttable[i].DESCRIPT,
	 				bcode:resulttable[i].BCODE,
	 				qtyonhand:$filter('currency')(resulttable[i].QTYONHAND,"")
	 			}
	 			$scope.negativebalancesalesDataVariable.push(temp);
 			}
 		}
 		if(report_name == 'iar'){
			$scope.inactiveinventoryDataVariable = [];
			for (var i = resulttable.length - 1; i >= 0; i--) {	
	 			var temp = {
	 				itemid:resulttable[i].PRODID,
	 				bcode:resulttable[i].BCODE,
	 				desc:resulttable[i].DESCRIPT,
	 				depart:resulttable[i].DEPART,
	 				cost:$filter('currency')(resulttable[i].COST,""),
	 				qtyonhand:$filter('currency')(resulttable[i].QTYONHAND,"")
	 			}
	 			$scope.inactiveinventoryDataVariable.push(temp);
 			}
 		}
 	}

 	function initchartobject () {
 		$scope.chartObject = {}
 		if($scope.cobj == 'BarChart'){
			$scope.chartObject.type = "BarChart";
 		}
 		else if($scope.cobj == 'ColumnChart'){
 			$scope.chartObject.type = "ColumnChart";
 		}
 		else if($scope.cobj == 'PieChart'){
 			$scope.chartObject.type = "PieChart";
 		}
 		return 	$scope.chartObject;
 	}

 	function createchart(resultdata)
 	{
 		$scope.widgetchart = initchartobject()
 		if(report_name == 'dtr'){
 			if($scope.cobj == 'PieChart'){
 				$scope.widgetchart.data =[["Type","Amount"]];
 				var totalCash = 0;
		        var totalCheque = 0 ;
		        var totalCr = 0 ;
				angular.forEach(resultdata, function(value, key) {
				 	if(value.CASH){
		                totalCash += parseFloat(value.CASH); 
		            }
		            if(value.PCHECK){
		                totalCheque += parseFloat(value.PCHECK); 
		            }
		            if(value.CRDCARD1){
		                totalCr += parseFloat(value.CRDCARD1) + parseFloat(value.CRDCARD2); 
		            }       
				});
				$scope.widgetchart.data.push(["Cash", totalCash]);
				$scope.widgetchart.data.push(["Cheque", totalCheque]);
				$scope.widgetchart.data.push(["Cash", totalCr]);
				
				$scope.widgetchart.options = {
		        	'title': 'Daily Tender '+$scope.location,
		        	'logScale': true
		    	};
 			}
 			else{
				$scope.widgetchart.data =[["Store","Cash","Cheque","Credit Cards"]];
				angular.forEach(resultdata, function(value, key) {
		  			$scope.widgetchart.data.push([(value.storenum != null ? value.storenum.toString() : "All Store"), parseFloat($filter('currency')(value.CASH,"")), parseFloat($filter('currency')(value.PCHECK,"")), parseFloat($filter('currency')(value.CRDCARD1 + value.CRDCARD2,""))]);
				});

				$scope.widgetchart.options = {
		        	'title': 'Daily Tender '+$scope.location,
		        	'logScale': true,
		        	'chartArea': {height:"70%"},
           	 		'bar': {groupWidth: "20%"},
            		'vAxis': {title: "Different View" , logScale: true},
            		'hAxis': {title: "Store"}
		    	};
 			}
 		}
 		if(report_name == 'dpr'){
			$scope.widgetchart.data =[["Department","Sales"]];
		   
			angular.forEach(resultdata, function(value, key) {
				if(value.depart != '' && value.sales > 0){
	  				$scope.widgetchart.data.push([ value.depart, parseFloat($filter('currency')(value.sales,""))]);
				}
			});

			$scope.widgetchart.options = {
	        	'title': 'Daily Department Report '+$scope.location,
	        	'logScale': true,
	        	'chartArea': {height:"70%"},
       	 		'bar': {groupWidth: "20%"},
        		'vAxis': {title: "Different View" , logScale: true},
        		'hAxis': {title: "Department"}
	    	};
		}
		if(report_name == 'sr'){
			$scope.widgetchart.data =[["Station","Sales"]];
		   
			angular.forEach(resultdata, function(value, key) {
				if(value.storenum != '' && value.TOTAL > 0){
	  				$scope.widgetchart.data.push([ value.sname.trim()+" "+value.storenum.trim(), parseFloat($filter('currency')(value.TOTAL,""))]);
				}
			});

			$scope.widgetchart.options = {
	        	'title': 'Daily Station Report '+$scope.location,
	        	'logScale': true,
	        	'chartArea': {height:"70%"},
       	 		'bar': {groupWidth: "20%"},
        		'vAxis': {title: "Stations" , logScale: true},
        		'hAxis': {title: "Sales"}
	    	};
		}
		if(report_name == 'cr'){
			$scope.widgetchart.data =[["Cashier","Sales"]];
		   
			angular.forEach(resultdata, function(value, key) {
				if(value.storenum != '' && value.totalsales > 0){
	  				$scope.widgetchart.data.push([ value.name.trim(), parseFloat($filter('currency')(value.totalsales,""))]);
				}
			});

			$scope.widgetchart.options = {
	        	'title': 'Daily Cashier Report '+$scope.location,
	        	'logScale': true,
	        	'chartArea': {height:"70%"},
       	 		'bar': {groupWidth: "20%"},
        		'vAxis': {title: "Cashier" , logScale: true},
        		'hAxis': {title: "Sales"}
	    	};
		}
 	}


	function departmentcall(){
		report_details.department(urllist.department)
		.then(
			function(responsedata){
				renderdata('departments',responsedata)
			}
		)
	}

	function categorycall(){
		report_details.category(urllist.category)
		.then(
			function(responsedata){
				renderdata('categoies',responsedata)
			}
		)
	}

	function vendorcall(){
		report_details.vendor(urllist.vendor)
		.then(
			function(responsedata){
				renderdata('vendors',responsedata)
			}
		)
	}
	
	function dailysalesreportcall(){
 		reportdata();
 		report_details.dailysalesreport(urllist.dailysalesreport,$scope.reportdata.dailysalesreport)
		.then(
			function(responsedata){
				if(responsedata != false){
					renderdata('dsr',responsedata)	
				}
				else{
					atomicNotifyService.error('No sales data found');
				}
			}
		)
	}

	function tenderreportcall(){
 		reportdata();
 		report_details.tenderreport(urllist.tenderreport,$scope.reportdata.tenderreport)
		.then(
			function(responsedata){
				if(responsedata != false){
					renderdata('dtr',responsedata)	
				}
				else{
					atomicNotifyService.error('No sales data found');
				}
			}
		)
	}

	function departmentreportcall(){
 		reportdata();
 		creport_name = "dpr";
 		report_details.departmentreport(urllist.departmentreport,$scope.reportdata.departmentreport)
		.then(
			function(responsedata){
				if(responsedata != false){
					renderdata('dpr',responsedata)	
				}
				else{
					atomicNotifyService.error('No sales data found');
				}
			}
		)
	}

	function stationreportcall(){
 		reportdata();
 		report_name = "sr";
 		report_details.stationreport(urllist.stationreport,$scope.reportdata.stationreport)
		.then(
			function(responsedata){
				if(responsedata != false){
					renderdata('sr',responsedata)	
				}
				else{
					atomicNotifyService.error('No sales data found');
				}
			}
		)
	}

	function cashierreportcall(){
 		reportdata();
 		report_name = "cr";
 		report_details.cashierreport(urllist.cashierreport,$scope.reportdata.cashierreport)
		.then(
			function(responsedata){
				if(responsedata != false){
					renderdata('cr',responsedata)	
				}
				else{
					atomicNotifyService.error('No sales data found');
				}
			}
		)
	}

	function zerosalereportcall(){
 		reportdata();
 		report_name = "zsr";
 		report_details.zerosalereport(urllist.zerosalereport,$scope.reportdata.zerosalereport)
		.then(
			function(responsedata){
				if(responsedata != false){
					renderdata('zsr',responsedata)	
				}
				else{
					atomicNotifyService.error('No sales data found');
				}
			}
		)
	}

	function negativebalancereportcall(){
 		reportdata();
 		report_name = "nbr";
 		report_details.negativebalancereport(urllist.negativebalancereport,$scope.reportdata.negativebalancereport)
		.then(
			function(responsedata){
				if(responsedata != false){
					renderdata('nbr',responsedata)	
				}
				else{
					atomicNotifyService.error('No sales data found');
				}
			}
		)
	}

	function inactivereportcall(){
 		reportdata();
 		report_name = "iar";
 		report_details.inactivereport(urllist.inactivereport,$scope.reportdata.inactivereport)
		.then(
			function(responsedata){
				if(responsedata != false){
					renderdata('iar',responsedata)	
				}
				else{
					atomicNotifyService.error('No sales data found');
				}
			}
		)
	}

	departmentcall();
	categorycall();
	vendorcall();
	loadreport();
	function loadreport(){
		if(report_name == 'dsr'){
			dailysalesreportcall();
		}

		if(report_name == 'dtr'){
			tenderreportcall();
		}

		if(report_name == 'dpr'){
			departmentreportcall();
		}

		if(report_name == 'sr'){
			stationreportcall();
		}

		if(report_name == 'cr'){
			cashierreportcall();
		}

		if(report_name == 'zsr'){
			zerosalereportcall();
		}

		if(report_name == 'nbr'){
			negativebalancereportcall();
		}

		if(report_name == 'iar'){
			inactivereportcall();
		}
	}
});

app.service('report_details',function($http,$q){
	return({
		department:department,
		category:category,
		vendor:vendor,
		dailysalesreport:dailysalesreport,
		tenderreport:tenderreport,
		departmentreport:departmentreport,
		stationreport:stationreport,
		cashierreport:cashierreport,
		zerosalereport:zerosalereport,
		negativebalancereport:negativebalancereport,
		inactivereport:inactivereport
	})

	function department(url)
	{
		var request = $http({
			method:'get',
			url:url,
			headers : {'Accept' : 'application/json'}
		});
		return (request.then(responseSuccess,responseFail))
	}
	
	function category(url)
	{
		var request = $http({
			method:'get',
			url:url,
			headers : {'Accept' : 'application/json'}
		});
		return (request.then(responseSuccess,responseFail))
	}

	function vendor(url)
	{
		var request = $http({
			method:'get',
			url:url,
			headers : {'Accept' : 'application/json'}
		});
		return (request.then(responseSuccess,responseFail))
	}


	function dailysalesreport(url,data){
		var request = $http({
			method:'get',
			url:url,
			params:data,
			headers : {'Accept' : 'application/json'}
		});
		return (request.then(responseSuccess,responseFail))
	}

	function tenderreport(url,data){
		var request = $http({
			method:'get',
			url:url,
			params:data,
			headers : {'Accept' : 'application/json'}
		});
		return (request.then(responseSuccess,responseFail))
	}


	function departmentreport(url,data){
		var request = $http({
			method:'get',
			url:url,
			params:data,
			headers : {'Accept' : 'application/json'}
		});
		return (request.then(responseSuccess,responseFail))
	}

	function stationreport(url,data){
		var request = $http({
			method:'get',
			url:url,
			params:data,
			headers : {'Accept' : 'application/json'}
		});
		return (request.then(responseSuccess,responseFail))
	}

	function cashierreport(url,data){
		var request = $http({
			method:'get',
			url:url,
			params:data,
			headers : {'Accept' : 'application/json'}
		});
		return (request.then(responseSuccess,responseFail))
	}

	function zerosalereport(url,data){
		var request = $http({
			method:'get',
			url:url,
			params:data,
			headers : {'Accept' : 'application/json'}
		});
		return (request.then(responseSuccess,responseFail))
	}

	function negativebalancereport(url,data){
		var request = $http({
			method:'get',
			url:url,
			params:data,
			headers : {'Accept' : 'application/json'}
		});
		return (request.then(responseSuccess,responseFail))
	}

	function inactivereport(url,data){
		var request = $http({
			method:'get',
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
		
        // Otherwise, use expected error message.
        return false;
	}
})