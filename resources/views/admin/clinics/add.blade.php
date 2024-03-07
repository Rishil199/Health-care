@extends('layouts.app')

@push('header_css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/datatables.min.css') }}" />
@endpush

@section('content-body')
<div class="card-title mb-3">Add New Clinic</div>
<form action="{{ route('clinics.store') }}" method="post" class="add_clinic_form" id="add_clinic_form" autocomplete="off">
    @csrf
    <div class="row">
        <div class="form-row col-12">
            @if($type == "clinic")
            <div class="col-md-6 form-group mb-3">
                <div class="form-group">
                    <label for="name">Hospital Name <span class="text-danger">*</span></label>
                    <input class="form-control" id="name" name="name[]" type="text" placeholder="Hospital Name" required />
                </div>
            </div>
            @endif
            @if($type == "branch")
            <div class="col-md-6 form-group mb-3">
                <div class="form-group">
                    <div class="form-label label-title d-block">
                        <label for="clinic">
                            Select Hospital 
                            <span class="text-danger">*</span>
                        </label>
                    </div>
                    <div class="input-wrapper">
                        <select name="clinic" id="clinic" class="form-control">
                        @foreach($clinic_details as $clinic)
                            <option value="{{ $clinic->id }}"> {{ $clinic->name }}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-md-6 form-group mb-3">
                <div class="form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input class="form-control" id="email" name="email[]" type="email" placeholder="Hospital Email" required />
                </div>
            </div>
        </div>
        <div class="form-row col-12">
            <div class="col-md-6 form-group mb-3">
                <div class="form-group">
                    <label for="phone_no">Phone No. <span class="text-danger">*</span></label>
                    <input class="form-control" id="phone_no" name="phone_no[]" type="text" placeholder="Hospital Phone No." required />
                </div>
            </div>
            <div class="col-md-6 form-group mb-3">
                <div class="form-group">
                    <label for="address">Address <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="address" name="address[]" type="text" placeholder="Hospital Address" style="resize: none;" required></textarea>
                </div>
            </div>
        </div>
        <div class="form-row col-12">
            <div class="col-md-6 form-group mb-3">
                <div class="form-group">
                    <div class="form-label label-title d-block">
                        <label for="status">Status <span class="text-danger">*</span></label>
                    </div>
                    <div class="input-wrapper">
                        <div class="input-block">
                            <input name="status[]" id="statusActive" type="radio" value="1" checked>
                            <label for="statusActive">Is Active</label>
                        </div>
                        <div class="input-block">
                            <input name="status[]" type="radio" value="0" id="statusNotActive">
                            <label for="statusNotActive">Not Active</label>
                        </div>
                    </div>
                </div>
            </div>
            @if($type == "clinic")
            <div class="col-md-6 form-group mb-3">
                <div class="form-group">
                    <div class="form-label label-title d-block">
                        <label for="branch_type">
                            Branch Type 
                            <span class="text-danger">*</span>
                        </label>
                    </div>
                    <div class="input-wrapper">
                        <div class="input-block">
                            <input name="branch_type[]" type="radio" value="1" id="mainBranch" checked>
                            <label for="mainBranch">Main Branch</label>
                        </div>
                        <div class="input-block">
                           <input name="branch_type[]" type="radio" value="0" id="subBranch">
                            <label for="subBranch">Sub Branch</label>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="col-md-12 text-right">
            <button class="btn btn-info mt-4" id="cancel_clinic_btn" type="button">Cancel</button>
            <button class="btn btn-info mt-4" id="add_clinic_btn" type="submit">Save</button>
        </div>            
    </div>
</form>
@endsection

@push('footer_js')
    <script type="text/javascript">
        var clinics_url = "{{ route('clinics.index') }}"
        var clinics_store_url = "{{ route('clinics.store') }}"
        var delete_clinic_url = "{{ route('clinics.destroy')}}"
    </script>
    <script src="{{ asset('assets/js/plugins/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/clinics.js') }}" />
@endpush
