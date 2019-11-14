    <!DOCTYPE html>
    <html>
    <head>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <style>
        .panel {
           margin-bottom: 0px !important; 
           background-color: #fff ;
           border: 1px solid transparent;
           border-radius: 4px;
           -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
           box-shadow: 0 1px 1px rgba(0,0,0,.05);
       }
       .panel-group {
        margin-bottom: 0px !important; 
    }
    .panel-group .panel+.panel {
    margin-top: 0px ! important; 
}
.panel-default>.panel-heading {
    color: #333;
    background-color: #fff !important;
    border-color: #ddd;
}
.glyphicon {
    position: relative;
    top: 1px;
    display: inline-block;
    font-family: 'Glyphicons Halflings';
    font-style: normal;
    font-weight: 400;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    font-size: 11px !important;
}
</style>

     <script type="text/javascript">
      $(document).ready(function () {
    $('.glyphicon').click(function () {

        $(this).toggleClass("glyphicon glyphicon-plus").toggleClass("glyphicon glyphicon-minus");
    });
});
     

</script> 



    </head>
    <body>

        <div class="container-fluid" style="padding:0px;">
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Grade 1 </a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#collapse1" href="#sectioncollapse"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>Section 1</a>
                                    </h4>
                                </div>
                                <div id="sectioncollapse" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="panel-group" id="sectioncontainer">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#sectioncontainer" href="#enslish"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>English</a>
                                                    </h4>
                                                </div>
                                                <div id="enslish" class="panel-collapse collapse in">
                                                    <div class="panel-body">
                                                        <div class="panel-group" id="data_attributes">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#data_attributes" href="#courseprogress"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>Course Progress</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="courseprogress" class="panel-collapse collapse in">
                                                                <div class="panel-body">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Students</th>
                                                                                <th>Lesson1</th>
                                                                                <th>Lesson2</th>
                                                                                <th>Lesson3</th>
                                                                                <th>Lesson4</th>
                                                                                <th>Lesson5</th>
                                                                                <th>Lesson6</th>
                                                                                <th>Lesson7</th>
                                                                                <th>Lesson8</th>
                                                                                <th>Lesson9</th>
                                                                                <th>Lesson10</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>Asghir</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Asghir</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Asghir</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Asghir</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                </div>    
                                                            </div>
                                                            <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h4 class="panel-title">
                                                                    <a data-toggle="collapse" data-parent="#data_attributes" href="#evaluation"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Evaluation</a>
                                                                </h4>
                                                            </div>
                                                            <div id="evaluation" class="panel-collapse collapse">
                                                                <div class="panel-body">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Students</th>
                                                                                <th>Quiz1</th>
                                                                                <th>Quiz2</th>
                                                                                <th>Quiz3</th>
                                                                                <th>Quiz4</th>
                                                                                <th>Quiz5</th>
                                                                                <th>Quiz6</th>
                                                                                <th>Quiz7</th>
                                                                                <th>Quiz8</th>
                                                                                <th>Quiz9</th>
                                                                                <th>Quiz10</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>Asghir</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Asghir</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Asghir</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Asghir</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                                <td>red</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>    
                                                            </div>
                                                            <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h4 class="panel-title">
                                                                    <a data-toggle="collapse" data-parent="#data_attributes" href="#result"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Result</a>
                                                                </h4>
                                                            </div>
                                                            <div id="result" class="panel-collapse collapse">
                                                                <div class="panel-body">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                               <th>Student Name</th>
                                                                               <th>Mid Term</th>
                                                                               <th>Final Term</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>Asghir</td>
                                                                                <td>A</td>
                                                                                <td>B</td>
                                                                            </tr>
                                                                            <tr>
                                                                               <td>Asghir</td>
                                                                               <td>A</td>
                                                                               <td>B</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Asghir</td>
                                                                                <td>A</td>
                                                                                <td>B</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Asghir</td>
                                                                                <td>A</td>
                                                                                <td>B</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>    
                                                            </div>
                                                            <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h4 class="panel-title">
                                                                    <a data-toggle="collapse" data-parent="#data_attributes" href="#lessonplan"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Lesson Plan</a>
                                                                </h4>
                                                            </div>
                                                            <div id="lessonplan" class="panel-collapse collapse">
                                                                <div class="panel-body">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                              <th >1 May</th>
                                                                              <th>2 May</th>
                                                                              <th>3-May</th>
                                                                              <th>4-May</th>
                                                                              <th>5-May</th>
                                                                              <th>6-May</th>
                                                                              <th>7-May</th>
                                                                              <th>8-May</th>
                                                                              <th>9-May</th>
                                                                              <th>10-May</th>
                                                                              </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>L1</td>
                                                                                <td>L1</td>
                                                                                <td>L1</td>
                                                                                <td>L1</td>
                                                                                <td>L1</td>
                                                                                <td>L1</td>
                                                                                <td>L1</td>
                                                                                <td>L1</td>
                                                                                <td>L1</td>
                                                                                <td>L1</td>
                                                                            </tr>
                                                                            
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>    
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#sectioncontainer" href="#math"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Math</a>
                                                </h4>
                                            </div>
                                            <div id="math" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <div class="panel-group" id="math_data_attribute">
                                                        <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#math_data_attribute" href="#courseprogress1"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Course Progress</a>
                                                            </h4>
                                                        </div>
                                                        <div id="courseprogress1" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Students</th>
                                                                            <th>Lesson1</th>
                                                                            <th>Lesson2</th>
                                                                            <th>Lesson3</th>
                                                                            <th>Lesson4</th>
                                                                            <th>Lesson5</th>
                                                                            <th>Lesson6</th>
                                                                            <th>Lesson7</th>
                                                                            <th>Lesson8</th>
                                                                            <th>Lesson9</th>
                                                                            <th>Lesson10</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>    
                                                        </div>
                                                        <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#math_data_attribute" href="#evaluation1"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Evaluation</a>
                                                            </h4>
                                                        </div>
                                                        <div id="evaluation1" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Students</th>
                                                                            <th>Quiz1</th>
                                                                            <th>Quiz2</th>
                                                                            <th>Quiz3</th>
                                                                            <th>Quiz4</th>
                                                                            <th>Quiz5</th>
                                                                            <th>Quiz6</th>
                                                                            <th>Quiz7</th>
                                                                            <th>Quiz8</th>
                                                                            <th>Quiz9</th>
                                                                            <th>Quiz10</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>    
                                                        </div>
                                                        <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#math_data_attribute" href="#result1"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Result</a>
                                                            </h4>
                                                        </div>
                                                        <div id="result1" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                              <th>Student Name</th>
                                                                              <th>Mid Term</th>
                                                                              <th>Final Term</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                             <td>Asghir</td>
                                                                             <td>A</td>
                                                                             <td>B</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>A</td>
                                                                            <td>B</td>
                                                                        </tr>
                                                                        <tr>
                                                                           <td>Asghir</td>
                                                                           <td>A</td>
                                                                           <td>B</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>A</td>
                                                                            <td>B</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>    
                                                        </div>
                                                        <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#math_data_attribute" href="#lessonplan1"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Lesson Plan</a>
                                                            </h4>
                                                        </div>
                                                        <div id="lessonplan1" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th >1 May</th>
                                                                            <th>2 May</th>
                                                                            <th>3-May</th>
                                                                            <th>4-May</th>
                                                                            <th>5-May</th>
                                                                            <th>6-May</th>
                                                                            <th>7-May</th>
                                                                            <th>8-May</th>
                                                                            <th>9-May</th>
                                                                            <th>10-May</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                              <td>L1</td>
                                                                              <td>L1</td>
                                                                              <td>L1</td>
                                                                              <td>L1</td>
                                                                              <td>L1</td>
                                                                              <td>L1</td>
                                                                              <td>L1</td>
                                                                              <td>L1</td>
                                                                              <td>L1</td>
                                                                              <td>L1</td>
                                                                        </tr>
                                                                       
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#sectioncontainer" href="#islamyat"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Islamyat</a>
                                                </h4>
                                            </div>
                                            <div id="islamyat" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <div class="panel-group" id="islamyat_data_attribute">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#islamyat_data_attribute" href="#courseprogress2">Course Progress</a>
                                                            </h4>
                                                        </div>
                                                        <div id="courseprogress2" class="panel-collapse collapse">
                                                            <div class="panel-body">

                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Students</th>
                                                                            <th>Lesson1</th>
                                                                            <th>Lesson2</th>
                                                                            <th>Lesson3</th>
                                                                            <th>Lesson4</th>
                                                                            <th>Lesson5</th>
                                                                            <th>Lesson6</th>
                                                                            <th>Lesson7</th>
                                                                            <th>Lesson8</th>
                                                                            <th>Lesson9</th>
                                                                            <th>Lesson10</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#islamyat_data_attribute" href="#evaluation2"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Evaluation</a>
                                                            </h4>
                                                        </div>
                                                        <div id="evaluation2" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                             <th>Students</th>
                                                                             <th>Quiz1</th>
                                                                             <th>Quiz2</th>
                                                                             <th>Quiz3</th>
                                                                             <th>Quiz4</th>
                                                                             <th>Quiz5</th>
                                                                             <th>Quiz6</th>
                                                                             <th>Quiz7</th>
                                                                             <th>Quiz8</th>
                                                                             <th>Quiz9</th>
                                                                             <th>Quiz10</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                            <td>red</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#islamyat_data_attribute" href="#result2"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Result</a>
                                                            </h4>
                                                        </div>
                                                        <div id="result2" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                             <th>Student Name</th>
                                                                             <th>Mid Term</th>
                                                                             <th>Final Term</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>A</td>
                                                                            <td>B</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>A</td>
                                                                            <td>B</td>
                                                                        </tr>
                                                                        <tr>
                                                                             <td>Asghir</td>
                                                                             <td>A</td>
                                                                             <td>B</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Asghir</td>
                                                                            <td>A</td>
                                                                            <td>B</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#islamyat_data_attribute" href="#lessonplan2"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Lesson Plan</a>
                                                            </h4>
                                                        </div>
                                                        <div id="lessonplan2" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                          <th >1 May</th>
                                                                          <th>2 May</th>
                                                                          <th>3-May</th>
                                                                          <th>4-May</th>
                                                                          <th>5-May</th>
                                                                          <th>6-May</th>
                                                                          <th>7-May</th>
                                                                          <th>8-May</th>
                                                                          <th>9-May</th>
                                                                          <th>10-May</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                              <td >L1</td>
                                                                              <td>L1</td>
                                                                              <td>L1</td>
                                                                              <td>L1</td>
                                                                              <td>L1</td>
                                                                              <td>L1</td>
                                                                              <td>L1</td>
                                                                              <td>L1</td>
                                                                              <td>L1</td>
                                                                              <td>L1</td>
                                                                        </tr>
                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Grade 2</a>
                            </h4>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                            <div class="panel-body"></div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Grade 3</a>
                            </h4>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse">
                            <div class="panel-body"></div>
                        </div>
                    </div>
                </div>
            </div>
             
             
             <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script> 
    </body>
    </html>
