@use ('App\Models\User')
<div class="modal-header">
    <div class="title">
        <strong>Book Appointment</strong>
    </div>
</div>
<div class="modal-body">
    <form action="" method="post" id="patient-clinic-appointment-form" class="patient-clinic-appointment-form">
        @csrf
        <div class="col-md-6 mb-1">
            <div class="form-group theme-form-group">
                <label class="theme-label" for="picker1">Hospital Name :
                  <span class="fw-normal">{{$clinic_name->user->first_name}}</span>
            </div>
        </div>
        <div class="form-group theme-form-group">
            <label for="appointment_date" class="theme-label">Select Date : </label> <span class="text-danger">*</span>
            {{-- <input type="date" name="appointment_date" id="appointment_date"> --}}
            <input class="form-control" id='datepicker' name="appointment_date" type="text" placeholder="Select appointment Date" required autocomplete="off" />
            </div>
                <div class="col-md-12 mb-3">
                    <div class="form-group theme-form-group">
                        <label class="theme-label mt-3" for="picker1">Select Doctor</label><span class="text-danger">*</span>
                        <div class="theme-form-input">
                            <select class="form-control form-select" name="doctor_id" id="doctor-dropdown" required>
                                <option value="">Select Doctor</option>
                                @foreach($doctors as $doctor)
                                <option value="{{$doctor->user->id}}">{{$doctor->user->fullName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            <input type="hidden" name="clinic_id" class="clinic_id" value="{{ $clinic_id }}">
            <input type="hidden" name="event_name" value="{{$clinic_id}}">
            <input type="hidden" name="created_by" value="{{ Auth::user()->id }}">
            {{-- <div class="theme-form-input">
                <label class="theme-label" for="time_start">Time Slot <span class="required">*</span></label>
                <div class="theme-form-input text-center">
                       <input type="hidden" id="modal-appointment-selected-date-for-check">
                       <select name="time_start" id="time_start" class="form-select form-group">
                            <option value=""> Select Time Slot </option>
                            @foreach ($available_slots as $time)
                                <option id="{{ $time }}" value="{{ $time }}" >{{ $time }}</option> 
                           @endforeach
                       </select>                                  
                </div>
            </div> --}}
            {{-- @if (Auth::user()->hasRole(User::ROLE_PATIENT)) --}}
                <div class="col-md-12 mb-3">
                    <div class="form-group theme-form-group">
                        <label class="theme-label" for="time_start">Time Slot</label><span class="text-danger">*</span>
                        <div class="theme-form-input">
                            <input type="hidden" id="modal-appointment-selected-date-for-check">
                            <select class="form-control form-select" name="time_start" id="time_start-dropdown" required>
                                <option value="">Select Timeslot</option>
                            </select>
                        </div>
                    </div>
                </div>
            {{-- @endif --}}
            <div class="text-center mt-2">
                <input type="submit" class="btn btn-primary create-appointment" id="create-appointment"
                    value="Save" />
                <button type="button" class="btn btn-outline-dark mt-0 mx-3 text-center" data-bs-dismiss="modal">
                    Cancel
                </button>
            </div>
        </div>
    </form>
</div>
<script>
    $("#patient-clinic-appointment-form").validate({
        rules: {
            time_start: {
                required: true
            },
            appointment_date: {
                required: true
            },
            doctor_id: {
                required: true
            }
        },
        messages: {
            'time_start': {
                required: "Select Time is required"
            },
            'appointment_date': {
                required: "Select Appoinment Date is required "
            },
            'doctor_id': {
                required: "Select Doctor is required."
            }
        }
    });
</script>
 <script>
    $(document).ready(function() {
        $('#doctor-dropdown').on('change', function() {
            let doctor_id = this.value;
            // let appointment_date = $("input[name='appointment_date']").val();
            // alert(appointment_date);
            $("#time_start-dropdown").html('');
            $.ajax({
                url: "{{ route('appointments.fetchTimeSlotsDoctor') }}",
                type: "POST",
                data: {
                    doctor_id: doctor_id,
                    // appointment_date: appointment_date
                },
                dataType: 'json',
                success: function(result) {
                    $('#time_start-dropdown').html(
                        '<option value="">Select Time Slot</option>');
                    console.log(result);
                    $.each(result.arr, function(key, value) {
                        console.log(key, value)
                        $("#time_start-dropdown").append('<option value="' + value +
                            '">' + value + '</option>');
                    });
                }
            });
        });
    });



    $(document).on('submit', '#patient-clinic-appointment-form', function(event) {
        event.preventDefault();
        var clinic_id = $('.clinic_id').val();
        var event_name=$('.clinic_id').val();
        let appointment_date = $("input[name='appointment_date']").val();
        $(this).addClass('pe-none');
        let data = $(this).serializeArray();
        data.push({ name: 'formType', value: 'patient-clinic-appointment-form' });
        $.ajax({
            url: '{{ route('patient_appointment_calender') }}',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: (function(data) {
                console.log(data);
                return false;
                if (data.status == '2') {
                    // setTimeout(() => {
                    toastr.error(data.message, '');
                    // return false;
                    // setTimeout(() => {
                    //     window.location.reload();
                    // }, 2000);
                    // }, 0);
                } else {
                    displayMessage("Appointment Added successfully!");
                    $('#myModal').modal('hide');
                    window.location.reload();
                }
                $('#loader').hide();
            }),
            error: function(response) {
                // error_notification_add();
            }
        }).always(function() {
            $(this).removeClass('pe-none');
        });
    });

    function displayMessage(message) {
        toastr.success(message, '');
    }
</script> 




