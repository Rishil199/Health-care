//setttings form

function validateSettingsForm( $form ) {
    if ( $form.length ) {
        let validateForm = $form.validate({
            rules: {
                start_time: {
                    required: true
                },
                end_time: {
                    required: true
                },
                duration: {
                    required: true,
                    number: true
                }
            },
            messages: {
                'start_time': {
                  required: "Start time is required. "
                },
                'end_time': {
                    required: "End time is required."
                },
                'duration': {
                    required: "Duration is required."
                }
            },
            submitHandler: ( form ) => {
                let url = $form.attr('action');
                $.ajax({
                    url:  url,
                    type: url.indexOf('/update') === -1 ? 'POST' : 'PUT',
                    dataType: 'json',
                    data: $form.serializeArray(),
                    success:function(response){
                        if(response.status){
                            url.indexOf('/update') === -1 ? displayMessage("Settings Updated Successfully") : displayMessage("Settings Updated Successfully"),
                            $form.parents('.modal').modal('hide');
                            window.location.reload();
                        }else{
                        }
                    },
                    error:function(error){
                        validateForm.showErrors(error.responseJSON.errors);
                    }
                });
            },
        });
    }
}
function displayMessage(message) {
        toastr.success(message, '');            
    }

$(document).on('click', '.settings-add-btn',function(e) {
    e.preventDefault();
    let add_settings_url = $(this).attr('data-url');
    if ( add_settings_url ) {
        $.ajax({
            url: add_settings_url,
            type: 'get',
            dataType: 'json',
            complete: function(response) {
                let resp = response.responseJSON;
                if ( resp ) {
                    if ( resp.status ) {
                        make_modal( 'add-settings-modal', resp.data.view, true, 'modal-lg' );
                        validateSettingsForm( $('.add_settings_form') );
                    }
                }
            }
        });
    }
});

$(document).ready(function () {
    if ($('#appointments_tab').length ) {
            $('#appointments_tab').DataTable({
                bDestroy: true,
                processing: true,
                serverSide: true,
                aaSorting: [],
                ajax:{ 
                    dashboard_url,
                    data:{table_name:'appointments_tab'}
                },
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'patient.phone_no', name: 'patient.phone_no' },
                    { data: 'patient.email', name: 'patient.email' },    
                     {data:'prescription',name:'prescription'},
                     {data:'appointment_date', name:'appointment_date'},
                     {data:'appointment_time',name:'appointment_time'}
                ],
                "bDestroy": true
            });
        }
});