
class Operation extends Main {

    constructor(){
        super()
        this.table1 = null;
        this.table2 = null;
        this.table3 = null;

    }

    DisplayTable1(tableElem){
        let self = this;

        $.ajax({
            url: "php/controllers/Machine/DisplayMachineLogsRecords.php",
            method: "POST",
            data: {
                
            },
            datatype: "json",
            success: function(response){
                // console.log(response);

                let newData = response.data.map(function(value){
                    return {
                        "RID": value['RID'],
                        "MACHINE_CODE": value['MACHINE_CODE'],
                        "DATE": main.GetDateOnly(value['IN_DATETIME']),
                        "IN_DATETIME": value['IN_DATETIME'],
                        "OUT_DATETIME": (value['OUT_DATETIME'] != null) ? value['OUT_DATETIME'] : "",
                        "DURATION": main.GetDurationMinutes(value['IN_DATETIME'], value['OUT_DATETIME']),
                        // "DURATION" : "",
                        "IN_BY": main.SetEmployeeNameByRFID(value['IN_BY']),
                        "OUT_BY": main.SetEmployeeNameByRFID(value['OUT_BY']),
                        "JOB_TITLE": main.SetJobPosition(main.SetEmployeeJobPositionByRFID(value['IN_BY'])),
                        "PURPOSE": main.SetPurpose(value['PURPOSE']),
                    }
                });

                // console.log(newData);
                
                self.table1 = new Tabulator(tableElem, {
                    data: newData,
                    pagination: "local",
                    paginationSize: 15,
                    paginationSizeSelector: [15, 25, 50, 100],
                    page: 1,
                    ajaxURL: "your_data_endpoint_here.json",
                    layout: "fitDataFill",
                    placeholder: "-NO DATA-",
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
                        {title: "MACHINE", field: "MACHINE_CODE",  headerFilter: "input", },
                        {title: "PURPOSE", field: "PURPOSE",  headerFilter: "input", },
                        {title: "DATE", field: "DATE", headerFilter: "input", },
                        {title: "TIME IN", field: "IN_DATETIME", headerFilter: "input", },
                        {title: "TIME OUT", field: "OUT_DATETIME", headerFilter: "input", },
                        {title: "DURATION", field: "DURATION", headerFilter: "input", bottomCalc:"sum"},
                        {title: "JOB TITLE", field: "JOB_TITLE", headerFilter: "input", },
                        {title: "IN", field: "IN_BY",  headerFilter: "input", formatter: function(cell){
                            let value = cell.getValue();
                            
                            return (value != "") ? value : "-";
                        }, },
                        
                        {title: "OUT", field: "OUT_BY", headerFilter: "input", formatter: function(cell){
                            let value = cell.getValue();
                            
                            return (value != "") ? value : "-";
                        }, },
                        
                        {title: "ACTION", field:"RID", width: 300, hozAlign: "left", frozen: true, headerSort: false, frozen:true, visible: false, formatter:function(cell){}},
                    ],
                });


                $("#spinner").hide();
                
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
                $("#spinner").hide();
            },
        });
    }
    ExportTable1(){

        this.table1.download("xlsx", "Injection Machine Operation.xlsx", { sheetName: "Sheet1" });
    }

    DisplayTable2(tableElem, startDate, endDate){
        let self = this;

        $.ajax({
            url: "php/controllers/Machine/DisplayMachineLogsRecordsByDate.php",
            method: "POST",
            data: {
                startDate: startDate,
                endDate: endDate,
            },
            datatype: "json",
            success: function(response){
                // console.log(response);
                let newData = response.data.map(function(value){
                    return {
                        "RID": value['RID'],
                        "MACHINE_CODE": value['MACHINE_CODE'],
                        "DATE": main.GetDateOnly(value['IN_DATETIME']),
                        "IN_DATETIME": value['IN_DATETIME'],
                        "OUT_DATETIME": (value['OUT_DATETIME'] != null) ? value['OUT_DATETIME'] : "",
                        "DURATION": main.GetDurationMinutes(value['IN_DATETIME'], value['OUT_DATETIME']),
                        // "DURATION" : "",
                        "IN_BY": main.SetEmployeeNameByRFID(value['IN_BY']),
                        "OUT_BY": main.SetEmployeeNameByRFID(value['OUT_BY']),
                        "JOB_TITLE": main.SetJobPosition(main.SetEmployeeJobPositionByRFID(value['IN_BY'])),
                        "PURPOSE": main.SetPurpose(value['PURPOSE']),
                    }
                });

                console.log(newData);

                self.DisplayTable3("", newData);
                self.SetChart1("", newData);
                
                self.table2 = new Tabulator(tableElem, {
                    data: newData,
                    pagination: "local",
                    paginationSize: 50,
                    paginationSizeSelector: [ 50, 100, 150],
                    page: 1,
                    ajaxURL: "your_data_endpoint_here.json",
                    layout: "fitDataFill",
                    placeholder: "-NO DATA-",
                    groupBy: function(data){

                        return data.MACHINE_CODE
                    },
                    columns: [
                        /* {title: "#", formatter: function(cell) {
                            const row = cell.getRow();
                            const table = row.getTable();
                            const page = table.getPage(); // current page number
                            const size = table.getPageSize(); // rows per page
                            const rowIndex = row.getPosition(true); // position in data
                            return ((page - 1) * size) + row.getPosition(true);
                        }, }, */
                        {title: "ID", field: "RID", headerFilter: "input", visible: false, },
                        {title: "MACHINE", field: "MACHINE_CODE",  headerFilter: "input", },
                        {title: "PURPOSE", field: "PURPOSE",  headerFilter: "input", },
                        {title: "DATE", field: "DATE", headerFilter: "input", },
                        {title: "TIME IN", field: "IN_DATETIME", headerFilter: "input", },
                        {title: "TIME OUT", field: "OUT_DATETIME", headerFilter: "input", },
                        {title: "DURATION", field: "DURATION", headerFilter: "input", bottomCalc:"sum"},
                        {title: "JOB TITLE", field: "JOB_TITLE", headerFilter: "input", },
                        {title: "IN", field: "IN_BY",  headerFilter: "input", formatter: function(cell){
                            let value = cell.getValue();
                            
                            return (value != "") ? value : "-";
                        }, },
                        
                        {title: "OUT", field: "OUT_BY", headerFilter: "input", formatter: function(cell){
                            let value = cell.getValue();
                            
                            return (value != "") ? value : "-";
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
    ExportTable2(){

        this.table2.download("xlsx", "Injection Machine Operation.xlsx", { sheetName: "Sheet1" });
    }


    DisplayTable3(tableElem, list){
                
        let map = {};

        list.forEach(item => {
            let user = item.IN_BY;
            let duration = parseFloat(item.DURATION);

            if (!map[user]) {
                map[user] = 0;
            }

            map[user] += duration;
        });

        let result = Object.entries(map).map(([user, total]) => ({
            USER: user,
            TOTAL: total
        }));

        // console.log(result);
        self.table3 = new Tabulator("#table-records3", {
            data: result,
            placeholder: "-NO DATA-",
            // pagination: "local",
            // paginationSize: 10,
            // paginationSizeSelector: [10, 25, 50, 100],
            // page: 1,
            // ajaxURL: "your_data_endpoint_here.json",
            layout: "fitDataFill",
            columns: [
                {title: "USER", field: "USER", headerFilter: "input"},
                {title: "TOTAL", field: "TOTAL", headerFilter: "input", formatter:function(cell){
                    return cell.getValue().toFixed(2);
                }},
            ],
        });
        
    }
    SetChart1(chart, list){
        
        let machineMap = {};
        
        list.forEach(item => {
            let machine = item.PURPOSE;
            if (!machineMap[machine]) {
                machineMap[machine] = 0;
            }
            machineMap[machine]++;
        });
        
        let result = Object.entries(machineMap).map(([label, value]) => ({
            label,
            value
        }));
        

        FusionCharts.ready(function() {
            var myChart = new FusionCharts({
                type: "pie2d",
                renderAt: "chart1",
                width: "100%",
                height: "400",
                dataFormat: "json",
                dataSource: {
                    chart: 
                    {
                        caption: "Total Category",
                        subcaption: "",
                        decimals: "1",
                        theme: "fusion",
                        showLegend: "1",
                    },
                    data: result,
                }
            }).render();
        });
    }
}

