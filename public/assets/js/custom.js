$(document).ready(function() {
       
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

   
});

function make_modal ( $className, $html = null, $open_modal = false, $dialogSize = null ) {
    let $modalHtml = '';
    let dialogClass = $dialogSize;
    $className = ( $className !== '' ) ? $className : 'custom-modal1';
    let id_name = $className.split(' ')[0];
    $modalHtml += `<div class="modal theme-modal fade ${$className}" id="${id_name}" role="document" data-bs-backdrop="static" data-keyboard="false">`;
        $modalHtml += `<div class="modal-dialog ${dialogClass} modal-dialog-centered modal-lg" role="document">`;
            $modalHtml += '<div class="modal-content append-wrapper">';
                $modalHtml += ( $html ) ? $html : '';
            $modalHtml += '</div>';
        $modalHtml += '</div>';
    $modalHtml += '</div>';

    $('body').append($modalHtml);

    let $elem = $('body').find('#' + id_name);
    if ( $open_modal ) {
        $elem.modal('show');
    }
    /* On close remove the modal */
    $elem.on('hidden.bs.modal', function(event) {
        $(this).remove();
    });
    return $elem;
}


function make_view_modal ( $className, $html = null, $open_modal = false, $dialogSize = null ) {
    let $modalHtml = '';
    let dialogClass = $dialogSize;
    $className = ( $className !== '' ) ? $className : 'custom-modal1';
    let id_name = $className.split(' ')[0];
    
    $modalHtml += `<div class="offcanvas offcanvas-end theme-offcanvas ${$className}" id="${id_name}" tabindex="-1" aria-labelledby="all_appointment_btn">`;
        $modalHtml += `<div class="offcanvas-body">`;
                $modalHtml += `<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>`
                $modalHtml += ( $html ) ? $html : '';
            $modalHtml += '</div>';
    $modalHtml += '</div>';

    $('body').append($modalHtml);

    let $elem = $('body').find('#' + id_name);
    if ( $open_modal ) {
        $elem.offcanvas('show')
    }
    /* On close remove the modal */
    $elem[0].addEventListener('hidden.bs.offcanvas', function () {
        this.remove()
    })
    return $elem;
}

function delete_confirmation(message = 'Are you sure you want to delete this record?', confirmButtonText = "Yes, delete!", cancelButtonText = 'No, cancel' ) {
    return Swal.fire({
        text: message,
        icon: "warning",
        showCancelButton: !0,
        buttonsStyling: !1,
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
        customClass: {
            confirmButton: "btn fw-bold btn-danger",
            cancelButton: "btn fw-bold btn-active-light-primary"
        }
    });
}

function reject_confirmation(message = 'Are you sure you want to reject this record?', confirmButtonText = "Yes, reject!", cancelButtonText = 'No, cancel' ) {
    return Swal.fire({
        text: message,
        icon: "warning",
        showCancelButton: !0,
        buttonsStyling: !1,
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
        customClass: {
            confirmButton: "btn fw-bold btn-danger",
            cancelButton: "btn fw-bold btn-active-light-primary"
        }
    });
}


$(function() {
  $('.responsive').slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: 8,
    slidesToScroll: 4,
    responsive: [
    {
        breakpoint: 1440,
        settings: {
            slidesToShow: 6,
            slidesToScroll: 4,
        }
    },
    {
        breakpoint: 1200,
        settings: {
            slidesToShow: 5,
            slidesToScroll: 3,
        }
    },
    {
        breakpoint: 991,
        settings: "unslick"
    }
  ]
}); 
});

