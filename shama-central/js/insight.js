/**
 * ---------------------------------------------------------
 *   Error message function
 * ---------------------------------------------------------
 */
var errorMessage = {
    timeout:'No sales data to display',
    badrequest:'No sales data to display',
    rest:'No sales data to display',
    payroll:'No payroll data to display',
    payrollformerror:'Payroll data not saved',
    payrolldeleteerror:'Payroll data not deleted',
    storedataerror:'Store data not found',
    usermessage:''
}
$(document).ready(function(){

    /**
     * Insight javascript file
     */
    
    var current_url = pagePath('/');

    var windowpage = {
        pagepath : pagePath('/')
    }   
  

    if(current_url[5] == 'show_std_list' || current_url[5] == 'promotestudents' || current_url[5] == 'savestudent')
    {

        $("#lsubmenu").css('display','block')
        if(current_url[5] == 'show_std_list' || current_url[5] == 'savestudent' || current_url[5] == 'classreport' )
        {
            $("#lsubmenu li:first-child").addClass('active')
        }
        else{
            $("#lsubmenu li:last-child").addClass('active')
        }
        
    }



     $("#student").click(function(){
       
        if($("#lsubmenu").css('display') == 'block')
        {
            $(".lsubmenu-icon").removeClass('lsubmenu-icon-rotate')
        }
        if($("#lsubmenu").css('display') == 'none'){
            $(".lsubmenu-icon").addClass('lsubmenu-icon-rotate')
        }
        $("#lsubmenu").slideToggle('slow')
     })
    
$("#reports").click(function(){
       
        if($("#midresult").css('display') == 'block')
        {
            $(".result-icon").removeClass('lsubmenu-icon-rotate')
        }
        if($("#midresult").css('display') == 'none'){
            $(".result-icon").addClass('lsubmenu-icon-rotate')
        }
        $("#midresult").slideToggle('slow')
     })
     $("#exams").click(function(){
       
        if($("#datasheet").css('display') == 'block')
        {
            $(".exams-icon").removeClass('lsubmenu-icon-rotate')
        }
        if($("#datasheet").css('display') == 'none'){
            $(".exams-icon").addClass('lsubmenu-icon-rotate')
        }
        $("#datasheet").slideToggle('slow')
     })

$("#manage_data").click(function(){
       
        if($("#reset_semester_lesson_plan").css('display') == 'block')
        {
            $(".manage-icon").removeClass('lsubmenu-icon-rotate')
        }
        if($("#reset_semester_lesson_plan").css('display') == 'none'){
            $(".manage-icon").addClass('lsubmenu-icon-rotate')
        }
        $("#reset_semester_lesson_plan").slideToggle('slow')
     })

    /**
     * ---------------------------------------------------------
     *   Enable/Disable filter inputs
     * ---------------------------------------------------------
     */

    // function enableFilterInput(status , single )
    // {

    //     if(status == 'enable' && single == false){
            
    //         getDepartmentList();
    //         getCategoryList();
    //         getVendorList();
    //     }
    //     if(status == 'enable' && single == "store"){

    //         getStoreList();
    //     }
    //     if(status == 'enable' && single == "department"){
    //         getDepartmentList();
    //     }
    //     if(status == 'enable' && single == "category"){
    //         getCategoryList();
    //     }
    //     if(status == 'enable' && single == "vendor"){
    //         getVendorList();
    //     }

    //     if(status == "enable" && single == "checkstore"){
    //         checknewstore();
    //     }
    // }

    /**
     * ---------------------------------------------------------
     *   Get current page path
     * ---------------------------------------------------------
     */

    function pagePath(spliter)
    {
        return window.location.pathname.split( spliter );
    }


    var inventory = windowpage.pagepath[3];

    function checknewstore()
    {
        ajaxType = "GET";
        urlpath = "api/customers_list/format/json";
        ajaxfunc(urlpath,"",errorhandler,updatenewstore);
       
    }

    function updatenewstore(data)
    {
        var storelist = [] ;
        storelength = data.length ;
        for (var i = 0; i <= storelength ; i++) {
            storelist[i] = data[i]; 
        };
        ajaxType = "GET";
        urlpath = "savestore";
        storedata = {'stores':storelist}  ;
        ajaxfunc(urlpath,storedata,errorhandler,getStoreResponse);
          
    }

    function getStoreResponse(response)
    {
        
    }

    /**
     * ---------------------------------------------------------
     *   Left menu front-end script
     * ---------------------------------------------------------
     */

    $(document).on('click','.sub-child',function(){
        var classHide = $( "#sub-menu" ).hasClass( "hide");
        $(this).closest('li').addClass('selectedMenu');
        if(classHide == true){
            $("#sub-menu").removeClass('hide');
            $("#sub-menu").addClass('show');
            $("#sub-menu li").slideDown('normal');
                      
        }else{
            $("#sub-menu").removeClass('show');
            $("#sub-menu").addClass('hide');
            $("#sub-menu li").slideUp('normal');
        }
    });

  
    if(current_url != ''){
        
        var classHide = $( "#sub-menu" ).hasClass( "hide");
        var subclass = $( "#sub-menu li.selectedMenu" );
        subclass.addClass('active-submenu');
       
        if(classHide == true){
            
            $("#sub-menu").removeClass('hide');
            $("#sub-menu").addClass('show');
            $("#sub-menu li").slideDown('normal');
                      
        }else{
            $("#sub-menu").removeClass('show');
            $("#sub-menu").addClass('hide');
            $("#sub-menu li").slideUp('normal');
        }    
    }
    if( inventory == "inventory"){
        inputdepartmentname = "inputInventoryDepartment";
        departmentresponsehandler(data);
        inputcategoryname = "inputInventoryCategory";
        categoryresponsehandler(data);
        inputvendorname = "inputInventoryVendor";
        vendorresponsehandler(data)
    }
});
var departments  ;
function dateconverter(dateinput)
{
    var d = new Date(dateinput);
    return d.getMonth() + 1 + "/"+d.getDate() + "/" + d.getFullYear()
}
function datetimeconverter(dateinput)
{
    var d = new Date(dateinput);
    return d.getMonth() + 1 + "/"+d.getDate() + "/" + d.getFullYear()+" "+d.getHours()+":"+d.getMinutes()+':'+d.getSeconds();
}
/**
 * ---------------------------------------------------------
 *   Ajax function
 * ---------------------------------------------------------
 */
