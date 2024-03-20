@extends('layouts.app')
@push('head_css_script')
<link href="{{ asset('assets/css/themes/lite-purple.min.css')}}" rel="stylesheet" type="text/css">
@endpush
@section('content')
<div class="login-page">
   <div class="login-logo">
      <a href="">
      <img src="{{ asset('assets/img/narolacare_logo.png') }}" alt="Logo">
      </a>
   </div>
   <div class="login-wrapper">
      <div class="login-upper">
         <div class="login-user-icon">
            <i class="lni lni-hospital"></i>
         </div>
      </div>
      <div class="login-middle">
         <x-auth-session-status class="alert-success" :status="session('status')" />
          <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <div class="input-with-error  mb-3">
               <div class="input-group">
                  <span class="input-group-text input-icon">
                  <i class="lni lni-envelope"></i>
                  </span>
                  <input type="email" class="form-control @error('email') is-invalid @enderror"  name="email" value="{{ $request->email }}" placeholder="E-Mail Address">
               </div>
               @error('email')
               <div class="mb-2"><span class="text-danger">{{ $message }}</span></div>
               @enderror
            </div>
            <div class="input-with-error mb-3">
               <div class="input-group ">
                  <span class="input-group-text input-icon">
                  <i class="lni lni-lock-alt"></i>
                  </span>
                  <input id="password" class="block mt-1 w-full form-control" type="password" name="password" placeholder="Password" required />
               </div>
               @error('password')
               <div class="mb-1"><span class="text-danger">{{ $message }}</span></div>
               @enderror
            </div>
               <div class="input-with-error">
               <div class="input-group mb-3">
                  <span class="input-group-text input-icon">
                  <i class="lni lni-lock-alt"></i>
                  </span>
                  <input id="password_confirmation" class="block mt-1 w-full form-control"
                           type="password"
                           name="password_confirmation" placeholder="Confirm Password" required />
                        <div class="form-control-feedback">
                           <i class="icon-user text-muted"></i>
                        </div>
                        @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
               </div>
           
            </div>
            <div class="theme-button">
              <button type="submit" class="btn btn-primary btn-block">{{ __('Reset Password') }}<i class="icon-circle-right2 position-right"></i></button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="ripple-background">
   <div class="circle xxlarge shade1"></div>
   <div class="circle xlarge shade2"></div>
   <div class="circle large shade3"></div>
   <div class="circle mediun shade4"></div>
   <div class="circle small shade5"></div>
</div>
@endsection