
<body class="no-skin">
    <?php include "partials/navbar.php";?>

    <div class="main-container ace-save-state" id="main-container">
        <script type="text/javascript">
            try{ace.settings.loadState('main-container')}catch(e){}
        </script>

        <?php include "partials/sidebar.php";?>
        <div class="main-content">
            <div class="main-content-inner">
                <div class="page-content">
                    <div class="page-header">
                        <h1>Machine</h1>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 pricing-box">
                            <div class="widget-box widget-color-orange">
                                <div class="widget-header">
                                    <h5 class="widget-title bigger lighter">List</h5>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Description:</label>
                                                    <input type="text" class="form-control" id="txtDesc">
                                                </div>
                                                <hr>
                                                <input type="hidden" id="hiddenID">
                                                <button class="btn btn-primary" id="btnAdd">Submit</button>
                                                <button class="btn btn-primary" id="btnUpdate" style="display: none;">Save</button>
                                                <button class="btn btn-default" id="btnCancel" style="display: none;">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 pricing-box">
                            <div class="widget-box widget-color-orange">
                                <div class="widget-header">
                                    <h5 class="widget-title bigger lighter">List</h5>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div id="table-records"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include "partials/footer.php";?>
        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
        </a>
    </div>
    <!-- JavaScript -->
    <script src="/<?php echo $rootFolder; ?>/script/Machine.js?v=<?php echo $generateRandomNumber; ?>"></script>
    <script>
        $("#menu_crud_machine").addClass("active");
        $("#menuUtilities").addClass("active open");

        let machine = new Machine();

        //DISPLAY RECORDS
        machine.DisplayRecords("#table-records");

        $("#btnOpenModalAdd").click(function(){
            
            $("#modalAdd").modal("show");

        });
        $("#btnAdd").click(function(){

            machine.desc = $("#txtDesc");
            machine.modal = $("#modalAdd");
            machine.table = "#table-records";

            machine.InsertRecord(machine);

        });
        $("#table-records").on("click", ".btnEditRecord", function(){
            let id = $(this).val();

            machine.id = id;
            machine.desc = $("#txtDesc");
            machine.modal = $("#modalEdit");
            machine.table = "#table-records";
            machine.hiddenID = $("#hiddenID");
            machine.btnAdd = $("#btnAdd");
            machine.btnCancel = $("#btnCancel");
            machine.btnUpdate = $("#btnUpdate");

            machine.SetRecord(machine);
        });
        $("#btnUpdate").click(function(){

            machine.desc = $("#txtDesc");
            machine.id = $("#hiddenID");
            machine.modal = $("#modalEdit");
            machine.table = "#table-records";
            machine.btnAdd = $("#btnAdd");
            machine.btnCancel = $("#btnCancel");
            machine.btnUpdate = $("#btnUpdate");

            // $("#btnAdd").show();
            // $("#btnUpdate").hide();
            // $("#btnCancel").hide();

            machine.UpdateRecord(machine);
        });
        $("#table-records").on("click", ".btnRemoveRecord", function(){
            let id = $(this).val();

            machine.table = "#table-records";
            machine.id = id;
            
            machine.RemoveRecord(machine);

        });
        $("#btnCancel").click(function(){

            $("#btnAdd").show();
            $("#btnUpdate").hide();
            $("#btnCancel").hide();
            $("#txtDesc").val("");
            $("#hiddenID").val("");

        });

        


    </script>

