@use ('App\Models\User')
<div class="modal-header">
    <div class="title">
        <strong>Appointment Details</strong>
    </div>
</div>
<div class="modal-body" id="myModal">
    <form action="" method="post" id="display-appointment-detail" class="display-appointment-detail">
        @csrf 
        <div class="col-md-12 mb-3">
            <div class="form-group theme-form-group">
                <label class="theme-label" for="picker1">Appointment Date -</label>
                    <span class="fw-normal">  {{\Carbon\Carbon::parse ($appointment_details->appointment_date)->format('d-m-Y')}}
             </span>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="form-group theme-form-group">
                <label class="theme-label" for="picker1">Appointment time - </label>
                    <span class="fw-normal">   {{ date('H:i:s', strtotime($appointment_details->time_start)) }} -
                    {{ date('H:i:s', strtotime($appointment_details->time_end)) }}
                  </span>
            </div>
        </div>
        <div class="form-group theme-form-group">
            {{-- <input type="date" name="appointment_date" id="appointment_date"> --}}
            </div>
                <div class="col-md-12 mb-3">
                    <div class="form-group theme-form-group">
                        <div class="theme-form-input">
                            <label class="theme-label" for="picker1">Doctor Name -</label>
                                <span class="fw-normal">{{$appointment_details->doctor->user->first_name}}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="form-group theme-form-group">
                        <div class="theme-form-input">
                            <label class="theme-label" for="picker1">Patient Name - </label>
                                <span class="fw-normal">{{$appointment_details->patient->first_name}}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="form-group theme-form-group">
                        <div class="theme-form-input">
                            <label class="theme-label" for="picker1">Disease Name -</label>
                                <span class="fw-normal">{{$appointment_details->disease_name}}</span>
                        </div>
                    </div>
                </div>

            <div class="text-center mt-2">
                <button type="button" class="btn btn-outline-dark mt-0 mx-3 text-center" data-bs-dismiss="modal">
                    Back
                </button>
            </div>
        </div>
</form> 
</div>






