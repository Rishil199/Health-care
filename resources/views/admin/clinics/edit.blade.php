@extends('layouts.app')

@push('header_css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/datatables.min.css') }}" />
@endpush

@section('content-body')
<div class="card-title mb-3">Edit Clinic</div>

<form action="{{ route('clinics.update',$clinic->id) }}" name="update_clinic_form" method="POST" class="update_clinic_form" id="update_clinic_form" autocomplete="off">
    @csrf
    <div class="row">
        <div class="form-row col-12">
            <div class="col-md-6 form-group mb-3">
                <div class="form-group">
                    <label for="name">Clinic Name <span class="text-danger">*</span></label>
                    <input class="form-control" id="name" name="name" value="{{ $clinic->user->first_name}}" type="text" placeholder="Clinic Name" required />
                </div>
            </div>
            <div class="col-md-6 form-group mb-3">
                <div class="form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input class="form-control" id="email" name="email" type="email" value="{{ $clinic->user->email}}" placeholder="Clinic Email" readonly />
                </div>
            </div>
        </div>
        <div class="form-row col-12">
            <div class="col-md-6 form-group mb-3">
                <div class="form-group">
                    <label for="phone_no">Phone No. <span class="text-danger">*</span></label>
                    <input class="form-control" id="phone_no" name="phone_no" value="{{ $clinic->phone_no}}" type="tel" placeholder="Clinic Phone No." required />
                </div>
            </div>
            <div class="col-md-6 form-group mb-3">
                <div class="form-group">
                    <label for="address">Address <span class="text-danger">*</span></label>
                    <textarea name="address" class="form-control" id="address" name="address" type="text" placeholder="Clinic Address" value="{{ $clinic->address}}" style="resize: none;" required>{{ $clinic->address}}</textarea>
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
                            <input name="status" id="statusActive" type="radio"  value="1" {{ $clinic->status == "1" ? 'checked': '' }}>
                            <label for="statusActive">Is Active</label>
                        </div>
                        <div class="input-block">
                            <input name="status" type="radio" id="statusNotActive" value="0" {{ $clinic->status == "0"  ? 'checked' : '' }}>
                            <label for="statusNotActive">Not Active</label>
                        </div>
                    </div>
                </div>
            </div>
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
                            <input name="branch_type" type="radio" value="1" id="mainBranch" {{ $clinic->is_main_branch == "1"  ? 'checked' : '' }}>
                            <label for="mainBranch">Main Branch</label>
                        </div>
                        <div class="input-block">
                           <input name="branch_type" type="radio" value="0" id="subBranch" {{ $clinic->is_main_branch == "0"  ? 'checked' : '' }}>
                            <label for="subBranch">Sub Branch</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-right">
            <button class="btn btn-danger mt-4" id="cancel_clinic_btn" type="button">Cancel</button>
            <button class="btn btn-info mt-4" id="update_clinic_btn" type="submit">Update</button>
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
    <script src="{{ asset('assets/js/clinics.js') }}"></script>
@endpush
