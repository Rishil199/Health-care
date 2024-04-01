if ( $('.doctors-table').length ) {
    var table = $('.doctors-table').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [],
        ajax: doctors_url,
        columns: [
            { data: 'fullname', name: 'fullname' },
            { data: 'email', name: 'email' },    
            { data: 'user.phone_no', name: 'user.phone_no' },
            { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
           
        ]
    });
}

if ( $('.doctors-patients-table').length ) {
    var table = $('.doctors-patients-table').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [],
        ajax: doctorss_url,
        columns: [

            { data: 'name', name: 'name' },
            {
                data: 'email',
                'render': function(data, type, full, meta)
                {
                    return '<a href="mailto:' + full.email + '?">' + full.email + '</a>';
                }
            },
            { data: 'user.phone_no', name: 'user.phone_no' },
            { data: 'action', name: 'action' },

        ]
    });
}

$(document).on('click', '.btn-add-doctors',function(e) {
    e.preventDefault();
    let add_doctors_url = $(this).attr('data-url');
    let $this = $(this);
    $this.addClass('pe-none');
    if ( add_doctors_url ) {
        $.ajax({
            url: add_doctors_url,
            type: 'get',
            dataType: 'json',
            complete: function(response) {
                let resp = response.responseJSON;
                if ( resp ) {
                    if ( resp.status ) {
                        make_modal( 'add-doctors-modal', resp.data.view, true, 'modal-lg' );
                        validateForm( $('.add-doctors-form') );
                        if ( $("#datepicker").length ) {
                            $("#datepicker").datepicker({
                                format: 'dd/mm/yyyy',
                                endDate:'Od'
                            });
                        }
                        if ( $("#clinic_id").length ) {
                            var parent_modal = $('#add-doctors-modal > .modal-dialog > .modal-content');
                            $('#clinic_id').select2({
                                dropdownParent: parent_modal,
                                width: '100%'
                            });
                        }
                    }
                }
            },
            error: function (response) {
                error_notification_add();
            }
        }).always(function(){
            $this.removeClass('pe-none');
        });
    }
});

function validateForm( $form ) {
    if ( $form.length ) {
        $.validator.addMethod("phoneNumber", function(value, element) {
            var regex = /^[+\-\d]+$/;
            return this.optional(element) || regex.test(value);
        }, "Please enter a valid phone number.");

        let validateForm = $form.validate({
            rules: {
                'first_name': {
                    required: true
                },
                'last_name': {
                    required: true
                },
                'email': {
                    required: true
                },
                'phone_no': {
                    required: true,
                    phoneNumber:true
                },
                'birth_date': {
                    required: true,
                    // date: true,
                },
                'expertice': {
                    required: true
                },
                'status': {
                    required: true
                },
                'clinic_id': {
                    required: true
                },
                'address': {
                    required: true
                },
                'gender': {
                    required: true
                },
                'degree': {
                    required: true
                },
                'experience': {
                    required: true
                }
            },
            messages: {
                'first_name': {
                  required: "Doctor first name is required. ",
                },
                'last_name':{
                    required: " Doctor last name is required."
                },
                'email': {
                  required: " Doctor email is required.",
                },
                'phone_no': {
                  required: "Doctor contact number is required",
                },
                'birth_date':{
                    required:'Doctor birth date is required.'
                },
                'expertice': {
                    required:'Doctor expertise is required.'
                },
                'status':{
                    required:'Doctor status is required.'
                },
                'clinic_id':{
                    required:'Doctor clinic is required.'
                },
                'address':{
                    required:'Doctor address is required.'
                },
                'gender':{
                    required:'Doctor gender is required.'
                },
                'degree':{
                    required:'Doctor degree is required.'
                },
                'experience':{
                    required:'Doctor experience is required.'
                }
              },
            errorPlacement: function(error, element) {
                // Styled checkboxes, radios, bootstrap switch
                if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container') ) {
                    if(element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                        error.appendTo( element.parent().parent().parent().parent() );
                    } else {
                        error.appendTo( element.parent().parent().parent().parent().parent() );
                    }
                }

                else if ( element.parent('div').hasClass('custom-checkbox') ) {
                    error.appendTo( element.parent().parent().parent().parent() );
                }

                // Unstyled checkboxes, radios
                else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
                    error.appendTo( element.parent().parent().parent() );
                }

                // Input with icons and Select2
                else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
                    error.appendTo( element.parent() );
                }

                // Inline checkboxes, radios
                else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                    error.appendTo( element.parent().parent().parent() );
                }

                // Input group, styled file input
                else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                    error.appendTo( element.parent().parent() );
                }

                else {
                    error.insertAfter(element);
                }
            },
            submitHandler: ( form ) => {
                let url = $form.attr('action');
                $('#loader').show();
                $.ajax({
                    url:  url,
                    type: url.indexOf('/update') === -1 ? 'POST' : 'PUT',
                    dataType: 'json',
                    data: $form.serializeArray(),
                    success:function(response){
                        $('#loader').hide();
                        if(response.status){
                            $('#loader').hide();
                            url.indexOf('/update') === -1 ? data_insert_notification() : data_update_notification(),
                            table.ajax.reload();
                            $form.parents('.modal').modal('hide');                        
                        }else{
                        }
                    },
                    error: function(xhr) {
                        $('#loader').hide();
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            validateForm.showErrors(errors);
                        } else {
                            error_notification_add();
                        }
                    },
                });
            },
        });
    }
}

