<div class="modal-content">
    <div class="modal-header">
        <div class="title">
            <strong>View Branch Details</strong>
        </div>
    </div>
    <div class="modal-body mx-5 mt-2">
        <div class="view-block">
            <div class="row">
                <div class="col-md-7">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="clinic">Hospital Name</label>
                        <div class="theme-form-input">
                           </spam>{{ $clinic->user->first_name }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="email">Email</label>
                        <div class="theme-form-input">
                          </spam>{{ $clinic->user->email }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="status">Status</label>
                        <div class="theme-form-input">
                            </spam>{{ $clinic->status==0 ? "Deactive" : "Active" }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="phone_no">Phone No</label>
                        <div class="theme-form-input">
                           </spam>{{ $clinic->user->phone_no }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="address">Address</label>
                        <div class="theme-form-input">
                           </spam>{{ $clinic->address }}</span>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        <div class="text-end">
        <button  type="button" class="btn btn-outline-dark mt-4 mx-3" data-bs-dismiss="modal">  
            Back 
        </button>
    </div>
    </div>
</div>