var ajaxType="GET" ;
var dataType="json";
var data = '';
function ajaxfunc(urlpath,data,errorhandler,succeshandler)
{
    $.ajax({
        type: ajaxType,
        dataType: dataType,
        url: urlpath,
        data:data,
        beforeSend: function(x) {
            if(x && x.overrideMimeType) {
                x.overrideMimeType("application/json;charset=UTF-8");   
            }
        },
        cache: false,
        async:   false,
        timeout: 30000,
        // Tell YQL what we want and that we want JSON
        // Work with the response
        error: errorhandler,
        success: succeshandler
    });
}

/**
 * ---------------------------------------------------------
 *   Ajax error handler function
 * ---------------------------------------------------------
 */

function errorhandler(request, status, err)
{
    $("#page-loader").css('display','none');
    if (err == "timeout") {
        $(".message-alert-box").show();
        $("#message-alert").show();
        $("#message-alert").html(errorMessage.timeout);
        $(".message-alert-box").fadeOut(7000);
    } 
    else if (err == "Bad Request") {
        $(".message-alert-box").show();
        $("#message-alert").focus().show();
        $("#message-alert").html(errorMessage.timeout);
        $(".message-alert-box").fadeOut(7000);
    } 
    else {
        // another error occured  
        $(".message-alert-box").show();
        $("#message-alert").show();
        $("#message-alert").html(errorMessage.timeout);
        $(".message-alert-box").fadeOut(7000);
    }
};


/**
 * ---------------------------------------------------------
 *   Inventory report error handler function
 * ---------------------------------------------------------
 */