function delete_notification(){
    let data = $('table').attr('name') ? $('table').attr('name') : 'Data';
    return swal.fire(({
        background: '#def5e5',
        iconHtml: '<div class="icon success"><svg width="30" height="30" id="Layer_1" style="enable-background:new 0 0 128 128;" version="1.1" viewBox="0 0 128 128" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><circle fill="#fff" cx="64" cy="64" r="64"></circle></g><g><path fill="#3EBD61" d="M54.3,97.2L24.8,67.7c-0.4-0.4-0.4-1,0-1.4l8.5-8.5c0.4-0.4,1-0.4,1.4,0L55,78.1l38.2-38.2   c0.4-0.4,1-0.4,1.4,0l8.5,8.5c0.4,0.4,0.4,1,0,1.4L55.7,97.2C55.3,97.6,54.7,97.6,54.3,97.2z"></path></g></svg></div>',
        color: '#395144',
        iconColor: '#395144',
        closeButtonColor: '#395144',
        toast: true,
        icon: 'success',
        title: data + ' ' +'has been deleted Successfully !',
        animation: false,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        allowOutsideClick: false,
        showCloseButton: true,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        },
        customClass: {
            closeButton: 'success-close',
            container: 'success-container',
            timerProgressBar: 'success-progress',
        }
    }));
}

function reject_notification(){
    // let Appointment = $('table').attr('name') ? $('table').attr('name') : 'Data';
    return swal.fire(({
        background: '#def5e5',
        iconHtml: '<div class="icon success"><svg width="30" height="30" id="Layer_1" style="enable-background:new 0 0 128 128;" version="1.1" viewBox="0 0 128 128" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><circle fill="#fff" cx="64" cy="64" r="64"></circle></g><g><path fill="#3EBD61" d="M54.3,97.2L24.8,67.7c-0.4-0.4-0.4-1,0-1.4l8.5-8.5c0.4-0.4,1-0.4,1.4,0L55,78.1l38.2-38.2   c0.4-0.4,1-0.4,1.4,0l8.5,8.5c0.4,0.4,0.4,1,0,1.4L55.7,97.2C55.3,97.6,54.7,97.6,54.3,97.2z"></path></g></svg></div>',
        color: '#395144',
        iconColor: '#395144',
        closeButtonColor: '#395144',
        toast: true,
        icon: 'success',
        title: 'Appointment has been Rejected Successfully !',
        animation: false,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        allowOutsideClick: false,
        showCloseButton: true,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        },
        customClass: {
            closeButton: 'success-close',
            container: 'success-container',
            timerProgressBar: 'success-progress',
        }
    }));
}

function error_notification() {
    return Swal.fire({
        background: '#ffe8e3',
        iconHtml: '<div class="icon danger"><svg height="30" viewBox="0 0 512 512" width="30" xmlns="http://www.w3.org/2000/svg"><path fill="#fff" d="M449.07,399.08,278.64,82.58c-12.08-22.44-44.26-22.44-56.35,0L51.87,399.08A32,32,0,0,0,80,446.25H420.89A32,32,0,0,0,449.07,399.08Zm-198.6-1.83a20,20,0,1,1,20-20A20,20,0,0,1,250.47,397.25ZM272.19,196.1l-5.74,122a16,16,0,0,1-32,0l-5.74-121.95v0a21.73,21.73,0,0,1,21.5-22.69h.21a21.74,21.74,0,0,1,21.73,22.7Z"></path></svg></div>',
        color: '#EC4D2B',
        iconColor: '#FB2576',
        closeButtonColor: '#FB2576',
        toast: true,
        icon: 'success',
        title: 'No Data Found!',
        animation: false,
        position: 'top-right',
        showConfirmButton: false,
        timer: false,
        allowOutsideClick: false,
        showCloseButton: true,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        },
        customClass: {
            closeButton: 'danger-close',
            container: 'danger-container',
        }
    });
}

function error_notification_add() {
    return Swal.fire({
        background: '#ffe8e3',
        iconHtml: '<div class="icon danger"><svg height="30" viewBox="0 0 512 512" width="30" xmlns="http://www.w3.org/2000/svg"><path fill="#fff" d="M449.07,399.08,278.64,82.58c-12.08-22.44-44.26-22.44-56.35,0L51.87,399.08A32,32,0,0,0,80,446.25H420.89A32,32,0,0,0,449.07,399.08Zm-198.6-1.83a20,20,0,1,1,20-20A20,20,0,0,1,250.47,397.25ZM272.19,196.1l-5.74,122a16,16,0,0,1-32,0l-5.74-121.95v0a21.73,21.73,0,0,1,21.5-22.69h.21a21.74,21.74,0,0,1,21.73,22.7Z"></path></svg></div>',
        color: '#EC4D2B',
        iconColor: '#FB2576',
        closeButtonColor: '#FB2576',
        toast: true,
        icon: 'success',
        title: 'Something went wrong!',
        animation: false,
        position: 'top-right',
        showConfirmButton: false,
        timer: false,
        allowOutsideClick: false,
        showCloseButton: true,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        },
        customClass: {
            closeButton: 'danger-close',
            container: 'danger-container',
        }
    });
}


