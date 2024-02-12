if ( $('.roles-table').length ) {
var table = $('.roles-table').DataTable({
    processing: true,
    serverSide: true,
    aaSorting: [],    
    ajax: roles_url,
    columns: [
        { data: 'name', name: 'name', class: 'text-capital' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false, searchable: false },
    ]
});
}

function delete_record(id) {
  delete_confirmation('Are you sure you want to delete this record?').then(function (response) {
        if (response['isConfirmed']) {
             $.ajax({
                url: delete_role_url,
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



function validateForm( $form ) {
    if ( $form.length ) {
        let validateForm = $form.validate({
            rules: {
                name: {
                    required: true
                },
                'permission[]': {
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
                            $('#loader').hide();
                            url.indexOf('/update') === -1 ? data_insert_notification() : data_update_notification(),
                            table.ajax.reload();
                            $form.parents('.modal').modal('hide');
                        }else{
                        }
                    },
                    error:function(error){
                        $('#loader').hide();
                        validateForm.showErrors(error.responseJSON.errors);
                    }
                });
            },
        });
    }
}

$('#add-btn').on('click',function(e){
    validateForm( $('#roles_form') );
})


$(document).on('click', '.edit-role',function(e) {
    e.preventDefault();
    let edit_url = $(this).attr('data-url');
    let $this = $(this);
    $this.addClass('pe-none');
    if ( edit_url ) {
        $.ajax({
            url: edit_url,
            type: 'get',
            dataType: 'json',
            complete: function(response) {
                let resp = response.responseJSON;
                if ( resp ) {
                    if ( resp.status ) {
                        make_modal( 'edit-role-modal', resp.data.view, true,'modal-lg' );
                        validateForm( $('.edit_roles_form') );
                    } else {
                        alert('Something went wrong, please try again.');
                    }
                }
            },
            error: function (response) {
                error_notification();
            }
        }).always(function(){
            $this.removeClass('pe-none');
        });;
    }
});

$(document).on('click', '.role-add-btn',function(e) {
    e.preventDefault();
    let add_url = $(this).attr('data-url');
    let $this = $(this);
    $this.addClass('pe-none');
    if ( add_url ) {
        $.ajax({
            url: add_url,
            type: 'get',
            dataType: 'json',
            complete: function(response) {
                let resp = response.responseJSON;
                if ( resp ) {
                    if ( resp.status ) {
                        make_modal( 'add-role-modal', resp.data.view, true, 'modal-lg' );
                        validateForm( $('.add_role_form') );
                    } else {
                        alert('Something went wrong, please try again.');
                    }
                }
            },
            error: function (response) {
                error_notification_add();
            }
        }).always(function(){
            $this.removeClass('pe-none');
        });;
    }
});