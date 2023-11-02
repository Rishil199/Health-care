@if ( !$modal_view )
    <div class="branch-panel">
        <hr class="my-3">
        <div class="row">
            <div class="form-row col-12">
                <h3>New Branch</h3>
                <hr>
            </div>
@endif
    <div class="col-md-6">
        <div class="form-group">
            <label for="name" class="theme-label">Clinic Name <span class="text-danger">*</span></label>
            <div class="theme-form-input">
                <input class="form-control" id="first_name" name="first_name" type="text" placeholder="Clinic Name" required />
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="email">Email <span class="text-danger">*</span></label>
            <div class="theme-form-input">
                <input class="form-control" id="email" name="email" type="email" placeholder="Clinic Email" required />
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="phone_no" class="theme-label">Phone No. <span class="text-danger">*</span></label>
            <div class="theme-form-input">
                <input class="form-control" id="phone_no" name="phone_no" type="text" placeholder="Clinic Phone No." required />
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="address" class="theme-label">Address <span class="text-danger">*</span></label>
            <div class="theme-form-input">
                <textarea class="form-control" id="address" name="address" type="text" placeholder="Clinic Address" style="resize: none;" required></textarea>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <div class="form-label label-title d-block">
                <label for="status" class="theme-label">Status <span class="text-danger">*</span></label>
            </div>
            <div class="input-wrapper d-flex">
                <div class="input-block">
                    <input name="status" id="statusActive" type="radio" value="1" checked>
                    <label class="theme-label" for="statusActive">Activate</label>
                </div>
                <div class="input-block ms-3">
                    <input name="status" type="radio" value="0" id="statusNotActive">
                    <label class="theme-label" for="statusNotActive">Deactive</label>
                </div>
            </div>
        </div>
    </div>    
@if ( !$modal_view )
        <div class="col-md-6 text-right">
            <a href="javascript: void(0);" class="btn btn-danger mt-4 remove-branch">Remove</a>
        </div>
    </div>
</div>
@endif