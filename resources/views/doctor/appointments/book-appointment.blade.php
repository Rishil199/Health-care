@use ('App\Models\User')
<div class="modal-header">
    <div class="title">
        <strong>Book Appointment</strong>
    </div>
</div>
<div class="modal-body" id="myModal">
    <form action="" method="post" id="add-appointment-form" class="add-appointment-form">
    @csrf
    

    <div class="col-md-6 mb-1">
        <div class="form-group theme-form-group">
            <label for="appointment_date" class="theme-label">Selected Date  : </label> <span
                class="fw-normal">{{\Carbon\Carbon::parse($selected_date)->format('d-m-Y') }}</span>
        </div>
    </div>


        <div class="form-group theme-form-group">
            <input type="hidden" name="appointment_date" id="appointment_date" value="{{ $appointment_date }}" />
            <label class="theme-label" for="picker1" >Select Patient <span class="text-danger">*</span></label>
            <div class="theme-form-input">
                <select class="form-control form-select search-multiple select-box" name="event_name" id="event_name">
                    <option value="">Select Patient</option>
                    @foreach( $patients as $patient )         
                    <option value="{{ $patient->user_id }}">{{ $patient->user->first_name }} - {{$patient->user->phone_no}}</option>
                    @endforeach
                </select>
            </div>
            @if(Auth::user()->hasAnyRole([User::ROLE_CLINIC, User::ROLE_RECEPTIONIST]))
            <label class="theme-label mt-3" for="picker1">Select Doctor <span class="text-danger">*</span></label>
            <div class="theme-form-input">
                <select class="form-control form-select" name="doctor_id" id="doctor_id">
                    <option value="">Select Doctor</option>
                    @foreach( $doctors as $doctor )
                    <option value="{{ $doctor->id }}">{{ $doctor->user->fullName }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <input type="hidden" name="clinic_id" value="{{$clinic_details->id ?? ''}}">
            <input type="hidden" name="receptionist_id" value="{{$receptionist_details->id?? ''}}">
            @if (Auth::user()->hasRole(User::ROLE_RECEPTIONIST))
            <input type="hidden" name="clinic_id" value="{{$receptionist_details->clinic_id?? ''}}">
            @endif
            <input type="hidden" name="created_by" value="{{Auth::user()->id}}">
            <input type="hidden" name="doctortime" id="doctortime">
            <div class="theme-form-input mt-3">
                <label class="theme-label" for="time_start">Time Slot <span class="required">*</span></label>
                <div class="theme-form-input text-center">
                    <input type="hidden" id="modal-appointment-selected-date-for-check">
                    <select name="time_start" id="time_start" class="form-select form-group select-box">
                        <option value=""> Select Time Slot </option>
                        @foreach( $available_slots as $time )
                            <option id="{{ $time }}" value="{{ $time }}" >{{ $time }}</option> 
                        @endforeach
                    </select>                                  
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="theme-form-input">
                            <label class="theme-label" for="Weight">Weight</label>
                            <div class="theme-form-input text-center">
                                <input type="text" name="weight" class="form-control " placeholder="(In KG)">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="theme-form-input">
                            <label class="theme-label " for="blood_pressure">Blood Pressure</label>
                            <div class="theme-form-input">
                                <input type="text" name="blood_pressure" class="form-control " placeholder="119/70">
                            </div>
                        </div>
                    </div>
                </div>
                

            <div class="text-center mt-4">
               <input type="submit" class="btn btn-primary create-appointment" id="create-appointment" value="Save" />
               <button  type="button" class="btn btn-outline-dark mt-0 mx-3 text-center" data-bs-dismiss="modal">  
                Cancel 
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    if($( "#add-appointment-form" ).length > 0){
        $( "#add-appointment-form" ).validate({
            rules: {
                time_start: {
                    required: true
                },
                event_name: {
                    required: true
                },
                doctor_id: {
                    required: true
                }
            },
            messages: {
                'time_start': {
                required: "Start time is required. ",
                },
                'event_name': {
                required: " Patient is required.",
                },
                'doctor_id': {
                required: "Doctor is required",
                },
            },
        });
    }
</script>

<script>

  $(document).ready(function () {
      $('#doctor_id').on('change', function() {
          var selectedDoctor = this.value;
          let appointment_date = $(document).find('#appointment_date').val();
        //   alert(selectedDoctor);
          $('#time_start').html();
  $.ajax({
    type: "post",
    url: "{{route('appointments.fetchDoctortimeslots')}}",
    data: {doctor_id:selectedDoctor,
            appointment_date,
     },
    dataType: "json",
    success: function (result) {
        $('#time_start').html('<option value="">Select Time Slot</option>');
                   console.log(result);
                   $.each(result.arr, function (key, value) {
                    console.log(key,value)
                       $("#time_start").append('<option value="' + value + '">'+ value +'</option>');
                   });
    },
    error: function(error,xhr,staus){
        console.log('Error:',error);
    }
});
});
});

</script>

