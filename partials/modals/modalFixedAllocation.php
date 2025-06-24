<div id="modalFixedAllocation" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitleAllocation">-</h4>
            </div>
            <div class="modal-body">
                <div class="form-group has-info">
                    <label>
                        <strong>OPERATOR:</strong>
                    </label>
                    <input type="text" class="form-control disabled input-lg" id="txtDisplayOperatorName">
                    <input type="hidden" class="" id="txtOperatorID">
                </div>
                <hr id="hr2">
                <div class="row" id="rowForm2">
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label>
                                <strong>PROCESS:</strong>
                            </label>
                            <select id="selectProcess" class="form-control"></select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group" id="formMachine" style="display: none; ">
                            <label>
                                <strong>MACHINE:</strong>
                            </label>
                            <select id="selectMachine" class="form-control"></select>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="hiddenFixedAllocationID">
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnSave">SAVE</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>