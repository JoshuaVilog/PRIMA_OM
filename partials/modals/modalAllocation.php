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
                <hr id="hr1">
                <div class="row" id="rowForm1">
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
                <div class="row" id="rowDisplay1" style="display:none;">
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group has-info">
                            <label>
                                <strong>SHIFT:</strong>
                            </label>
                            <input type="text" class="form-control disabled input-lg" id="txtDisplayShift">
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group has-info">
                            <label>
                                <strong>STATUS:</strong>
                            </label>
                            <input type="text" class="form-control disabled input-lg" id="txtDisplayAttendanceStatus">
                        </div>
                    </div>
                </div>
                <hr id="hr2">
                <div class="row" id="rowForm2" style="display:none;">
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label>
                                <strong>PROCESS:</strong>
                            </label>
                            <select id="selectProcess" class="form-control"></select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group" id="formMachine" style="display:none;">
                            <label>
                                <strong>MACHINE:</strong>
                            </label>
                            <select id="selectMachine" class="form-control"></select>
                        </div>
                    </div>
                </div>
                <div class="row" id="rowDisplay2" style="display:none;">
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group has-info">
                            <label>
                                <strong>PROCESS:</strong>
                            </label>
                            <input type="text" class="form-control disabled input-lg" id="txtDisplayProcess">
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group has-info" id="formDisplayMachine" style="display:none;">
                            <label>
                                <strong>MACHINE:</strong>
                            </label>
                            <input type="text" class="form-control disabled input-lg" id="txtDisplayMachine">
                        </div>
                    </div>
                </div>
                <hr id="hr3">
                <div class="form-group">
                    <label>
                        <strong>REMARKS:</strong>
                    </label>
                    <textarea id="txtRemarks" class="form-control" rows="3"></textarea>
                </div>

                <input type="hidden" id="hiddenAllocationID">
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnSave">SAVE</button>
                <button class="btn btn-primary" id="btnIn">IN</button>
                <button class="btn btn-danger" id="btnOut">OUT</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>