function inventoryReportErrorHandler(request, status, err)
{
    colspan = $("#report-header th").length;
    if (err == "timeout") {
        $("#page-loader").fadeOut("slow");
        $(".message-alert-box").show();
        $("#message-alert").html("No sales data found");
        $("#reporttablebody-phase-two").html(''); 
        var cont_str = '';
        cont_str += '<tr><td class="no-record" colspan="'+colspan+'">No record found</td></tr>';
        $("#reporttablebody-phase-two").prepend(cont_str);
        $(".message-alert-box").fadeOut(10000);
    } 
    else if (err == "Bad Request") {
        $("#page-loader").fadeOut("slow");
        $(".message-alert-box").show();
        $("#message-alert").html("Inventory data not found");
        $(".message-alert-box").fadeOut(10000);
        $("#reporttablebody-phase-two").html(''); 
        var cont_str = '';
        cont_str += '<tr><td class="no-record" colspan="'+colspan+'">No record found</td></tr>';
        $("#reporttablebody-phase-two").prepend(cont_str);
        
    } 
    else {
        $("#page-loader").fadeOut("slow");
        // another error occured  
        $(".message-alert-box").show();
        $("#message-alert").html("No sales data found");
        $("#reporttablebody-phase-two").html(''); 
        var cont_str = '';
        cont_str += '<tr><td class="no-record" colspan="'+colspan+'">No record found</td></tr>';
        $("#reporttablebody-phase-two").prepend(cont_str);
        $(".message-alert-box").fadeOut(10000);
    }
}


function message(message,display)
{
    if(display == 'show'){
        $(".lms-notification-popup").show();
        $(".user-message").show().fadeToggle(5000);
        $(".message-text").text(message)
        $(".message-text").show();
    }
    else{
        $(".lms-notification-popup").hide();
        $(".user-message").hide();
        $(".message-text").hide();
    }
}

function validateFile(filename)
{
    var validformats = ["pdf","doc","docx","xls","xlsx","XLS","PDF","DOC","DOCX","XLSX"];
    var extension = filename.replace(/^.*\./, '');
    
    if(validformats.indexOf(extension) != -1){
        return true;
    }
    else{
        return false;
    }

}

function drawTenderBarChart(tenderdata,period)
{
    if(tenderdata != undefined)
    {
        $(".dashboard-no-report-data").hide();
        var bardata = new google.visualization.DataTable();
        bardata.addColumn("string","Store");
        bardata.addColumn("number","Cahs");   
        bardata.addColumn("number","Cheque");   
        bardata.addColumn("number","Credit Cards");   

        responseLength = (tenderdata.length == 1 ? 0 : tenderdata.length -1 );
        for (var i = 0;  i <= responseLength ; i++) {       
            bardata.addRows([[(tenderdata[i].storenum != null ? tenderdata[i].storenum.toString() : "All Store"), Math.round(parseFloat(tenderdata[i].CASH)),tenderdata[i].PCHECK,tenderdata[i].CRDCARD1+tenderdata[i].CRDCARD2]]);  
        }

        var baroptions = {
            title : 'Daily Tender - '+period,
            chartArea: {height:'100%'},
            bar: {groupWidth: "20%"},
            legend: {position: 'right'},
            vAxis: {title: 'Different View'},
            hAxis: {title: 'Store'}
        };
        
        var chart = new google.visualization.BarChart(document.getElementById('barchart-container'));
        chart.draw(bardata, baroptions);
    }else{
        $(".dashboard-no-report-data").show();
    }
   
}

