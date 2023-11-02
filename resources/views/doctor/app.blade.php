<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{ config('app.name', 'Laravel') }}</title>
      <!-- Fonts -->
      <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
      <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/css/iconsfont.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/css/light-style.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
      
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
      <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
      <link href="https://cdn.jsdelivr.net/bootstrap.timepicker/0.2.6/css/bootstrap-timepicker.min.css" rel="stylesheet" />
      
      @stack('header_css')
   </head>
   <body class="text-left">
      <div class="page-loader">
         <div class="spinner"></div>
      </div>
      @yield('content')
      @if(Auth::check())
      <div class="header-upper">
         <div class="container">
            <div class="row align-items-center justify-content-between">
               <div class="col-md-4 col-6">
                  <div class="logo">
                     <a href="{{route('doctor_dashboard')}}">
                     <img src="{{ asset('assets/img/narolacare_logo.png') }}" alt="Logo">
                     </a>
                  </div>
               </div>
               <div class="col-md-3 col-6">
                  <div class="hu-right">
                     <div class="noti-block dropdown drop-style-1">
                        {{-- <a href="" class="noti-icon" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell"></i>
                        </a> --}}
                        {{-- <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                           <div class="noti-title">
                              <span>Notification</span>
                              <a href="">View all</a>
                           </div>
                           <ul class="list-unstyled noti-list theme-scroll">
                              <li class="noti-list-item">
                                 <a class="dropdown-item" href="#">
                                    <div class="noti-list-image">
                                       <img src="{{ asset('assets/img/man.png') }}" alt="user-image">
                                    </div>
                                    <div class="noti-list-desc">
                                       <div class="noti-list-user">
                                          Deekshay
                                       </div>
                                       <div class="noti-list-info-wrapper">
                                          <div class="noti-list-info">
                                             Appointment Cancelled
                                          </div>
                                          <div class="noti-time">
                                             <i class="bi bi-clock-history"></i>
                                             <span>8 hours ago</span>
                                          </div>
                                       </div>
                                    </div>
                                 </a>
                              </li>
                              <li class="noti-list-item">
                                 <a class="dropdown-item" href="#">
                                    <div class="noti-list-image">
                                       <img src="{{ asset('assets/img/man.png') }}" alt="user-image">
                                    </div>
                                    <div class="noti-list-desc">
                                       <div class="noti-list-user">
                                          Deekshay
                                       </div>
                                       <div class="noti-list-info-wrapper">
                                          <div class="noti-list-info">
                                             Appointment Cancelled
                                          </div>
                                          <div class="noti-time">
                                             <i class="bi bi-clock-history"></i>
                                             <span>8 hours ago</span>
                                          </div>
                                       </div>
                                    </div>
                                 </a>
                              </li>
                           </ul>
                        </div> --}}
                     </div>
                     <div class="profile-avatar-block dropdown drop-style-regular">
                        <a href="" class="profile-avatar-icon" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                           <div class="profile-img">
                              <img src="{{ asset('assets/img/man.png') }}" alt="">
                           </div>
                           <div class="profile-text">
                              {{ Auth::user()->first_name}}
                           </div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                           <ul class="list-unstyled">
                              <li class="profile-list-item">
                                 <a class="dropdown-item icon-text" href="edit-profile.html">
                                    <div class="icon">
                                       <i class="lni lni-user"></i>
                                    </div>
                                    <div class="icon-desc">
                                       Change Profile
                                    </div>
                                 </a>
                              </li>
                              <li class="profile-list-item">
                                 <a class="dropdown-item icon-text" href="{{ route('change-password') }}">
                                    <div class="icon">
                                       <i class="lni lni-cog"></i>
                                    </div>
                                    <div class="icon-desc">
                                       Change Password
                                    </div>
                                 </a>
                              </li>
                              <li class="profile-list-item">
                                 <a href="javascript:void(0)" class="dropdown-item icon-text settings-add-btn" data-url="{{ route('settings.create')}}" data-toggle="addmodal" data-target="#myAddModal" id="settings-add-btn" >
                                    <div class="icon">
                                       <i class="lni lni-cog"></i>
                                    </div>
                                    <div class="icon-desc">
                                       Change Settings
                                    </div>
                                 </a>
                              </li>
                              <li class="profile-list-item">
                                 <a class="dropdown-item icon-text" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <div class="icon">
                                       <i class="lni lni-cog"></i>
                                    </div>
                                    <div class="icon-desc">
                                       {{ __('Logout') }}
                                    </div>
                                 </a>
                                 <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                 </form>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="header-lower">
         <div class="header-upper-block show">
            <div class="header-upper-left">
               <div class="header-btn">
                  <button class="btn">
                     <svg version="1.1" width="22" height="22" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        viewBox="0 0 299.1 292.7" style="enable-background:new 0 0 299.1 292.7;" xml:space="preserve">
                        <style type="text/css">
                           .st0{fill:#26282B;}
                        </style>
                        <g>
                           <path class="st0" d="M6.6,18.9L6.6,18.9c0-8.7,7-15.7,15.7-15.7h256.1c8.7,0,15.7,7,15.7,15.7v0c0,8.7-7,15.7-15.7,15.7H22.4
                              C13.7,34.7,6.6,27.6,6.6,18.9z"/>
                           <path class="st0" d="M6.7,146.9L6.7,146.9c0-8.7,7-15.7,15.7-15.7h256.1c8.7,0,15.7,7,15.7,15.7v0c0,8.7-7,15.7-15.7,15.7H22.4
                              C13.7,162.6,6.7,155.6,6.7,146.9z"/>
                           <path class="st0" d="M182.4,274.9L182.4,274.9c0,8.7-7.1,15.8-15.8,15.8H22.5c-8.7,0-15.8-7.1-15.8-15.8v0
                              c0-8.7,7.1-15.8,15.8-15.8h144.1C175.3,259.2,182.4,266.2,182.4,274.9z"/>
                        </g>
                     </svg>
                  </button>
               </div>
            </div>
            <div class="header-upper-right open">
               <div class="hur-block d-lg-none">
                  <div class="logo">
                     <a href="{{route('doctor_dashboard')}}">
                     <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
                     </a>
                  </div>
                  <div class="close">
                     <i class="lni lni-close"></i>
                  </div>
               </div>
                  <ul class="list-unstyled theme-scroll responsive">
                     <li>
                        <a href="{{route('doctor_dashboard')}}">
                           <span class="svg-icon">
                              <svg class="me-2" version="1.1" width="16" height="16" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 515 512" style="enable-background:new 0 0 515 512;" xml:space="preserve">
                                 <g>
                                    <path d="M311.5,1c57.3,0,114.7,0,172,0c8.6,2.7,17.2,6,22.4,13.8c3.7,5.6,5.8,12.1,8.6,18.2c0,78.3,0,156.7,0,235
                                       c-0.2,0.3-0.4,0.5-0.5,0.8c-6.2,21.5-18.7,30.9-41.2,30.9c-50.7,0-101.3,0-152-0.1c-4.3,0-8.7-0.3-12.9-1.3
                                       c-17.5-4.4-28.2-19-28.2-38.2c-0.1-46.8,0-93.6,0-140.5c0-26.5-0.1-53,0-79.5c0.1-17.4,9-30.9,24.2-36.7C306.4,2.5,309,1.8,311.5,1
                                       z" fill="#545a6d"></path>
                                    <path d="M2.5,482c0-78.7,0-157.3,0-236c0.2-0.3,0.4-0.6,0.5-0.9c6.4-21.6,18.8-30.9,41.2-30.9c51,0,102,0,153,0
                                       c24.3,0,40,15.8,40.1,40.1c0.1,19.8,0,39.7,0,59.5c0,53.2,0,106.3,0,159.5c0,16.3-6.8,28.6-21.5,36c-3.2,1.6-6.8,2.5-10.3,3.7
                                       c-57,0-114,0-171,0c-11.8-2.8-21.6-8.6-27.4-19.6C5.2,489.8,4,485.8,2.5,482z" fill="#545a6d"></path>
                                    <path d="M205.5,1c6.2,3,13.1,5.2,18.5,9.2c9.3,7,13.2,17.4,13.2,28.9c0.1,31.5,0.2,63,0,94.5c-0.2,21.9-16,37.9-38,38
                                       c-52.8,0.2-105.6,0.2-158.4,0c-18.8-0.1-32.7-11.3-37.3-29.4c-0.2-0.8-0.6-1.5-0.9-2.3c0-36,0-72,0-108c0.6-1.7,1.3-3.3,1.8-5
                                       C7.7,16.8,14.2,9.3,23.9,4.7C27,3.3,30.3,2.2,33.5,1C90.8,1,148.2,1,205.5,1z" fill="#545a6d"></path>
                                    <path d="M311.5,513c-3.6-1.3-7.3-2.2-10.7-4c-13.6-6.9-20.8-18.2-20.9-33.2c-0.3-32.2-0.4-64.3,0-96.5c0.3-21.6,16.6-36.9,38.4-37
                                       c38.3-0.2,76.6,0,115-0.1c13.7,0,27.3,0,41,0c20.8,0,34.1,10.3,39.5,30.4c0.1,0.5,0.5,0.9,0.7,1.3c0,35.7,0,71.3,0,107
                                       c-2.6,5.8-4.6,12.1-8,17.4c-5.5,8.5-14.5,12.3-24,14.6C425.5,513,368.5,513,311.5,513z" fill="#545a6d"></path>
                                 </g>
                              </svg>
                           </span>
                           <span class="svg-text">
                           Dashboard
                           </span>
                        </a>
                     </li>
                     <li>
                        <a href="{{route('appointments.index')}}">
                           <span class="svg-icon">
                              <svg class="me-2" width="20" height="20" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 384 384" style="enable-background:new 0 0 384 384;" xml:space="preserve">
                                 <g>
                                    <path d="M384.8,113.5c-2.7,4.7-5,9.6-8.2,14c-5.6,7.8-11.7,15.3-17.8,22.7c-1.9,2.3-1.7,3.8-0.1,6.1c5.7,8.2,11.2,16.5,16.8,24.8
                                       c7.4,11,5.3,21.3-5.6,28.6c-39.4,26.4-78.9,52.8-118.3,79.2c-2,1.4-3.9,3.1-5.4,5c-18.7,23.7-37.3,47.5-56,71.3
                                       c-8.6,11-18.7,12.2-29.8,3.4c-4.2-3.3-8.5-6.6-13-10.1c-4.7,3.2-9.5,6.3-14.2,9.5c-6,4-12,8.2-18.1,12c-2.9,1.8-6.2,3.1-9.3,4.7
                                       c-2.3,0-4.5,0-6.8,0c-6.6-1.9-10.8-6.5-14.5-12.1c-25.5-38.3-51.3-76.4-76.8-114.7c-2.8-4.2-4.6-9-6.9-13.5c0-1.3,0-2.5,0-3.8
                                       c1.4-7.7,6.5-12.4,12.8-16.5c34.5-22.9,68.9-46,103.4-69.1c2-1.4,3.9-3.1,5.4-5c36.7-46.7,73.4-93.5,110.1-140.3
                                       c8.4-10.7,18.5-12,29.2-3.7c38.1,29.7,76.2,59.5,114.3,89.2c4.6,3.6,7.2,8.1,8.7,13.5C384.8,110.5,384.8,112,384.8,113.5z
                                       M151.9,131.1c0.1,0.2,0.3,0.4,0.4,0.7c5.3-3.5,10.5-7,15.8-10.5c7.6-5.1,15.1-10.2,22.7-15.2c3.8-2.5,6.8-2.3,8.8,0.7
                                       c2.2,3.2,1.3,6-2.7,8.7c-0.8,0.6-1.6,1.1-2.5,1.7c-44.8,30-89.7,60-134.5,90c-1.5,1-3,2.1-4.3,2.9c13.1,29.6,7.9,55.1-15.2,77
                                       c9.8,14.6,19.5,29.1,29.4,43.8c13.1-6.9,26.7-9,40.9-6.3c14.4,2.7,26.2,9.9,35.8,21.2c59.8-40,119.3-79.9,178.6-119.6
                                       c-13.2-29.6-7.9-55.1,15.2-77c-9.8-14.6-19.6-29.2-29.2-43.5c-29.5,13.1-54.9,8.1-77.1-15c-2.6,1.8-5.4,3.6-8.2,5.5
                                       c-4,2.6-7,2.3-9.1-1c-1.9-3-1-5.8,2.8-8.4c15.6-10.4,31.1-20.9,46.7-31.3c11-7.4,21.2-5.3,28.6,5.8c17.5,26.1,35.1,52.3,52.6,78.4
                                       c0.7,1.1,1.5,2.2,2.6,3.6c7.1-9,14-17.7,20.8-26.5c3.7-4.8,3.3-8.4-1.6-12.2C331,74.7,292.8,44.9,254.6,15.1
                                       c-5.4-4.2-8.8-3.8-13,1.6c-11.4,14.5-22.8,29.1-34.2,43.7C188.9,83.9,170.4,107.5,151.9,131.1z M347,159.1
                                       c-17.4,13.2-23.2,42.6-11.9,60.4c10.2-6.9,20.5-13.7,30.6-20.7c3.1-2.2,3.7-6.1,1.5-9.4C360.7,179.3,353.9,169.3,347,159.1z
                                       M304.6,95.8c-6.9-10.2-13.5-20.3-20.4-30.2c-2.3-3.4-6.2-4.2-9.6-2c-10.2,6.7-20.3,13.5-30.5,20.3
                                       C254.3,98.4,281.2,108.2,304.6,95.8z M76.3,340.5c6.5,9.6,12.9,19.2,19.4,28.8c3.4,5,6.9,5.7,12,2.3c9-6,18-12,27-18.1
                                       c0.7-0.5,1.3-1.1,1.9-1.6C123.3,334.8,93.7,329.2,76.3,340.5z M45.7,216.7c-9.8,6.5-19.3,12.9-28.8,19.2c-5.4,3.6-6.1,7-2.4,12.6
                                       c5.9,8.8,11.8,17.6,17.7,26.4c0.5,0.8,1.2,1.4,1.8,2.1C51.5,262.3,56.8,235.5,45.7,216.7z M216.7,312.9c-0.1-0.1-0.3-0.3-0.4-0.4
                                       c-19.6,13.1-39.3,26.3-59.2,39.6c3.8,3,7.1,5.6,10.5,8.2c5.6,4.4,9,4,13.3-1.5c11.4-14.5,22.8-29.1,34.2-43.7
                                       C215.7,314.5,216.2,313.7,216.7,312.9z" fill="#545a6d"/>
                                    <path d="M264.2,218.1c-0.1,32.5-21.2,61.1-51.9,70.4c-4.5,1.4-7.2,0.3-8.3-3.1c-1.1-3.4,0.3-5.8,3.9-7.3c5.6-2.4,11.4-4.5,16.5-7.7
                                       c21.7-13.6,32.8-40.5,27.2-65.3c-5.9-26.2-26.9-45.6-52.9-48.9c-37.3-4.7-69.5,22.5-71.1,60c-1.2,29.5,19.4,56.1,49,63
                                       c2.5,0.6,4.9,1.1,5.7,4.1c1.2,4.7-2.3,8.2-7.4,7.1c-19.1-4.3-34.4-14.4-45.5-30.5c-31.3-45.6-2.9-108.3,52-114.9
                                       C225.7,139.6,264.4,173.8,264.2,218.1z" fill="#545a6d"/>
                                    <path d="M177.1,189c4.3,6.5,8,12.1,11.9,17.6c0.5,0.8,2,1.2,3.1,1.2c2,0,3.9-0.6,5.9-0.8c9.4-0.7,17.5,1.9,22.2,10.7
                                       c5,9.2,4.7,18.4-1.1,27.3c-0.7,1-1.5,2-2.2,2.9c4.4,7.6,4.6,9.8,1.2,12.2c-3.3,2.3-5.2,1.4-10.1-4.5c-5.5,1.1-10.6,2.5-15.9,3.2
                                       c-4.3,0.6-6.8-1.8-6.8-5.5c-0.1-3.5,2.1-5.2,6.4-5.7c3.1-0.3,6.2-1.1,9.9-1.9c-5.6-8.4-10.7-16.1-16-23.7c-0.5-0.7-1.9-0.9-2.8-1
                                       c-1.9,0-3.7,0.4-5.6,0.4c-8,0-14.8-2.5-18.7-10c-4-7.8-3.5-15.5,1.4-22.7c1.3-2,1.5-3.2,0.1-5.2c-2.7-3.8-2.3-6.7,0.6-8.8
                                       c3.1-2.2,5.9-1.4,8.7,2.6c0.5,0.7,1,1.4,1.2,1.7c4.4-0.6,8.4-1.4,12.5-1.7c4.2-0.2,6.5,2.1,6.5,5.6c-0.1,3.5-2.4,5.5-6.5,5.6
                                       C181.3,188.6,179.6,188.8,177.1,189z M196.7,218.2c4.6,6.8,8.8,13.1,13.2,19.6c3.2-5,3.2-10.9,0-15.3
                                       C206.8,218.1,202.6,216.9,196.7,218.2z M168.4,196.2c-3.3,8.3,1.2,14.8,9.2,13.7C174.6,205.4,171.6,201.1,168.4,196.2z" fill="#545a6d"/>
                                    <path d="M77.6,299.3c-1.5-1.4-3.7-2.6-4.6-4.5c-1.2-2.4-0.1-4.9,2.2-6.5c4.3-3,8.7-5.8,13-8.8c4.1-2.8,8.3-5.6,12.4-8.3
                                       c3.4-2.2,6.7-1.7,8.6,1c1.9,2.8,1.1,6-2.3,8.3c-8.4,5.7-16.8,11.3-25.2,16.8C80.8,298.1,79.6,298.5,77.6,299.3z" fill="#545a6d"/>
                                    <path d="M275.2,166.7c-1.4-1.3-3.8-2.5-4.2-4.2c-0.4-1.9,0.3-5.1,1.8-6.2c8.7-6.3,17.7-12.2,26.6-18c2.9-1.9,6.2-1,7.8,1.7
                                       c1.6,2.7,1,5.7-2,7.8c-8.5,5.8-17.2,11.6-25.8,17.3C278.5,165.8,277.2,166,275.2,166.7z" fill="#545a6d"/>
                                 </g>
                              </svg>
                           </span>
                           <span class="svg-text">
                           Appointments
                           </span>
                        </a>
                     </li>
                     <li class="has-sublist">
                        <a href="{{ route('patients')}}">
                           <span class="svg-icon">
                              <svg class="me-2" width="20" height="20" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 380 384" style="enable-background:new 0 0 380 384;" xml:space="preserve">
                                 <g>
                                    <path d="M-1.2,257.5c0.8-3.8,1.5-7.6,2.5-11.3C9.7,215,37.9,193.1,70.3,193c48.4-0.1,96.7-0.2,145.1,0c19.8,0.1,36.7,7.5,50.7,21.6
                                       c3.2,3.3,3.6,7.2,1.3,10.5c-2,3-5.9,4.3-9.3,2.9c-1.4-0.6-2.8-1.7-3.9-2.8c-11.1-10.9-24.5-16.3-39.9-16.3
                                       c-47.7-0.1-95.5-0.2-143.2,0c-31.2,0.1-55.6,24-56.3,55c-0.4,18.1-0.1,36.2-0.1,54.4c0,0.7,0.1,1.4,0.3,2.7c1.6,0,3,0,4.5,0
                                       c26.6,0,53.2,0,79.9,0c1.4,0,2.8,0,4.1,0.1c4.2,0.4,7.1,3.5,7.2,7.7c0.1,4.1-2.8,7.5-6.9,8c-1.6,0.2-3.2,0.1-4.9,0.1
                                       c-29.9,0-59.7-0.1-89.6,0.1c-4.9,0-8.5-1.5-10.5-6.1C-1.3,306.5-1.3,282-1.2,257.5z" fill="#545a6d" />
                                    <path d="M228.3,385c-2-2.4-4.6-4.6-6-7.3c-9.1-17.8-18-35.6-26.8-53.5c-1.2-2.4-2.5-3.2-5.1-3.2c-12.1,0.1-24.2,0.1-36.4,0.1
                                       c-1,0-2,0-3,0c-4.9-0.4-8.2-3.6-8.2-8c0-4.4,3.3-7.9,8.2-8c15.9-0.1,31.7-0.1,47.6,0c3.9,0,6.3,2.3,8,5.8
                                       c7.1,14.4,14.4,28.8,21.6,43.2c0.6,1.1,1.1,2.2,2,3.8c0.7-1.6,1.3-2.8,1.8-4c12.9-30.1,25.8-60.3,38.8-90.4
                                       c2.5-5.7,6.9-7.9,11.5-5.2c1.9,1.1,3.5,3.2,4.5,5.2c14.3,28.4,28.6,56.8,42.7,85.4c1.6,3.3,3.4,4.4,7.1,4.4
                                       c11.9-0.3,23.7,0,35.6-0.2c4.8-0.1,8.5,1.4,10.7,5.9c0,1.5,0,3,0,4.5c-2.2,4.5-5.8,5.9-10.7,5.9c-14.1-0.2-28.2-0.2-42.4,0
                                       c-5.6,0.1-9-2-11.5-7.1c-12.1-24.6-24.5-49.2-36.8-73.7c-0.6-1.2-1.2-2.3-2.1-4c-0.7,1.6-1.3,2.6-1.8,3.7
                                       c-12.7,29.6-25.3,59.2-38.2,88.7c-1.3,3-3.9,5.5-5.9,8.2C231.8,385,230,385,228.3,385z" fill="#545a6d"/>
                                    <path d="M142.9,160.9c-44.2,0.1-80.3-35.9-80.2-80c0-44,35.9-79.9,79.9-80c44.2-0.1,80.2,35.9,80.2,80
                                       C222.8,125,187,160.8,142.9,160.9z M206.7,80.9C206.6,45.6,178,17,142.8,16.9c-35.3-0.1-64,28.8-64,64.2c0,35.4,28.8,64,64.2,63.9
                                       C178.2,144.9,206.8,116.1,206.7,80.9z" fill="#545a6d"/>
                                 </g>
                              </svg>
                           </span>
                           <span class="svg-text">
                           Patient
                           </span>
                        </a>
                     </li>
                  </ul>
            </div>
         </div>
      </div>
      <div class="breadcrumbs">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-12">
                  <div class="breadcums">
                     <ul class="list-unstyled">
                        <li>
                           <span>
                              <svg class="me-2" version="1.1" width="16" height="16" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 515 512" style="enable-background:new 0 0 515 512;" xml:space="preserve">
                                 <g>
                                    <path d="M311.5,1c57.3,0,114.7,0,172,0c8.6,2.7,17.2,6,22.4,13.8c3.7,5.6,5.8,12.1,8.6,18.2c0,78.3,0,156.7,0,235
                                       c-0.2,0.3-0.4,0.5-0.5,0.8c-6.2,21.5-18.7,30.9-41.2,30.9c-50.7,0-101.3,0-152-0.1c-4.3,0-8.7-0.3-12.9-1.3
                                       c-17.5-4.4-28.2-19-28.2-38.2c-0.1-46.8,0-93.6,0-140.5c0-26.5-0.1-53,0-79.5c0.1-17.4,9-30.9,24.2-36.7C306.4,2.5,309,1.8,311.5,1
                                       z" fill="#6c757d" />
                                    <path d="M2.5,482c0-78.7,0-157.3,0-236c0.2-0.3,0.4-0.6,0.5-0.9c6.4-21.6,18.8-30.9,41.2-30.9c51,0,102,0,153,0
                                       c24.3,0,40,15.8,40.1,40.1c0.1,19.8,0,39.7,0,59.5c0,53.2,0,106.3,0,159.5c0,16.3-6.8,28.6-21.5,36c-3.2,1.6-6.8,2.5-10.3,3.7
                                       c-57,0-114,0-171,0c-11.8-2.8-21.6-8.6-27.4-19.6C5.2,489.8,4,485.8,2.5,482z" fill="#6c757d"/>
                                    <path d="M205.5,1c6.2,3,13.1,5.2,18.5,9.2c9.3,7,13.2,17.4,13.2,28.9c0.1,31.5,0.2,63,0,94.5c-0.2,21.9-16,37.9-38,38
                                       c-52.8,0.2-105.6,0.2-158.4,0c-18.8-0.1-32.7-11.3-37.3-29.4c-0.2-0.8-0.6-1.5-0.9-2.3c0-36,0-72,0-108c0.6-1.7,1.3-3.3,1.8-5
                                       C7.7,16.8,14.2,9.3,23.9,4.7C27,3.3,30.3,2.2,33.5,1C90.8,1,148.2,1,205.5,1z" fill="#6c757d"/>
                                    <path d="M311.5,513c-3.6-1.3-7.3-2.2-10.7-4c-13.6-6.9-20.8-18.2-20.9-33.2c-0.3-32.2-0.4-64.3,0-96.5c0.3-21.6,16.6-36.9,38.4-37
                                       c38.3-0.2,76.6,0,115-0.1c13.7,0,27.3,0,41,0c20.8,0,34.1,10.3,39.5,30.4c0.1,0.5,0.5,0.9,0.7,1.3c0,35.7,0,71.3,0,107
                                       c-2.6,5.8-4.6,12.1-8,17.4c-5.5,8.5-14.5,12.3-24,14.6C425.5,513,368.5,513,311.5,513z" fill="#6c757d"/>
                                 </g>
                              </svg>
                           </span>
                           <span>
                           Dashboard
                           </span> /
                            @yield('content-breadcrumb')
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
      @yield('content-body')
      @endif
      <footer>
         <div class="container">
            <div class="row">
               <div class="col-sm-6 copyright-text">2022 © Doctorly</div>
               <div class="col-sm-6 designed-text">Designed and Developed by Narola</div>
            </div>
         </div>
      </footer>
      <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
      <script src="{{ asset('assets/js/plugins/validation/jquery.validate.min.js') }}"></script>
      <script src="{{ asset('assets/js/plugins/validation/additional-methods.js') }}"></script>
      <script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}"></script>
      <script src="{{ asset('assets/js/custom.js') }}"></script>
      <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
      <script src="{{ asset('assets/js/script.js') }}"></script>
      <script src="{{ asset('assets/js/slick.min.js') }}"></script>
      <script src="{{ asset('assets/js/appointments.js') }}"></script>
      <script>
         $(window).on('load',function(){
            setTimeout(function(){ // allowing 3 secs to fade out loader
            $('.page-loader').fadeOut('slow');
            },1000);
         });
      </script>   
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
      <script src="https://cdn.jsdelivr.net/bootstrap.timepicker/0.2.6/js/bootstrap-timepicker.min.js"></script>
      
      @stack('footer_js')
   </body>
</html>