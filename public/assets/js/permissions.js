if ( $('.permissions-table').length ) {
var table = $('.permissions-table').DataTable({
    processing: true,
    serverSide: true,
    "aaSorting": [],	
    ajax: permissions_url,
    columns: [
        {data: 'name', name: 'name', class: 'text-capital'},
        {data: 'created_at', name: 'created_at'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
});
}
function delete_record(id) {
    delete_confirmation('Are you sure you want to delete this record?').then(function (response) {
        if (response['isConfirmed']) {
             $.ajax({
                url: delete_permission_url,
                type: 'DELETE',
                dataType: 'json',
                data: {
                    'id': id,
                },
                success: function (response) {
                    if(response.status)
                    {
                        delete_notification();
                        table.ajax.reload();
                    }
                    else
                    {
                       error_notification();
                    }
                    
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

$(document).on('click', '.edit-permission',function(e) {
    e.preventDefault();
    let edit_permission_url = $(this).attr('data-url');
    let $this = $(this);
    $this.addClass('pe-none');
    if ( edit_permission_url ) {
        $.ajax({
            url: edit_permission_url,
            type: 'get',
            dataType: 'json',
            complete: function(response) {
                let resp = response.responseJSON;
                if ( resp ) {
                    if ( resp.status ) {
                        make_modal( 'edit-permission-modal', resp.data.view, true,'modal-lg' );
                        validateForm( $('.edit-permissions-form') );
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
})

$(document).on('click', '.permission-add-btn',function(e) {
    e.preventDefault();
    let add_permission_url = $(this).attr('data-url');
    let $this = $(this);
    $this.addClass('pe-none');
    if ( add_permission_url ) {
        $.ajax({
            url: add_permission_url,
            type: 'get',
            dataType: 'json',
            complete: function(response) {
                let resp = response.responseJSON;
                if ( resp ) {
                    if ( resp.status ) {
                        make_modal( 'add-permission-modal', resp.data.view, true, 'modal-lg' );
                        validateForm( $('.add_permissions_form') );
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