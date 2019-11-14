<?php
?>
<html>
<head>
 <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
 <title></title>
 <script type="text/javascript">
       

function check(str)
                {
                    var selState = str;
    
                    // console.log(selState);
                    alert(selState);
                    $.ajax({
                        url: "Check/ajax_call", //The url where the server req would we made.
                        async: false,
                        type: "POST", //The type which you want to use: GET/POST
                        data: "state="+selState, //The variables which are going.
                        dataType: "JSON", //Return data type (what we expect).
                          
                        //This is the function which will be called if ajax call is successful.
                        success: function(data) {
                            //data is the html of the page where the request is made.
                             var appenddata;
                                
                          } 
                    })
                


}
        </script>

	
</head>
<body>

<h1><?php echo $data; ?></h1>
<input type="checkbox" value="1"  onclick="check(this.value)" />
</body>
</html>