function drawTenderColumnChart(tenderdata,period)
{
    if(tenderdata != undefined)
    {
        $(".dashboard-no-report-data").hide();
       var columndata = new google.visualization.DataTable();
    
        columndata.addColumn("string","Store");      
        columndata.addColumn("number","Cahs");   
        columndata.addColumn("number","Cheque");   
        columndata.addColumn("number","Credit Cards");      

        var totalCash = 0;

        responseLength = (tenderdata.length == 1 ? 0 : tenderdata.length -1 );
        for (var i = 0;  i <= responseLength ; i++) {       
            columndata.addRows([[(tenderdata[i].storenum != null ? tenderdata[i].storenum.toString() : "All Store"), Math.round(parseFloat(tenderdata[i].CASH)),tenderdata[i].PCHECK,tenderdata[i].CRDCARD1+tenderdata[i].CRDCARD2]]);  
        }

        var columnoptions = {
            title : 'Daily Tender - '+period,
            chartArea: {height:'70%'},
            bar: {groupWidth: "20%"},
            legend: {position: 'right'},
            vAxis: {title: 'Different View'},
            hAxis: {title: 'Store'}
        };
        
        var chart = new google.visualization.ColumnChart(document.getElementById('columnchart-container'));
        chart.draw(columndata, columnoptions);  
    }else{
        $(".dashboard-no-report-data").show();
    }
    
}

function drawTenderPieChart(tenderdata,period)
{
    if(tenderdata != undefined)
    {
        $(".dashboard-no-report-data").hide();
        var piedata = new google.visualization.DataTable();
    
        piedata.addColumn("string","Type");      
        piedata.addColumn("number","Amount");     

        var totalCash = 0;
        var totalCheque = 0 ;
        var totalCr = 0 ;
        responseLength = (tenderdata.length == 1 ? 0 : tenderdata.length -1 );
        for (var i = 0;  i <= responseLength ; i++) {
            if(tenderdata[i].CASH){
                totalCash += parseFloat(tenderdata[i].CASH); 
            }
            if(tenderdata[i].PCHECK){
                totalCheque += parseFloat(tenderdata[i].PCHECK); 
            }
            if(tenderdata[i].CRDCARD1){
                totalCr += parseFloat(tenderdata[i].CRDCARD1) + parseFloat(tenderdata[i].CRDCARD2); 
            }       
        }
        piedata.addRows([["Cash", totalCash ]]); 
        piedata.addRows([["Cheque", totalCheque ]]); 
        piedata.addRows([["Cash", totalCr ]]);

        var pieoptions = {
            title : 'Daily Tender - '+period,
            legend: {position: 'right'}
        };
        
        var chart = new google.visualization.PieChart(document.getElementById('piechart-container'));
        chart.draw(piedata, pieoptions); 
    }else{
        $(".dashboard-no-report-data").show();
    }
    
}

function drawDepartBarChart(departdata,period)
{
    if(departdata != undefined)
    {
        $(".dashboard-no-report-data").hide();
       var bardata = new google.visualization.DataTable();

        bardata.addColumn("string","Department");
        bardata.addColumn("number","Sales");

        var responseLength =  departdata.length -1 ;
        for (var i = 0;  i <= responseLength ; i++) {
            
            if(departdata[i].depart != '' && departdata[i].sales > 0){
                bardata.addRows([[ departdata[i].depart.trim(),departdata[i].sales]]);
            }     
              
        }
        
        var baroption = {
            title : 'Daily Department Report - '+period,
            legend: {position: 'right'},
            chartArea: {height:'100%'},
            bar: {groupWidth: "20%"},
            vAxis: {title: 'Different View' , logScale: true},
            hAxis: {title: 'Department'}
        };
        
        var chart = new google.visualization.BarChart(document.getElementById('barchart-container'));
        chart.draw(bardata, baroption);  
    }else{
        $(".dashboard-no-report-data").show();
    }
    
}

function drawDepartColumnChart(departdata,period){
    if(departdata != undefined){
        $(".dashboard-no-report-data").hide();
        var columndata = new google.visualization.DataTable();

        columndata.addColumn("string","Department");
        columndata.addColumn("number","Sales");

        var responseLength =  departdata.length -1 ;
        for (var i = 0;  i <= responseLength ; i++) {
            
            if(departdata[i].depart != '' && departdata[i].sales > 0){
                columndata.addRows([[ departdata[i].depart.trim(),departdata[i].sales]]);
            }     
              
        }
        
        var columnoptions = {
            title : 'Daily Department Report - '+period,
            legend: {position: 'right'},
            chartArea: {height:'70%'},
            bar: {groupWidth: "20%"},
            vAxis: {title: 'Different View',logScale: true},
            hAxis: {title: 'Department'}
        };
        
        var chart = new google.visualization.ColumnChart(document.getElementById('columnchart-container'));
        chart.draw(columndata, columnoptions); 
    }else{
        $(".dashboard-no-report-data").show();
    }
    
}

