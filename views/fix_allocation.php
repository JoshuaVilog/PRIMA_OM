
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
                        <h1>Fix Allocation</h1>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-12 pricing-box">
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
        
        <!-- MODAL  -->
        <?php
        include "partials/modals/modalFixedAllocation.php";
        // include "partials/modals/modalAddRecord.php";
        // include "partials/modals/modalEditRecord.php";
        ?>
    </div>
    <!-- JavaScript -->
    <script src="/<?php echo $rootFolder; ?>/script/FixedAllocation.js?v=<?php echo $generateRandomNumber; ?>"></script>
    <script src="/<?php echo $rootFolder; ?>/script/Allocation.js?v=<?php echo $generateRandomNumber; ?>"></script>
    <script>

        let fixedAllocation = new FixedAllocation();
        let allocation = new Allocation();

        fixedAllocation.DisplayFixedAllocation("#table-records");


        $("#table-records").on("click", ".btnModifyRecord", function(){
            let value = $(this).val();

            $("#txtDisplayOperatorName").val(main.SetEmployeeNameByRFID(value));
            $("#txtOperatorID").val(value);

            fixedAllocation.FindOperatorFixedAllocation(value, function(response){
                // console.log(response);
                if(response == null){

                    $("#hiddenFixedAllocationID").val(0);
                    allocation.PopulateProcess($("#selectProcess"));
                    $("#formMachine").hide();
                } else {
                    allocation.PopulateProcess($("#selectProcess"), response.PROCESS);
                    $("#hiddenFixedAllocationID").val(response.RID);

                    if(response.MACHINE_CODE == 0){

                        allocation.PopulateMachine($("#selectMachine"), 0,);
                        $("#formMachine").hide();
                    } else {

                        allocation.PopulateMachine($("#selectMachine"), response.PROCESS, response.MACHINE_CODE);
                        $("#formMachine").show();
                    }

                }

                $("#modalFixedAllocation").modal("show");

            });
        });

        $("#selectProcess").change(function(){
            let processID = $(this).val();
            let process = allocation.CheckProcessType(processID);

            if(process == "MACHINE"){

                $("#formMachine").show();
                allocation.PopulateMachine($("#selectMachine"), processID);
            } else if(process == "PROCESS"){

                $("#formMachine").hide();
                allocation.PopulateMachine($("#selectMachine"), 0);
            } else {
                $("#formMachine").hide();
                allocation.PopulateMachine($("#selectMachine"), 0);
            }
        });
        $("#btnSave").click(function(){

            fixedAllocation.operator = $("#txtOperatorID").val();
            fixedAllocation.process = $("#selectProcess").val();
            fixedAllocation.machine = $("#selectMachine").val();
            fixedAllocation.allocationID = $("#hiddenFixedAllocationID").val();
            fixedAllocation.modal = $("#modalFixedAllocation");
            fixedAllocation.table = "#table-records";

            fixedAllocation.UpdateFixedAllocation(fixedAllocation);

        })





        /*  
        let record = new Record();
        //DISPLAY RECORDS
       record.DisplayRecords("#table-records");

        $("#btnOpenModalAdd").click(function(){
            
            $("#modalAdd").modal("show");

        });
        $("#btnAdd").click(function(){

            record.desc = $("#txtDesc");
            record.modal = $("#modalAdd");
            record.table = "#table-records";

            record.InsertRecord(record);

        });
        $("#table-records").on("click", ".btnEditRecord", function(){
            let id = $(this).val();

            record.id = id;
            record.desc = $("#txtEditDesc");
            record.modal = $("#modalEdit");
            record.table = "#table-records";
            record.hiddenID = $("#hiddenID");

            record.SetRecord(record);
        });
        $("#btnUpdate").click(function(){

            record.desc = $("#txtEditDesc");
            record.id = $("#hiddenID");
            record.modal = $("#modalEdit");
            record.table = "#table-records";

            record.UpdateRecord(record);
        });
        $("#table-records").on("click", ".btnRemoveRecord", function(){
            let id = $(this).val();

            record.table = "#table-records";
            record.id = id;
            
            record.RemoveRecord(record);

        });
 */
        


    </script>

