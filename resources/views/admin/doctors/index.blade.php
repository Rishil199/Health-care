@extends('layouts.app')
@push('header_css')
<link rel="stylesheet" href="{{ asset('assets/css/plugins/datatables.min.css') }}" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endpush
@section('content-breadcrumb')
<li>
   <span>
      <svg width="20" height="20" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 409.6 409.6" style="enable-background:new 0 0 409.6 409.6;" xml:space="preserve">
      <g>
         <path d="M410.4,292.8c-2,4-5.3,5-9.6,5c-20.3-0.1-40.5-0.1-60.8-0.1c-1.4,0-2.9,0-4.8,0c0,1.8,0,3.2,0,4.6
            c0,15.9,0,31.7,0,47.6c0,7.1-2.2,9.3-9.4,9.3c-80.1,0-160.2,0-240.4,0c-7.4,0-9.6-2.1-9.6-9.5c0-15.7,0-31.5,0-47.2
            c0-1.4,0-2.9,0-4.8c-1.8,0-3.2,0-4.6,0c-20.4,0-40.8,0-61.2,0c-7.2,0-9.3-2.2-9.3-9.3c0-11.9-0.1-23.7,0-35.6
            c0.4-42.6,19.2-74.2,56.8-94.4c0.7-0.4,1.4-0.8,1.7-0.9c-3.9-6.1-8.4-11.8-11.5-18.1C29.8,102.6,54,58.1,94.6,52.7
            c14-1.9,27,0.8,39.3,7.6c4,2.2,5.4,5.8,3.7,9.3c-1.7,3.6-5.7,5-9.8,2.8c-10.2-5.4-20.8-7.8-32.4-6.1c-22,3.3-39.1,22.8-40,45.9
            C54.6,134.5,71,155.6,92.6,160c7.6,1.5,15.1,1.5,22.6-0.3c5-1.2,8.6,0.6,9.6,4.5c1,4.2-1.5,7.4-6.6,8.6c-14.7,3.5-28.8,2-42.3-4.7
            c-1.6-0.8-4.2-0.9-5.9-0.1c-34.2,14.9-52.8,41.1-55.3,78.3c-0.8,12.3-0.1,24.7-0.1,37.4c20.7,0,41.3,0,61.9,0
            c6.7-47.9,31.9-82.4,75.3-104.2c-17.6-19.4-24.8-41.9-19.7-67.7c3.5-17.7,12.6-32.5,27-43.6c30.8-23.8,72.4-21.2,99.5,5.7
            c26.7,26.5,31.6,72.7,0.9,105.6c43.2,21.6,68.3,56.3,75.2,104.3c20.4,0,40.9,0,61.5,0c0.1-0.1,0.5-0.3,0.5-0.5
            c-0.4-19.6,2.3-39.5-3.7-58.8c-8.4-26.9-25.7-45.9-51.9-56.6c-1.6-0.6-4-0.5-5.5,0.2c-13.7,6.8-27.9,8.3-42.7,4.7
            c-4.9-1.2-7.3-4.3-6.4-8.4c0.8-4,4.5-5.9,9.4-4.8c26.9,5.6,50.4-7.8,58-33c5.4-17.8-0.6-37.9-15.3-49.8
            c-15.7-12.6-33-14.5-51.3-6.3c-1.7,0.8-3.3,1.7-5.1,2.4c-3.5,1.3-6.9,0-8.5-3.1c-1.6-3.1-0.9-7,2.5-8.7c5.3-2.7,10.8-5.4,16.5-6.9
            c27.1-7,53.8,4.2,68.3,28.3c13.7,22.7,10.6,51.9-7.8,72.3c-0.6,0.7-1.2,1.4-1.5,1.8c7,4.7,14.3,8.8,20.8,14
            c21.6,17.5,33.9,40.3,37.2,67.9c0.1,1,0.5,2,0.7,3C410.4,258.7,410.4,275.7,410.4,292.8z M321.5,345.4c0.1-1.1,0.1-2,0.1-2.9
            c0-15.2,0.5-30.4-0.1-45.6c-2-49.6-25.8-85-70.9-105.9c-2.4-1.1-4.3-1.1-6.6,0.3c-9,5.8-18.9,9.1-29.5,10.3
            c-17,2-32.8-1.4-47.5-10.2c-1.3-0.8-3.4-1.4-4.6-0.9c-15.3,6-28.9,14.9-40.2,26.8c-22.2,23.3-32.8,51.2-32.6,83.3
            c0.1,13.5,0,26.9,0,40.4c0,1.4,0,2.9,0,4.5C167,345.4,244,345.4,321.5,345.4z M205.1,188.5c33.2,0.7,61.3-26.8,62-60.7
            c0.7-33.3-26.7-61.5-60.6-62.1c-33.7-0.7-61.6,26.6-62.4,60.7C143.4,159.8,170.8,187.8,205.1,188.5z" fill="#545a6d"/>
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
               <a href="javascript:void(0)" data-url="{{ route('doctors.create') }}" class="btn-add-doctors" data-bs-toggle="addmodal" data-bs-target="#myAddModal" id="btn-add-doctors">
                  <button class="btn btn-back ripple-hover plus">
                     <span class="svg-icon me-2">
                        <svg fill="#fff" width="18" version="1.1" id="lni_lni-plus" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                           y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                           <path d="M61,30.3H33.8V3c0-1-0.8-1.8-1.8-1.8S30.3,2,30.3,3v27.3H3c-1,0-1.8,0.8-1.8,1.8S2,33.8,3,33.8h27.3V61c0,1,0.8,1.8,1.8,1.8
                              s1.8-0.8,1.8-1.8V33.8H61c1,0,1.8-0.8,1.8-1.8S62,30.3,61,30.3z" fill="#fff"/>
                        </svg>
                     </span>
                     <span class="svg-text">
                     Add Doctor
                     </span>
                  </button>
               </a>
               <span data-href="{{ route('doctors.exportCSV') }}" id="export" class="btn btn-back ms-3" onclick ="exportDocotrs (event.target);">Export</span>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-12">
         <div class="theme-block mt-4">
            <div class="table-responsive">
               <table class="table theme-table sr-table doctors-table" id="doctors-table" name="Doctor">
                  <thead class="table-dark">
                     <th>Name</th>
                     <th>Hospital name</th>
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
@endsection
@push('footer_js')
<script type="text/javascript">
   let doctors_url = "{{ route('doctors.index') }}"  
   let doctors_store_url = "{{ route('doctors.store') }}"
   let delete_doctors_url = "{{ route('doctors.destroy')}}"  
   let changeStatus = "{{ route('doctors.changeStatus')}}"
</script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="{{ asset('assets/js/plugins/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/doctors.js') }}"></script>
<script>
   function exportDocotrs(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
}
</script>
@endpush