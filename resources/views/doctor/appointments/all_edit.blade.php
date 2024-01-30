{{-- <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
 --}}
 <style>
 .theme-prescrip {
    margin-right: 580px;
    font-weight: normal;
    /* margin-top: 10px;  */
}


</style>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<div class="modal-content">
    <div class="modal-header">
        <div class="title">
            <strong>Current Appointment Details<strong>
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
        <form action="{{ route('all-appointments.update',$all_appointent->id) }}" data-url="{{ route('all-appointments.update',$all_appointent->id) }}" data-id="{{$all_appointent->id}}" method="post" class="edit-all-appointments-form" id="edit-all-appointments-form" name="edit-all-appointments-form" autocomplete="off">
            @csrf
            <div class="col-md-6 mb-1">
                <div class="form-group theme-form-group">
                    <input type="hidden" data-id="{{ $all_appointent->id }}" id="data_id">
                    <label for="patient_name" class="theme-label">Patient Name :</label> <span class="fw-normal">{{ $all_appointent->user->first_name }}</span>
                </div>
            </div>
             <div class="col-md-6 mb-3">
                <div class="form-group theme-form-group">
                    <label for="appointment_date" class="theme-label">Appointment Date and Time : </label> <span class="fw-normal"> {{ date('d-m-Y', strtotime($all_appointent->appointment_date )) }} {{ date('H:i', strtotime($all_appointent->time_start))}} - {{ date('H:i', strtotime($all_appointent->time_end)) }} </span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="form-group theme-form-group">
                        <label for="disease_name" class="theme-label">Prescription <span class="required">*</span></label>
                        <div class="theme-form-input">
                            <textarea class="form-control" id="disease_name" name="disease_name" type="text" placeholder="Prescription details" style="resize: none;" value="{{ $all_appointent->disease_name}}" required> </textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <div class="form-group theme-form-group">
                        <label for="is_complete" class="theme-label">Does It completed?</label>
                        <div class="form-check form-switch form-switch-md ps-0">
                            <label class="switch" for="is_complete">
                                    <div class="form-check form-switch form-switch-md"><label class="switch"><input data-id={{$all_appointent->id}} class="toggle-class form-check-input" type="checkbox" id="is_complete" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive"  value="1" checked  disabled></label></div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 mb-3">
                    <div class="form-group theme-form-group d-flex justify-content-between">
                        <div class="">
                            <label for="next_date" class="theme-label">Next Appointment Date</label>
                            <div class="theme-form-input">
                                <input class="form-control" id='datepicker' name="next_date" type="text" placeholder="Next Appointment Date" value="{{$all_appointent->next_date ? date('d-m-Y', strtotime($all_appointent->next_date )) : null }}" />
                            </div>
                        </div>
                        <div class="ms-2 me-5">
                            <label for="next_date" class="theme-label">Timeslot</label>
                            <select name="next_start_time" id="next_start_time" class="form-select form-group">
                                <option value=""> Select Time Slot </option>
                                @foreach( $time as $tm )
                                    <option value="{{ $tm['start'] }} - {{$tm['end']}}" {{ $tm['start'] == $all_appointent->next_start_time ? 'selected' : '' }}  @if($tm['start'] . '-' . $tm['end'] == in_array( $tm['start'] . '-' . $tm['end'], $available_slot)) disabled class="disable-time"
                                        @elseif($tm['start'] < $current_time) 
                                         hidden
                                        @else 
                                            {{ $tm['start'] == $all_appointent->next_start_time ? 'selected' : '' }}
                                        @endif>{{ $tm['start'] }} - {{ $tm['end']}}</option>           
                                @endforeach
                            </select>
                        
                       </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    {{-- <div class="text-left ml-0"> --}}
                    <label for="prescription" class="theme-prescrip"><b>Prescription :</b> {{$all_appointent->disease_name}}</label>
                    <button class="btn btn-back mt-4 app_btn" id="validation-next" type="submit"><i class="lni lni-save"></i>Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
if ( $("#datepicker").length ) {
    var dateToday = new Date(); 
    $('#datepicker').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        ampm: true,
        shortTime: false,
        date: true,
        time: false,
        monthPicker: true,
        year: true,
        switchOnClick: true,
        minTime: '00:01am',
        maxTime: '11:59pm',
        minDate: dateToday
      });
}

 // $( "#edit-all-appointments-form" ).validate({
 //      rules: {
 //        disease_name: {
 //            required: true
 //        }
 //      }
 //    });

$(document).on('click', '.app_btn',function(e) {    
    var status = $("#is_complete").prop('checked') == true ? 1 : 0;
    var disease_name = $("#disease_name").val();
    var id = $("#data_id").data('id');  
    var next_date = $("#datepicker").val();
    var next_start_time = $('#next_start_time').val();
    let $this = $(this);
    $this.addClass('pe-none');
    $.ajax({ 
           type: "GET", 
           dataType: "json", 
           url: "{{ route('appointments.changeStatus')}}", 
           data: {'is_complete': status, 'id': id, 'disease_name': disease_name, 'next_date':next_date,'next_start_time':next_start_time}, 
            beforeSend: function() {
                $('#loader').show();
            },
            success: function (data) {
                console.log("ydedees");
                window.location.reload();
                $('#loader').hide();
            },
            error: function (data) {
                error_notification();
            }
        }).always(function(){
            $this.removeClass('pe-none');
        }); 
}) 
</script>
