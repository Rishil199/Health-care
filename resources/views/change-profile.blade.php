@extends('layouts.app')
@section('content-body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-4 mt-5 mb-5">
                <div class="card">
                    <div class="card-header">{{ __('Change Profile') }}</div>                    
                    <form  method="POST" action="{{ route('update-profile') }}" autocomplete="off" class="p-4" name="updateProfile" id="updateProfile">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                              <div class="form-group theme-form-group">
                                 <label class="theme-label" for="first_name">First Name <span class="required">*</span></label>
                                 <div class="theme-form-input">
                                    <input class="form-control" id="first_name" name="first_name" type="text" placeholder="First Name" value="{{ $users->first_name}}" />
                                 </div>
                                 @error('first_name')
                                <div class="mb-3"><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                              </div>
                           </div>
                           <div class="col-md-6 mb-3">
                              <div class="form-group theme-form-group">
                                 <label class="theme-label" for="last_name">Last Name</label>
                                 <div class="theme-form-input">
                                    <input class="form-control" id="last_name" name="last_name" type="text" placeholder="Last Name" value="{{ $users->last_name}}" />
                                 </div>
                                 @error('last_name')
                                <div class="mb-3"><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                              </div>
                           </div>
                           <div class="col-md-6 mb-3">
                              <div class="form-group theme-form-group">
                                 <label class="theme-label" for="email">Email <span class="required">*</span></label>
                                 <div class="theme-form-input">
                                    <input class="form-control" id="email" name="email" type="email" placeholder="Last Name" value="{{ $users->email}}" readonly/>
                                 </div>
                                 @error('email')
                                <div class="mb-3"><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                              </div>
                           </div>
                           <div class="col-md-6 mb-3">
                              <div class="form-group theme-form-group">
                                 <label class="theme-label" for="phone_no">Phone No <span class="required">*</span></label>
                                 <div class="theme-form-input">
                                    <input class="form-control" id="phone_no" name="phone_no" type="tel" placeholder="Last Name" value="{{ $users->phone_no}}" />
                                 </div>
                                 @error('phone_no')
                                <div class="mb-3"><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                              </div>
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
    title: 'Profile Updated successfully!',
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

$( "#updateProfile" ).validate({
  rules: {
    email: {
        email: true,
        required: true
    },
    first_name: {
        required: true
    },
    phone_no: {
        required: true
    }
  }
});
</script>
@endpush