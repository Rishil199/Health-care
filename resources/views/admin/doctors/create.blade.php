<div class="modal-content">
    <div class="modal-header">
        <div class="title">
            <strong>Add New Doctor </strong>
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
        <form action="{{ route('doctors.store') }}" method="post" class="add-doctors-form" id="add-doctors-form" autocomplete="off">
            @csrf
            <div class="row">
               <div class="col-md-6 mb-3">
                  <div class="form-group theme-form-group">
                     <label class="theme-label" for="first_name">First Name <span class="required">*</span></label>
                        <div class="theme-form-input">
                           <input class="form-control" id="first_name" name="first_name" type="text" placeholder="Doctor First Name" />
                        </div>
                  </div>
               </div>
               <div class="col-md-6 mb-3">
                  <div class="form-group theme-form-group">
                     <label class="theme-label" for="last_name">Last Name <span class="required">*</span></label>
                        <div class="theme-form-input">
                            <input class="form-control" id="last_name" name="last_name" type="text" placeholder="Doctor Last Name" />
                        </div>
                  </div>
               </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="email">Email <span class="required">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="email" name="email" type="email" placeholder="Doctor Email" required />
                  </div>
               </div>
            </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="phone_no">Phone No. <span class="text-danger">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="phone_no" name="phone_no" type="text" placeholder="Doctor Phone No." required />
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
                        <input name="gender" id="male" type="radio" value="male">
                        <label for="male" class="theme-label" >Male</label>
                     </div>
                     <div class="theme-input radio ms-3">
                        <input name="gender" type="radio" id="female" value="female">
                        <label for="female" class="theme-label">Female</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="address">Address <span class="text-danger">*</span></label>
                  <div class="theme-form-input">
                     <textarea class="form-control" id="address" name="address" type="text" placeholder="Doctor Address" style="resize: none;" required></textarea>
                  </div>
               </div>
            </div>
            @if(Auth::user()->hasRole(['Super Admin']))
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="picker1">Select Clinic <span class="text-danger">*</span></label>
                  <div class="theme-form-input">
                     <select class="form-control form-select" name="clinic_id">
                        <option value="">Select Clinic</option>
                        @foreach($clinics as $value)
                        <option value="{{ $value->id }}">{{ ucfirst($value->user->first_name) }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
            </div>
            @endif
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <div class="d-block ">
                     <label class="theme-label" for="status">Status <span class="required">*</span></label>
                  </div>
                  <div class="input-wrapper d-flex">
                     <div class="theme-input radio">
                        <input name="status" id="statusActive" type="radio" value="1" checked>
                        <label for="statusActive" class="theme-label">Activate</label>
                     </div>
                     <div class="theme-input radio ms-3">
                        <input name="status" type="radio" value="0" id="statusNotActive">
                        <label for="statusNotActive" class="theme-label">Deactive</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="degree">Degree <span class="required">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="degree" name="degree" type="text" placeholder="Doctor Degree" required />
                  </div>
               </div>
            </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="experience">Experience <span class="required">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="experience" name="experience" type="text" placeholder="Doctor Experience" required />
                  </div>
               </div>
            </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="expertice">Expertice <span class="text-danger">*</span></label>
                  <div class="theme-form-input">
                     <textarea class="form-control" id="expertice" name="expertice" type="text" placeholder="Doctor Expertice" style="resize: none;" required></textarea>
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
                        Add
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
