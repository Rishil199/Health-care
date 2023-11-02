<div class="modal-content">
   <div class="modal-header">
      <div class="title">
         <strong>Edit Receptionist <strong>
      </div>
      <button type="button" class="btn-close btn" data-bs-dismiss="modal" aria-label="Close">
         <svg fill="#000000" width="20" height="20" version="1.1" id="lni_lni-close" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
         <path d="M34.5,32L62.2,4.2c0.7-0.7,0.7-1.8,0-2.5c-0.7-0.7-1.8-0.7-2.5,0L32,29.5L4.2,1.8c-0.7-0.7-1.8-0.7-2.5,0
               c-0.7,0.7-0.7,1.8,0,2.5L29.5,32L1.8,59.8c-0.7,0.7-0.7,1.8,0,2.5c0.3,0.3,0.8,0.5,1.2,0.5s0.9-0.2,1.2-0.5L32,34.5l27.7,27.8
               c0.3,0.3,0.8,0.5,1.2,0.5c0.4,0,0.9-0.2,1.2-0.5c0.7-0.7,0.7-1.8,0-2.5L34.5,32z" fill="#fff">
         </path>
         </svg>
      </button>
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
                        <input class="form-control" id="email" name="email" type="email" placeholder="Receptionist Email" value="{{ $receptionist->user->email}}" readonly/>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 mb-3">
                  <div class="form-group theme-form-group">
                     <label class="theme-label" for="phone_no">Phone No. <span class="text-danger">*</span></label>
                     <div class="theme-form-input">
                        <input class="form-control" id="phone_no" name="phone_no" type="text" placeholder="Receptionist Phone No." value="{{ $receptionist->user->phone_no}}" />
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
                     <label class="theme-label" for="picker1">Select Clinic</label>
                     <div class="theme-form-input">
                        <select class="form-control form-select" name="clinic_id">
                           <option value="">Select Clinic</option>
                           @foreach($clinics as $value)
                           <option value="{{ $value->id }}" {{ $receptionist->clinic_id == $value->id ? 'selected' : '' }}>{{ @$value->user->first_name }}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 mb-3">
                  <div class="form-group theme-form-group">
                     <div class="d-block ">
                        <label class="theme-label" for="status">Status <span class="required">*</span></label>
                     </div>
                     <div class="input-wrapper d-flex">
                        <div class="theme-input radio">
                           <input name="status" id="statusActive" type="radio" value="1" {{ $receptionist->status == "1"  ? 'checked' : '' }}>
                           <label for="statusActive" class="theme-label">Activate</label>
                        </div>
                        <div class="theme-input radio ms-3">
                           <input name="status" type="radio" value="0" id="statusNotActive" {{ $receptionist->status == "0"  ? 'checked' : '' }}>
                           <label for="statusNotActive" class="theme-label">Deactive</label>
                        </div>
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
                     <label class="theme-label" for="qualification">Qualification <span class="required">*</span></label>
                     <div class="theme-form-input">
                        <input class="form-control" id="qualification" name="qualification" type="text" placeholder="Receptionist qualification" value="{{ $receptionist->qualification}}" />
                     </div>
                  </div>
               </div>
               <div class="col-md-6 mb-3">
                  <div class="form-group theme-form-group">
                     <label class="theme-label" for="experience">Experience <span class="required">*</span></label>
                     <div class="theme-form-input">
                        <input class="form-control" id="experience" name="experience" type="text" placeholder="Receptionist Experience" value="{{ $receptionist->experience}}" />
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer justify-content-center">
                 <button type="submit" value="Update" id="validation-next" class="btn btn-back mt-4">
                     <i class="lni lni-save"></i>
                     Update
                 </button>
            </div>
            </div>
        </form>
    </div>
</div>
