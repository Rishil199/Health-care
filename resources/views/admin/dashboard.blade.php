@extends('layouts.app')
@push('header_css')
@endpush
@section('content-body')
<div class="master-wrrapper-conter">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <div class="welcome-title">
               <div class="wt-lower">
                 
                       @if (Auth::user()->hasRole('Hospital'))
                       {{-- @php var_dump($clinics);@endphp --}}
                       <p>Hospital name :<b style="color: black"> {{Auth::user()->first_name}}</b> </p>
                       @foreach($clinics as $clinic )
                       @switch($clinic->is_main_branch)
                       @case(1)
                      <p>Branch : <b style="color: black">Main Branch </b> </p>
                        @break
                        @case(0)
                        <p>Branch : <b style="color: black">Sub Branch </b> </p>
                           @break
                        @endswitch
                        @endforeach
                      @endif 
                      <p>Welcome <b class="theme-black">{{Auth::user()->first_name}}</b> to the  {{$title}}</p>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-12">
            <div class="welcome-block">
               <div class="welcome-user">
                  <span class="wu-text">Doctor App</span>
                  <span class="text-muted wu-text-lower">{{ Auth::user()->name }}</span>
               </div>
            </div>
            <div class="doctors-data-block">
               <div class="row">
                  <div class="col-xl-3 col-lg-3 doctors-data-left">
                     <div class="row">
                        @if(Auth::user()->hasAnyRole(['Super Admin','Hospital','Receptionist','Patient']))
                        <div class="col-lg-12 col-sm-4">
                           <div class="doc-data-card doctor">
                              <div class="doc-data-img"><img src="{{ asset('assets/img/stethoscope.svg') }}" alt=""></div>
                              <div class="doc-data">
                                 <div class="doc-data-count">
                                     @if(Auth::user()->hasAnyRole(['Super Admin','Hospital','Doctor','Receptionist']))
                                    <a href="{{route('doctors.index')}}">{{ count($doctors) }}</a>
                                    @endif
                                     @if(Auth::user()->hasRole(['Patient']))
                                     <a href="{{route('doctorslisting.index')}}">{{ count($doctors) }}</a>
                                     @endif
                                 </div>
                                 <div class="doc-data-title">Doctors</div>
                              </div>
                           </div>
                        </div>
                        @endif
                        @if(Auth::user()->hasAnyRole(['Super Admin','Hospital','Receptionist','Doctor']))
                        <div class="col-lg-12 col-sm-4">
                           <div class="doc-data-card patient">
                              <div class="doc-data-img"><img src="{{ asset('assets/img/examination.svg') }}" alt=""></div>
                              <div class="doc-data">
                                 <div class="doc-data-count">
                                    <a href="{{route('patients.index')}}">{{ count($patients) }}</a>
                                 </div>
                                 <div class="doc-data-title">Patients</div>
                              </div>
                           </div>
                        </div>
                        @endif
                        @if(Auth::user()->hasAnyRole(['Super Admin','Hospital']))
                        <div class="col-lg-12 col-sm-4">
                           <div class="doc-data-card receptionist">
                              <div class="doc-data-img"><img src="{{ asset('assets/img/receptionist.svg') }}" alt=""></div>
                              <div class="doc-data">
                                 <div class="doc-data-count">
                                    <a href="{{route('receptionists.index')}}">{{ $receptionistCount }}</a>
                                 </div>
                                 <div class="doc-data-title">Staff </div>
                              </div>
                           </div>
                        </div>
                        @endif
                     </div>
                  </div>
                  <div class="col-xl-9 col-lg-9 doctors-data-right">
                     <div class="row">
                        <div class="col-md-4 mb-3">
                           <div class="theme-card">
                              <div class="theme-card-fig">
                                 <span class="theme-card-fig-title">Appointments</span>
                                 @if(Auth::user()->hasAnyRole(['Super Admin','Hospital','Patient','Doctor','Receptionist']))
                                 <span class="theme-card-fig-count">{{ $appointmentsCount }}</span>
                                 @endif
                              </div>
                              <span class="link-circle"></span>
                           </div>
                        </div>
                        {{-- <div class="col-md-4 mb-3">
                           <div class="theme-card dark">
                              <div class="theme-card-fig">
                                 <span class="theme-card-fig-title">Revenue</span>
                                 <span class="theme-card-fig-count">$583,032,31</span>
                              </div>
                              <span class="link-circle"></span>
                           </div>
                        </div>
                        <div class="col-md-4 mb-3">
                           <div class="theme-card">
                              <div class="theme-card-fig">
                                 <span class="theme-card-fig-title">Today's Earning</span>
                                 <span class="theme-card-fig-count">$323.00</span>
                              </div>
                              <span class="link-circle"></span>
                           </div>
                        </div> --}}
                        <div class="col-md-4 mb-3">
                           <div class="theme-card dark">
                              <div class="theme-card-fig">
                                 <span class="theme-card-fig-title">Today's Appointments</span>
                                  @if(Auth::user()->hasAnyRole(['Super Admin','Hospital','Patient','Doctor','Receptionist']))
                                 <span class="theme-card-fig-count">{{ $todays_appointment }}</span>
                                 @endif
                              </div>
                              <span class="link-circle"></span>
                           </div>
                        </div>
                        <div class="col-md-4 mb-3">
                           <div class="theme-card">
                              <div class="theme-card-fig">
                                 <span class="theme-card-fig-title">Completed Appointments</span>
                                  @if(Auth::user()->hasAnyRole(['Super Admin','Hospital','Patient','Doctor','Receptionist']))
                                 <span class="theme-card-fig-count">{{ $past_appointment }}</span>
                                 @endif
                              </div>
                              <span class="link-circle"></span>
                           </div>
                        </div>
                        <div class="col-md-4 mb-3">
                           <div class="theme-card dark">
                              <div class="theme-card-fig">
                                 <span class="theme-card-fig-title">Upcoming Appointments</span>
                                  @if(Auth::user()->hasAnyRole(['Super Admin','Hospital','Patient','Doctor','Receptionist']))
                                 <span class="theme-card-fig-count">{{ $upcoming_appointment }}</span>
                                 @endif
                              </div>
                              <span class="link-circle"></span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-12">
                     <div class="latest-user-block theme-block">
                        <div class="title">
                           <strong>Latest Users</strong>
                        </div>
                        <div class="theme-tab">
                           <ul class="nav nav-tabs" id="latestUserTab" role="tablist">
                              @if(Auth::user()->hasAnyRole(['Super Admin','Hospital','Receptionist','Doctor','Patient']))
                              <li class="nav-item" role="presentation">
                                 <button class="btn active" id="doc-tab" data-bs-toggle="tab" data-bs-target="#doc-tab-pane" type="button" role="tab" aria-controls="doc-tab-pane" aria-selected="true">
                                    <span class="svg-icon">
                                       <svg version="1.1" class="me-2" width="26" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 384 384" style="enable-background:new 0 0 384 384;" xml:space="preserve">
                                          <g>
                                             <path d="M74.3,40c0-4.7,0-8.8,0-12.9c0-3.1,1.1-5.2,4.3-5.5c2.8-0.3,4.6,2,4.7,5.5c0.1,4.1,0,8.2,0,12.6c12.7,0,25.3,0,38.3,0
                                                c0-4.1,0-8.2,0-12.2c0-3.9,1.8-6.2,4.7-5.9c3.5,0.4,4.4,2.7,4.3,5.9c-0.1,4,0,8,0,12.2c12.5,0,24.7,0,37.5,0c0-4.2,0-8.4,0-12.6
                                                c0-3.6,1.9-5.8,4.6-5.5c3.2,0.3,4.4,2.4,4.4,5.5c-0.1,4.1,0,8.2,0,12.6c12.7,0,25.2,0,38.3,0c0-4.2,0-8.4,0-12.6
                                                c0-3.6,1.8-5.8,4.6-5.5c3.2,0.3,4.4,2.4,4.4,5.4c-0.1,4.1,0,8.2,0,12.9c1.8,0,3.5,0,5.2,0c7.6,0,15.2-0.1,22.9,0
                                                c15.9,0.1,27.4,11.7,27.4,27.6c0,54.2,0,108.5,0,162.7c0,1.5,0,2.9,0,5.1c3.6-2.3,6.7-4.3,9.8-6.3c12.2-8,24.3-16.2,36.7-24
                                                c14.2-9,32.2-1.3,35.7,15.1c2,9.4-2.1,18.8-11.1,24.7c-18.6,12.2-37.2,24.4-55.7,36.6c-4.3,2.8-8.5,5.7-12.9,8.4
                                                c-2,1.2-2.6,2.6-2.5,4.8c0.1,13.7,0.1,27.5,0,41.2c0,17.1-11.7,28.8-28.7,28.8c-66.5,0-133,0-199.5,0c-16.6,0-28.3-11.6-28.3-28.3
                                                c0-89.5,0-179,0-268.5C23.3,51.5,34.6,40.1,51,40C58.6,40,66.2,40,74.3,40z M74.2,49.3c-0.8-0.1-1.2-0.3-1.5-0.3
                                                c-7.5,0-15-0.1-22.5,0c-10.4,0.1-17.9,7.7-17.9,18.1c0,90,0,180,0,270c0,10.9,7.8,18.6,18.7,18.6c66.9,0,133.7,0,200.6,0
                                                c11.3,0,19.1-7.8,19.1-19.1c0.1-11.7,0-23.5,0-35.2c0-1.1,0-2.1,0-3.7c-1.4,0.8-2.3,1.3-3.1,1.8c-12.1,8-24.2,15.9-36.4,23.8
                                                c-1.6,1-3.6,2-5.5,2.1c-12,0.5-24,0.8-36,1c-4.8,0.1-6.7-3.1-4.5-7.5c1.4-2.9,3-5.7,4.6-8.9c-18,0-35.3,0-52.7,0
                                                c-1.2,0-2.8,0.4-3.7-0.2c-1.5-1-3.6-2.8-3.5-4.1c0.1-1.6,2-3.3,3.5-4.5c0.7-0.6,2.2-0.2,3.3-0.2c17.6,0,35.2,0,52.9,0
                                                c5.8,0,6-0.2,7.5-6c-1.4,0-2.8,0-4.1,0c-18.7,0-37.5,0-56.2,0c-1.1,0-2.6,0.4-3.3-0.2c-1.5-1.2-3.4-2.9-3.5-4.5
                                                c-0.1-1.3,2-3,3.5-4.1c0.7-0.6,2.2-0.2,3.3-0.2c21,0,42,0,63-0.1c1.9,0,3.9-0.6,5.5-1.6c7.6-4.8,15.1-9.8,22.6-14.7
                                                c2.5-1.6,5.1-1.8,6.8,1c1.6,2.6,0.6,4.8-1.8,6.4c-1,0.7-2.1,1.4-3.1,2.1c-5.8,3.8-11.6,7.7-17.6,11.6c1.9,2.9,3.6,5.4,5.5,8.2
                                                c37.8-24.8,75.5-49.6,113.3-74.4c-1.9-2.9-3.6-5.4-5.4-8.2c-1.2,0.8-2.3,1.4-3.3,2.1c-20.8,13.6-41.6,27.3-62.3,40.9
                                                c-3.3,2.1-6.1,1.9-7.5-0.6c-1.7-3.1-0.2-5.2,2.4-6.8c4.5-2.9,9.1-5.8,13.4-8.9c1.2-0.8,2.2-2.7,2.2-4.1
                                                c0.1-57.2,0.1-114.5,0.1-171.7c0-9.3-6.4-17.1-15.5-17.7c-10.2-0.7-20.4-0.2-31-0.2c0,1.5,0.1,2.9,0,4.2c-0.3,3.9,0.2,6.6,4.5,8.8
                                                c7.3,3.8,9.7,13.2,6.5,20.6c-3.2,7.5-11.4,11.7-19.4,9.8c-7.2-1.7-12.3-7.5-13.2-15c-0.8-6.9,3.3-13.7,10-17c1-0.5,2.4-1.6,2.5-2.6
                                                c0.3-2.9,0.1-5.9,0.1-8.8c-13,0-25.6,0-38.2,0c0,1.8,0.1,3.3,0,4.8c-0.4,3.6,0.3,5.9,4.2,7.7c7.3,3.5,10.1,12.6,7.1,20.3
                                                c-2.9,7.7-10.9,12.2-18.9,10.6c-7.3-1.5-12.6-7-13.6-14.2c-1-7.4,2.6-14,9.3-17.7c1.1-0.6,2.6-1.6,2.7-2.5c0.3-3,0.1-6.1,0.1-9.1
                                                c-12.8,0-25.1,0-37.5,0c0,1.5,0.1,2.8,0,4c-0.3,3.9,0.2,6.6,4.5,8.8c7.2,3.7,9.7,13.2,6.5,20.6c-3.3,7.7-11.6,11.8-19.7,9.8
                                                c-7-1.7-12-7.5-12.8-14.9c-0.8-6.8,3.2-13.6,9.6-16.8c1.1-0.6,2.7-1.7,2.8-2.7c0.4-2.9,0.1-5.9,0.1-8.8c-13,0-25.6,0-38.2,0
                                                c0,2.7,0.1,5,0,7.4c-0.1,2.1,0.5,3.2,2.6,4.2c7.4,3.3,11,10.5,9.5,18.4c-1.4,7.6-7.7,13.3-15.6,13.8c-7.4,0.6-14.6-4.3-17-11.6
                                                c-2.4-7.2,0.1-15.6,6.8-19.2c4.2-2.3,5.3-4.9,4.7-9.1C74.1,52,74.2,50.8,74.2,49.3z M228.2,314.7c37.9-24.9,75.6-49.6,113.4-74.4
                                                c-2-3-3.8-5.5-5.6-8.2c-38,24.9-75.6,49.6-113.3,74.4C224.6,309.3,226.3,311.9,228.2,314.7z M348.9,235c5.5-6.2,5.9-13.8,1.2-19.4
                                                c-4.2-5.1-11.1-6.7-16.4-3.7C338.7,219.5,343.7,227.1,348.9,235z M196.9,316.7c7.3,0,14.2,0,21.8,0c-4.3-6.5-8.1-12.3-12.2-18.6
                                                c-3.2,6-6.1,11.4-8.9,16.8C197.4,315.5,197.2,316.1,196.9,316.7z M133.6,76.3c0.1-4.4-3.2-7.9-7.6-8c-4.6-0.1-8.2,3.4-8.2,7.9
                                                c0,4.3,3.6,7.9,7.9,7.9C129.9,84.2,133.5,80.6,133.6,76.3z M219.5,68.3c-4.4,0-7.9,3.4-7.9,7.8c-0.1,4.4,3.8,8.2,8.1,8
                                                c4.3-0.1,7.7-3.7,7.7-8.1C227.3,71.6,223.9,68.3,219.5,68.3z M79,68.3c-4.4-0.1-7.9,3.2-8,7.6c-0.2,4.5,3.5,8.2,7.9,8.2
                                                c4.2,0,7.9-3.7,7.9-7.9C86.8,72,83.3,68.4,79,68.3z M164.7,76.1c0,4.3,3.5,7.9,7.8,8c4.3,0.1,8.2-3.8,8.1-8.1
                                                c-0.1-4.3-3.7-7.7-8-7.7C168.1,68.3,164.8,71.7,164.7,76.1z" fill="#fff"></path>
                                             <path d="M82,179.7c-16.9,0-30.5-13.5-30.6-30.4c-0.1-16.8,13.6-30.6,30.4-30.6c16.9,0,30.5,13.6,30.6,30.4
                                                C112.6,165.9,98.9,179.7,82,179.7z M81.7,170.7c12.1,0.1,21.8-9.5,21.8-21.5c0-11.6-9.5-21.3-21.1-21.4c-12.1-0.1-21.8,9.3-22,21.3
                                                C60.3,160.9,69.8,170.6,81.7,170.7z" fill="#fff"></path>
                                             <path d="M81.9,254.7c-16.9,0-30.5-13.6-30.5-30.5c0-16.9,13.7-30.5,30.5-30.5c16.9,0,30.5,13.7,30.5,30.5
                                                C112.5,241,98.8,254.7,81.9,254.7z M81.9,245.7c12.1,0,21.7-9.7,21.5-21.8c-0.1-11.8-9.8-21.2-21.8-21.2
                                                c-11.8,0.1-21.4,9.8-21.3,21.6C60.5,236.2,70,245.7,81.9,245.7z" fill="#fff"></path>
                                             <path d="M81.8,329.7c-16.9-0.1-30.5-13.7-30.4-30.6c0.1-16.9,13.8-30.4,30.6-30.4c16.8,0.1,30.4,13.7,30.4,30.6
                                                C112.5,316.1,98.7,329.7,81.8,329.7z M81.7,320.7c12.1,0.1,21.8-9.5,21.8-21.5c0-11.6-9.5-21.3-21.1-21.4
                                                c-12.1-0.1-21.8,9.3-22,21.3C60.3,310.9,69.8,320.6,81.7,320.7z" fill="#fff"></path>
                                             <path d="M190.5,145c-17.9,0-35.7,0-53.6,0c-1.1,0-2.6,0.4-3.3-0.2c-1.4-1.1-3.5-2.8-3.4-4.2c0.1-1.6,2.1-3.2,3.5-4.5
                                                c0.7-0.6,2.2-0.2,3.3-0.2c35.7,0,71.5,0,107.2,0c1,0,2-0.1,3,0.1c2.6,0.4,4.1,1.8,4.1,4.5c0,2.7-1.6,4.1-4.2,4.4c-1,0.1-2,0-3,0
                                                C226.2,145,208.3,145,190.5,145z" fill="#fff"></path>
                                             <path d="M190.6,211c17.9,0,35.7,0,53.6,0c1,0,2-0.1,3,0.1c2.6,0.4,4.1,1.8,4.1,4.5c0,2.7-1.6,4.1-4.2,4.4c-0.9,0.1-1.7,0-2.6,0
                                                c-35.9,0-71.7,0-107.6,0c-1.1,0-2.6,0.4-3.3-0.2c-1.4-1.1-3.5-2.8-3.4-4.1c0.1-1.6,2.1-3.2,3.5-4.5c0.7-0.6,2.2-0.2,3.3-0.2
                                                C154.9,211,172.7,211,190.6,211z" fill="#fff"></path>
                                             <path d="M164.3,160c-9.6,0-19.2,0-28.8,0c-4.4,0-7-3.7-4.7-6.7c0.9-1.2,2.9-2.2,4.4-2.2c19.6-0.1,39.2-0.1,58.8-0.1
                                                c2.9,0,4.9,1.4,4.9,4.5c0,3.1-2,4.5-4.9,4.5C184,160,174.2,160,164.3,160z" fill="#fff"></path>
                                             <path d="M164.6,226c9.5,0,19,0,28.5,0c3.1,0,5.5,0.9,5.7,4.4c0.2,3-1.9,4.6-5.9,4.6c-19,0-38,0-56.9,0c-2.7,0-5-0.5-5.9-3.5
                                                c-0.9-3,1.4-5.5,5.3-5.5C145.1,226,154.8,226,164.6,226z" fill="#fff"></path>
                                             <path d="M49.5,116.7c0,6.9,0,13.7,0,20.6c0,3.7-1.6,5.6-4.5,5.6c-2.9,0-4.4-1.9-4.5-5.7c0-13.6,0-27.2,0-40.8
                                                c0-3.2,0.9-5.5,4.4-5.8c2.9-0.3,4.6,2,4.6,5.9C49.5,103.2,49.5,110,49.5,116.7z" fill="#fff"></path>
                                             <path d="M50,78.6c-0.7,1.9-1,4.1-2.2,5.4c-1.7,1.9-4.1,1.7-6,0c-2.2-2-2.1-9.3,0.1-11.1c2-1.7,4.4-1.8,6,0.2
                                                C49.1,74.4,49.3,76.5,50,78.6z" fill="#fff"></path>
                                             <path d="M78.2,149.9c3.9-3.7,6.9-6.5,9.8-9.4c2.2-2.2,4.6-3.1,7.2-0.7c2.1,2,1.8,4.5-0.8,7.1c-3.8,3.7-7.7,7.4-11.6,11.1
                                                c-3,2.8-4.9,2.7-7.7,0c-2.2-2.1-4.3-4.2-6.3-6.3c-1.9-2-2.1-4.4-0.2-6.4c2.1-2.2,4.5-2,6.6,0.1C76.3,146.7,77.1,148.2,78.2,149.9z" fill="#fff"></path>
                                             <path d="M78.7,224.5c3.5-3.4,6.5-6.2,9.5-9c2.7-2.5,5.2-2.8,7.1-0.6c2.3,2.7,1.2,5-1,7.1c-3.9,3.7-7.7,7.4-11.6,11.1
                                                c-2.9,2.7-4.8,2.6-7.7-0.2c-2.1-2-4.1-4-6.1-6.1c-2-2.1-2.4-4.5-0.3-6.6c2.1-2.1,4.5-1.8,6.6,0.3C76.3,221.6,77.3,222.9,78.7,224.5
                                                z" fill="#fff"></path>
                                             <path d="M78.5,299.7c3.7-3.5,6.6-6.3,9.6-9.1c2.2-2.2,4.6-3.1,7.2-0.7c2.1,2,1.9,4.5-0.8,7.1c-3.8,3.7-7.7,7.4-11.6,11.1
                                                c-3,2.8-4.9,2.7-7.7,0c-2.2-2.1-4.3-4.2-6.3-6.3c-1.9-2-2.1-4.3-0.2-6.4c2.1-2.2,4.5-2,6.6,0.1C76.3,296.6,77.2,298.1,78.5,299.7z" fill="#fff"></path>
                                          </g>
                                       </svg>
                                    </span>
                                    <span class="svg-text">
                                    Appointments
                                    </span>
                                 </button>
                              </li>
                              @endif
                              @if(Auth::user()->hasAnyRole(['Super Admin','Hospital','Receptionist','Patient']))
                              <li class="nav-item" role="presentation">
                                 <button class="btn" id="recipt-tab" data-bs-toggle="tab" data-bs-target="#recipt-tab-pane" type="button" role="tab" aria-controls="recipt-tab-pane" aria-selected="false">
                                    <span class="svg-icon">
                                       <svg width="26" class="me-2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 520.9 504.1" style="enable-background:new 0 0 520.9 504.1;" xml:space="preserve">
                                          <style type="text/css">
                                             .st0{fill:#fff;}
                                             .st1{fill:#FDFEFE;}
                                          </style>
                                          <g>
                                             <path class="st0" d="M521.9,304c-2.8,8.5-5,17.2-10.3,24.6c-10.3,14.3-23.9,23-41.6,25.6c-28.5,4.1-56.7-14.4-65.1-41.9   c-9.8-32.2,9.9-67.4,42.7-75.1c5.5-1.3,6.4-3.5,6.4-8.6c-0.1-16.4-2.7-32-12.5-45.8c-17.5-24.9-51.4-30.4-75.2-11.6   C351,183.2,343,199.3,343,218.7c-0.3,54.7-0.2,109.3,0,164c0.1,29.1-7.7,55.6-26.2,78.3c-18.1,22.1-41.1,36.1-70,39.1   c-35.3,3.6-64.3-9.1-87.8-34.7c-15.4-16.8-24.5-37-28.1-59.6c-1.5-9.7-2.2-19.5-1.9-29.3c0.1-2.6-0.4-4.2-3.3-5.1   c-14.4-4.2-21.5-13.7-21.8-28.8c-0.1-7.2-0.3-14.3,0-21.5c0.2-3.8-1.3-5.2-4.7-6.1c-20.7-6-39-16.4-54.2-31.5   c-19.1-18.9-31.3-41.6-34.3-68.7c-0.1-0.6-0.6-1.1-0.9-1.7c0-9.7,0-19.3,0-29c4,0,8-0.2,12,0.1c3.9,0.3,5.1-0.9,5.1-5   c-0.2-21.7-0.1-43.3-0.1-65c0-13.7,0-27.3,0-41C27,53.6,39.8,37,58.5,32c2.6-0.7,4.1-1.9,5.3-4.5c5-10.2,16.8-16.2,26.8-14   c13,2.8,21.3,11.9,22.1,24.2c0.7,10.6-6.6,21.8-16.7,25.4c-11.5,4.1-23.5,0.5-30.2-9c-4.3-6.2-4.5-6.2-10.7-2   C47.6,57.2,44.1,64.8,44,73.7c-0.2,35.3,0,70.7-0.1,106c0,3.2,0.8,4.5,4.2,4.3c5.5-0.2,11,0.2,16.5-0.1c4.1-0.2,5.5,0.9,5.4,5.2   c-0.2,9.3-0.6,18.6,1.8,27.8c7,27.5,28.8,46.5,57.1,51.1c20.9,3.4,40.5-0.4,57.8-12.9c16.1-11.6,25-27.5,27.4-47.2   c0.8-6.7,0.7-13.3,0.7-19.9c0-3.1,1.1-3.9,4.1-4c4.2-0.1,9.9,2.1,12.3-1.1c2-2.7,0.7-8,0.7-12.2c0-16,0.4-32-0.1-48   c-0.6-17.1-0.4-34.3-0.8-51.4c-0.2-9.7-5.7-16.3-13.9-21c-3-1.8-4.6-0.4-6.3,2.3c-5.5,8.6-13.6,12.8-23.6,11.9   c-11.6-1-19.2-7.6-22.5-18.9c-4.2-14.3,5.9-29.7,20.8-31.6c11.5-1.5,21.7,3.7,26.7,14c1.1,2.2,2.4,3.2,4.6,4   c21.2,7,32.1,22.1,32.1,44.5c0,34,0.2,68,0,102c0,4.7,1.4,5.8,5.9,5.7c11.2-0.3,10.9-0.1,11.3,11.1c0.9,28.6-7.2,54.1-24.9,76.5   c-16.3,20.6-37.1,34.6-62.1,42.2c-5.6,1.7-7.4,4.1-7.2,9.9c0.3,8.1,1,16.3-0.7,24.4c-2.4,11.9-7.9,20.8-20.8,23.1   c-2.5,0.4-3.4,1.7-3.5,4.4c-0.7,18.7,0.9,37,9.3,54c15.5,31.3,39.5,50.8,75.4,53.4c39.4,2.8,72.1-22.8,86.4-57.1   c5.7-13.7,8-28.1,8-42.8c0.1-54.8,0.2-109.6,0-164.5c-0.1-32.2,21.4-64.2,53.5-73.3c22.4-6.4,43.3-2.2,61.6,12.3   c21,16.7,30,39.1,29.9,65.6c0,3.8-1.1,8.2,0.5,11.3c1.6,3.3,6.8,2.4,10.3,3.8c21.3,8.1,34.3,23.3,39.2,45.5c0.2,0.8,0.2,1.6,1,2.1   C521.9,292,521.9,298,521.9,304z M137.9,303.2c5.8-0.3,11.6-0.1,17.4-1.1c40.3-6.8,69.9-27.8,86.7-65.6c4.4-9.9,6.3-20.6,6.8-31.5   c0.1-1.4,0.7-3.6-1.3-3.8c-4.8-0.3-9.8-0.8-14.4,0.2c-2.7,0.6-0.7,4.8-1.6,7.2c-0.4,0.9-0.5,1.9-0.6,2.9   c-2.3,17.9-9.5,33.7-21.9,46.6c-22.2,23-49.7,30.9-80.9,26.9c-41.9-5.3-73.8-39.7-75.2-80.3c-0.1-2.7-0.9-3.9-3.8-3.8   c-5.5,0.2-11,0.4-16.5-0.1c-5.2-0.5-6.2,1.7-5.8,6.3c1.8,21,9.1,39.9,22.7,55.9C72.7,290,102.5,303,137.9,303.2z M419.8,294.7   c-1.5,20.6,16.8,42.9,41.9,42.8c25-0.1,42.9-19.2,43.1-42.5c0.2-23.6-19.2-43.1-42.8-42.9C438.6,252.3,418.8,271.9,419.8,294.7z    M138.2,320c-4.7,0-9.3,0.1-14,0c-2.2,0-3.4,0.5-3.4,3c0.1,6.6-0.3,13.3,0.2,19.9c0.7,9.2,4.3,12,13.5,12c3,0,6,0,9,0   c5.9-0.1,8.4-1.8,10.1-7.5c2.5-8.3,0.8-16.8,1.2-25.3c0.1-2.1-1.6-2.2-3.1-2.2C147.2,320,142.7,320,138.2,320z M188.9,47.1   c5.1,0,8.8-3.4,8.9-8.1c0.1-4.7-4.3-9-9-8.9c-4.7,0.1-8,3.9-8,8.9C180.9,44,184,47.1,188.9,47.1z M94.9,39c0-4.5-4.2-9-8.4-8.8   C82,30.3,78,34.4,78,39c0,4.7,3.8,8.1,8.9,8.1C91.9,47,94.9,43.9,94.9,39z"/>
                                             <path class="st1" d="M138.2,320c4.5,0,9,0,13.5,0c1.6,0,3.2,0,3.1,2.2c-0.3,8.4,1.3,17-1.2,25.3c-1.7,5.8-4.2,7.5-10.1,7.5   c-3,0-6,0-9,0c-9.2,0-12.8-2.9-13.5-12c-0.5-6.6-0.1-13.3-0.2-19.9c0-2.5,1.2-3.1,3.4-3C128.9,320,133.6,320,138.2,320z"/>
                                             <path class="st0" d="M461.9,320.1c-14.6,0-25.2-10.8-25.1-25.7c0-13.9,11.4-25.2,25.3-25.4c13.6-0.2,25.8,12,25.7,25.9   C487.7,309.5,475.5,321.1,461.9,320.1z M462,303.1c5.1,0,8.8-3.6,8.8-8.2c-0.1-4.6-4.1-8.6-8.7-8.7c-4.1-0.1-8.3,4.5-8.2,9   C453.9,300,457,303.1,462,303.1z"/>
                                          </g>
                                       </svg>
                                    </span>
                                    <span class="svg-text">
                                    Doctors
                                    </span>
                                 </button>
                              </li>
                              @endif
                              @if(Auth::user()->hasAnyRole(['Super Admin','Hospital','Receptionist','Doctor']))
                              <li class="nav-item" role="presentation">
                                 <button class="btn" id="patient-tab" data-bs-toggle="tab" data-bs-target="#patient-tab-pane" type="button" role="tab" aria-controls="patient-tab-pane" aria-selected="false">
                                    <span class="svg-icon">
                                       <svg width="26" class="me-2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                          <g>
                                             <path class="st0" d="M145,261.2c0-1-0.1-2,0-3c1.4-12-0.2-22.8-10.3-31.2c-3.9-3.3-5.9-8.5-7.7-13.3c-1.3-3.6-3.6-5-7.1-5.8   c-19.4-4.4-31.1-19.4-30.9-39.2c0.1-12.6,10.9-23.5,23.6-23.8c0.8,0,1.7-0.1,2.5,0c4.9,0.9,6.3-1.1,6-5.9   c-0.4-7.5,2.5-10.1,10.2-10.1c14.2,0,28.3-0.2,42.5,0.1c12.7,0.3,21.2-5.5,26.6-16.6c0.5-1,1-2.1,1.6-3.1   c3.4-5.8,10.8-5.9,14.1-0.1c1.8,3.2,3,6.7,5.3,9.6c5.6,6.9,12.8,10.4,21.7,10.2c4.2-0.1,8.3-0.1,12.5,0c6.6,0.1,9.1,2.9,9.5,9.5   c0.1,2.2-1.7,5.9,1.7,6.2c3.6,0.3,2.8-3.7,3.3-6.1c4.4-19.8,4.5-39.3-4.1-58.1c-12.3-26.6-33.1-42.3-62.2-46.6   c-25.4-3.7-47.5,4-66,21.1c-13.4,12.4-21.3,28.2-23.9,46.5c-0.9,6.1-0.8,12.3-0.8,18.4c0,5.3-2.9,8.7-7.3,8.9   c-4.6,0.2-8.3-3.3-8.7-8.5c-1.3-19.4,2.5-37.9,12.3-54.7c14.3-24.4,35.3-40.5,63.2-46.6c28.4-6.2,54.7-0.6,77.8,17   c28.4,21.6,40.7,51,38.4,86.3c-0.5,7.6-1.4,15.2-3.4,22.6c-0.5,1.7-0.6,3.1,1.1,4.4c15.4,11.1,11.6,31.1,3.3,43   c-5.7,8.3-13.9,13.3-23.7,15.4c-3.8,0.8-5.9,2.4-7.4,6.1c-3.3,8.1-7.9,15.4-14.6,21.2c-2.6,2.3-3.4,4.9-3.4,8.3   c0.2,10-0.5,20,0.2,30c0.8,11.3-4.3,19.6-12,26.7c-19.5,18-55.7,17-74.3-2c-6.4-6.6-11-14.1-9.9-24   C145.4,269.9,145,265.6,145,261.2z M162.2,145c-8,0-14.7,0-21.4,0c-2.2,0-3.9,0.2-3.8,3.1c0.5,15.1-1.1,30.3,1,45.3   c3.8,27.2,25.6,46.5,53.3,47.4c32.2,1.1,57.6-24.1,57.7-56.4c0-11.5-0.1-23,0.1-34.5c0.1-3.8-0.8-5.3-4.9-5.1   c-12.8,0.7-23.9-3.1-32.6-12.9c-1.9-2.2-3.3-2.1-5.2,0.1c-4.3,5-9.6,8.5-15.9,10.8C180.7,146.3,170.7,144.4,162.2,145z M225,265.5   c0-4-0.1-8,0-12c0.1-2.5-0.3-3.7-3.3-2.5c-19.1,8.1-38.4,8.1-57.5,0c-2.4-1-3.3-0.7-3.2,2c0.1,8.1,0,16.3,0,24.4   c0,1.8,0.8,3.2,1.7,4.6c5.8,9.1,14.6,13.3,24.9,14.6c11,1.3,21-0.9,30-7.8C225.7,282.7,225.7,274.3,225,265.5z M121,177.5   C121,177.5,121,177.5,121,177.5c0-3.8-0.1-7.6,0-11.4c0-2-0.6-3.4-2.6-4.3c-5.4-2.6-12.5,1-13.4,6.9c-1.2,7.8,5.5,19.1,12.8,21.8   c2.2,0.8,3.1,0.3,3.1-2C121,184.8,121,181.1,121,177.5z M265,177C265,177,265,177,265,177c0,3.5,0.1,7-0.1,10.5   c-0.2,3.6,1.3,4.1,4.1,2.5c7.7-4.3,11.3-11,11.8-19.5c0.3-4.5-3.1-8.5-7.4-9.3c-5.6-1.1-8.5,1.3-8.5,6.9C265,171,265,174,265,177z"/>
                                             <path class="st0" d="M401,291.1c0-17.8-0.1-35.7,0.1-53.5c0-3.8-1.3-5.2-5-5.7c-22.5-3.1-40.8-13.8-55.3-31.3   c-14.5-17.6-20.4-37.9-19.8-60.5c0.4-17,0.6-34-0.1-51c-0.4-10.9,11-24.9,24.2-24.1c0.2,0,0.3,0,0.5,0c7.4,0,7.4,0,7.5-7.4   c0.1-6.3,4.2-9.9,9.9-8.5c4.2,1,6,4.2,6,8.1c0.2,10.5,0.2,21,0,31.5c-0.1,5.4-3.4,8.3-8.1,8.2c-4.9-0.1-7.5-3.4-7.9-8.9   c-0.2-2.6,2.5-7.1-3.7-7.2c-8.2-0.1-12.1,1.9-12.1,7.6c-0.2,21.3-1.5,42.8,0.3,64c2,23.7,13.9,42.8,35.2,54.7   c28.2,15.7,55.8,13.2,81.1-6c15.5-11.7,24.5-28,26.3-47.9c1.9-21.1,0.5-42.2,0.8-63.4c0.1-6.7-8.9-11.8-14.7-8.7   c-2.1,1.1-1.2,3.3-1.2,5c0,4-0.7,7.6-4.7,9.7c-5.3,2.7-11.1-0.2-11.2-6.1c-0.3-11.2-0.3-22.3,0-33.5c0.1-3.7,2.1-6.8,6.3-7.2   c4.4-0.4,8.9,0.9,8.8,5.8c-0.2,9,4,9.9,11.9,10.7C489.5,67,497,77.4,497,91c0,17.8,0.2,35.7,0,53.5c-0.3,24.7-9,46.1-26.6,63.4   c-13.8,13.5-30.5,21.6-49.7,24c-4.1,0.5-3.6,3.1-3.6,5.7c0,35.2,0,70.3,0,105.5c0,7.1-1.4,13.9-4.7,20.1   c-7.3,13.8-18.8,21.5-34.5,21.6c-33.5,0.3-67,0.2-100.5,0c-3.8,0-5.7,0.9-7.3,4.7c-7.1,16.4-25.8,23.7-42,16.9   c-15.5-6.5-23-25.1-16.8-41.4c8-21,35.6-26.8,51.5-10.9c3.5,3.5,6.6,7.2,8,11.8c0.8,2.4,2,3.1,4.3,3.1c24.5,0,49-0.1,73.5,0   c4.1,0,3.7-2.5,3.4-4.9c-2.4-14.9-7.6-28.6-16.9-40.5c-15-19.3-34.6-30.7-58.9-33.8c-3.6-0.5-7.3-0.7-10.9-0.9   c-5.1-0.2-8.2-3.3-8.2-8.1c0.1-4.8,3.2-7.9,8.4-7.8c24.5,0.2,46.3,7.8,65.3,23.3c18.4,15.1,30.2,34.3,35.6,57.4   c0.9,3.7,1.3,7.5,1.7,11.3c0.3,2.8,1.6,3.9,4.5,4c17.9,0.6,28.4-9.4,28.4-27.5C401,324.7,401,307.9,401,291.1z M225,377.1   c0,8.8,7.1,16,15.7,15.9c8.8-0.1,16.4-7.5,16.3-16c0-8.4-7.8-16-16.4-16C232.1,361,225,368.3,225,377.1z"/>
                                             <path class="st0" d="M192.9,497c-55,0-110,0-165,0c-8.6,0-11-2.3-11-10.9c0-36.7-0.1-73.3,0-110c0.1-28.7,10.8-53.3,31-73.3   c16.5-16.3,36.6-26.2,59.9-29c4.1-0.5,8.3-0.9,12.4-0.8c5.5,0.1,8.7,3.2,8.6,8.2c-0.1,4.7-3.2,7.7-8.5,7.8   c-25.4,0.5-47,9.7-64.3,28.4c-12.5,13.5-20.3,29.5-22.2,48c-2.2,21.4-0.4,42.9-1,64.4c-0.1,2.3,0.7,3.3,3.2,3.3   c11.2-0.1,22.3-0.1,33.5,0c2.7,0,3.4-1.1,3.4-3.6c-0.1-6.5-0.1-13,0-19.5c0.1-5.7,2.9-8.9,7.8-9c5.1-0.1,8.1,3.2,8.2,9.1   c0,21.8,0.1,43.7-0.1,65.5c0,3.9,0.7,5.5,5.1,5.5c66-0.1,132-0.1,198,0c4.4,0,5.1-1.5,5.1-5.5c-0.2-21.7,0-43.3-0.1-65   c0-4.7,1.4-8.3,6.2-9.5c5.3-1.4,9.6,2,9.7,7.7c0.2,6.7,0.1,13.3,0,20c-0.1,2.8,0.5,4.3,3.8,4.2c10.8-0.2,21.7-0.2,32.5,0   c3.3,0.1,3.9-1.4,3.8-4.2c-0.1-6.3-0.1-12.7,0-19c0.1-5.7,3-8.8,7.9-8.9c5,0,8,3.2,8.1,8.7c0.1,26.2,0.1,52.3,0,78.5   c0,6.2-3.1,8.8-10.1,8.8C303.6,497,248.3,497,192.9,497z M53.1,481c5.3,0,10.7-0.1,16,0c2.6,0.1,4-0.5,3.9-3.5   c-0.2-8.3-0.1-16.7,0-25c0-2.5-0.7-3.6-3.4-3.5c-11,0.1-22,0.1-33,0c-2.9,0-3.7,1-3.7,3.8c0.1,8.2,0.2,16.3,0,24.5   c-0.1,3.3,1.4,3.9,4.2,3.8C42.5,480.9,47.8,481,53.1,481z M333.3,481c5.3,0,10.7-0.1,16,0c2.8,0.1,3.8-0.9,3.8-3.7   c-0.1-8.2-0.1-16.3,0-24.5c0-2.6-0.6-3.9-3.6-3.9c-11,0.1-22,0.1-33,0c-2.6,0-3.6,0.8-3.5,3.4c0.1,8.3,0.1,16.7,0,25   c-0.1,2.9,1.1,3.7,3.8,3.6C322.3,480.9,327.8,481,333.3,481z"/>
                                          </g>
                                       </svg>
                                    </span>
                                    <span class="svg-text">
                                    Patients
                                    </span>
                                 </button>
                              </li>
                              @endif
                           </ul>
                           @if(Auth::user()->hasAnyRole(['Super Admin','Hospital','Receptionist','Doctor','Patient']))
                           <div class="tab-content" id="latestUserTabContent">
                              <div class="tab-pane fade show active" id="doc-tab-pane" role="tabpanel" aria-labelledby="doc-tab" tabindex="0">
                                 <div class="table-responsive">
                                    <table class="table theme-table sr-table">
                                       <thead class="table-dark">
                                          @if(Auth::user()->hasAnyRole(['Super Admin','Hospital','Receptionist','Doctor']))
                                          <th>Name</th>
                                          @else
                                          <th>Name</th>
                                          @endif
                                          <th>Contact No</th>
                                          <th>Email</th>
                                          <th>Prescription</th>
                                          <th>Appointment Date</th>
                                          <th>Appointment Time</th>
                                       </thead>
                                       <tbody>
                                          @foreach($appointments as $appointment)
                                          <tr>
                                             <td>{{ ucfirst($appointment->user->first_name) . ' ' . ucfirst($appointment->user->last_name) }}</td>
                                             <td>{{ $appointment->user->phone_no }}</td>
                                             <td class="email_link"> <a href="mailto:{{ $appointment->user->email }}">{{ $appointment->user->email }}</a></td>
                                             <td>{{ $appointment->disease_name ? $appointment->disease_name : 'N/A'}}</td> <td>{{ date('d-m-Y', strtotime($appointment->appointment_date )) ?? 'N/A'}} </td>                                
                                             <td>{{ $appointment->time_start }} - {{ $appointment->time_end }}</td>
                                          </tr>
                                          @endforeach
                                          @if(count($appointments) == 0)
                                          <tr>
                                             <td colspan="6" class="text-center">No Data Found</td>
                                          </tr>
                                          @endif
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                              @endif
                              @if(Auth::user()->hasAnyRole(['Super Admin','Hospital','Receptionist','Patient']))
                                 <div class="tab-pane fade" id="recipt-tab-pane" role="tabpanel" aria-labelledby="recipt-tab" tabindex="0">
                                    <div class="table-responsive">
                                       <table class="table theme-table sr-table">
                                          <thead class="table-dark">
                                             <th>Name</th>
                                             <th>Contact No</th>
                                             <th>Email</th>
                                             <th>View Details</th>
                                          </thead>
                                          <tbody>
                                             @foreach($doctors as $doctor)
                                             <tr>
                                                <td>{{ ucfirst($doctor->user->first_name) . ' ' . ucfirst($doctor->user->last_name)}}</td>
                                                <td>{{ $doctor->user->phone_no }}</td>
                                                <td class="email_link"><a href="mailto:{{ $doctor->user->email }}">{{ $doctor->user->email }}</a></td>
                                                <td>
                                                   <div class="table-btns"><a class="dropdown-item doctor-view" href="javascript:void(0)" data-url="{{  route('doctors.view',$doctor->id) }}" data-id=" $doctor->id " data-bs-toggle="viewmodal" data-bs-target="#myViewModal">
                                                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                         </svg>
                                                      </a>
                                                   </div>
                                                </td>
                                             </tr>
                                             @endforeach
                                             @if(count($doctors) == 0)
                                             <tr>
                                                <td colspan="6" class="text-center">No Data Found</td>
                                             </tr>
                                             @endif
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              @endif
                              @if(Auth::user()->hasAnyRole(['Super Admin','Hospital','Receptionist','Doctor']))
                              <div class="tab-pane fade" id="patient-tab-pane" role="tabpanel" aria-labelledby="patient-tab" tabindex="0">
                                 <div class="table-responsive">
                                    <table class="table theme-table sr-table">
                                       <thead class="table-dark">
                                          <th>Name</th>
                                          <th>Contact No</th>
                                          <th >Email</th>
                                          <th>View Details</th>
                                       </thead>
                                       <tbody>
                                          @foreach($patients as $patient)
                                          <tr>
                                             <td>{{ ucfirst($patient->user->first_name) . ' ' . ucfirst($patient->user->last_name)}}</td>
                                             <td>{{ $patient->user->phone_no }}</td>
                                             <td  class="email_link"><a href="mailto:{{ $patient->user->email }}">{{ $patient->user->email }}</a></td>
                                             <td>
                                                <div class="table-btns">
                                                   <a class="dropdown-item patient-view" href="javascript:void(0)" data-url="{{ route('patients.view',$patient->id)}}" data-id="{{$patient->id}}" data-toggle="viewmodal" data-target="#myViewModal">
                                                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                         <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                         <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                      </svg>
                                                   </a>
                                                </div>
                                             </td>
                                          </tr>
                                          @endforeach
                                          @if(count($patients) == 0)
                                          <tr>
                                             <td colspan="6" class="text-center">No Data Found</td>
                                          </tr>
                                          {{-- @else 
                                          <h2>data</h2> --}}
                                          @endif
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                              @endif
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  {{-- <div class="col-xl-3 col-lg-3 graph-data-left">
                     <div class="monthly-earnings-block theme-block">
                        <div class="title">
                           <strong>Monthly Earning</strong>
                        </div>
                        <div class="monthly-earning-data">
                           <div class="this-month text-muted">This month</div>
                           <div class="month-data">$0</div>
                           <div class="monthly-earning-graph">
                              <div id="montlyEarnings"></div>
                           </div>
                        </div>
                     </div>
                  </div> --}}
                  {{-- <div class="col-xl-9 col-lg-9 graph-data-right">
                     <div class="row">
                        <div class="col-12">
                           <div class="monthly-registered-user-block theme-block">
                              <div class="title">
                                 <strong>Monthly Registered User</strong>
                              </div>
                              <div class="monthly-registered-user-data">
                                 <div class="monthly-registered-graph">
                                    <div id="registeredUser"></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div> --}}
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('footer_js')
<script src="{{ asset('assets/js/doctors.js') }}"></script>
<script src="{{ asset('assets/js/patients.js') }}"></script>

@endpush