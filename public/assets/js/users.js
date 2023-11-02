var table = $('.users_datatable').DataTable({
    processing: true,
    serverSide: true,
    "aaSorting": [],	
    ajax: users_url,
    columns: [
        {data:'first_name', name: 'first_name'},
        {data: 'name', name: 'name'},
        {
		  	'render': function(data, type, full, meta)
		    {
		  		return '<a href="mailto:' + full.email + '?">' + full.email + '</a>';
			}
		},
        {data: 'created_at', name: 'created_at'},
        {
            data: 'action', 
            name: 'action', 
            orderable: false, 
            searchable: false
        },
    ]
});

$(document).on('click', '.add-user',function(e) {
    e.preventDefault();
    let add_user_url = $(this).attr('data-url');
    if ( add_user_url ) {
        $.ajax({
            url: add_user_url,
            type: 'get',
            dataType: 'json',
            complete: function(response) {
                let resp = response.responseJSON;
                if ( resp ) {
                    if ( resp.status ) {
                        make_modal( 'add-user-modal', resp.data.view, true );
                        validateForm( $('.add_user_form') );
                    }
                }
            }
        });
    }
});

function validateForm( $form ) {
    if ( $form.length ) {
        console.log('$form', $form);
        let validateForm = $form.validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    email: true,
                    required: true
                },
                first_name: {
                    required: true
                },
                last_name: {
                    required: true
                },
                roles_type: {
                    required: true
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
                            Swal.fire(response.message)
                            Swal.fire(
                              response.status,
                              response.message,
                              'success'
                            ).then(function() {
                                // table.ajax.reload();
                                $form.parents('.modal').modal('hide');
                            });                        
                        }else{
                        }
                    },
                    error: function(error) {
                        $('#loader').hide();
                        console.log('error.responseJSON.errors', error.responseJSON.errors)
                        validateForm.showErrors(error.responseJSON.errors);
                    }
                });
            },
        });
    }
}

$(document).on('click', '.btn-add-user', function(event) {
    validateForm( $('#add_user_form') );
});

$(document).on('click', '.edit-user', function(event) {
    validateForm( $('#edit_user_form') );
});

function delete_record(id) {
    delete_confirmation('Are you sure you want to delete this record?').then(function (response) {
        if (response['isConfirmed']) {
             $.ajax({
                url: delete_user_url,
                type: 'DELETE',
                dataType: 'json',
                data: {
                    'id': id,
                },
                success: function (data) {
                    swal.fire("Deleted!", "User has been deleted.", "success");
                    table.ajax.reload();
                },
                error: function (data) {
                    swal.fire("NOT Deleted!", "Something went wrong.", "error");
                }
            })
        }
    });
}

$(document).on('click', '.edit-user',function(e) {
    e.preventDefault();
    let edit_user_url = $(this).attr('data-url');
    if ( edit_user_url ) {
        $.ajax({
            url: edit_user_url,
            type: 'get',
            dataType: 'json',
            complete: function(response) {
                let resp = response.responseJSON;
                if ( resp ) {
                    if ( resp.status ) {
                        make_modal( 'edit-user-modal', resp.data.view, true );
                        validateForm( $('#edit_user_form') );
                    }
                }
            }
        })
    }        
})