$(document).on('click', '.toggle-class',function(e) {
    var status = $(this).prop('checked') == true ? 1 : 0;  
        var doctors_id = $(this).data('id');  
        $.ajax({ 
           type: "GET", 
           dataType: "json", 
           url: changeStatus, 
           data: {'status': status, 'doctors_id': doctors_id}, 
            success: function (data) {
                status_update_notification()
                table.ajax.reload();
            },
            error: function (data) {
                error_notification();
            }
    }); 
}) 

$(document).on('click', '.btn-edit-doctors', function(event) {
    validateForm( $('#edit-doctors-form') );
});

function delete_record(id) {
    delete_confirmation('Are you sure you want to delete this record?').then(function (response) {
        if (response['isConfirmed']) {
             $.ajax({
                url: delete_doctors_url,
                type: 'DELETE',
                dataType: 'json',
                data: {
                    'id': id,
                },
                success: function (data) {
                    delete_notification();
                    table.ajax.reload();
                },
                error: function (data) {
                    error_notification();
                }
            })
        }
    });
}


$(document).on('click', '.doctor-view',function(e) {
    e.preventDefault();
    let add_view_url = $(this).attr('data-url');
    let $this = $(this);
    $this.addClass('pe-none');
    if ( add_view_url ) {
        $.ajax({
            url: add_view_url,
            type: 'get',
            dataType: 'json',
            complete: function(response) {
                let resp = response.responseJSON;
                if ( resp ) {
                    if ( resp.status ) {
                        make_modal( 'add-branch-modal', resp.data.view, true ,'modal-lg' );
                        validateForm( $('.add_branch_form') );
                    }
                }
            },
            error: function (response) {
                error_notification();
            }
        }).always(function(){
            $this.removeClass('pe-none');
        });
    }
});

$(document).on('click', '.edit-doctor',function(e) {
    e.preventDefault();
    let edit_doctor_url = $(this).attr('data-url');
    let $this = $(this);
    $this.addClass('pe-none');
    if ( edit_doctor_url ) {
        $.ajax({
            url: edit_doctor_url,
            type: 'get',
            dataType: 'json',
            complete: function(response) {
                let resp = response.responseJSON;
                    if ( resp.status ) {
                        make_modal( 'add-edit-doctor-modal', resp.data.view, true, 'modal-lg' );
                        validateForm( $('#update-doctors-form') );
                        if ( $("#datepicker").length ) {
                            $("#datepicker").datepicker({
                                format: 'dd/mm/yyyy',
                                endDate:'Od'
                            });
                        }
                        if ( $("#clinic_id").length ) {
                            var parent_modal = $('#add-edit-doctor-modal > .modal-dialog > .modal-content');
                            $('#clinic_id').select2({
                                dropdownParent: parent_modal,
                                width: '100%'
                            });
                        }
                    }
            },
            error: function (response) {
                error_notification();
            }
        }).always(function(){
            $this.removeClass('pe-none');
        });
    }
});



    function initializeDataTable() {
        if ($('#doctors-tab').length ) {
                $('#doctors-tab').DataTable({
                    bDestroy: true,
                    processing: true,
                    serverSide: true,
                    aaSorting: [],
                    ajax:{   
                     dashboard_url,
                     data:{table_name:'doctors-tab'}
                    },
                    columns: [
                        { data: 'fullname', name: 'fullname' },
                        { data: 'user.phone_no', name: 'user.phone_no' }, 
                        { data: 'user.email', name: 'user.email' },  
                        {data: 'action', name:'action'}  
                    ],
                    "bDestroy": true
                });
            }
        }


        $('#recipt-tab').click(function () { 
            initializeDataTable();
        });

        $(document).ready(function () {
            initializeDataTable();
        });

        $(document).ready(function (){
        $("#patient-tab").click(function(){
        if ($('#patient-table').length ) {
        $('#patient-table').DataTable({
            bDestroy: true,
            processing: true,
            serverSide: true,
            aaSorting: [],
            ajax:{   
             dashboard_url,
             data:{table_name:'patient-tab'}
            },
            columns: [
                { data: 'name', name: 'name' },
                { data: 'user.phone_no', name: 'user.phone_no' }, 
                { data: 'user.email', name: 'user.email' },  
                {data: 'action', name:'action'}  
            ],
            "bDestroy": true
        });
    }
})

});

