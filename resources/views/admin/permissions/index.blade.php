@extends('layouts.app')
@push('header_css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/datatables.min.css') }}" />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endpush
@section('content-breadcrumb')
<li>
   <span>
      <svg fill="#545a6d" width="20" height="20" version="1.1" id="lni_lni-lock-alt" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
      <g>
         <path d="M46.9,19.9v-3.2c0-8-6-14.7-13.6-15.4c-4.2-0.4-8.4,1.1-11.5,3.9c-3,2.8-4.8,6.7-4.8,10.8v3.8c-6,0.9-10.5,6.1-10.5,12.3
            V51c0,6.5,5.3,11.8,11.8,11.8h27.3c6.5,0,11.8-5.3,11.8-11.8V32C57.5,25.9,52.9,20.9,46.9,19.9z M24.2,7.8c2.4-2.2,5.5-3.3,8.8-3
            c5.8,0.5,10.4,5.7,10.4,11.9v3H20.6V16C20.6,12.9,21.9,9.9,24.2,7.8z M54,50.9c0,4.6-3.7,8.3-8.3,8.3H18.3c-4.6,0-8.3-3.7-8.3-8.3
            V32.2c0-4.9,4-9,9-9h25.9c5,0,9.1,3.9,9.1,8.8V50.9z" fill="#545a6d"></path>
         <path d="M32,35.5c-1,0-1.8,0.8-1.8,1.8v2.6v2.6v5.3c0,1,0.8,1.8,1.8,1.8s1.8-0.8,1.8-1.8v-5.3v-2.6v-2.6C33.8,36.3,33,35.5,32,35.5
            z" fill="#545a6d"></path>
      </g>
      </svg>
   </span>
   <span>
   {{ $title }}
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
               <a href="javascript:void(0)" data-url="{{ route('permissions.create')}}" class="permission-add-btn" data-toggle="addmodal" data-target="#myAddModal" id="permission-add-btn">
               <button class="btn btn-back ripple-hover plus">
                  <span class="svg-icon me-2">
                     <svg fill="#fff" width="18" version="1.1" id="lni_lni-plus" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                        y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                        <path d="M61,30.3H33.8V3c0-1-0.8-1.8-1.8-1.8S30.3,2,30.3,3v27.3H3c-1,0-1.8,0.8-1.8,1.8S2,33.8,3,33.8h27.3V61c0,1,0.8,1.8,1.8,1.8
                           s1.8-0.8,1.8-1.8V33.8H61c1,0,1.8-0.8,1.8-1.8S62,30.3,61,30.3z" fill="#fff"/>
                     </svg>
                  </span>
                  <span class="svg-text">
                  Add Permission
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
               <table class="table theme-table sr-table permissions-table " id="permissions-table" name="Permission">
                  <thead class="table-dark">
                    <th>Name</th>
                    <th>Created At</th>
                    <th style="width:15% ;">Action</th>
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
        let permissions_url = "{{ route('permissions.index') }}"
        let delete_permission_url = "{{ route('permissions.destroy')}}" 
    </script>
    <script src="{{ asset('assets/js/plugins/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/permissions.js') }}"></script>
@endpush