function drawDepartPieChart(departdata,period){
    if(departdata != undefined){
        $(".dashboard-no-report-data").hide();
        var piedata = new google.visualization.DataTable();
        piedata.addColumn("string","Department");
        piedata.addColumn("number","Sales");

        var responseLength =  departdata.length -1 ;
        for (var i = 0;  i <= responseLength ; i++) {
            
            if(departdata[i].depart != '' && departdata[i].sales > 0){
                piedata.addRows([[ departdata[i].depart.trim(),departdata[i].sales]]);
            }        
        }
        
        var pieoptions = {
            title : 'Daily Department Report - '+period,
            legend: {position: 'right'},

            vAxis: {title: 'Different View',logScale: true},
            hAxis: {title: 'Department'}
        };
        
        var chart = new google.visualization.PieChart(document.getElementById('piechart-container'));
        chart.draw(piedata, pieoptions); 
    }else{
        $(".dashboard-no-report-data").show();
    }
 
}

function drawStationBarChart(stationdata,period){
    if(stationdata != undefined)
    {   
        $(".dashboard-no-report-data").hide();
        var bardata = new google.visualization.DataTable();

        bardata.addColumn("string","Station");
        bardata.addColumn("number","Sales");

        var responseLength =  stationdata.length -1 ;
        for (var i = 0;  i <= responseLength ; i++) {
            
            if(stationdata[i].storenum != '' && stationdata[i].TOTAL > 0){
                bardata.addRows([[ stationdata[i].sname.trim()+" "+stationdata[i].storenum.trim() ,stationdata[i].TOTAL]]);
            }     
              
        }
        
        var baroption = {
            title : 'Daily Station Report - '+period,
            legend: {position: 'right'},
            chartArea: {height:'100%'},
            bar: {groupWidth: "20%"},
            vAxis: {title: 'Stations'},
            hAxis: {title: 'Sales',logScale:true}
        };
        
        var chart = new google.visualization.BarChart(document.getElementById('barchart-container'));
        chart.draw(bardata, baroption);
    }else{
        $(".dashboard-no-report-data").show();
    }
     
}

function drawStationColumnChart(stationdata,period){
    if(stationdata != undefined)
    {
        $(".dashboard-no-report-data").hide();
        var columndata = new google.visualization.DataTable();

        columndata.addColumn("string","Station");
        columndata.addColumn("number","Sales");

        var responseLength =  stationdata.length -1 ;
        for (var i = 0;  i <= responseLength ; i++) {
            
            if(stationdata[i].storenum != '' && stationdata[i].TOTAL > 0){
                columndata.addRows([[ stationdata[i].sname.trim()+" "+stationdata[i].storenum.trim(),stationdata[i].TOTAL]]);
            }     
              
        }
        
        var columnoptions = {
            title : 'Daily Station Report - '+period,
            legend: {position: 'right'},
            chartArea: {height:'70%'},
            bar: {groupWidth: "20%"},
            vAxis: {title: 'Sales',logScale:true},
            hAxis: {title: 'Stations'}
        };
        
        var chart = new google.visualization.ColumnChart(document.getElementById('columnchart-container'));
        chart.draw(columndata, columnoptions); 
    }else{
        $(".dashboard-no-report-data").show();
    }
  
}

