@use ('App\Models\User')
@extends('layouts.app')
@push('header_css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/datatables.min.css') }}" />
@endpush
@section('content-breadcrumb')
<style>
.btn-back{
   background-color: #263b5e;
    color: white;
}

</style>

<li>
   <span><a href="{{route('clinics.index')}}" class="text-black text-decoration-none">
    Hospitals  
    </a>
   </span>       / 
   <span class="mx-2 text-black ">
  {{$main_clinic->user->first_name}}    
      </span>    /
   <span>
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
   <span  class="text-black">
         {{$title}}
   </span>
</li>

@endsection
@section('content-body')
<div class="container mt-2">
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
         <div class="card-header d-flex justify-content-between align-items-center mx-3 mt-3">
            <h4 class="mb-0">Hospital Information</h4>
            
        @if(Auth::user()->hasRole(User::ROLE_SUPER_ADMIN))
            <button class="btn-back btn-sm" onclick="window.location='{{route('clinics.index')}}'">Back</button>
            @elseif (Auth::user()->hasRole(User::ROLE_PATIENT))
            <button class="btn-back btn-sm" onclick="window.location='{{route('clinicsListing.index')}}'">Back</button>
            @endif
        </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                           <strong>Hospital Name : </strong> <span>{{ optional($main_clinic->user)->first_name }}</span>
                        </li>
                        <li class="list-group-item">
                           <strong>Email : </strong> <a href="mailto:{{ optional($main_clinic->user)->email }}" class="mb-2">{{ optional($main_clinic->user)->email }}</a>
                        </li>
                        <li class="list-group-item">
                           <strong>Status : </strong> <span>{{ $main_clinic->status==0 ? "Deactive" : "Active" }}</span>
                        </li>
                        <li class="list-group-item">
                           <strong>Phone : </strong> <span>{{ optional($main_clinic->user)->phone_no }}</span>
                        </li>
                        <li class="list-group-item">
                           <strong>Address : </strong> <span>{{ $main_clinic->address }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <h4 class="mx-4">Branch Details </h4>
        <div class="col-12">
        <div class="row">
             <div class="theme-block mt-4">
                <div class="table-responsive">
                   <table class="table theme-table sr-table branches-table" id="branches-table" name="Branch">
                      <thead class="table-dark">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone No.</th>
                        <th>Status</th>
                        <th>Created At</th>
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
   </div>
@endsection

@push('footer_js')
    <script type="text/javascript">
        var branches_url = "{{ route('clinics.view',$slug) }}"
        var delete_branch_url = "{{ route('branches.destroy')}}"
        let changeStatus = "{{ route('clinics.changeStatus')}}"
    </script>
    <script src="{{ asset('assets/js/plugins/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/clinics.js') }}"></script>
@endpush
