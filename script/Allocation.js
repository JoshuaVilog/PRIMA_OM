class Allocation extends Main{
    constructor(){
        super()
        this.tableDisplay = null;
        this.tableDisplayAllocationLogs = null;
        this.totalOperatorAttendance = 0;
        this.totalOperatorRecorded = 0;
    }
    DisplayTotalAttendance(elemTotalOperator, elemTotalRecorded){

        elemTotalOperator.text(this.totalOperatorAttendance);
        elemTotalRecorded.text(this.totalOperatorRecorded);

    }
    /* 

    */

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
                let totalNotRecorded = response.data.filter(function(x){return x.ALLOCATION_ID == 0}).length;

                self.totalOperatorAttendance = response.data.length;
                self.totalOperatorRecorded = self.totalOperatorAttendance - totalNotRecorded;


                self.tableDisplay = new Tabulator(tableElem, {
                    data: response.data,
                    pagination: "local",
                    paginationSize: 25,
                    paginationSizeSelector: [25, 50, 100],
                    page: 1,
                    ajaxURL: "your_data_endpoint_here.json",
                    layout:"fitDataFill",
                    responsiveLayout:"collapse",
                    columns: [
                        {title: "#", formatter: "rownum", visible: true, },
                        {title: "id", field:"id", visible: false, },
                        {title: "ID", field: "ALLOCATION_ID", headerFilter: "input", visible: false, },
                        {title: "OPERATOR", field: "EMPLOYEE_NAME", headerFilter: "input", resizable: false,},
                        {title: "SHIFT", field: "SHIFT", formatter: function(cell){

                            return (cell.getValue() != 0) ? main.SetShift(cell.getValue()) : "-";
                        }, resizable: false, },
                        {title: "STATUS", field: "ATTENDANCE_STATUS", formatter: function(cell){
                            return (cell.getValue() != 0) ? main.SetAttendanceStatus(cell.getValue()) : "-";
                        }, resizable: false, },
                        {title: "ACTION", field:"ALLOCATION_ID", hozAlign: "left", headerSort: false, resizable: false, frozen:true, formatter:function(cell){
                            let id = cell.getValue();
                            let rowData = cell.getRow().getData();

                            let setStatus = '<button class="btn btn-success btn-minier btnSetStatus" value="'+rowData.EMPLOYEE_ID+'">Set Status</button>';
                            let modify = '<button class="btn btn-warning btn-minier btnModify" value="'+id+'">Modify</button>';
                            
                            if(id == 0){
                                return setStatus;
                            } else {
                                if(rowData.ATTENDANCE_STATUS == "1"){

                                    return modify;
                                } else {
                                    return "-";
                                }
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
    DisplayAllocationLogRecords(tableElem){
        let self = this;

        $.ajax({
            url: "php/controllers/Allocation/AllocationLogsRecords.php",
            method: "POST",
            data: {},
            datatype: "json",
            success: function(response){

                // console.log(response);

                self.tableDisplayAllocationLogs = new Tabulator(tableElem, {
                    data: response.data,
                    pagination: "local",
                    paginationSize: 25,
                    paginationSizeSelector: [25, 50, 100],
                    page: 1,
                    ajaxURL: "your_data_endpoint_here.json",
                    layout: "fitDataFill",
                    columns: [
                        {title: "#", formatter: "rownum", },
                        {title: "ID", field: "RID", headerFilter: "input", visible: false, },
                        {title: "OPERATOR", field: "OPERATOR", headerSort: false, formatter: function(cell){
                            let value = cell.getValue();
                            
                            return (value != 0) ? main.SetEmployeeName(value) : "-";
                        }, },
                        {title: "PROCESS", field: "PROCESS", headerSort: false, formatter: function(cell){
                            let value = cell.getValue();

                            return (value != 0) ? main.SetProcessName(value) : "-";
                        }, },
                        {title: "MACHINE", field: "MACHINE_CODE", headerSort: false, formatter: function(cell){
                            let value = cell.getValue();

                            return (value != 0) ? main.SetMachineName(value) : "-";
                        },},
                        {title: "IN", field: "IN_DATETIME", headerSort: false, },
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
                        {title: "ACTION", field:"RID", width: 300, hozAlign: "left", frozen: true, headerSort: false, frozen:true, visible: false, formatter:function(cell){}},
                    ],
                });
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }
    RealtimeFetch(sessionStorageItem, date){
        
        let datetime = sessionStorage.getItem(sessionStorageItem);  
        let self = this;

        $.ajax({
            url: 'php/controllers/Allocation/RealtimeFetchAllocationRecord.php', 
            type: 'POST',
            data:{
                date: date,
                oldDateTime: datetime,
            },
            success: function(data) {
                // console.log(data);
               
                sessionStorage.setItem(sessionStorageItem, self.GetPhilippinesDateTime());

                if(data != 0){

                    // console.log(data);
                    let newData = data.map(function(value){
                        return {
                            "id": value['id'],
                            "EMPLOYEE_ID": value['EMPLOYEE_ID'],
                            "EMPLOYEE_NAME": main.SetEmployeeName(value['EMPLOYEE_ID']),
                            "ALLOCATION_ID": value['ALLOCATION_ID'],
                            "SHIFT": value['SHIFT'],
                            "ATTENDANCE_STATUS": value['ATTENDANCE_STATUS'],
                        }

                    });

                    // console.log(newData);
                    self.UpdateTableDisplay(newData);
                }
                
        
            },
            error: function(err) {
                console.log("Error:"+JSON.stringify(err));
            }
        });

    }

  /* 
 
  */
    PopulateProcess(selectElem, id){
        let list = JSON.parse(localStorage.getItem(this.lsProcessList));
        let options = '<option value="">-Select-</option>';

        for(let index = 0; index < list.length; index++){
            let selected = "";
            if(id != undefined && list[index].RID == id){
                selected = "selected";
            }

            options += '<option value="'+list[index].RID+'" '+selected+'>'+list[index].PROCESS_NAME+'</option>';

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
                    let selected = "";
                    if(id != undefined && list[index].RID == id){
                        selected = "selected";
                    }
                    options += '<option value="'+list[index].RID+'" '+selected+'>'+list[index].MACHINE_NAME+'</option>';
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
            let selected = "";
            if(this.GetShiftType() == list[index].a){
                selected = "selected";
            }
            
            options += '<option value="'+list[index].a+'" '+selected+'>'+list[index].b+'</option>';
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

    /* 
    
    */

    InsertEmployeeAttendance(attendance){
        let self = this;

        if(attendance.date == "" || attendance.process == "" && attendance.attendanceStatus == "1"){
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
                    operatorName: attendance.operatorName,
                    date: attendance.date,
                    shift: attendance.shift,
                    attendanceStatus: attendance.attendanceStatus,
                    process: attendance.process,
                    machine: attendance.machine,
                    remarks: attendance.remarks,
                },
                datatype: "json",
                success: function(response){
                    response = JSON.parse(response);

                    console.log(response.message);

                    self.UpdateTableDisplay([response.message]);

                    Swal.fire({
                        title: 'Attendance saved successfully!',
                        text: '',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Proceed!',
                        timer: 2000,
                        willClose: () => {
                            // window.location.href = "dashboard";
                            attendance.modal.modal("hide");
                            // self.DisplayRecords(attendance.date, attendance.table);
                        },
                    })
                },
                error: function(err){
                    console.log("Error:"+JSON.stringify(err));
                    alert("Error inserting.");
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
    

    UpdateOutAllocation(allocation){
        let self = this;
        $.ajax({
            url: "php/controllers/Allocation/UpdateOutAllocation.php",
            method: "POST",
            data: {
                allocationID: allocation.allocationID,
                remarks: allocation.remarks,
            },
            datatype: "json",
            success: function(response){
                // console.log(response);
                // callback(response)

                Swal.fire({
                    title: 'Operator Out successfully!',
                    text: '',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Proceed!',
                    timer: 2000,
                    willClose: () => {
                        // window.location.href = "dashboard";
                        allocation.modal.modal("hide");
                        self.DisplayRecords(allocation.date, allocation.table);


                    },
                })
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }
    UpdateInAllocation(allocation){
        let self = this;
        $.ajax({
            url: "php/controllers/Allocation/UpdateInAllocation.php",
            method: "POST",
            data: {
                attendanceID: allocation.attendanceID,
                operator: allocation.operator,
                process: allocation.process,
                machine: allocation.machine,
                remarks: allocation.remarks,
            },
            datatype: "json",
            success: function(response){
                // console.log(response);
                // callback(response)

                Swal.fire({
                    title: 'Operator In successfully!',
                    text: '',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Proceed!',
                    timer: 2000,
                    willClose: () => {
                        // window.location.href = "dashboard";
                        allocation.modal.modal("hide");
                        self.DisplayRecords(allocation.date, allocation.table);


                    },
                })
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }

    UpdateTableDisplay(data){
        let parseData = data;

        this.tableDisplay.updateData(parseData);

        /* this.tableDisplay.updateData(parseData).then(() => {
            console.log("Column updated successfully");
        }).catch((error) => {
            console.error("Error updating column:", error);
        }); */

    }
}

