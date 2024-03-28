@use ('App\Models\User')
<div class="modal-content">
    <div class="modal-header">
        <div class="title">
            <strong>Add New Doctor </strong>
        </div>
    </div>
    <div class="modal-body">
        <form action="{{ route('doctors.store') }}" method="post" class="add-doctors-form" id="add-doctors-form" autocomplete="off">
            @csrf
            <div class="row">
               <div class="col-md-6 mb-3">
                  <div class="form-group theme-form-group">
                     <label class="theme-label" for="first_name">First Name <span class="required">*</span></label>
                        <div class="theme-form-input">
                           <input class="form-control" id="first_name" name="first_name" type="text" placeholder="Enter First Name" />
                        </div>
                  </div>
               </div>
               <div class="col-md-6 mb-3">
                  <div class="form-group theme-form-group">
                     <label class="theme-label" for="last_name">Last Name <span class="required">*</span></label>
                        <div class="theme-form-input">
                            <input class="form-control" id="last_name" name="last_name" type="text" placeholder="Enter Last Name" />
                        </div>
                  </div>
               </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="email">Email <span class="required">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="email" name="email" type="email" placeholder="Enter Email" required />
                  </div>
               </div>
            </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="phone_no">Phone No. <span class="text-danger">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="phone_no" name="phone_no" type="tel" placeholder="Enter Phone No." required />
                  </div>
               </div>
            </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="birth_date">Birth Date: <span class="text-danger">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id='datepicker' name="birth_date" type="text" placeholder="Birth Date" />
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
                        <input name="gender" id="male" type="radio" value="male" checked>
                        <label for="male" class="theme-label" >Male</label>
                     </div>
                     <div class="theme-input radio ms-3">
                        <input name="gender" type="radio" id="female" value="female">
                        <label for="female" class="theme-label">Female</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-12 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="address">Address <span class="text-danger">*</span></label>
                  <div class="theme-form-input">
                     <textarea class="form-control" id="address" name="address" type="text" placeholder="Enter Address" style="resize: none;" required></textarea>
                  </div>
               </div>
            </div>
            @if(Auth::user()->hasRole(User::ROLE_SUPER_ADMIN))
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="clinic_id">Choose Hospital <span class="text-danger">*</span></label>
                  <div class="theme-form-input">
                     <select class="form-control form-select" name="clinic_id" id="clinic_id">
                        <option value="">Choose Hospital</option>
                        @foreach($clinics as $value)
                        <option value="{{ $value->id }}">{{ ucfirst($value->user->first_name) }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
            </div>
            @endif
            {{-- <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <div class="d-block ">
                     <label class="theme-label" for="status">Status <span class="required">*</span></label>
                  </div>
                  <div class="input-wrapper d-flex">
                     <div class="theme-input radio">
                        <input name="status" id="statusActive" type="radio" value="1" checked>
                        <label for="statusActive" class="theme-label">Activate</label>
                     </div> --}}
                     {{-- <div class="theme-input radio ms-3"> --}}
                        <input name="status" type="hidden" value="0" id="statusNotActive">
                        {{-- <label for="statusNotActive" class="theme-label">Deactive</label> --}}
                     {{-- </div>
                  </div>
               </div>
            </div> --}}
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="degree">Degree <span class="required">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="degree" name="degree" type="text" placeholder="Enter Degree" required />
                  </div>
               </div>
            </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="experience">Experience <span class="required">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="experience" name="experience" type="text" placeholder="Enter Experience" required />
                  </div>
               </div>
            </div>
            <div class="col-md-12 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="expertise">Expertise <span class="text-danger">*</span></label>
                  <div class="theme-form-input">
                     <textarea class="form-control" id="expertise" name="expertice" type="text" placeholder="Enter Expertise" style="resize: none;" required></textarea>
                  </div>
               </div>
            </div>
         </div>
         <div class="spinner-border text-primary d-none" role="status" id="submit-loader">
           <span class="sr-only">Loading...</span>
         </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" value="Add" id="validation-next" class="btn btn-back mt-4">
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
