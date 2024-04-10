@extends('layouts.app')
@push('header_css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/datatables.min.css') }}" />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="{{ asset('assets/js/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush
@section('content-breadcrumb')
    <li>
        <span>
            <svg width="20" height="20" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 409.6 409.6"
                style="enable-background:new 0 0 409.6 409.6;" xml:space="preserve">
                <g>
                    <path d="M410.4,292.8c-2,4-5.3,5-9.6,5c-20.3-0.1-40.5-0.1-60.8-0.1c-1.4,0-2.9,0-4.8,0c0,1.8,0,3.2,0,4.6
                    c0,15.9,0,31.7,0,47.6c0,7.1-2.2,9.3-9.4,9.3c-80.1,0-160.2,0-240.4,0c-7.4,0-9.6-2.1-9.6-9.5c0-15.7,0-31.5,0-47.2
                    c0-1.4,0-2.9,0-4.8c-1.8,0-3.2,0-4.6,0c-20.4,0-40.8,0-61.2,0c-7.2,0-9.3-2.2-9.3-9.3c0-11.9-0.1-23.7,0-35.6
                    c0.4-42.6,19.2-74.2,56.8-94.4c0.7-0.4,1.4-0.8,1.7-0.9c-3.9-6.1-8.4-11.8-11.5-18.1C29.8,102.6,54,58.1,94.6,52.7
                    c14-1.9,27,0.8,39.3,7.6c4,2.2,5.4,5.8,3.7,9.3c-1.7,3.6-5.7,5-9.8,2.8c-10.2-5.4-20.8-7.8-32.4-6.1c-22,3.3-39.1,22.8-40,45.9
                    C54.6,134.5,71,155.6,92.6,160c7.6,1.5,15.1,1.5,22.6-0.3c5-1.2,8.6,0.6,9.6,4.5c1,4.2-1.5,7.4-6.6,8.6c-14.7,3.5-28.8,2-42.3-4.7
                    c-1.6-0.8-4.2-0.9-5.9-0.1c-34.2,14.9-52.8,41.1-55.3,78.3c-0.8,12.3-0.1,24.7-0.1,37.4c20.7,0,41.3,0,61.9,0
                    c6.7-47.9,31.9-82.4,75.3-104.2c-17.6-19.4-24.8-41.9-19.7-67.7c3.5-17.7,12.6-32.5,27-43.6c30.8-23.8,72.4-21.2,99.5,5.7
                    c26.7,26.5,31.6,72.7,0.9,105.6c43.2,21.6,68.3,56.3,75.2,104.3c20.4,0,40.9,0,61.5,0c0.1-0.1,0.5-0.3,0.5-0.5
                    c-0.4-19.6,2.3-39.5-3.7-58.8c-8.4-26.9-25.7-45.9-51.9-56.6c-1.6-0.6-4-0.5-5.5,0.2c-13.7,6.8-27.9,8.3-42.7,4.7
                    c-4.9-1.2-7.3-4.3-6.4-8.4c0.8-4,4.5-5.9,9.4-4.8c26.9,5.6,50.4-7.8,58-33c5.4-17.8-0.6-37.9-15.3-49.8
                    c-15.7-12.6-33-14.5-51.3-6.3c-1.7,0.8-3.3,1.7-5.1,2.4c-3.5,1.3-6.9,0-8.5-3.1c-1.6-3.1-0.9-7,2.5-8.7c5.3-2.7,10.8-5.4,16.5-6.9
                    c27.1-7,53.8,4.2,68.3,28.3c13.7,22.7,10.6,51.9-7.8,72.3c-0.6,0.7-1.2,1.4-1.5,1.8c7,4.7,14.3,8.8,20.8,14
                    c21.6,17.5,33.9,40.3,37.2,67.9c0.1,1,0.5,2,0.7,3C410.4,258.7,410.4,275.7,410.4,292.8z M321.5,345.4c0.1-1.1,0.1-2,0.1-2.9
                    c0-15.2,0.5-30.4-0.1-45.6c-2-49.6-25.8-85-70.9-105.9c-2.4-1.1-4.3-1.1-6.6,0.3c-9,5.8-18.9,9.1-29.5,10.3
                    c-17,2-32.8-1.4-47.5-10.2c-1.3-0.8-3.4-1.4-4.6-0.9c-15.3,6-28.9,14.9-40.2,26.8c-22.2,23.3-32.8,51.2-32.6,83.3
                    c0.1,13.5,0,26.9,0,40.4c0,1.4,0,2.9,0,4.5C167,345.4,244,345.4,321.5,345.4z M205.1,188.5c33.2,0.7,61.3-26.8,62-60.7
                    c0.7-33.3-26.7-61.5-60.6-62.1c-33.7-0.7-61.6,26.6-62.4,60.7C143.4,159.8,170.8,187.8,205.1,188.5z"
                        fill="#545a6d" />
                </g>
            </svg>
        </span>
        <span>
            {{ $title }}
        </span>
    </li>
    <style>
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@endsection
@section('content-body')
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-12 doctors-data-left">
                <div class="row">
                    <div class="col-lg-12 col-sm-4">
                        <div class="doc-data-card doctor">
                            <div class="doc-data-img"><img src="{{ asset('assets/img/receptionist.svg') }}" alt="">
                            </div>
                            <div class="doc-data">
                                <div class="doc-data-count">
                                    <a href="{{ route('all_patient_appointment') }}" id="all_patient_appointment"
                                        data-total={{ $all_appointment }}
                                        class="appointment-view all-patient-appointment-btn">{{ $all_appointment }}</a>
                                </div>
                                <div class="doc-data-title app-data-title cursor-pointer">All Appointments</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-4">
                        <div class="doc-data-card patient">
                            <div class="doc-data-img"><img src="{{ asset('assets/img/examination.svg') }}" alt="">
                            </div>
                            <div class="doc-data">
                                <div class="doc-data-count">
                                    <a href="{{ route('todays_patient_appointment') }}"
                                        class="appointment-view todays-patient-appointment-btn">{{ $todays_appointment }}</a>
                                </div>
                                <div class="doc-data-title app-data-title cursor-pointer">Today's Appointments</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-4">
                        <div class="doc-data-card receptionist">
                            <div class="doc-data-img"><img src="{{ asset('assets/img/receptionist.svg') }}" alt="">
                            </div>
                            <div class="doc-data">
                                <div class="doc-data-count">
                                    <a href="{{ route('upcoming_patient_appointment') }}"
                                        class="appointment-view upcoming-patient-appointment-btn">{{ $upcoming_appointment }}</a>
                                </div>
                                <div class="doc-data-title app-data-title cursor-pointer">Upcoming Appointments</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-4">
                        <div class="doc-data-card receptionist">
                            <div class="doc-data-img"><img src="{{ asset('assets/img/receptionist.svg') }}" alt="">
                            </div>
                            <div class="doc-data">
                                <div class="doc-data-count">
                                    <a href="{{ route('past_patient_appointment') }}"
                                        class="appointment-view past-patient-appointment-btn">{{ $past_appointment }}</a>
                                </div>
                                <div class="doc-data-title app-data-title cursor-pointer">Completed Appointments</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-12">
                <div id='full_calendar_events'>
                    <div class="modal fade theme-modal" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('footer_js')
        <script src="{{ asset('assets/js/plugins/select2/select2.min.js') }}"></script>
        <script>
            //form validation
            //full calender insert
            $(document).ready(function() {
                var SITEURL = "{{ url('/') }}";
                var calendar = $('#full_calendar_events').fullCalendar({
                    editable: true,
                    editable: true,
                    events: "{{ route('patient_appointments.index') }}",
                    timeFormat: 'H(:mm)',
                    displayEventTime: true,
                    eventRender: function(event, element, view) {
                        if (event.allDay === 'true') {
                            event.allDay = true;
                        } else {
                            event.allDay = false;
                        }
                    },
                    eventClick: function(calEvent, jsEvent, view) {
                        var patient_appointment_id = calEvent.id;
                        // console.log(patient_appointment_id);
                    $.ajax({
                        type: "get",
                        url: "{{route('patient_appointments.index')}}",
                        data: {
                            view:true,
                            patient_appointment_id:patient_appointment_id,
                            _token: "{{csrf_token()}}",
                            formtype: 'display-appointment-modal'
                        },
                        dataType: "json",
                        complete: function (response) {
                            // console.log(response);
                            // return false;
                            if(response && response.responseJSON)
                            {
                                let resp= response.responseJSON;
                                make_modal('display-appointment-modal', resp.data.view, true,'modal-lg')
                            }
                            else 
                            {
                                console.log("Error: Response is undefined or null.");
                            }
                        }
                    });
                    },
                    selectable: true,
                    eventOverlap: false,
                    selectHelper: true,
                    select: function(calendar_date, allDay, start, end, cell) {
                        let appointment_date = $.fullCalendar.formatDate(calendar_date, "Y-MM-DD");
                        // console.log(appointment_date);
                        // console.log('appointment_dates ', calendar_date, moment(calendar_date).format('YYYY/MM/DD hh:mm'))
                        if (moment().format('YYYY-MM-DD') === calendar_date.format('YYYY-MM-DD') ||
                            calendar_date.isAfter(moment())) {
                            let $this = $(this);
                            $this.addClass('pe-none');
                            $.ajax({
                                url: "{{ route('patient_appointments.index') }}",
                                type: 'get',
                                dataType: 'JSON',
                                async: false,
                                cache: false,
                                data: {
                                    load_view: true,
                                    appointment_date: appointment_date,
                                },
                                complete: response => {
                                    let resp = response.responseJSON;
                                    if (resp) {
                                        if (resp.status) {
                                            make_modal('patient-book-appointment-modal', resp
                                                .data.view, true, 'modal-lg');
                                            $('#doctor-dropdown').select2({
                                                dropdownParent: $('#patient-book-appointment-modal'),
                                                width: '100%'
                                            });
                                            $('#clinic-dropdown').select2({
                                                dropdownParent: $(
                                                    '#patient-book-appointment-modal'
                                                ),
                                                width: '100%',
                                                minimumInputLength: 1,
                                                ajax: {
                                                    url: "{{ route('patient.fetchClinics') }}",
                                                    type: "GET",
                                                    dataType: "json",
                                                    delay: 250,
                                                    processResults: function(data) {
                                                        console.log(data);
                                                        return {
                                                            results: data
                                                        };
                                                    },
                                                    cache: true
                                                }
                                            });
                                        }
                                    }
                                },
                                success: function(response) {
                                    console.log(response);
                                    return false;
                                    $.each(response.appointments, function(index, el) {
                                        let ti = el.time_start;
                                        let te = el.time_end;
                                        var booked_slot = (ti + '-' + te);
                                        if (response.available_slot.includes(
                                                booked_slot)) {}
                                        if (ti < response.current_time) {
                                            console.log('less time')
                                        }
                                    });
                                },
                                error: function(response) {
                                    error_notification();
                                }
                            }).always(function() {
                                $this.removeClass('pe-none');
                            });
                        }
                        return false;
                        if (moment().format('YYYY-MM-DD') === appointment_date.format('YYYY-MM-DD') ||
                            appointment_date.isAfter(moment())) {} else {}
                    },
                });
            });

            //all appointment data
            $(document).on('click', '.doc-data', function(e) {
                e.preventDefault();
                let $this = $(this).find('a.all-patient-appointment-btn');
                let add_view_url = $this.attr('href');
                if (add_view_url) {
                    console.log('add_view_url', add_view_url)
                    $.ajax({
                        url: add_view_url,
                        type: 'get',
                        dataType: 'json',
                        async: false,
                        cache: false,
                        data: {
                            load_view: 1,
                        },
                        complete: function(response) {
                            let resp = response.responseJSON;
                            if (resp) {
                                if (resp.status) {
                                    make_view_modal('view-appointment-details-modal theme-offcanvas-xl',
                                        resp.data.view, true);
                                    if ($(document).find('.all-patient-appointments-table').length) {
                                        var table = $(document).find('.all-patient-appointments-table')
                                            .DataTable({
                                                processing: true,
                                                serverSide: true,
                                                aaSorting: [],
                                                ajax: "{{ route('all_patient_appointment') }}",
                                                columns: [
                                                    {
                                                        data:'doctor_name',
                                                        name:'doctor_name'
                                                    },
                                                    {
                                                        data: 'doctor.user.phone_no',
                                                        name: 'phone_no'
                                                    },
                                                    {
                                                        data: 'appointment_date',
                                                        name: 'appointment_date'
                                                    },
                                                    {
                                                        data: 'created_by',
                                                        name: 'created_by'
                                                    },
                                                    {
                                                        data: 'status',
                                                        name: 'status'
                                                    },
                                                    // { data: 'action', name: 'action' },

                                                ],
                                                "columnDefs": [{
                                                    className: "patient_link",
                                                    "targets": [0]
                                                }, ]
                                            });
                                    }
                                }
                            }
                        }
                    });
                }
            });

            //todays appointment data
            $(document).on('click', '.doc-data', function(e) {
                e.preventDefault();
                let $this = $(this).find('a.todays-patient-appointment-btn');
                let add_view_url = $this.attr('href');
                if (add_view_url) {
                    console.log('add_view_url', add_view_url)
                    $.ajax({
                        url: add_view_url,
                        type: 'get',
                        dataType: 'json',
                        async: false,
                        cache: false,
                        data: {
                            load_view: 1,
                        },
                        complete: function(response) {
                            let resp = response.responseJSON;
                            if (resp) {
                                console.log('resp', resp)
                                if (resp.status) {
                                    make_view_modal(
                                        'todays-patient-appointment-details-modal theme-offcanvas-xl',
                                        resp.data.view, true);
                                    if ($(document).find('.todays-patient-appointments-table').length) {
                                        var table = $(document).find('.todays-patient-appointments-table')
                                            .DataTable({
                                                processing: true,
                                                serverSide: true,
                                                aaSorting: [],
                                                ajax: "{{ route('todays_patient_appointment') }}",
                                                columns: [
                                                    {
                                                        data:'doctor_name',
                                                        name:'doctor_name'
                                                    },
                                                    {
                                                        data: 'doctor.user.phone_no',
                                                        name: 'phone_no'
                                                    },
                                                    {
                                                        data: 'appointment_date',
                                                        name: 'appointment_date'
                                                    },
                                                    {
                                                        data: 'created_by',
                                                        name: 'created_by'
                                                    },
                                                    {
                                                        data: 'status',
                                                        name: 'status'
                                                    },
                                                    // { data: 'action', name: 'action' },
                                                ],
                                                "columnDefs": [{
                                                    className: "patient_link",
                                                    "targets": [0]
                                                }]
                                            });
                                    }
                                }
                            }
                        }
                    });
                }
            });

            //upcoming appointments data
            $(document).on('click', '.doc-data', function(e) {
                e.preventDefault();
                let $this = $(this).find('a.upcoming-patient-appointment-btn');
                let add_view_url = $this.attr('href');
                if (add_view_url) {
                    console.log('add_view_url', add_view_url)
                    $.ajax({
                        url: add_view_url,
                        type: 'get',
                        dataType: 'json',
                        async: false,
                        cache: false,
                        data: {
                            load_view: 1,
                        },
                        complete: function(response) {
                            let resp = response.responseJSON;
                            if (resp) {
                                console.log('resp', resp)
                                if (resp.status) {
                                    make_view_modal(
                                        'upcoming-patient-appointment-details-modal theme-offcanvas-xl',
                                        resp.data.view, true);
                                    if ($(document).find('.upcoming-patient-appointments-table').length) {
                                        var table = $(document).find('.upcoming-patient-appointments-table')
                                            .DataTable({
                                                processing: true,
                                                serverSide: true,
                                                aaSorting: [],
                                                ajax: "{{ route('upcoming_patient_appointment') }}",
                                                columns: [
                                                    {
                                                        data:'doctor_name',
                                                        name:'doctor_name'
                                                    },
                                                    {
                                                        data: 'doctor.user.phone_no',
                                                        name: 'phone_no'
                                                    },
                                                    {
                                                        data: 'appointment_date',
                                                        name: 'appointment_date'
                                                    },
                                                    {
                                                        data: 'created_by',
                                                        name: 'created_by'
                                                    },
                                                    {
                                                        data: 'status',
                                                        name: 'status'
                                                    },
                                                    // { data: 'action', name: 'action' },
                                                ],
                                                "columnDefs": [{
                                                    className: "patient_link",
                                                    "targets": [0]
                                                }]
                                            });
                                    }
                                }
                            }
                        }
                    });
                }
            });

            //past appointment data
            $(document).on('click', '.doc-data', function(e) {
                e.preventDefault();
                let $this = $(this).find('a.past-patient-appointment-btn');
                let add_view_url = $this.attr('href');
                if (add_view_url) {
                    $.ajax({
                        url: add_view_url,
                        type: 'get',
                        dataType: 'json',
                        async: false,
                        cache: false,
                        data: {
                            load_view: 1,
                        },
                        complete: function(response) {
                            let resp = response.responseJSON;
                            if (resp) {
                                console.log('resp', resp)
                                if (resp.status) {
                                    make_view_modal(
                                        'past-patient-appointment-details-modal make_view_modal theme-offcanvas-xl',
                                        resp.data.view, true);
                                    if ($(document).find('.past-patient-appointments-table').length) {
                                        var table = $(document).find('.past-patient-appointments-table')
                                            .DataTable({
                                                processing: true,
                                                serverSide: true,
                                                aaSorting: [],
                                                ajax: "{{ route('past_patient_appointment') }}",
                                                columns: [
                                                    {
                                                        data:'doctor_name',
                                                        name:'doctor_name'
                                                    },
                                                    {
                                                        data: 'doctor.user.phone_no',
                                                        name: 'phone_no'
                                                    },
                                                    {
                                                        data: 'appointment_date',
                                                        name: 'appointment_date'
                                                    },
                                                    {
                                                        data: 'next_date',
                                                        name: 'next_date'
                                                    },
                                                    {
                                                        data: 'created_by',
                                                        name: 'created_by'
                                                    },
                                                    {
                                                        data: 'status',
                                                        name: 'status'
                                                    },
                                                    // { data: 'action', name: 'action' },
                                                ],
                                                // "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                                                //     console.log(aData.disease_name);
                                                //       if (aData.disease_name != "" && aData.disease_name != 'N/A') {
                                                //         $('td', nRow).css('background-color', 'var(--theme-light-green);');
                                                //       }
                                                // },
                                                "columnDefs": [{
                                                    className: "patient_link",
                                                    "targets": [0]
                                                }]
                                            });
                                    }
                                }
                            }
                        }
                    });
                }
            });

            $(".update-status").click(function(ev) {
                let update_status = $(this).attr("data-update-status");
                alert(update_status);
                reject_confirmation('Are you sure you want to Reject this appointment?').then(function(response) {
                    if (response['isConfirmed']) {
                        $.ajax({
                            url: "{{ route('all-patient-appointments.destroy') }}",
                            type: 'DELETE',
                            dataType: 'json',
                            data: {
                                'id': id,
                            },
                            success: function(response) {
                                if (response.status) {
                                    reject_notification();
                                    $(document).find('#all-patient-appointments-table').DataTable()
                                        .ajax.reload();
                                    $(document).find('#todays-patient-appointments-table')
                                        .DataTable().ajax.reload();
                                    $(document).find('#upcoming-patient-appointments-table')
                                        .DataTable().ajax.reload();
                                    $(document).find('#past-patient-appointments-table').DataTable()
                                        .ajax.reload();
                                }
                            },
                            error: function(response) {
                                error_notification();
                            }

                        })
                    }
                });
            })
        </script>

        <script src="{{ asset('assets/js/plugins/datatables.min.js') }}"></script>
        <script src="{{ asset('assets/js/appointments.js') }}"></script>
    @endpush
