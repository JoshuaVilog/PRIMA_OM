
class Main {
    constructor(){
        this.systemLocalStorageTitle = "odas";
        this.lsProcessList = this.systemLocalStorageTitle +"-process-list";
        this.lsMachineList = this.systemLocalStorageTitle +"-machine-list";
        this.lsEmployeeList = this.systemLocalStorageTitle +"-employee-list";

    }
    GetCurrentDate(){
        let currentDate = new Date();
        let year = currentDate.getFullYear();
        let month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-indexed
        let day = currentDate.getDate().toString().padStart(2, '0');
        let formattedDate = `${year}-${month}-${day}`;

        // console.log(formattedDate);  // Outputs something like: 2024-05-29
        return formattedDate;

    }

    AttendanceStatusList(){
        let list = [
            {a: 1, b:"PRESENT", },
            {a: 2, b:"ABSENT", },
            {a: 3, b:"UA", },
            {a: 4, b:"AWOL", },
            {a: 5, b:"LACKING", },
        ];

        return list;
    }
    ShiftList(){
        let list = [
            {a: 1, b: "DAY SHIFT", },
            {a: 2, b: "NIGHT SHIFT", },
        ]

        return list;
    }

    GetProcessList(){
        let self = this;
        $.ajax({
            url: "php/controllers/Process/Records.php",
            method: "POST",
            data: {},
            datatype: "json",
            success: function(response){
                // console.log(response);
                let list = response.data;

                localStorage.setItem(self.lsProcessList, JSON.stringify(list))
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }
    GetMachineList(){
        let self = this;
        $.ajax({
            url: "php/controllers/Machine/Records.php",
            method: "POST",
            data: {},
            datatype: "json",
            success: function(response){
                // console.log(response);
                let list = response.data;

                localStorage.setItem(self.lsMachineList, JSON.stringify(list))
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }
    GetEmployeeRecords(){
        let self = this;
        $.ajax({
            url: "php/controllers/Allocation/EmployeeRecords.php",
            method: "POST",
            data: {},
            datatype: "json",
            success: function(response){
                // console.log(response);
                let list = response.data;

                localStorage.setItem(self.lsEmployeeList, JSON.stringify(list));
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }


    SetProcessName(processID){
        let list = JSON.parse(localStorage.getItem(this.lsProcessList));
        let result = list.find(element => element.RID === processID);
            
        return result ? result.PROCESS_NAME: "";
    }
    SetProcessTypeByID(processID){
        let list = JSON.parse(localStorage.getItem(this.lsProcessList));
        let result = list.find(element => element.RID === processID);
            
        return result ? result.PROCESS_TYPE: "";
    }
    SetMachineName(machineID){
        let list = JSON.parse(localStorage.getItem(this.lsMachineList));
        let result = list.find(element => element.RID === machineID);
            
        return result ? result.MACHINE_NAME: "";
    }
    SetEmployeeName(id){
        let list = JSON.parse(localStorage.getItem(this.lsEmployeeList));
        let result = list.find(element => element.EMPLOYEE_ID === id);
            
        return result ? result.EMPLOYEE_NAME: "";
    }

}


let main = new Main()

main.GetProcessList();
main.GetMachineList();
main.GetEmployeeRecords();

