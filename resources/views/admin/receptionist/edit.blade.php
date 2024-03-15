<div class="modal-content">
   <div class="modal-header">
      <div class="title">
         <strong>Edit Staff <strong>
      </div>
   </div>
   <div class="modal-body">
     <form action="{{ route('receptionists.update',$receptionist->id) }}" method="post" class="update-receptionists-form" id="update-receptionists-form" autocomplete="off">
      @csrf
         <div class="row">
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="first_name">First Name <span class="required">*</span></label>
                     <div class="theme-form-input">
                         <input class="form-control" id="first_name" name="first_name" type="text" placeholder="First Name" value="{{ $receptionist->user->first_name}}" />
                     </div>
                  </div>
               </div>
               <div class="col-md-6 mb-3">
                  <div class="form-group theme-form-group">
                     <label class="theme-label" for="last_name">Last Name <span class="required">*</span></label>
                     <div class="theme-form-input">
                        <input class="form-control" id="last_name" name="last_name" type="text" placeholder="Last Name" value="{{ $receptionist->user->last_name}}" />
                     </div>
                  </div>
               </div>
               <div class="col-md-6 mb-3">
                  <div class="form-group theme-form-group">
                     <label class="theme-label" for="email">Email <span class="required">*</span></label>
                     <div class="theme-form-input">
                        <input class="form-control" id="email" name="email" type="email" placeholder="Staff Email" value="{{ $receptionist->user->email}}" readonly/>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 mb-3">
                  <div class="form-group theme-form-group">
                     <label class="theme-label" for="phone_no">Phone No. <span class="text-danger">*</span></label>
                     <div class="theme-form-input">
                        <input class="form-control" id="phone_no" name="phone_no" type="tel" placeholder="Staff Phone No." value="{{ $receptionist->user->phone_no}}" />
                     </div>
                  </div>
               </div>
               <div class="col-md-6 mb-3">
                  <div class="form-group theme-form-group">
                     <label class="theme-label" for="birth_date">Birth Date: <span class="text-danger">*</span></label>
                     <div class="theme-form-input">
                        <input class="form-control date" id="datepicker" name="birth_date" type="text" value="{{ date('m/d/Y', strtotime($receptionist->birth_date))}}" />
                     </div>
                  </div>
               </div>
               <div class="col-md-6 mb-3">
                  <div class="form-group theme-form-group">
                     <div class="d-block ">
                        <label class="theme-label" for="gender">Gender <span class="required">*</span></label>
                     </div>
                     <div class="input-wrapper d-flex">
                        <div class="theme-input radio">
                           <input name="gender" id="male" type="radio" value="male" {{ $receptionist->gender == "male"  ? 'checked' : '' }}>
                           <label for="male" class="theme-label" >Male</label>
                        </div>
                        <div class="theme-input radio ms-3">
                           <input name="gender" type="radio" id="female" value="female" {{ $receptionist->gender == "female"  ? 'checked' : '' }}>
                           <label for="female" class="theme-label">Female</label>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 mb-3">
                  <div class="form-group theme-form-group">
                     <label class="theme-label" for="clinic_id">Choose Clinic</label>
                     <div class="theme-form-input">
                        <select class="form-control form-select" name="clinic_id" id="clinic_id">
                           <option value="">Choose Clinic</option>
                           @foreach($clinics as $value)
                           <option value="{{ $value->id }}" {{ $receptionist->clinic_id == $value->id ? 'selected' : '' }}>{{ $value?->user?->first_name }}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
               </div>
            
               <div class="col-md-6 mb-3">
                  <div class="form-group theme-form-group">
                     <label class="theme-label" for="qualification">Qualification <span class="required">*</span></label>
                     <div class="theme-form-input">
                        <input class="form-control" id="qualification" name="qualification" type="text" placeholder="Staff qualification" value="{{ $receptionist->qualification}}" />
                     </div>
                  </div>
               </div>
               <div class="col-md-6 mb-3">
                  <div class="form-group theme-form-group">
                     <label class="theme-label" for="experience">Experience <span class="required">*</span></label>
                     <div class="theme-form-input">
                        <input class="form-control" id="experience" name="experience" type="text" placeholder="Staff Experience" value="{{ $receptionist->experience}}" />
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer justify-content-center">
                 <button type="submit" value="Update" id="validation-next" class="btn btn-back mt-4">
                     <i class="lni lni-save"></i>
                     Save
                 </button>
                 <button  type="button" class="btn btn-outline-dark mt-4  mx-3" data-bs-dismiss="modal">  
                  Cancel 
              </button>
            </div>
            </div>
        </form>
    </div>
</div>