function drawStationPieChart(stationdata,period){
    if(stationdata != undefined)
    {
        $(".dashboard-no-report-data").hide();
        var piedata = new google.visualization.DataTable();

        piedata.addColumn("string","Station");
        piedata.addColumn("number","Sales");

        var responseLength =  stationdata.length -1 ;
        for (var i = 0;  i <= responseLength ; i++) {
            
            if(stationdata[i].storenum != '' && stationdata[i].TOTAL > 0){
                piedata.addRows([[ stationdata[i].sname.trim(),stationdata[i].TOTAL]]);
            }     
        }
        
        var pieoptions = {
            title : 'Daily Station Report - '+period,
            legend: {position: 'right'},
            vAxis: {title: 'Station'},
            hAxis: {title: 'Sales'}
        };
        
        var chart = new google.visualization.PieChart(document.getElementById('piechart-container'));
        chart.draw(piedata, pieoptions);   
    }else{
        $(".dashboard-no-report-data").show();
    }
}

function drawCashierBarChart(cashierdata,period){
    if(cashierdata != undefined){
        $(".dashboard-no-report-data").hide();
        var bardata = new google.visualization.DataTable();

        bardata.addColumn("string","Cashier");
        bardata.addColumn("number","Sales");

        var responseLength =  cashierdata.length -1 ;
        for (var i = 0;  i <= responseLength ; i++) {
            
            if(cashierdata[i].storenum != '' && cashierdata[i].totalsales > 0){
                bardata.addRows([[ cashierdata[i].name.trim()+" "+cashierdata[i].storenum.trim(),cashierdata[i].totalsales]]);
            }     
        }
        var baroption = {
            title : 'Daily Cashier Report - '+period,
            chartArea: {height:'100%'},
            bar: {groupWidth: "20%"},
            legend: {position: 'right'},
            vAxis: {title: 'Cashier'},
            hAxis: {title: 'Sales',logScale:true}
        };
        
        var chart = new google.visualization.BarChart(document.getElementById('barchart-container'));
        chart.draw(bardata, baroption);   
    }else{
        $(".dashboard-no-report-data").show();
    }
}

function drawCashierColumnChart(cashierdata,period){
    if(cashierdata != undefined)
    {
        $(".dashboard-no-report-data").hide();
         var columndata = new google.visualization.DataTable();

        columndata.addColumn("string","Cashier");
        columndata.addColumn("number","Sales");

        var responseLength =  cashierdata.length -1 ;
        for (var i = 0;  i <= responseLength ; i++) {
            
            if(cashierdata[i].storenum != '' && cashierdata[i].totalsales > 0){
                columndata.addRows([[ cashierdata[i].name.trim()+" "+cashierdata[i].storenum.trim(),cashierdata[i].totalsales]]);
            }    
        }
        
        var columnoptions = {
            title : 'Daily Cashier Report - '+period,
            chartArea: {height:'70%'},
            bar: {groupWidth: "20%"},
            legend: {position: 'right'},
            vAxis: {title: 'Cashier'},
            hAxis: {title: 'Sales'}
        };
        
        var chart = new google.visualization.ColumnChart(document.getElementById('columnchart-container'));
        chart.draw(columndata, columnoptions); 
    }else{
        $(".dashboard-no-report-data").show();
    }
}

function drawCashierPieChart(cashierdata,period){
    if(cashierdata != undefined)
    {
        $(".dashboard-no-report-data").hide();
        var piedata = new google.visualization.DataTable();

        piedata.addColumn("string","Cashier");
        piedata.addColumn("number","Sales");

        var responseLength =  cashierdata.length -1 ;
        for (var i = 0;  i <= responseLength ; i++) {
            
            if(cashierdata[i].storenum != '' && cashierdata[i].totalsales > 0){
                piedata.addRows([[ cashierdata[i].name.trim(),cashierdata[i].totalsales]]);
            }     
        }
        
        var pieoptions = {
            title : 'Daily Cashier Report - '+period,
            chartArea: {height:'100%'},
            legend: {position: 'right'},
            vAxis: {title: 'Different View'},
            hAxis: {title: 'Store'}
        };
        
        var chart = new google.visualization.PieChart(document.getElementById('piechart-container'));
        chart.draw(piedata, pieoptions); 
    }
    else{
        $(".dashboard-no-report-data").show();
    }
}

function parseDate(str) {
    var m = str.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/);
    return m;
}

