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
<div class="modal-body">
    <form action="" method="post" id="add-patient-appointment-form" class="add-patient-appointment-form">
    @csrf
        <div class="form-group theme-form-group">
            <input type="hidden" name="appointment_date" id="appointment_date" value="{{ $appointment_date }}" />
            <label class="theme-label" for="picker1">Select Clinic <span class="text-danger">*</span></label>
            <div class="theme-form-input">
                <select class="form-control form-select" name="event_name" id="clinic-dropdown">
                    <option value="">Select Clinic</option>
                    @foreach( $clinics as $clinic )
                    @if($clinic->status==1)
                    <option value="{{ $clinic->user_id }}">{{ $clinic->user->fullName }}</option>
                    @endif 
                    @endforeach
                </select>
            </div>
            @if(Auth::user()->hasRole(['Patient']))
            <div class="col-md-12 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="picker1">Select Doctor</label>
                  <div class="theme-form-input">
                     <select class="form-control form-select" name="doctor_id" id="doctor-dropdown">
                     </select>
                  </div>
               </div>
            </div>
            @endif
            @if(Auth::user()->hasAnyRole(['Clinic','Receptionist']))
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
            <input type="hidden" name="clinic_id" value="{{@$clinic_details->id}}">
            <input type="hidden" name="receptionist_id" value="{{@$receptionist_details->id}}">
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
           @if(Auth::user()->hasRole(['Patient']))
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
               <input type="submit" class="btn btn-primary create-appointment" id="create-appointment" value="Add" />
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
        let $this = $(this);
        $this.addClass('pe-none');
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
                $this.removeClass('pe-none');
            });
    });
    function displayMessage(message) {
        toastr.success(message, '');            
    }

</script>