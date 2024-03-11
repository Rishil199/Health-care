 <div class="modal-content">
    <div class="modal-header">
        <div class="title">
            <strong>View Staff Detail</strong>
        </div>
    </div>
    <div class="modal-body mx-5">
        <div class="view-block">
            <div class="row">
                <div class="col-md-7">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="firstName">Name:</label>
                        <div class="theme-form-input">
                           <span>{{ $receptionist->user->first_name }} {{ $receptionist->user->last_name }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="email">Email:</label>
                        <div class="theme-form-input">
                          <span>{{ $receptionist->user->email }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="status">Status:</label>
                        <div class="theme-form-input">
                           <span>{{ $receptionist->status==0 ? "Deactive" : "Active" }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="phone_no">Phone No.:</label>
                        <div class="theme-form-input">
                          <span>{{ $receptionist->user->phone_no }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="birth_date">Birth Date:</label>
                        <div class="theme-form-input">
                            <span>{{ date('d/m/Y', strtotime($receptionist->birth_date)) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="gender">Gender:</label>
                        <div class="theme-form-input">
                           <span>{{ $receptionist->gender }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="degree">Qualification:</label>
                        <div class="theme-form-input">
                            <span>{{ $receptionist->qualification }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="experience">Experience:</label>
                        <div class="theme-form-input">
                           <span>{{ $receptionist->experience }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-end">
        <button  type="button" class="btn btn-dark mt-0  mx-3" data-bs-dismiss="modal">  
            Back 
        </button>
    </div>
    </div>
</div>
