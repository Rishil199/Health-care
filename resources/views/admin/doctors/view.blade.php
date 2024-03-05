<div class="modal-content">
    <div class="modal-header">
        <div class="title">
            <strong>View Doctor Detail</strong>
        </div>
    </div>
    <div class="modal-body">
        <div class="view-block">
            <div class="row">
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="firstName">Name:</label>
                        <div class="theme-form-input">
                            <input type="text" id="firstName" class="form-control" value="{{ $doctor->user->first_name }} {{ $doctor->user->last_name }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="email">Email:</label>
                        <div class="theme-form-input">
                            <input type="email" id="email" class="form-control" value="{{ $doctor->user->email }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="status">Status:</label>
                        <div class="theme-form-input">
                            <input type="text" id="status" class="form-control" value="{{ $doctor->status==0 ? "Deactive" : "Active" }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="phone_no">Phone No.:</label>
                        <div class="theme-form-input">
                            <input type="text" id="phone_no" class="form-control" value="{{ $doctor->user->phone_no }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="address">Address:</label>
                        <div class="theme-form-input">
                            <input type="text" id="address" class="form-control" value="{{ $doctor->address }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="birth_date">Birth Date:</label>
                        <div class="theme-form-input">
                            <input type="text" id="birth_date" class="form-control" value="{{ date('d/m/Y', strtotime($doctor->birth_date)) }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="gender">Gender:</label>
                        <div class="theme-form-input">
                            <input type="text" id="gender" class="form-control" value="{{ $doctor->gender }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="degree">Degree:</label>
                        <div class="theme-form-input">
                            <input type="text" id="degree" class="form-control" value="{{ $doctor->degree }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="experience">Experience:</label>
                        <div class="theme-form-input">
                            <input type="text" id="experience" class="form-control" value="{{ $doctor->experience }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="expertice">Expertice</label>
                        <div class="theme-form-input">
                            <input type="text" id="expertice" class="form-control" value="{{ $doctor->expertice }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button  type="button" class="btn btn-outline-dark mt-0  mx-3" data-bs-dismiss="modal">  
                Back 
            </button>
        </div>
    </div>
</div>
