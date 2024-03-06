<div class="modal-content">
    <div class="modal-header">
        <div class="title">
            <strong>View Branch Details</strong>
        </div>
    </div>
    <div class="modal-body">
        <div class="view-block">
            <div class="row">
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="clinic">Hospital Name:</label>
                        <div class="theme-form-input">
                            <input type="text" id="clinic" class="form-control" value="{{ $clinic->user->first_name }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="email">Email:</label>
                        <div class="theme-form-input">
                            <input type="email" id="email" class="form-control" value="{{ $clinic->user->email }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="status">Status:</label>
                        <div class="theme-form-input">
                            <input type="text" id="status" class="form-control" value="{{ $clinic->status==0 ? "Deactive" : "Active" }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="phone_no">Phone No.:</label>
                        <div class="theme-form-input">
                            <input type="text" id="phone_no" class="form-control" value="{{ $clinic->user->phone_no }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="address">Address:</label>
                        <div class="theme-form-input">
                            <input type="text" id="address" class="form-control" value="{{ $clinic->address }}" disabled>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        <div class="text-center">
        <button  type="button" class="btn btn-outline-dark mt-4 mx-3" data-bs-dismiss="modal">  
            Back 
        </button>
    </div>
    </div>
</div>
