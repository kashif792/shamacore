
<?php //Initial $this->load->helper('html');
?>
<html>
    <head>
        <title>jQuery Ajax tutorial using Code Igniter Framework</title>
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#states-dropdown').change(function () {
                    var selState = $(this).attr('value');
    
                    console.log(selState);
                    alert(selState);
                    $.ajax({
                        url: "Site/ajax_call", //The url where the server req would we made.
                        async: false,
                        type: "POST", //The type which you want to use: GET/POST
                        data: "state="+selState, //The variables which are going.
                        dataType: "html", //Return data type (what we expect).
                          
                        //This is the function which will be called if ajax call is successful.
                        success: function(data) {
                            //data is the html of the page where the request is made.
                            $('#city').html(data);
                        }
                    })
                });
            });


    function check(str)
                {
                    var selState = str;
    
                    // console.log(selState);
                    alert(selState);
                    $.ajax({
                        url: "Site/ajax_call", //The url where the server req would we made.
                        async: false,
                        type: "POST", //The type which you want to use: GET/POST
                        data: "state="+selState, //The variables which are going.
                        dataType: "JSON", //Return data type (what we expect).
                          
                        //This is the function which will be called if ajax call is successful.
                        success: function(data) {
                            //data is the html of the page where the request is made.
                             var appenddata;
                                $.each(data, function(key, value) {
                                $('#section').append($("<option/>", {
                                    value: key,
                                    text: value
                                }));
                                });
                            //$('#section').html(appenddata);
                        }
                    })
                


}
        </script>
    </head>
      
    <body>
 
<div id="wrapper">
 
<div id="states-dropdown"><?php print form_dropdown('states',$states); ?></div>
 
                                          <select name="states-dropdown" id="states-dropdown" onchange="check(this.value)" >
                                                <?php 

                                                    if(count($states))
                                                    {

                                                        foreach ($states as $key => $value) {
                                                            ?>
                                                                 <option  value="<?php echo $value->id; ?>"><?php echo $value->grade; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                ?>

                                                
                                            </select>
<div id="city">
   <select id="section">
     <option value="-1">Select Section</option>
    </select>
</div>
 
        </div>
 
    </body>
</html>