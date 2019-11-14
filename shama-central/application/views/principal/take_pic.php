<style type="text/css">
    body {
        margin: 0;
        padding: 0;
    }

    .img {
        background: #ffffff;
        padding: 12px;
        border: 1px solid #999999;
    }

    .shiva {
        -moz-user-select: none;
        background: #2A49A5;
        border: 1px solid #082783;
        box-shadow: 0 1px #4C6BC7 inset;
        color: white;
        padding: 3px 5px;
        text-decoration: none;
        text-shadow: 0 -1px 0 #082783;
        font: 12px Verdana, sans-serif;
    }
    .btn-pic{
        font-size: 18px;
        padding: 5px 5px;
        color: #fff;
        background-color: #337ab7;
        border-color: #2e6da4;
        border: 1px solid transparent;
        text-transform: uppercase;
        cursor: pointer;
    }
     
   
    form {
    text-align: center;
}
</style>
<html>

<body style="background-color:#dfe3ee;">
    
    <div id="main">
        <div id="content">

            <script type="text/javascript" src="<?php echo base_url();?>js/scripts/webcam.js"></script>
            <script language="JavaScript">
                document.write(webcam.get_html(600, 420));
            </script>
            <form>
                <br />
                     <input type=button value="snap" onClick="take_snapshot()" class="btn-pic">
                     <input  type="button" class="btn-pic"
                       style="font-weight: black;display: inline;"
                       value="Close"
                       onclick="closeMe()">
            </form>
        </div>

        <script type="text/javascript">
            
            webcam.set_api_url('<?php echo base_url();?>Principal_controller/saveImage');
            webcam.set_swf_url('<?php echo base_url();?>js/scripts/webcam.swf');
            webcam.set_quality(90);
            webcam.set_shutter_sound(true);
            webcam.set_hook('onComplete', 'my_completion_handler');

            function take_snapshot() {
               webcam.snap();




            }

            function my_completion_handler(msg) {
                webcam.reset();
                // if (msg.match(/(http\:\/\/\S+)/)) {
                //     document.getElementById('img').innerHTML = '<h3>Upload Successfuly done</h3>' + msg;

                //     document.getElementById('img').innerHTML = "<img src=" + msg + " class=\"img\">";
                //     webcam.reset();
                // } else {
                //     alert("Error occured we are trying to fix now: " + msg);
                // }
            }



        </script>
        <script>
function closeMe()
{
    window.opener = self;
    window.close();
}
</script>

        <div id="img">
        </div>
    </div>
</body>

</html>


