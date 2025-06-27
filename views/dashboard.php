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
                    <h1>Dashboard</h1>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group">
                            <label for="">
                                <strong>DATE:</strong>
                            </label>
                            <input type="date" id="txtDate" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <table id="table-display">
                            <tr>
                                <td colspan="2"><strong>ATTENDANCE </strong></td>
                            </tr>
                            <tr>
                                <td>PRESENT</td>
                                <td id="tdTotalPresent">-</td>
                            </tr>
                            <tr>
                                <td>ABSENT</td>
                                <td id="tdTotalAbsent">-</td>
                            </tr>
                            <tr>
                                <td><strong>TOTAL RECORDED</strong></td>
                                <td id="tdTotalRecorded">-</td>
                            </tr>
                            <tr>
                                <td><strong>TOTAL OPERATOR</strong></td>
                                <td id="tdTotalOperator">-</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                                <h5 class="widget-title bigger lighter">List</h5>
                            </div>
                            <div class="widget-body">
                                <div class="widget-main">
                                    <div id="table-records1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                                <h5 class="widget-title bigger lighter">List</h5>
                            </div>
                            <div class="widget-body">
                                <div class="widget-main">
                                    <div id="table-records2"></div>
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
<!-- <script src="/<?php echo $rootFolder; ?>/script/FixedAllocation.js?v=<?php echo $generateRandomNumber; ?>"></script>
<script src="/<?php echo $rootFolder; ?>/script/Allocation.js?v=<?php echo $generateRandomNumber; ?>"></script> -->
<script>
    $("#txtDate").val(main.GetShiftDate());

    setTimeout(() => {
        let date = $("#txtDate").val();

        displayTableRecord1(date);
        displayTotalAttendance(date);
        displayTableRecord2(date);
    }, 1000);

    $("#txtDate").change(function(){
        let date = $(this).val();

        displayTableRecord1(date);
        displayTotalAttendance(date);
        displayTableRecord2(date);
    });

    function displayTableRecord1(date){

        $.ajax({
            url: "php/controllers/Allocation/GetAllocationRecords1.php",
            method: "POST",
            data: {
                date: date,
            },
            datatype: "json",
            success: function(response){

                // console.log(response);

                var table1 = new Tabulator("#table-records1", {
                    data: response.data,
                    pagination: "local",
                    paginationSize: 25,
                    paginationSizeSelector: [25, 50, 100],
                    page: 1,
                    ajaxURL: "your_data_endpoint_here.json",
                    layout: "fitDataFill",
                    columns: [
                        {title: "#", formatter: function(cell) {
                            const row = cell.getRow();
                            const table = row.getTable();
                            const page = table.getPage(); // current page number
                            const size = table.getPageSize(); // rows per page
                            const rowIndex = row.getPosition(true); // position in data
                            return ((page - 1) * size) + row.getPosition(true);
                        }, },
                        {title: "ID", field: "RID", headerFilter: "input", visible: false, },
                        {title: "OPERATOR", field: "OPERATOR", headerSort: false, formatter: function(cell){
                            let value = cell.getValue();
                            
                            return (value != 0 && value != null) ? main.SetEmployeeName(value) : "-";
                        }, },
                        {title: "PROCESS", field: "PROCESS", headerSort: false, formatter: function(cell){
                            let value = cell.getValue();

                            return (value != 0 && value != null) ? main.SetProcessName(value) : "-";
                        }, },
                        {title: "MACHINE", field: "MACHINE_CODE", headerSort: false, formatter: function(cell){
                            let value = cell.getValue();

                            return (value != 0 && value != null) ? main.SetMachineName(value) : "-";
                        },},
                        {title: "STATUS", field: "ATTENDANCE_STATUS", headerSort: false, formatter: function(cell){
                            let value = cell.getValue();

                            cell.getElement().style.backgroundColor = (value == 1)? "#C3FDB8":"#FF6347";

                            return (value != 0) ? main.SetAttendanceStatus(value) : "-";
                        },},
                        /* {title: "IN", field: "IN_DATETIME", headerSort: false, },
                        {title: "IN", field: "IN_BY", headerSort: false, formatter: function(cell){
                            let value = cell.getValue();

                            return (value != 0) ? main.SetEmployeeName(value) : "-";
                        },},
                        {title: "OUT", field: "OUT_DATETIME", headerSort: false, },
                        {title: "OUT", field: "OUT_BY", headerSort: false, formatter: function(cell){
                            let value = cell.getValue();

                            return (value != 0) ? main.SetEmployeeName(value) : "-";
                        },},
                        {title: "REMARKS", field: "REMARKS", headerSort: false,  },
                        {title: "ACTION", field:"RID", width: 300, hozAlign: "left", frozen: true, headerSort: false, frozen:true, visible: false, formatter:function(cell){}}, */
                    ],
                });
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }

    function displayTotalAttendance(date){

        $.ajax({
            url: "php/controllers/Allocation/GetAttendanceByDate.php",
            method: "POST",
            data: {
                date: date,
            },
            datatype: "json",
            success: function(response){

                let data = response.data;
                let present = 0;
                let absent = 0;
                let totalRecorded = 0;

                for(let index = 0; index < data.length; index++){

                    if(data[index].ATTENDANCE_STATUS != 0){
                        totalRecorded++;

                        if(data[index].ATTENDANCE_STATUS == '1'){
                            present++;
                        } else if(data[index].ATTENDANCE_STATUS != '1'){
                            absent++;
                        }

                    }

                }

                $("#tdTotalOperator").text(data.length);
                $("#tdTotalPresent").text(present);
                $("#tdTotalAbsent").text(absent);
                $("#tdTotalRecorded").text(totalRecorded);

            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }

    

    function displayTableRecord2(date){

        $.ajax({
            url: "php/controllers/Allocation/GetAllocationRecords2.php",
            method: "POST",
            data: {
                date: date,
            },
            datatype: "json",
            success: function(response){

                // console.log(response);
                var table2 = new Tabulator("#table-records2", {
                    data: response.data,
                    pagination: "local",
                    paginationSize: 25,
                    paginationSizeSelector: [25, 50, 100],
                    page: 1,
                    ajaxURL: "your_data_endpoint_here.json",
                    layout: "fitDataFill",
                    columns: [
                        {title: "#", formatter: function(cell) {
                            const row = cell.getRow();
                            const table = row.getTable();
                            const page = table.getPage(); // current page number
                            const size = table.getPageSize(); // rows per page
                            const rowIndex = row.getPosition(true); // position in data
                            return ((page - 1) * size) + row.getPosition(true);
                        }, },
                        {title: "ID", field: "RID", headerFilter: "input", visible: false, },
                        {title: "PROCESS", field: "PROCESS", headerSort: false, formatter: function(cell){
                            let value = cell.getValue();

                            return (value != 0 && value != null) ? main.SetProcessName(value) : "-";
                        }, },
                        {title: "MACHINE", field: "MACHINE", headerSort: false, formatter: function(cell){
                            let value = cell.getValue();

                            return (value != 0 && value != null) ? main.SetMachineName(value) : "-";
                        },},
                        {title: "OPERATOR", field: "OPERATOR", headerSort: false, formatter: function(cell){
                            let value = cell.getValue();
                            
                            return (value != 0 && value != null) ? main.SetEmployeeName(value) : "-";
                        }, },
                        {title: "ACTION", field:"RID", width: 300, hozAlign: "left", frozen: true, headerSort: false, frozen:true, visible: false, formatter:function(cell){}},
                    ],
                });

                
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }

</script>
