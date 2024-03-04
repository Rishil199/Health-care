if ( $('.clinics-table').length ) {
    var table = $('.clinics-table').DataTable({
        processing: true,
        serverSide: true,
        "aaSorting": [],
        ajax: clinics_url,
        columns: [
            { data: 'fullname', name: 'fullname' },
            { data: 'email', name: 'email' },           
            { data: 'user.phone_no', name: 'user.phone_no' },
            { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
    });
}

// $('.clinics-table').dataTable( );

if ( $('.branches-table').length ) {
    var table = $('.branches-table').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [],    
        ajax: branches_url,
        columns: [
            { data: 'fullname', name: 'fullname' },
            { data: 'email', name: 'email' },    
            { data: 'user.phone_no', name: 'user.phone_no' },
            { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false, width: '5%' },
        ]
    });
}

function validateForm( $form ) {
    if ( $form.length ) {
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
                },
                'status': {
                    required: true
                },
                'branch_type': {
                    required: true
                },
                'address': {
                    required: true
                }
            },
            messages: {
                'first_name': {
                  required: " Hospital name is required. ",
                },
                'email': {
                    required: "  Hospital email is required.",
                },
                'phone_no': {
                    required: " Hospital contact number is required."
                },
                'status':{
                    required: "  Hospital status is required."
                },
                'branch_type':{
                    required: "  Hospital branch type is required."
                },
                'address':{
                    required: "  Hospital address is required."
                },

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
                $.ajax({
                    url:  url,
                    type: url.indexOf('/update') === -1 ? 'POST' : 'PUT',
                    dataType: 'json',
                    cache: true,
                    data: $form.serializeArray(),
                    beforeSend: function() {
                        $('#loader').show();
                    },
                    success:function(response){
                        if(response.status){
                            url.indexOf('/update') === -1 ? data_insert_notification() : data_update_notification(),
                            table.ajax.reload();
                            $form.parents('.modal').modal('hide');  
                        }
                    },
                    error: function(error) {
                        $('#loader').hide();
                        error_notification_add();
                        validateForm.showErrors(error.responseJSON.errors);
                    },
                    complete: function() {
                        $('#loader').hide();
                    },
                });
            },
        });
    }
}

$(document).on('click', '.add-new-branch', function(event) {
    event.preventDefault();
    let $this = $(this);
    $this.addClass('pe-none');
    $.ajax({
        url: add_branch,
        type: 'get',
        dataType: 'json',
        complete: function ( response ) {
            let resp = response.responseJSON;
            if ( resp.status ) {
                $('#branch-wrapper').append(resp.data.view);
            }
        },
        error: function (response) {
            error_notification_add();
        }
    }).always(function(){
        $this.removeClass('pe-none');
    });
});

$(document).on('click', '.btn-add-clinic', function(event) {
    validateForm( $('#add-clinic-form') );
});

$('#add_clinic_btn').on('click',function(e){
    validateForm( $('#add_clinic_form') );
})

$('.branch_add_btn').on('click',function(e){
    $('#clinic_dropdown').show();
})

$('#update_clinic_btn').on('click',function(e){
    validateForm( $('#update_clinic_form') );
})

$('#cancel_clinic_btn').on('click',function(e){
    window.location.href = clinics_url;
})

function delete_record(id) {
    delete_confirmation('Are you sure you want to delete this record?').then(function (response) {
        if (response['isConfirmed']) {
             $.ajax({
                url: delete_branch_url,
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

function delete_main_record(id) {
    delete_confirmation('Are you sure you want to delete this record? If you delete this main branch all your sub-branches will be deleted?').then(function (response) {
        if (response['isConfirmed']) {
             $.ajax({
                url: delete_clinic_url,
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

$(document).on('click', '.add-branch',function(e) {
    e.preventDefault();
    let add_branch_url = $(this).attr('data-url');
    let $this = $(this);
    $this.addClass('pe-none');
    if ( add_branch_url ) {
        $.ajax({
            url: add_branch_url,
            type: 'get',
            dataType: 'json',
            complete: function(response) {
                let resp = response.responseJSON;
                if ( resp ) {
                    if ( resp.status ) {
                        make_modal( 'add-branch-modal', resp.data.view, true,'modal-lg');
                        validateForm( $('.add_branch_form') );
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

$(document).on('click', '.add-main-branch',function(e) {
    e.preventDefault();
    let add_main_branch_url = $(this).attr('data-url');
    let $this = $(this);
    $this.addClass('pe-none');
    if ( add_main_branch_url ) {
        $.ajax({
            url: add_main_branch_url,
            type: 'get',
            dataType: 'json',
            complete: function(response) {
                let resp = response.responseJSON;
                if ( resp ) {
                    if ( resp.status ) {
                        make_modal( 'add-main-branch-modal', resp.data.view, true, 'modal-lg' );
                        validateForm( $('.add_branch_form') );
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

$(document).on('click', '.edit-branch',function(e) {
    e.preventDefault();
    let edit_branch_url = $(this).attr('data-url');
    let $this = $(this);
    $this.addClass('pe-none');
    if ( edit_branch_url ) {
        $.ajax({
            url: edit_branch_url,
            type: 'get',
            dataType: 'json',
            complete: function(response) {
                let resp = response.responseJSON;
                    if ( resp.status ) {
                        make_modal( 'add-edit-branch-modal', resp.data.view, true,  'modal-lg' );
                        validateForm( $('#update_clinic_form') );
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

/* Remove Branch */
$(document).on('click', '.remove-branch', function(event) {
    event.preventDefault();
    let $panel = $(this).parents('.branch-panel');
    if ( $panel.length ) {
        $panel.fadeOut('slow', function() {
            $panel.remove();
        });
    }
});


$(document).on('click', '.toggle-class',function(e) {
    var status = $(this).prop('checked') == true ? 1 : 0;  
    var clinic_id = $(this).data('id');  
    $.ajax({ 
       type: "GET", 
       dataType: "json", 
       url: changeStatus, 
       data: {'status': status, 'clinic_id': clinic_id}, 
        success: function (data) {
            status_update_notification()
            table.ajax.reload();
        },
        error: function (data) {
            error_notification();
        }
    }); 
}) 