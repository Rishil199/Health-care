@extends('layouts.app')
@push('header_css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/datatables.min.css') }}" />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endpush
@section('content-breadcrumb')
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
   {{$title}}
   </span> 
</li>
@endsection
@section('content-body')
<div class="container">
   <div class="row">
      <div class="col-12">
         <div class="title main-title title-btn">
            <div class="title-text">
               <strong>{{$title}} List</strong>
            </div>
            <div class="form-btns title-btn">
               <a href="javascript:void(0)" data-url="{{ route('users.createUser') }}" class="add-user" data-bs-toggle="addmodal" data-bs-target="#myAddModal">
               <button class="btn btn-back ripple-hover plus">
                  <span class="svg-icon me-2">
                     <svg fill="#fff" width="18" version="1.1" id="lni_lni-plus" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                        y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                        <path d="M61,30.3H33.8V3c0-1-0.8-1.8-1.8-1.8S30.3,2,30.3,3v27.3H3c-1,0-1.8,0.8-1.8,1.8S2,33.8,3,33.8h27.3V61c0,1,0.8,1.8,1.8,1.8
                           s1.8-0.8,1.8-1.8V33.8H61c1,0,1.8-0.8,1.8-1.8S62,30.3,61,30.3z" fill="#fff"/>
                     </svg>
                  </span>
                  <span class="svg-text">
                  Add User
                  </span>
               </button>
               </a>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-12">
         <div class="theme-block mt-4">
            <div class="table-responsive">
                <table class="table theme-table sr-table users_datatable" id="users_datatable">
                  <thead class="table-dark">
                    <th>Name</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Registeration Date</th>
                    <th>Action</th>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@push('footer_js')
   <script>
      var users_url = "{{ route('users.index') }}"
      var delete_user_url = "{{ route('users.destroy') }}"
   </script>
   <script src="{{ asset('assets/js/plugins/datatables.min.js') }}"></script>
   <script src="{{ asset('assets/js/users.js') }}"></script> 
@endpush
