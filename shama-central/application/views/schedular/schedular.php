<?php
// require_header
require APPPATH.'views/__layout/header.php';

// require_top_navigation
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation
require APPPATH.'views/__layout/leftnavigation.php';
?>

<link rel="stylesheet" href="<?php echo base_url(); ?>js/bs-iconpicker/css/bootstrap-iconpicker.min.css">
<script src="<?php echo base_url(); ?>js/jquery.mjs.nestedSortable.js"></script>

<div class="col-sm-10" ng-controller="schCtrl">


    <?php
        // require_footer
        require APPPATH.'views/__layout/filterlayout.php';
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
    <div id="delete_location" class="modal fade">
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
                    <button type="button" id="remove_location" class="btn btn-default " value="save">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <div id="delete_school" class="modal fade">
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
                    <button type="button" id="remove_school" class="btn btn-default " value="save">Yes</button>
                </div>
            </div>
        </div>
    </div>



    <div class="panel panel-default">
        <div class="panel-heading">
            <label>Lesson Sets</label>
        </div>
        <div class="panel-body">

            <input type="hidden" id="shama_api_path" value="<?php echo SHAMA_CORE_API_PATH; ?>">

            <div class="row">
                <div class="col-lg-12">
                    <form class="form-inline">
                    <div class="form-group">
                        <label for="select_class">Grade <span class="required"></span></label>
                            
                        <select ng-options="item.name for item in classlist track by item.id"  name="select_class" id="select_class"  ng-model="select_class" ng-change="changeclass()" class="form-control"> </select>
                    </div>

                    <div class="form-group">
                        <label for="inputSemester">Semester <span class="required"></span></label>
                        <select ng-options="item.name for item in semesterlist track by item.id"  name="inputSemester" id="inputSemester"  ng-model="inputSemester" ng-change="changesemester()" class="form-control"></select>
                    </div>

                     <div class="pull-right">
                        <button id="btnReload" type="button" class="btn btn-primary" ng-click="saveschedular()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">
                             Save
                        </button>
                    </div>
                    </form>
                </div>
            </div>

            <div id="container">
                <div class="col-sm-12">
                        <div class="panel-body" id="cont">
                            <ol class="sortable">
                            </ol>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style type="text/css">
          .placeholder {
            outline: 1px dashed #4183C4;
            margin: 0;
            display: block;
            padding: 18px 15px;
        }

        .mjs-nestedSortable-error {
            background: #fbe3e4;
            border-color: transparent;
        }

        #tree {
            width: 550px;
            margin: 0;
        }

        ol {
            max-width: 450px;
            padding-left: 25px;
        }

        ol.sortable,ol.sortable ol {
            list-style-type: none;
            padding-left: 0;
            margin-bottom: 15px;
        }

        .sortable li div {
            border: 1px solid #d4d4d4;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            cursor: move;
            border-color: #D4D4D4 #D4D4D4 #BCBCBC;
            margin: 0;
            display: block;
            padding: 10px 15px;
            margin-bottom: -1px;
            background-color: #fff;
            border: 1px solid #ddd;
        }

        .sortable > li > div:nth-child(1){
            font-weight: bold;
        }

        li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {
            border-color: #999;
        }

        .disclose, .expandEditor {
            cursor: pointer;
            width: 20px;
            display: none;
        }

        .sortable li.mjs-nestedSortable-collapsed > ol {
            display: none;
        }

        .sortable li.mjs-nestedSortable-branch > div > .disclose {
            display: inline-block;
        }

        .sortable span.ui-icon {
            display: inline-block;
            margin: 0;
            padding: 0;
        }

        .menuDiv {
            background: #EBEBEB;
        }

        .menuEdit {
            background: #FFF;
        }

        .itemTitle {
            vertical-align: middle;
            cursor: pointer;
        }

        .deleteMenu {
            float: right;
            cursor: pointer;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 0;
        }

        h2 {
            font-size: 1.2em;
            font-weight: 400;
            font-style: italic;
            margin-top: .2em;
            margin-bottom: 1.5em;
        }

        h3 {
            font-size: 1em;
            margin: 1em 0 .3em;
        }

        p,ol,ul,pre,form {
            margin-top: 0;
            margin-bottom: 1em;
        }

        dl {
            margin: 0;
        }

        dd {
            margin: 0;
            padding: 0 0 0 1.5em;
        }

        code {
            background: #e5e5e5;
        }

        input {
            vertical-align: text-bottom;
        }

        .notice {
            color: #c33;
        }
</style>


<script src="<?php echo base_url(); ?>js/schedular/app.js"></script>
<?php
// require_footer
require APPPATH.'views/__layout/footer.php';
?>
