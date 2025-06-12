class Allocation extends Main{
    constructor(){
        super()
        this.tableDisplay = null;
    }

    DisplayRecords(date, tableElem){
        let self = this;

        $.ajax({
            url: "php/controllers/Allocation/GetAttendanceByDate.php",
            method: "POST",
            data: {
                date: date,
            },
            datatype: "json",
            success: function(response){

                // console.log(response);

                self.tableDisplay = new Tabulator(tableElem, {
                    data: response.data,
                    pagination: "local",
                    paginationSize: 25,
                    paginationSizeSelector: [25, 50, 100],
                    page: 1,
                    ajaxURL: "your_data_endpoint_here.json",
                    layout: "fitDataFill",
                    columns: [
                        {title: "#", formatter: "rownum", },
                        {title: "ID", field: "ALLOCATION_ID", headerFilter: "input", visible: false, },
                        {title: "OPERATOR", field: "EMPLOYEE_NAME", headerFilter: "input"},
                        {title: "SHIFT", field: "SHIFT", },
                        {title: "STATUS", field: "ATTENDANCE_STATUS", },
                        {title: "ACTION", field:"ALLOCATION_ID", width: 300, hozAlign: "left", frozen: true, headerSort: false, frozen:true, formatter:function(cell){
                            let id = cell.getValue();
                            let rowData = cell.getRow().getData();

                            let setStatus = '<button class="btn btn-success btn-minier btnSetStatus" value="'+rowData.EMPLOYEE_ID+'">Set Status</button>';
                            let modify = '<button class="btn btn-warning btn-minier btnModify" value="'+id+'">Modify</button>';
                            
                            if(id == 0){
                                return setStatus;
                            } else {
                                return modify;
                            }
                        }},
                    ],
                });
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }
  
    PopulateProcess(selectElem){
        let list = JSON.parse(localStorage.getItem(this.lsProcessList));
        let options = '<option value="">-Select-</option>';

        for(let index = 0; index < list.length; index++){
            options += '<option value="'+list[index].RID+'">'+list[index].PROCESS_NAME+'</option>';

        }

        selectElem.html(options);
    }
    PopulateMachine(selectElem, processID){
        let list = JSON.parse(localStorage.getItem(this.lsMachineList));
        let options = '';

        if(processID == "0"){
            options += '<option value="0">-</option>';
        } else {
            for(let index = 0; index < list.length; index++){

                if(processID == list[index].MACHINE_TYPE){
    
                    options += '<option value="'+list[index].RID+'">'+list[index].MACHINE_NAME+'</option>';
                }
            }
        }
        
        selectElem.html(options);
    }
    PopulateAttendanceStatus(selectElem){
        let list = this.AttendanceStatusList();
        let options = '';

        for(let index = 0; index < list.length; index++){
            options += '<option value="'+list[index].a+'">'+list[index].b+'</option>';

        }

        selectElem.html(options);
    }
    PopulateShift(selectElem){
        let list = this.ShiftList();
        let options = '';
        
        for(let index = 0; index < list.length; index++){
            options += '<option value="'+list[index].a+'">'+list[index].b+'</option>';

        }

        selectElem.html(options);
    }
    CheckProcessType(processID){
        let processType = this.SetProcessTypeByID(processID);

        if(processType == "1"){
            // MACHINE
            return "MACHINE";
        } else if(processType == "2"){
            // PROCESS
            return "PROCESS";
        }
    }

    InsertEmployeeAttendance(attendance){

        if(attendance.date == "" || attendance.process == ""){
            Swal.fire({
                title: 'Incomplete Form.',
                text: 'Please complete the login form.',
                icon: 'warning'
            })
        } else {
            
            $.ajax({
                url: "php/controllers/Allocation/InsertAttendance.php",
                method: "POST",
                data: {
                    operator: attendance.operator,
                    date: attendance.date,
                    shift: attendance.shift,
                    attendanceStatus: attendance.attendanceStatus,
                    process: attendance.process,
                    machine: attendance.machine,
                    remarks: attendance.remarks,
                },
                datatype: "json",
                success: function(response){
                    console.log(response);
    
                    Swal.fire({
                        title: 'Record added successfully!',
                        text: '',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Proceed!',
                        timer: 2000,
                        willClose: () => {
                            // window.location.href = "dashboard";
                        },
                    })
                },
                error: function(err){
                    console.log("Error:"+JSON.stringify(err));
                },
            });
        }
    }

    GetAttendanceRecord(attendanceID, callback){
        $.ajax({
            url: "php/controllers/Allocation/GetAttendanceByRID.php",
            method: "POST",
            data: {
                id:attendanceID,
            },
            datatype: "json",
            success: function(response){
                // console.log(response);
                callback(response)
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }
    /* 
    

    */

    UpdateOutAllocation(allocation){

        $.ajax({
            url: "php/controllers/Allocation/UpdateOutAllocation.php",
            method: "POST",
            data: {
                allocationID: allocation.allocationID,
                remarks: allocation.remarks,
            },
            datatype: "json",
            success: function(response){
                console.log(response);
                // callback(response)

                alert("TEST")
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }
    UpdateInAllocation(){


    }
}

