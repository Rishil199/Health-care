{{-- <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
 --}}

<style>
    .theme-prescrip {
        margin-right: 580px;
        font-weight: normal;
        /* margin-top: 10px;  */
    }

    .table-font{
        font-weight: normal;
    }
</style>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<div class="modal-content">
    <div class="modal-header">
        <div class="title">
            <strong>Current Appointment Details<strong>
        </div>
    </div>
    <div class="modal-body">
        <form action="{{ route('all-appointments.update', $all_appointent->id) }}"
            data-url="{{ route('all-appointments.update', $all_appointent->id) }}" data-id="{{ $all_appointent->id }}"
            method="post" class="edit-all-appointments-form" id="edit-all-appointments-form"
            name="edit-all-appointments-form" autocomplete="off">
            @csrf
            <div class="col-md-6 mb-1">
                <div class="form-group theme-form-group">
                    <input type="hidden" data-id="{{ $all_appointent->id }}" id="data_id">
                    <label for="patient_name" class="theme-label">Patient Name :</label> <span
                        class="fw-normal">{{ $all_appointent->user->first_name }}</span>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group theme-form-group">
                    <label for="appointment_date" class="theme-label">Appointment Date and Time : </label> <span
                        class="fw-normal"> {{ date('d-m-Y', strtotime($all_appointent->appointment_date)) }}
                        {{ date('H:i', strtotime($all_appointent->time_start)) }} -
                        {{ date('H:i', strtotime($all_appointent->time_end)) }} </span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-group theme-form-group">
                        <label for="Weight" class="theme-label">Weight </label>
                        <div class="theme-form-input">
                            <input type="text" name="weight" class="form-control"  placeholder="(In KG)" value="{{ $all_appointent->weight }}">
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group theme-form-group">
                        <label for="Weight" class="theme-label">Blood Pressure </label>
                        <div class="theme-form-input">
                            <input type="text" name="blood_pressure" class="form-control" placeholder="119/70">
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-group theme-form-group">
                        <label for="observation" class="theme-label">Observation <span class="required">*</span></label>
                        <div class="theme-form-input">
                            <input type="text" class="form-control" id="disease_name" name="disease_name"
                                type="text" placeholder="Observation"  value="">
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group theme-form-group">
                        <label for="disease_name" class="theme-label">Prescription <span class="required">*</span></label>
                        <div class="theme-form-input">
                            <input type="text" class="form-control" id="prescription" name="prescription"
                                type="text" placeholder="Prescription" value="" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 ">
                    <div class="form-group theme-form-group ">
                        {{-- <div class="me-3"> --}}
                            <label for="next_date" class="theme-label">Next Appointment Date</label>
                            <div class="theme-form-input">
                                <input class="form-control mt-1 px-1 " id='datepicker' name="next_date"
                                    type="text" placeholder="Next Appointment Date"
                                    value="{{ $all_appointent->next_date ? date('d-m-Y', strtotime($all_appointent->next_date)) : null }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        {{-- <div class="ms-3 "> --}}
                            <div class="form-group theme-form-group ">
                            <label for="next_date" class="theme-label">Timeslot</label>
                            <div class="theme-form-input">
                            <select name="next_start_time" id="next_start_time" class="form-select form-group mt-1 ">
                                <option value="">Select Time Slot</option>
                                @foreach ($time as $tm)
                                    <option value="{{ $tm['start'] }} - {{ $tm['end'] }}">
                                        {{ $tm['start'] }} - {{ $tm['end'] }}
                                        {{-- <option id="{{ $time }}" value="{{ $time }}" >{{ $time }}</option>  --}}
                                        {{-- @if (in_array($tm['start'] . '-' . $tm['end'], $available_slot) || $tm['start'] < $current_time) disabled @endif
                                        {{ $all_appointent?->next_start_time == ($tm['start'] . ' - ' . $tm['end']) ? 'selected' : '' }}>
                                        {{ $tm['start'] }} - {{ $tm['end'] }} --}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-group theme-form-group">
                        <label for="observation" class="theme-label mt-3">Dietplan <span class=""></span></label>
                        <div class="theme-form-input">
                            <input type="text" class="form-control" id="dietplan" name="dietplan"
                                type="text" placeholder="Dietplan"  value="">
                        </div>
                    </div>
                </div>


                <div class="col-md-6 mb-3">
                    <div class="form-group theme-form-group">
                        <label for="is_complete" class="theme-label mt-3">Does It completed?</label>
                        <div class="form-check form-switch form-switch-md ps-0">
                            <label class="switch" for="is_complete">
                                <div class="form-check form-switch form-switch-md"><label class="switch"><input
                                            data-id={{ $all_appointent->id }} class="toggle-class form-check-input"
                                            type="checkbox" id="is_complete" data-onstyle="success"
                                            data-offstyle="danger" data-toggle="toggle" data-on="Active"
                                            data-off="InActive" value="1" cheked disabled ></label></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>




            <div class="modal-footer justify-content-center">
                <button class="btn btn-back mt-4 app_btn" id="validation-next" type="submit"><i class="lni lni-save"></i>Save</button>
                <button  type="button" class="btn btn-outline-dark mt-4 mx-3 text-center" data-bs-dismiss="modal">  
                    Back 
                </button>
            </div>
            

                <h5 class="mb-3"> Medical History -</h5>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="appointments_table">
                    <thead class="table table-light">
                        <tr>
                            <th>Sr.no</th>
                            <th scope="col">Appointment Date</th>
                            <th scope="col">Appointment Time</th>
                            <th scope="col">Observation</th>
                            <th scope="col">Prescription</th>
                            <th scope="col">Weight</th>
                            <th scope="col">Blood Pressure</th>
                            <th scope="col">Diet Plan</th>
                            <th scope="col">Next Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count=0;?>
                        @foreach ($appointment_history as $history)
                        <?php $count++;?>
                        <tr class="table-font">
                            <td>{{$count}}</td>
                            <td>{{ \Carbon\Carbon::parse($history->appointment_date)->format('d-m-Y')}}</td>
                            <td>{{ $history->time_start }} - {{ $history->time_end }}</td>
                            <td>{{ $history->disease_name !==null && $history->disease_name !=='' ? $history->disease_name:'-'}}</td>
                            <td>{{ $history->prescription ?? '-'}}</td>
                            <td>{{ $history->weight ?? '-' }}</td>
                            <td>{{ $history->blood_pressure ?? '-' }}</td>
                            <td>{{ $history->dietplan ?? '-' }}</td>
                            <td>{{ $history->next_date ? \Carbon\Carbon::parse($history->next_date)->format('d-m-Y') : '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>            
        </form>
    </div>
</div>
{{-- </div> --}}

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>

$(document).ready(function () {
    $('#appointments_table').DataTable();
});
</script> --}}










<script>
    if ($("#datepicker").length) {
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

    $(document).on('click', '.app_btn', function(e) {
        var status = $("#is_complete").prop('checked') == true ? 1 : 0;
        var disease_name = $("#disease_name").val();
        var prescription=$("#prescription").val();
        console.log("prescription",prescription);
        var id = $("#data_id").data('id');
        var next_date = $("#datepicker").val();
        var next_start_time = $('#next_start_time').val();
        let $this = $(this);
        $this.addClass('pe-none');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ route('appointments.changeStatus') }}",
            data: {
                'is_complete': status,
                'id': id,
                'disease_name': disease_name,
                'prescription':prescription,
                'next_date': next_date,
                'next_start_time': next_start_time
            },
            beforeSend: function() {
                $('#loader').show();
            },
            success: function(data) {
                console.log("ydedees");
                window.location.reload();
                $('#loader').hide();
            },
            error: function(xhr) {
                if(xhr.status===422){
                         var errors= xhr.responseJSON.errors;   
                         validateForm.showErrors(errors);
                        }else {
                        //    error_notification_add();
                        console.log("Something went wrong.")
                        }
                    },
                    complete: function() {
            $this.removeClass('pe-none');
            }
        });
    });
    
</script>
