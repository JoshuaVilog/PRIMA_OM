<div id="modalAllocation" class="modal fade">
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
                <hr>
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label>
                                <strong>SHIFT:</strong>
                            </label>
                            <select id="selectShift" class="form-control"></select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label>
                                <strong>STATUS:</strong>
                            </label>
                            <select id="selectAttendanceStatus" class="form-control"></select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>
                        <strong>PROCESS:</strong>
                    </label>
                    <select id="selectProcess" class="form-control"></select>
                </div>
                <div class="form-group" id="formMachine" style="display:none;">
                    <label>
                        <strong>MACHINE:</strong>
                    </label>
                    <select id="selectMachine" class="form-control"></select>
                </div>
                <div class="form-group">
                    <label>
                        <strong>REMARKS:</strong>
                    </label>
                    <textarea id="txtRemarks" class="form-control" rows="3"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnSave">SAVE</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>