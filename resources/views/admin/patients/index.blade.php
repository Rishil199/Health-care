@extends('layouts.app')
@push('header_css')
<link rel="stylesheet" href="{{ asset('assets/css/plugins/datatables.min.css') }}" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endpush
@section('content-breadcrumb')
<li>
   <span>
      <svg class="me-2" width="20" height="20" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 380 384" style="enable-background:new 0 0 380 384;" xml:space="preserve">
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
               <a href="javascript:void(0)" data-url="{{ route('patients.create') }}" class="btn-add-patients" data-bs-toggle="addmodal" data-bs-target="#myAddModal" id="btn-add-patients">
                  <button class="btn btn-back ripple-hover plus">
                     <span class="svg-icon me-2">
                        <svg fill="#fff" width="18" version="1.1" id="lni_lni-plus" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                           y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                           <path d="M61,30.3H33.8V3c0-1-0.8-1.8-1.8-1.8S30.3,2,30.3,3v27.3H3c-1,0-1.8,0.8-1.8,1.8S2,33.8,3,33.8h27.3V61c0,1,0.8,1.8,1.8,1.8
                              s1.8-0.8,1.8-1.8V33.8H61c1,0,1.8-0.8,1.8-1.8S62,30.3,61,30.3z" fill="#fff"/>
                        </svg>
                     </span>
                     <span class="svg-text">
                     Adds Patient
                     </span>
                  </button>
               </a>
               <span data-href="{{ route('patients.exportCSV') }}" id="export" class="btn btn-back ms-3" onclick ="exportPatients (event.target);">Export</span>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-12">
         <div class="theme-block mt-4">
            <div class="table-responsive">
               <table class="table theme-table sr-table patients-table" id="patients-table" name="Patient">
                  <thead class="table-dark">
                     <th>Name</th>
                     <th>Email</th>
                     <th>Phone No.</th>
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
   let patients_url = "{{ route('patients.index') }}"  
   let patients_store_url = "{{ route('patients.store') }}"
   let delete_patients_url = "{{ route('patients.destroy')}}"  
   let changeStatus = "{{ route('patients.changeStatus')}}"
</script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="{{ asset('assets/js/plugins/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/patients.js') }}"></script>
<script>
   function exportPatients(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
}
</script>
@endpush