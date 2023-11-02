@extends('layouts.app')
@section('content-body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-4 mt-5 mb-5">
               <h6>Please configure the settings first.</h6>
               <h6>Click on the below link to configure the settings</h6>
               <h6><a href="javascript:void(0)" class="dropdown-item icon-text settings-add-btn link-btn justify-content-center" data-url="{{ route('settings.create')}}" data-toggle="addmodal" data-target="#myAddModal" id="settings-add-btn" >Configure Settings</a></h6>
            </div>
        </div>
    </div>
@endsection
@push('footer_js')
