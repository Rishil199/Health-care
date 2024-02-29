@use ('App\Models\User')
<style> 
/* .select-box {
    width:-750px;
    z-index: 19999 !important;
} */
/* .book-appointment {
    modal-xl;
} */

</style>
<div class="modal-header">
    <div class="title">
        <strong>Book Appointment</strong>
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
            <input type="hidden" name="clinic_id" value="{{@$clinic_details->id}}">
            <input type="hidden" name="receptionist_id" value="{{@$receptionist_details->id}}">
            <input type="hidden" name="created_by" value="{{Auth::user()->id}}">
            <input type="hidden" name="doctortime" id="doctortime">
            <div class="theme-form-input mt-3">
                <label class="theme-label" for="time_start">Time Slot <span class="required">*</span></label>
                <div class="theme-form-input text-center">
                    <input type="hidden" id="modal-appointment-selected-date-for-check">
                    <select name="time_start" id="time_start" class="form-select form-group select-box">
                        <option value=""> Select Time Slot </option>
                        {{-- @foreach( $available_slots as $time )
                            <option id="{{ $time }}" value="{{ $time }}" >{{ $time }}</option> 
                        @endforeach --}}
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
            </div>
        </div>
    </form>
</div>

<script>
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
      }
    });   
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

