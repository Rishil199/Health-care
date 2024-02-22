@extends('layouts.app')
@push('head_css_script')
<link href="{{ asset('assets/css/themes/lite-purple.min.css')}}" rel="stylesheet" type="text/css">
@endpush
@section('content')
<div class="login-page">

   <div class="container h-100">
      <div class="row h-100 align-items-center">
         <div class="col-lg-6 col-md-12 col-12">
           <div class="login-logo"> 
               <a href="">
               <img src="{{ asset('assets/img/narolacare_logo.png') }}" alt="Logo">
               </a>
            </div>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatum dolor incidunt iure fugiat aliquid quam obcaecati ipsam quidem repellendus a, assumenda iste mollitia hic esse facilis quae, distinctio ratione soluta.</p>
         </div>

          <div class="col-lg-6 col-md-12 col-12">
            <div class="page_wrapper">
               <div class="login_main">
                  <x-auth-session-status class="alert-success" :status="session('status')" />
                  <form  method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}" autocomplete="off">
                     @csrf
                     <div class="input-with-error">
                        <div class="input-group mb-3">
                           <span class="input-group-text input-icon">
                           <i class="lni lni-envelope"></i>
                           </span>
                           <input type="email" class="form-control @error('email') is-invalid @enderror"  name="email" value="{{ old('email') }}" placeholder="E-Mail Address">
                        </div>
                        @error('email')
                        <div class="mb-3"><span class="text-danger">{{ $message }}</span></div>
                        @enderror
                     </div>
                     <div class="input-with-error">
                        <div class="input-group mb-3">
                           <span class="input-group-text input-icon">
                           <i class="lni lni-lock-alt"></i>
                           </span>
                           <input type="password" class="form-control @error('password') is-invalid @enderror"  name="password" placeholder="Password">
                        </div>
                        @error('password')
                        <div class="mb-3"><span class="text-danger">{{ $message }}</span></div>
                        @enderror
                     </div>
                     <div class="theme-button">
                        <button type="submit" class="btn btn-primary">Log in</button>
                     </div>
                     <div class="forgot-pass">
                        <a href="{{ route('password.request') }}" class="text-primary">
                        <i class="lni lni-unlock"></i>
                        <span> Forgot your password?</span>
                        </a>
                     </div>
                  </form>
               </div>
            </div>
          </div>
      </div>
   </div>

</div>
<!-- <div class="ripple-background">
   <div class="circle xxlarge shade1"></div>
   <div class="circle xlarge shade2"></div>
   <div class="circle large shade3"></div>
   <div class="circle mediun shade4"></div>
   <div class="circle small shade5"></div>
</div> -->
@endsection