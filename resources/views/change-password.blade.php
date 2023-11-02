@extends('layouts.app')
@push('header_css')
<link rel="stylesheet" href="{{ asset('assets/css/plugins/datatables.min.css') }}" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endpush
@section('content-breadcrumb')
<li>
   <span>
   </span>
   <span>
   Change Password
   </span>
</li>
@endsection
@section('content-body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-4 mt-5 mb-5">
                <div class="card">
                    <div class="card-header">{{ __('Change Password') }}</div>                    
                    <form  method="POST" action="{{ route('update-password') }}" autocomplete="off" class="p-4">
                        @csrf
                        <div class="input-with-error">
                            <div class="input-group mb-3">
                                <span class="input-group-text input-icon">
                                    <i class="lni lni-envelope"></i>
                                </span>
                                <input name="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" id="oldPasswordInput" placeholder=" Old Password">
                            </div>
                            @error('old_password')
                            <div class="mb-3"><span class="text-danger">{{ $message }}</span></div>
                            @enderror
                        </div>
                        <div class="input-with-error">
                            <div class="input-group mb-3">
                                <span class="input-group-text input-icon">
                                    <i class="lni lni-lock-alt"></i>
                                </span>
                                <input name="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" id="newPasswordInput" placeholder=" New Password">
                            </div>
                            @error('new_password')
                            <div class="mb-3"><span class="text-danger">{{ $message }}</span></div>
                            @enderror
                        </div>
                        <div class="input-with-error">
                            <div class="input-group mb-3">
                                <span class="input-group-text input-icon">
                                    <i class="lni lni-lock-alt"></i>
                                </span>
                                <input name="new_password_confirmation" type="password" class="form-control" id="confirmNewPasswordInput" placeholder=" Confirm New Password">
                            </div>
                        </div>
                        <div class="theme-button">
                           <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('footer_js')
<script>
@if($message = session('status'))
Swal.fire({
    background: '#def5e5',
    iconHtml: '<div class="icon success"><svg width="30" height="30" id="Layer_1" style="enable-background:new 0 0 128 128;" version="1.1" viewBox="0 0 128 128" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><circle fill="#fff" cx="64" cy="64" r="64"></circle></g><g><path fill="#3EBD61" d="M54.3,97.2L24.8,67.7c-0.4-0.4-0.4-1,0-1.4l8.5-8.5c0.4-0.4,1-0.4,1.4,0L55,78.1l38.2-38.2   c0.4-0.4,1-0.4,1.4,0l8.5,8.5c0.4,0.4,0.4,1,0,1.4L55.7,97.2C55.3,97.6,54.7,97.6,54.3,97.2z"></path></g></svg></div>',
    color: '#395144',
    iconColor: '#395144',
    closeButtonColor: '#395144',
    toast: true,
    icon: 'success',
    title: 'Password Changed successfully!',
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
@endif
</script>
@endpush


