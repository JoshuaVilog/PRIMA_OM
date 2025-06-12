
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
                        <h1>OPERATOR DAILY ALLOCATION</h1>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-12 pricing-box">
                            <div class="widget-box widget-color-orange">
                                <div class="widget-header">
                                    <h5 class="widget-title bigger lighter">List</h5>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>
                                                        <strong>SELECT DATE:</strong>
                                                    </label>
                                                    <input type="date" id="txtDate" class="form-control">
                                                </div>
                                            </div>
                                        </div>
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
        include "partials/modals/modalAllocation.php";
        // include "partials/modals/modalEditRecord.php";
        ?>
    </div>
    <!-- JavaScript -->
    <script src="/<?php echo $rootFolder; ?>/script/Allocation.js?v=<?php echo $generateRandomNumber; ?>"></script>
    <script>
        let allocation = new Allocation();
    
        $("#txtDate").val(main.GetCurrentDate());

        //DISPLAY RECORDS
        allocation.DisplayRecords(main.GetCurrentDate(), "#table-records");

        $("#txtDate").change(function(){
            let date = $(this).val();

            allocation.DisplayRecords(date, "#table-records");
        });

        $("#table-records").on("click", ".btnSetStatus", function(){
            let operatorID = $(this).val();

            // console.log(id);
            $("#hr1").show();
            $("#hr2").hide();
            $("#hr3").hide();

            $("#rowForm1").show();
            $("#rowDisplay1").hide();
            $("#rowForm2").show();
            $("#rowDisplay2").hide();

            $("#btnSave").show();
            $("#btnIn").hide();
            $("#btnOut").hide();

            $("#modalAllocation").modal("show");
            populateSelectForms();
            $("#txtOperatorID").val(operatorID);
            $("#txtDisplayOperatorName").val(main.SetEmployeeName(operatorID));
            $("#modalTitleAllocation").text("SET STATUS");
        });
        $("#table-records").on("click", ".btnModify", function(){
            let id = $(this).val();

            // console.log(id);
            allocation.GetAttendanceRecord(id, function(data){
                console.log(data);
                $("#txtDisplayOperatorName").val(main.SetEmployeeName(data.OPERATOR));
                $("#txtOperatorID").val(data.OPERATOR);

                if(data.ALLOCATION_RID == 0){
                    // IN
                    $("#modalTitleAllocation").text("IN");

                    
                    $("#hr2").show();
                    $("#hr3").hide();
                    
                    $("#btnIn").show();
                    $("#btnOut").hide();

                    
                    $("#rowDisplay1").show();
                    $("#rowForm2").show();
                    $("#rowDisplay2").hide();

                    populateSelectForms();

                } else {
                    // OUT
                    $("#modalTitleAllocation").text("OUT");

                    $("#rowDisplay1").show();
                    $("#rowForm2").hide();
                    $("#rowDisplay2").show();
                    
                    $("#btnIn").hide();
                    $("#btnOut").show();

                    $("#txtDisplayShift").val(main.SetShift(data.SHIFT));
                    $("#txtDisplayAttendanceStatus").val(main.SetAttendanceStatus(data.ATTENDANCE_STATUS));
                    $("#txtDisplayProcess").val(main.SetProcessName(data.ALLOCATION_RID.PROCESS));
                    $("#hiddenAllocationID").val(data.ALLOCATION_RID.RID);

                    if(data.ALLOCATION_RID.MACHINE_CODE == 0){
                        $("#formDisplayMachine").hide();
                    } else {
                        $("#formDisplayMachine").show();
                        $("#txtDisplayMachine").val(main.SetMachineName(data.ALLOCATION_RID.MACHINE_CODE))

                    }


                    $("#hr2").hide();
                    $("#hr3").show();
                }

            });

            $("#rowForm1").hide();
            $("#hr1").hide();
            $("#btnSave").hide();
            $("#modalAllocation").modal("show");
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
            let date = $("#txtDate").val();
            let operator = $("#txtOperatorID").val();
            let shift = $("#selectShift").val();
            let attendanceStatus = $("#selectAttendanceStatus").val();
            let process = $("#selectProcess").val();
            let machine = $("#selectMachine").val();
            let remarks = $("#txtRemarks").val();

            allocation.date = date;
            allocation.operator = operator;
            allocation.shift = shift;
            allocation.attendanceStatus = attendanceStatus;
            allocation.process = process;
            allocation.machine = machine;
            allocation.remarks = remarks;

            allocation.InsertEmployeeAttendance(allocation);


        });
        $("#btnOut").click(function(){
            let allocationID = $("#hiddenAllocationID").val();
            let remarks = $("#txtRemarks").val();

            allocation.allocationID = allocationID;
            allocation.remarks = remarks;

            allocation.UpdateOutAllocation(allocation);


        });




        function populateSelectForms(){
            $("#formMachine").hide();
            allocation.PopulateProcess($("#selectProcess"));
            allocation.PopulateMachine($("#selectMachine"), 0);
            allocation.PopulateAttendanceStatus($("#selectAttendanceStatus"));
            allocation.PopulateShift($("#selectShift"));
        }



        /* 

        */


    </script>

