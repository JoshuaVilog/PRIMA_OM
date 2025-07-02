
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
    GetPhilippinesDateTime(){
        const options = {
            timeZone: "Asia/Manila", 
            year: "numeric", 
            month: "2-digit", 
            day: "2-digit", 
            hour: "2-digit", 
            minute: "2-digit", 
            second: "2-digit",
            hour12: false
        };
    
        const formatter = new Intl.DateTimeFormat("en-US", options);
        const parts = formatter.formatToParts(new Date());
    
        // Format to YYYY-MM-DD HH:MM:SS
        const year = parts.find(p => p.type === "year").value;
        const month = parts.find(p => p.type === "month").value;
        const day = parts.find(p => p.type === "day").value;
        const hour = parts.find(p => p.type === "hour").value;
        const minute = parts.find(p => p.type === "minute").value;
        const second = parts.find(p => p.type === "second").value;
    
        return `${year}-${month}-${day} ${hour}:${minute}:${second}`;
    }
    GetShiftDate(){
        // Get current time in Philippines (UTC+8)
        const currentDate = new Date();
        const philippinesOffset = 8 * 60; // in minutes
        const utc = currentDate.getTime() + (currentDate.getTimezoneOffset() * 60000);
        const phTime = new Date(utc + (philippinesOffset * 60000));

        const hour = phTime.getHours();

        let year = currentDate.getFullYear();
        let month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-indexed
        let day;
        // let formattedDate = `${year}-${month}-${day}`;

        // Determine shift
        /* if (hour >= 7 && hour < 19) {
            return "Dayshift";
        } else {
            return "Nightshift";
        } */
        if (hour >= 7 && hour < 19) {
            day = currentDate.getDate().toString().padStart(2, '0');
        } else {
            day = currentDate.getDate().toString().padStart(2, '0') - 1;
        }

        return `${year}-${month}-${day}`
    }
    GetShiftType(){
        // Get current time in Philippines (UTC+8)
        const now = new Date();
        const philippinesOffset = 8 * 60; // in minutes
        const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
        const phTime = new Date(utc + (philippinesOffset * 60000));

        const hour = phTime.getHours();

        // Determine shift
        if (hour >= 7 && hour < 19) {
            //DAYSHIFT
            return 1;
        } else {
            //NIGHTSHIFT
            return 2;
        }
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


    SetShift(id){
        let list = this.ShiftList();
        let result = list.find(element => element.a === parseInt(id));
            
        return result ? result.b: "";
    }
    SetAttendanceStatus(id){
        let list = this.AttendanceStatusList();
        let result = list.find(element => element.a === parseInt(id));
            
        return result ? result.b: "";
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

