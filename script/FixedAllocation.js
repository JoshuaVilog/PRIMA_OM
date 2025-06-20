class FixedAllocation {
    constructor(){
        // super()
        this.tableDisplay = null;
    }


    DisplayFixedAllocation(tableElem){
        $.ajax({
            url: "php/controllers/FixedAllocation/DisplayFixedAllocation.php",
            method: "POST",
            data: {},
            datatype: "json",
            success: function(response){
                // console.log(response);

                this.tableDisplay = new Tabulator(tableElem, {
                    data: response.data,
                    pagination: "local",
                    paginationSize: 25,
                    paginationSizeSelector: [25, 50, 100],
                    page: 1,
                    ajaxURL: "your_data_endpoint_here.json",
                    layout: "fitDataFill",
                    columns: [
                        {title: "ID", field: "id", visible:false, headerFilter: "input"},
                        {title: "OPERATOR", field: "OPERATOR_NAME", headerFilter: "input"},
                        {title: "PROCESS", field: "PROCESS", formatter: function(cell){
                            let value = cell.getValue();

                            return (value != 0) ? main.SetProcessName(value) : "-";
                        }, },
                        {title: "MACHINE CODE", field: "MACHINE_CODE", formatter: function(cell){
                            let value = cell.getValue();

                            return (value != 0) ? main.SetMachineName(value) : "-";
                        }, },
                        {title: "ACTION", field:"OPERATOR", width: 300, hozAlign: "left", headerSort: false, frozen:true, formatter:function(cell){
                            let id = cell.getValue();
                            let edit = '<button class="btn btn-primary btn-minier btnModifyRecord" value="'+id+'">Modify</button>';
                            let remove = '<button class="btn btn-danger btn-minier btnRemoveRecord" value="'+id+'">Remove</button>';

                            return edit;
                        }},
                    ],
                });

            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });

    }

    UpdateFixedAllocation(){
        $.ajax({
            url: "php/controllers/FixedAllocation/DisplayFixedAllocation.php",
            method: "POST",
            data: {
                date: date,
            },
            datatype: "json",
            success: function(response){
                // console.log(response);

            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });

    }

    FindOperatorFixedAllocation(operator, callback){
        $.ajax({
            url: "php/controllers/FixedAllocation/FindOperatorFixedAllocation.php",
            method: "POST",
            data: {
                operator: operator,
            },
            datatype: "json",
            success: function(response){
                // console.log(response);
                callback(response);
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });

    }




}