if ( $('.patients-table').length ) {
    var table = $('.patients-table').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [],    
        ajax: patients_url,
        columns: [
            { data: 'fullname', name: 'fullname' },
            { data: 'email', name: 'email' },    
            { data: 'user.phone_no', name: 'user.phone_no' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
}



$(document).on('click', '.btn-add-patients',function(e) {
    e.preventDefault();
    let add_patients_url = $(this).attr('data-url');
    let $this = $(this);
    $this.addClass('pe-none');
    if ( add_patients_url ) {
        $.ajax({
            url: add_patients_url,
            type: 'get',
            dataType: 'json',
            complete: function(response) {
                let resp = response.responseJSON;
                if ( resp ) {
                    if ( resp.status ) {
                        make_modal( 'add-patients-modal', resp.data.view, true,'modal-xl' );
                        validateForm( $('.add-patients-form') );
                        if ( $("#datepicker").length ) {
                            $("#datepicker").datepicker({
                            format: 'dd/mm/yyyy'
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
        console.log('$form', $form);
        let validateForm = $form.validate({
            rules: {
                'first_name': {
                    required: true
                },
                'email': {
                    required: true
                },
                'phone_no': {
                    required: true
                },
                'address': {
                    required: true
                },
                'gender': {
                    required: true
                },
            },
            errorPlacement: function(error, element) {
                // Styled checkboxes, radios, bootstrap switch
                if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container') ) {
                    console.log('call in if 1' );
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
                console.log(url);
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
                    error: function(error) {
                        $('#loader').hide();
                        // error_notification();
                        console.log('error.responseJSON.errors', error.responseJSON.errors)
                        validateForm.showErrors(error.responseJSON.errors);
                    }
                });
            },
        });
    }
}

function delete_record(id) {
    delete_confirmation('Are you sure you want to delete this record?').then(function (response) {
        if (response['isConfirmed']) {
             $.ajax({
                url: delete_patients_url,
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

$(document).on('click', '.patient-view',function(e) {
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
                        make_modal( 'add-branch-modal', resp.data.view, true, 'modal-lg' );
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

$(document).on('click', '.edit-patient',function(e) {
    e.preventDefault();
    let edit_patient_url = $(this).attr('data-url');
    if ( edit_patient_url ) {
        $.ajax({
            url: edit_patient_url,
            type: 'get',
            dataType: 'json',
            complete: function(response) {
                let resp = response.responseJSON;
                if ( resp ) {
                    if ( resp.status ) {
                        make_modal( 'add-edit-patient-modal', resp.data.view, true, 'modal-xl' );
                        validateForm( $('#update-patients-form') );
                        validateForm( $('#edit-patients-form') );
                        if ( $("#datepicker").length ) {
                            $("#datepicker").datepicker({
                            format: 'dd/mm/yyyy'
                            });
                        }
                    }
                }
            }
        });
    }
});


if ( $('.clinics-patients-table').length ) {
    var table = $('.clinics-patients-table').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [],
        ajax: clinicss_url,
        columns: [
            { 
                'render': function(data, type, full, meta)
                {
                    return full.user.first_name + ' ' + full.user.last_name;
                },
                
            },
            {
                'render': function(data, type, full, meta)
                {
                    return '<a href="mailto:' + full.user.email + '?">' + full.user.email + '</a>';
                }
            },
            { data: 'user.phone_no', name: 'user.phone_no' },
            { data: 'address', name: 'address' },
            { data: 'status', name: 'status' },


        ]
    });
}