<form id="editUnitForm" action="{{ route('admin.unit.update', $unit->id) }}" method="post">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Edit Unit</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="server_side_error" role="alert"></div>
            </div>
            <div class="col-sm-12">
                <div class="step step_1">
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <label for="unitName" class="form-label">Unit Name <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="unitName" class="form-control" value="{{ $unit->unitName }}"
                                    placeholder="Enter unit name" required>
                            </div>
                        </div>
                        <div class="col-lg-12 form-group">
                            <label for="machineCount" class="form-label">Machine Count <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="machineCount" class="form-control"
                                    value="{{ $unit->machineCount }}" placeholder="Enter machine count" min="0"
                                    required>
                            </div>
                        </div>
                        <div class="col-lg-12 form-group">
                            <label for="mgTarget" class="form-label">Management Target <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="mgTarget" class="form-control" value="{{ $unit->mgTarget }}" placeholder="Enter management target" min="0" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-lg-12 form-group">
                            <label for="capacity_kg" class="form-label">Capacity (KG) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="capacity_kg" class="form-control" value="{{ $unit->capacity_kg }}" placeholder="Enter capacity in KG" min="0" step="0.01" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="editUnitBtn" class="btn btn-primary" data-check-area="modal-body">Update
            Unit</button>
    </div>
</form>
