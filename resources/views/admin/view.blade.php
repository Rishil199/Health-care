<div class="modal-content">
    <div class="modal-header">
        <div class="title">
            <strong>View Patient Detail</strong>
        </div>
        <button type="button" class="btn-close btn" data-bs-dismiss="modal" aria-label="Close">
            <svg fill="#000000" width="20" height="20" version="1.1" id="lni_lni-close" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
            <path d="M34.5,32L62.2,4.2c0.7-0.7,0.7-1.8,0-2.5c-0.7-0.7-1.8-0.7-2.5,0L32,29.5L4.2,1.8c-0.7-0.7-1.8-0.7-2.5,0
               c-0.7,0.7-0.7,1.8,0,2.5L29.5,32L1.8,59.8c-0.7,0.7-0.7,1.8,0,2.5c0.3,0.3,0.8,0.5,1.2,0.5s0.9-0.2,1.2-0.5L32,34.5l27.7,27.8
               c0.3,0.3,0.8,0.5,1.2,0.5c0.4,0,0.9-0.2,1.2-0.5c0.7-0.7,0.7-1.8,0-2.5L34.5,32z" fill="#fff">
            </path>
            </svg>
        </button>
    </div>
    <div class="modal-body">
        <div class="view-block">
            <div class="row">
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="firstName">Name:</label>
                        <div class="theme-form-input">
                            <input type="text" id="firstName" class="form-control" value="{{ $patient->user->first_name }} {{ $patient->user->last_name }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="email">Email:</label>
                        <div class="theme-form-input">
                            <input type="text" id="email" class="form-control" value="{{ $patient->user->email }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="phone_no">Phone No.:</label>
                        <div class="theme-form-input">
                            <input type="text" id="phone_no" class="form-control" value="{{ $patient->user->phone_no }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="address">Address:</label>
                        <div class="theme-form-input">
                            <input type="text" id="address" class="form-control" value="{{ $patient->address }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="birth_date">Admit Date:</label>
                        <div class="theme-form-input">
                            <input type="text" id="admit_date" class="form-control" value="{{ date('d/m/Y', strtotime($patient->admit_date)) }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="gender">Gender:</label>
                        <div class="theme-form-input">
                            <input type="text" id="gender" class="form-control" value="{{ $patient->gender }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="disease_name">Disease Name:</label>
                        <div class="theme-form-input">
                            <input type="text" id="disease_name" class="form-control" value="{{ $patient->disease_name }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="prescription">Prescription:</label>
                        <div class="theme-form-input">
                            <input type="text" id="prescription" class="form-control" value="{{ $patient->prescription }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="allergies">Allergies:</label>
                        <div class="theme-form-input">
                            <input type="text" id="allergies" class="form-control" value="{{ $patient->allergies }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="illness">Medical History:</label>
                        <div class="theme-form-input">
                            <input type="text" id="illness" class="form-control" value="{{ $patient->illness == "yes"  ? 'Yes' : 'No' }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="exercise">Exercise:</label>
                        <div class="theme-form-input">
                            <input type="text" id="exercise" class="form-control" value="{{ $patient->exercise == "yes"  ? 'Yes' : 'No' }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="alchohol_consumption">Alchohol Consumption:</label>
                        <div class="theme-form-input">
                            <input type="text" id="alchohol_consumption" class="form-control" value="{{ $patient->alchohol_consumption == "yes"  ? 'Yes' : 'No' }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="diet">Diet:</label>
                        <div class="theme-form-input">
                            <input type="text" id="diet" class="form-control" value="{{ $patient->diet == "yes"  ? 'Yes' : 'No' }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="smoke">Smoke:</label>
                        <div class="theme-form-input">
                            <input type="text" id="smoke" class="form-control" value="{{ $patient->smoke == "yes"  ? 'Yes' : 'No' }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
