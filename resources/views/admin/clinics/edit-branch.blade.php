<div class="modal-content">
   <div class="modal-header">
      <div class="title">
         <strong>
            Edit Branch Details 
         <strong>
      </div>
   </div>
   <div class="modal-body">
      <form action="{{ route('clinics.update',$clinic->id) }}" method="post" class="update_clinic_form" id="update_clinic_form">
         @csrf
         <div class="row">
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="name">Hospital Name <span class="required">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="first_name" name="first_name" type="text" placeholder="Hospital Name" value="{{ $clinic->user->first_name}}" />
                  </div>
               </div>
            </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="email">Email <span class="required">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="email" name="email" type="email" placeholder="Hospital Email" value="{{ $clinic->user->email}}" readonly />
                  </div>
               </div>
            </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="phone_no">Phone No. <span class="text-danger">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="phone_no" name="phone_no" type="tel" placeholder="Hospital Phone No." value="{{ $clinic->user->phone_no}}" />
                  </div>
               </div>
            </div>
            {{-- <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <div class="d-block ">
                     <label class="theme-label" for="status">Status <span class="required">*</span></label>
                  </div>
                  <div class="input-wrapper d-flex">
                     <div class="theme-input radio">
                        <input name="status" id="statusActive" type="radio" value="1" {{ $clinic->status == "1"  ? 'checked' : '' }}>
                        <label for="statusActive" class="theme-label">Activate</label>
                     </div>
                     <div class="theme-input radio ms-3">
                        <input name="status" type="radio" value="0" id="statusNotActive" {{ $clinic->status == "0"  ? 'checked' : '' }}>
                        <label for="statusNotActive" class="theme-label">Deactive</label>
                     </div>
                  </div>
               </div>
            </div> --}}
            {{-- @if($clinic->is_main_branch != 1)
            <div class="col-md-6">
              <div class="form-group theme-form-group">
                  <div class="form-label label-title d-block">
                      <label class="theme-label" for="status">Branch  <span class="text-danger">*</span></label>
                  </div>
                  <div class="input-wrapper d-flex">
                     <div class="theme-input radio">
                          <input name="branch_type" type="radio" value="1" id="mainBranch" {{ $clinic->is_main_branch == '1' ? 'checked' : '' }}>
                          <label for="mainBranch" class="theme-label">Main Branch</label>
                     </div>
                     <div class="theme-input radio ms-3">
                          <input name="branch_type" type="radio" value="0" id="subBranch" {{ $clinic->is_main_branch == '0'  ? 'checked' : '' }} >
                          <label for="subBranch" class="theme-label">Sub Branch</label>
                     </div>
                  </div>
               </div>
            </div>
            @endif --}}
            <div class="col-md-12 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="address">Address <span class="text-danger">*</span></label>
                  <div class="theme-form-input">
                     <textarea class="form-control" id="address" name="address" type="text" style="resize: none;" value="{{ $clinic->address}}">{{ $clinic->address}}</textarea>
                  </div>
               </div>
            </div>
            <div class="modal-footer justify-content-center">
               <button type="submit" value="Update" id="validation-next" class="btn btn-back mt-4">
                  <i class="lni lni-save"></i>
                  Save
               </button>
               <button  type="button" class="btn btn-outline-dark mt-4 mx-3" data-bs-dismiss="modal">  
                  Cancel 
              </button>
            </div>
         </div>
      </form>
   </div>
</div>
