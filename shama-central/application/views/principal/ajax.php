<!doctype html>
<html>
<head>
  <meta charset='utf-8'>
  
  <!--
  Loading Handsontable (full distribution that includes all dependencies apart from jQuery)
  -->
  <script data-jsfiddle="common" src="js/excel/demo/js/jquery.min.js"></script>

  <link data-jsfiddle="common" rel="stylesheet" media="screen" href="js/excel/dist/handsontable.css">
  <link data-jsfiddle="common" rel="stylesheet" media="screen" href="js/excel/dist/pikaday/pikaday.css">
  <script data-jsfiddle="common" src="js/excel/dist/pikaday/pikaday.js"></script>
  <script data-jsfiddle="common" src="js/excel/dist/moment/moment.js"></script>
  <script data-jsfiddle="common" src="js/excel/dist/zeroclipboard/ZeroClipboard.js"></script>
  <script data-jsfiddle="common" src="js/excel/dist/numbro/numbro.js"></script>
  <script data-jsfiddle="common" src="js/excel/dist/numbro/languages.js"></script>
   <script data-jsfiddle="common" src="js/excel/dist/handsontable.js"></script>

  <!--
  Loading demo dependencies. They are used here only to enhance the examples on this page
  -->
  <link data-jsfiddle="common" rel="stylesheet" media="screen" href="js/excel/demo/css/samples.css?20140331">

  <link rel="stylesheet" media="screen" href="js/excel/demo/js/highlight/styles/github.css">
  <link rel="stylesheet" href="js/excel/demo/css/font-awesome/css/font-awesome.min.css">
<style>
table.htCore tr td:nth-child(2), table.htCore tr th:nth-child(6) {
    display:none;
}
</style>
  
</head>

<body>


<div class="wrapper">
  <div class="wrapper-row">

    <div id="container">
      <div class="columnLayout">

        <div class="rowLayout">
      <div class="descLayout">
        <div class="pad" data-jsfiddle="example1">
          <div id="exampleConsole" class="console"></div>

          <div id="example1"></div>

          <p>
            
            <button  id="export-file" onclick="exportdata()" class="intext-btn">
                Export as a file
      </button>
      <button name="save" onclick="save()" id="save" class="intext-btn">Save</button>
      <button class="dump" name="dump" data-dump="#example1" data-instance="hot" title="Print current data source to console">
          <i class="fa fa-terminal"></i>
          Dump data to console
        </button>

      <form class="form-horizontal well" action="<?php echo base_url(); ?>index.php/Principal_controller/ImportDefaultPlan" method="post" name="upload_excel" enctype="multipart/form-data">
            <input type="file" name="file" id="file" class="input-large">
            <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading">Upload</button>
      </form>

          </p>
        </div>
      </div>

      <div class="codeLayout">
        <div class="pad">

        </div>
      </div>
    </div>

        <div class="footer-text">
        </div>
      </div>

    </div>

  </div>
</div>

<div id="outside-links-wrapper"></div>

<script>
$( document ).ready(function() {

            var
              $container = $("#example1"),
              $parent = $container.parent(),
              autosaveNotification,
              hot;
              var data_array = []
              get_data();
               
               function get_data()
               {
                var userdata = []

                  $.ajax({
                    url: 'getdata',
                    dataType: 'json',
                    type: 'GET',
                    success: function (res) {
                       for (var i = res.length - 1; i >= 0; i--) {
                          var temp = []
                           temp.push(res[i].id)
                           temp.push(res[i].day)
                           temp.push(res[i].name)
                           temp.push(res[i].content)
                           temp.push(res[i].notes)
                          data_array.push(temp)
                       }
                       initobj();
                    }
                  });

               }

            function initobj()
            {

               var container = $("#example1").handsontable({
                data: data_array,
                colHeaders: ['Day', 'Name','Content', 'Notes'],
                startRows: 20,
                startCols: 4,
                rowHeaders: true,
                contextMenu: ['remove_row','row_above', 'row_below'],
                manualRowResize: true,
                columnSorting: true,
                sortIndicator: true,
                stretchH: 'all',
                autoColSize: true,
                autoWrapRow: true,
                dropdownMenu: true,
                 columns: [
                  {data: 0},
                  {data: 1},
                  {data: 2},
                  {data: 3},
                  {data: 4},
                  
                  ],
                  // afterSelectionEnd: function(x1, y1, x2, y2)
                  // {

                    
    
                    
                  // },


          beforeRemoveRow:function(index,amount)
          {
             var id = $("#example1").handsontable('getDataAtRow',index,1);
                    var data = {
                        
                        id:id,
                    }

                     $.ajax({
                     url:'deleteplan',
                      type: 'POST',
                      data: {data:data,candelete:true},
                      success: function(res){
                       for (var i = res.length - 1; i >= 0; i--) {
                          // if(!res[i].id){
                          // var temp = []
                          //  temp.push(res[i].id='add')
                          // data_array.push(temp)
                          //     }
                             }
                     alert("success");
                     alert(res);
                      },
                        error: function(){
                     alert("Fail")
                  }});

          },
                  

                  afterChange: function (change, source)
                   {
                    if (source === 'loadData') {
                        return; //don't save this change
                    }

                    var data = {
                        cellheader: change[0][1],
                        cellvalue:change[0][3]

              
                    }

                  //   var jsonString = JSON.stringify(data_array);
                  //   $.ajax({
                  //    url:'Savedata',
                  //     type: 'POST',
                  //     data: {data:jsonString,candelete:true},
                  //     success: function(res){
                  //      // for (var i = res.length - 1; i >= 0; i--) {
                  //      //    if(!res[i].id){
                  //      //    var temp = []
                  //      //     temp.push(res[i].id='add')
                  //      //    data_array.push(temp)
                  //      //        }
                  //      //      }
                  //    alert("success");
                  //    alert(res);
                  //     },
                  //       error: function(){
                  //    alert("Fail")
                  // }});

                    console.log(data_array);
                    if(!(change[0][2]))
                        {
                          //Add function here
                          //alert('new');
                        }
                        else if(change[0][2] != change[0][3]){
                          //edit case here
                          //alert('edit');
                        }
                        else if(!(change[0][0] && change[0][1])){
                          //edit case here
                          //alert('edit');
                        }
                    console.log(change);
                    console.log(source);
                    console.log(data);
                    
                },
         
              });

               var $container = $("#example1");
              var handsontable = $container.data('handsontable');
             // alert(handsontable);
              console.log(handsontable);
          }

           
            function save()
            {
              var jsonString = JSON.stringify(data_array);
                    $.ajax({
                     url:'Savedata',
                      type: 'POST',
                      data: {data:jsonString,candelete:true},
                      success: function(res){
                       // for (var i = res.length - 1; i >= 0; i--) {
                       //    if(!res[i].id){
                       //    var temp = []
                       //     temp.push(res[i].id='add')
                       //    data_array.push(temp)
                       //        }
                       //      }
                     alert("success");

                     alert(res);
                     location.reload();
                      },
                        error: function(){
                     alert("Fail")
                  }});

            }

            function destroyhadsontable()
            {
              container = $("#example1").handsontable('getInstance');
              container.destroy();
            }
  
          )};
</script>

          
</body>
</html>
