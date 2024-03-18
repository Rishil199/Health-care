@use ('App\Models\User')
<div class="modal-header">
    <div class="title">
        <strong>Book Appointment</strong>
    </div>
</div>
<div class="modal-body">
    <form action="" method="post" id="add-patient-appointment-form" class="add-patient-appointment-form">
        @csrf
        <div class="col-md-6 mb-1">
            <div class="form-group theme-form-group">
                <label for="appointment_date" class="theme-label">Selected Date  : </label> <span
                    class="fw-normal">{{\Carbon\Carbon::parse($selected_date)->format('d-m-Y') }}</span>
            </div>
        </div>
        <div class="form-group theme-form-group">
            <input type="hidden" name="appointment_date" id="appointment_date" value="{{ $appointment_date }}" />
            <label class="theme-label" for="picker1">Select Hospital <span class="text-danger">*</span></label>
            <div class="theme-form-input">
                <select class="form-control form-select search-multiple select-box" name="event_name" id="clinic-dropdown">
                    <option value="">Select Hospital</option>
                    {{-- @foreach( $clinics as $clinic ) --}}
                    {{-- @if($clinic->status==1) --}}
                    <option value=""></option>
                    {{-- @endif 
                    @endforeach --}}
                </select>
            </div>
            @if(Auth::user()->hasRole(User::ROLE_PATIENT))
            <div class="col-md-12 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label mt-3" for="picker1">Select Doctor</label>
                  <div class="theme-form-input">
                      <select class="form-control form-select" name="doctor_id" id="doctor-dropdown">
                          <option value="">Select Doctor</option>
                    </select>
                  </div>
               </div>
            </div>
            @endif
            @if(Auth::user()->hasAnyRole([User::ROLE_CLINIC,User::ROLE_RECEPTIONIST]))
            <div class="col-md-6 mb-3">
            <label class="theme-label" for="picker1">Select Doctor <span class="text-danger">*</span></label>
            <div class="theme-form-input">
                <select class="form-control form-select" name="doctor_id" id="doctor_id">
                    <option value="">Select Doctor</option>
                    @foreach( $doctors as $doctor )
                    @if($doctor->status==1)
                    <option value="{{ $doctor->id }}">{{ $doctor->user->fullName }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            </div>
            @endif
            <input type="hidden" name="clinic_id" class="clinic_id"  value="{{$clinic_details?->id}}">
            {{-- <input type="hidden" name="receptionist_id" value="{{$receptionist_details?->id}}"> --}}
            <input type="hidden" name="created_by" value="{{Auth::user()->id}}">
            {{-- <div class="theme-form-input">
                <label class="theme-label" for="time_start">Time Slot <span class="required">*</span></label>
                <div class="theme-form-input text-center">
                       <input type="hidden" id="modal-appointment-selected-date-for-check">
                       <select name="time_start" id="time_start" class="form-select form-group">
                            <option value=""> Select Time Slot </option>
                            @foreach( $available_slots as $time )
                                <option id="{{ $time }}" value="{{ $time }}" >{{ $time }}</option> 
                           @endforeach
                       </select>                                  
                </div>
            </div> --}}
           @if(Auth::user()->hasRole(User::ROLE_PATIENT))
            <div class="col-md-12 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="time_start">Time Slot</label>
                  <div class="theme-form-input">
                    <input type="hidden" id="modal-appointment-selected-date-for-check">
                    <select class="form-control form-select" name="time_start" id="time_start-dropdown">
                    </select>
                  </div>
               </div>
            </div>
            @endif
            <div class="text-center mt-2">
               <input type="submit" class="btn btn-primary create-appointment" id="create-appointment" value="Save" />
               <button  type="button" class="btn btn-outline-dark mt-0 mx-3 text-center" data-bs-dismiss="modal">  
                    Cancel 
                </button>
            </div>
        </div>
    </form>
</div>
<script>
    $( "#add-patient-appointment-form" ).validate({
      rules: {
        time_start: {
            required: true
        },
        event_name: {
            required: true
        },
        doctor_id:{
            required:true
        }
      },
      messages:{
        'time_start':{
           required : "Select time is required"
        },
        'event_name':{
            required:"Select Hospital is required "
        },
        'doctor_id':{
        required:"Select Doctor is required."
        }
      }
    });   
</script>
<script>
   $(document).ready(function () {
       $('#clinic-dropdown').on('change', function () {
           var idCountry = this.value;
           $("#doctor-dropdown").html('');
           $.ajax({
               url: "{{ route('appointments.fetchDoctors')}}",
               type: "POST",
               data: {
                   clinic_id: idCountry,
               },
               dataType: 'json',
               success: function (result) {
                   $('#doctor-dropdown').html('<option value="">Select Doctor</option>');
                   $.each(result.doctors, function (key, value) {
                       $("#doctor-dropdown").append('<option value="' + value.user.id + '">' + value.user.first_name + '</option>');
                   });
               }
           });
       });
    });


   $(document).ready(function () {
       $('#clinic-dropdown').on('change', function () {
           let clinic_id = this.value;
           $('.clinic_id').val(clinic_id);
           let appointment_date = $(document).find('#appointment_date').val();
           $("#time_start-dropdown").html('');
           $.ajax({
               url: "{{ route('appointments.fetchTimeSlots')}}",
               type: "POST",
                data: {
                    clinic_id: clinic_id,
                    appointment_date: appointment_date,
                },
               dataType: 'json',
               success: function (result) {
                   $('#time_start-dropdown').html('<option value="">Select Time Slot</option>');
                   console.log(result);
                   $.each(result.arr, function (key, value) {
                    console.log(key,value)
                       $("#time_start-dropdown").append('<option value="' + value + '">'+ value +'</option>');
                   });
               }
           });
       });
    });


    $(document).ready(function () {
       $('#doctor-dropdown').on('change', function () {
           let doctor_id = this.value;
           let appointment_date = $(document).find('#appointment_date').val();
           $("#time_start-dropdown").html('');
           $.ajax({
               url: "{{ route('appointments.fetchTimeSlotsDoctor')}}",
               type: "POST",
               data:  {
                    doctor_id: doctor_id,
                    appointment_date: appointment_date},
               dataType: 'json',
               success: function (result) {
                   $('#time_start-dropdown').html('<option value="">Select Time Slot</option>');
                   console.log(result);
                   $.each(result.arr, function (key, value) {
                    console.log(key,value)
                       $("#time_start-dropdown").append('<option value="' + value + '">'+ value +'</option>');
                   });
               }
           });
       });
    });

    

     $(document).on('submit', '#add-patient-appointment-form', function(event) {
        event.preventDefault();
       var clinic_id =$('.clinic_id').val();
        $(this).addClass('pe-none');
        let data = $(this).serializeArray();
        $.ajax({
            url: '{{ route('patient_appointment_calender')}}',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: (function(data) {
                displayMessage("Appointment Added successfully!");
                $('#myModal').modal('hide');
                $('#loader').hide();
                window.location.reload();
                calendar.fullCalendar('unselect');
                }),
            error: function (response) {
                error_notification_add();
            }
            }).always(function(){
                $(this).removeClass('pe-none');
            });
    });
    function displayMessage(message) {
        toastr.success(message, '');            
    }

</script>



{{-- $(document).ready(function () {
    // alert("hello");
    $('#clinic-dropdown').select2({
        ajax: {
            url: "patient.fetchClinics",
            dataType: "json",
            delay: 250,
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
});
 --}}