function data_insert_notification(){
    let data = $('table').attr('name') ? $('table').attr('name') : 'Data';
    return swal.fire(({
        background: '#def5e5',
        iconHtml: '<div class="icon success"><svg width="30" height="30" id="Layer_1" style="enable-background:new 0 0 128 128;" version="1.1" viewBox="0 0 128 128" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><circle fill="#fff" cx="64" cy="64" r="64"></circle></g><g><path fill="#3EBD61" d="M54.3,97.2L24.8,67.7c-0.4-0.4-0.4-1,0-1.4l8.5-8.5c0.4-0.4,1-0.4,1.4,0L55,78.1l38.2-38.2   c0.4-0.4,1-0.4,1.4,0l8.5,8.5c0.4,0.4,0.4,1,0,1.4L55.7,97.2C55.3,97.6,54.7,97.6,54.3,97.2z"></path></g></svg></div>',
        color: '#395144',
        iconColor: '#395144',
        closeButtonColor: '#395144',
        toast: true,
        icon: 'success',
        title: data + ' ' +'Inserted Successfully!',
        animation: false,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        allowOutsideClick: false,
        showCloseButton: true,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        },
        customClass: {
            closeButton: 'success-close',
            container: 'success-container',
            timerProgressBar: 'success-progress',
        }
    }));
}

function data_update_notification(){
    let data = $('table').attr('name') ? $('table').attr('name') : 'Data';
    return swal.fire(({
        background: '#def5e5',
        iconHtml: '<div class="icon success"><svg width="30" height="30" id="Layer_1" style="enable-background:new 0 0 128 128;" version="1.1" viewBox="0 0 128 128" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><circle fill="#fff" cx="64" cy="64" r="64"></circle></g><g><path fill="#3EBD61" d="M54.3,97.2L24.8,67.7c-0.4-0.4-0.4-1,0-1.4l8.5-8.5c0.4-0.4,1-0.4,1.4,0L55,78.1l38.2-38.2   c0.4-0.4,1-0.4,1.4,0l8.5,8.5c0.4,0.4,0.4,1,0,1.4L55.7,97.2C55.3,97.6,54.7,97.6,54.3,97.2z"></path></g></svg></div>',
        color: '#395144',
        iconColor: '#395144',
        closeButtonColor: '#395144',
        toast: true,
        icon: 'success',
        title: data + ' ' +'has been Updated Successfully!',
        animation: false,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        allowOutsideClick: false,
        showCloseButton: true,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        },
        customClass: {
            closeButton: 'success-close',
            container: 'success-container',
            timerProgressBar: 'success-progress',
        }
    }));
}

function status_update_notification(){
    swal.fire({
        background: '#def5e5',
        iconHtml: '<div class="icon success"><svg width="30" height="30" id="Layer_1" style="enable-background:new 0 0 128 128;" version="1.1" viewBox="0 0 128 128" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><circle fill="#fff" cx="64" cy="64" r="64"></circle></g><g><path fill="#3EBD61" d="M54.3,97.2L24.8,67.7c-0.4-0.4-0.4-1,0-1.4l8.5-8.5c0.4-0.4,1-0.4,1.4,0L55,78.1l38.2-38.2   c0.4-0.4,1-0.4,1.4,0l8.5,8.5c0.4,0.4,0.4,1,0,1.4L55.7,97.2C55.3,97.6,54.7,97.6,54.3,97.2z"></path></g></svg></div>',
        color: '#395144',
        iconColor: '#395144',
        closeButtonColor: '#395144',
        toast: true,
        icon: 'success',
        title: 'Status Updated Successfully !',
        animation: false,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        allowOutsideClick: false,
        showCloseButton: true,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        },
        customClass: {
            closeButton: 'success-close',
            container: 'success-container',
            timerProgressBar: 'success-progress',
        }
    });
}


