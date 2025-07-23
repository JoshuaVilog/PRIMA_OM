<style>
    #table-display, #table-display td {
        border: 1px solid;
        padding: 10px;
    }
    #table-display{
        margin: 5px;
    }

</style>
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
                    <h1>Machine Logs</h1>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                                <h5 class="widget-title bigger lighter">List</h5>
                            </div>
                            <div class="widget-body">
                                <div class="widget-main">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="">
                                                    <strong>START DATE:</strong>
                                                </label>
                                                <input type="date" id="txtStartDate" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="">
                                                    <strong>END DATE:</strong>
                                                </label>
                                                <input type="date" id="txtEndDate" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6"></div>
                                        <div class="col-sm-2">
                                            <button class="btn btn-success btn-sm" id="btnExport2">Export</button>
                                        </div>
                                    </div>
                                    <i class="ace-icon fa fa-spinner fa-spin blue bigger-125" id="spinner"></i>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div id="table-records3"></div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div id="chart1"></div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div id="table-records2"></div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="row" style="display:none;">
                    <div class="col-xs-12 col-sm-12">
                        <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                                <h5 class="widget-title bigger lighter">List</h5>
                            </div>
                            <div class="widget-body">
                                <div class="widget-main">
                                    <button class="btn btn-success btn-sm" id="btnExport1">Export</button>
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

    <!-- MODAL  -->
    <?php
    //include "modal/modalAdd.php";
    //include "modal/modalEdit.php";
    ?>
</div>
<!-- JavaScript -->
<script src="/<?php echo $rootFolder; ?>/script/Operation.js?v=<?php echo $generateRandomNumber; ?>"></script>
<script>
    let operation = new Operation();

    $("#txtStartDate").val(main.GetCurrentDate());
    $("#txtEndDate").val(main.GetCurrentDate());

    setTimeout(() => {
        let startDate = $("#txtStartDate").val();
        let endDate = $("#txtEndDate").val();

        $("#txtStartDate").prop("max", startDate);
        $("#txtEndDate").prop("min", startDate);

        operation.DisplayTable1("#table-records")
        operation.DisplayTable2("#table-records2", startDate, endDate);
    }, 500);

    setInterval(() => {
        let startDate = $("#txtStartDate").val();
        let endDate = $("#txtEndDate").val();

        operation.DisplayTable1("#table-records")
        operation.DisplayTable2("#table-records2", startDate, endDate);
    }, 60000);
    
    $("#txtStartDate").change(function(){
        let value = $(this).val();
        let endDate = $("#txtEndDate").val();

        $("#txtEndDate").prop("min", value);
        operation.DisplayTable2("#table-records2", value, endDate);
        $("#spinner").show();
    });
    $("#txtEndDate").change(function(){
        let value = $(this).val();
        let startDate = $("#txtStartDate").val();

        $("#txtStartDate").prop("max", value);
        operation.DisplayTable2("#table-records2", startDate, value);
        $("#spinner").show();
    });

    $("#btnExport1").click(function(){
        operation.ExportTable1();
    });

    $("#btnExport2").click(function(){
        operation.ExportTable2();
    });
</script>
