@use ('App\Models\User')
<div class="modal-content">
   <div class="modal-header">
      <div class="title">
         <strong>Edit Patient <strong>
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
     <form action="{{ route('patients.update',$patient->id) }}" method="post" class="update-patients-form" id="update-patients-form" autocomplete="off">
      @csrf
         <div class="row">
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="first_name">Patient First Name <span class="required">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="first_name" name="first_name" type="text" placeholder="Patient First Name" value="{{ $patient->user->first_name}}" required />
                  </div>
               </div>
            </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="email">Email <span class="required">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="email" name="email" type="email" placeholder="Patient Email" value="{{ $patient->user->email}}" readonly />
                  </div>
               </div>
            </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="phone_no">Phone No. <span class="text-danger">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="phone_no" name="phone_no" type="tel" placeholder="Patirnt Phone No." value="{{ $patient->user->phone_no}}" required />
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
                        <input name="gender" id="male" type="radio" value="male" {{ $patient->gender == "male"  ? 'checked' : '' }}>
                        <label for="male" class="theme-label" >Male</label>
                     </div>
                     <div class="theme-input radio ms-3">
                        <input name="gender" type="radio" id="female" value="female" {{ $patient->gender == "female"  ? 'checked' : '' }}>
                        <label for="female" class="theme-label">Female</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="admit_date">Admit Date: <span class="text-danger">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="datepicker" name="admit_date" type="text" value="{{ date('d/m/Y', strtotime($patient->admit_date))}}" />
                  </div>
               </div>
            </div>
            @if(Auth::user()->hasRole(User::ROLE_CLINIC))
               <input type="hidden" name="clinic_id" value="{{ $patient->clinic_id }}" />
            @endif
            @if(Auth::user()->hasRole(User::ROLE_SUPER_ADMIN))
               <div class="col-md-6 mb-3">
                  <div class="form-group theme-form-group">
                     <label class="theme-label" for="picker1">Select Clinic</label>
                     <div class="theme-form-input">
                        <select class="form-control form-select" name="clinic_id" id="clinic-dropdown">
                           <option value="">Select Clinic</option>
                           @foreach($clinics as $value)
                           <option value="{{ $value->id }}" {{ $patient->clinic_id == $value->id ? 'selected' : '' }}>{{ @$value->user->first_name }}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 mb-3">
                  <div class="form-group theme-form-group">
                     <label class="theme-label" for="picker1">Select Doctor</label>
                     <div class="theme-form-input">
                        <select class="form-control form-select" name="doctor_id" id="doctor-dropdown">
                           <option value="">Select Doctor</option>
                           @foreach($doctors as $value)
                           <option value="{{ $value->id }}" {{ $patient->doctor_id == $value->id  ? 'selected' : '' }}>{{ $value->user->first_name }} {{ $value->user->last_name }}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
               </div>
            @endif


               {{-- Hieght --}}
            <div class="col-md-3 mb-3">
               <div class="form-group theme-form-group">
                   <div class="d-block">
                       <label class="theme-label" for="height">Height <span class="text-danger">*</span></label>
                   </div>
                   <div class="input-wrapper d-flex">
                       <div class="theme-form-input">
                           <input class="form-control " type="text" name="height" placeholder="(In CM)" id="height" value="{{$patient->height}}" >
                       </div>
                   </div>
               </div>
           </div>
     {{-- Weight --}}
           <div class="col-md-3 mb-3">
            <div class="form-group theme-form-group">
                <div class="d-block">
                    <label class="theme-label" for="weight">Weight <span class="text-danger">*</span></label>
                </div>
                <div class="input-wrapper d-flex">
                    <div class="theme-form-input">
                        <input class="form-control " type="text" name="weight" placeholder="(In KG)" value="{{$patient->weight}}" id="weight" >
                    </div>
                </div>
            </div>
        </div>

       {{-- Address --}}
       <div class="col-md-6 mb-3">
         <div class="form-group theme-form-group">
            <label class="theme-label" for="address">Address <span class="text-danger">*</span></label>
            <div class="theme-form-input">
               <textarea class="form-control" id="address" name="address" type="text" placeholder="Patient Address" style="resize: none;" value="{{ $patient->address}}" required> {{ $patient->address}}</textarea>
            </div>
         </div>
      </div>

        {{-- Blood group  --}}
        <div class="col-md-3 mb-3">
         <div class="form-group theme-form-group">
             <div class="d-block ">
                 <label class="theme-label" for="blood_group">Blood Group <span
                         class="text-danger">*</span></label>
             </div>
             <div class="input-wrapper d-flex">
                 <div class="theme-form-input ">
                     <input class="form-control " type="text" name="blood_group" value="{{$patient->blood_group}}"
                         placeholder="Blood Group" id="blood_group" >
                 </div>
             </div>
                 </div>
         </div>
         
        {{-- Blood Pressure  --}}

        <div class="col-md-3 mb-3">
         <div class="form-group theme-form-group">
                 <div class="d-block">
                     <label class="theme-label" for="blood_pressure" >Blood Pressure<span
                             class="text-danger">*</span></label>
                 </div>
                 <div class="input-wrapper d-flex">
                     <div class="theme-form-input ">
                         <input class="form-control " type="text"
                             name="blood_pressure" placeholder="119/70" id="blood_pressure" value="{{$patient->blood_pressure}}" >
                     </div>
                 </div>
                 </div>
             </div>

               {{--  Relation --}}
             <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="relation">Relation<span class="required">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="relation" name="relation" type="text" placeholder="Enter Relation" value="{{$patient->relation}}"  />
                  </div>
               </div>
            </div>

            {{-- Relative name --}}
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="relative_name">Relative Name <span class="required">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="relative_name" name="relative_name" type="text" placeholder="Enter Relative Name" value="{{$patient->relative_name}}"  />
                  </div>
               </div>
            </div>

            {{-- Emergency Contact --}}
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="emergency_contact">Emergency contact <span class="required">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="emergency_contact" name="emergency_contact" type="tel" placeholder="Emergency contact" value="{{$patient->emergency_contact}}" />
                  </div>
               </div>
            </div>

          {{--Disease --}}  
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="disease_name">Disease Name <span class="text-danger">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="disease_name" name="disease_name" value="{{ $patient->disease_name}}" type="text" placeholder="Disease Name">
                  </div>
               </div>
            </div>

            {{-- Prescription --}}
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="prescription">Prescription <span class="text-danger">*</span></label>
                  <div class="theme-form-input">
                     <textarea class="form-control" id="prescription" name="prescription" type="text" placeholder="Prescription List" style="resize: none;" value="{{ $patient->prescription}}" required> {{ $patient->prescription }} </textarea>
                  </div>
               </div>
            </div>

            {{-- Allergies --}}
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="allergies">Allergies </label>
                  <div class="theme-form-input">
                     <textarea class="form-control" id="allergies" name="allergies" type="text" placeholder="Allergies List" style="resize: none;" value="{{ $patient->allergies}}">{{ $patient->allergies }}</textarea>
                  </div>
               </div>
            </div>

            {{--Exercise  --}}
            <div class="col-md-8 mb-3">
               <div class="form-group theme-form-group">
                  <div class="d-block ">
                     <label class="theme-label" for="exercise">Exercise<span class="required">*</span></label>
                  </div>
                  <div class="input-wrapper d-flex">
                     <div class="theme-input radio ms-3">
                        <input name="exercise" id="never" type="radio" value="never" {{ $patient->exercise == "never"  ? 'checked' : '' }}>
                        <label for="never" class="theme-label" >Never</label>
                     </div>
                     <div class="theme-input radio ms-3">
                        <input name="exercise" id="1_2_days" type="radio" value="1-2 Days" {{ $patient->exercise == "1-2 Days"  ? 'checked' : '' }}>
                        <label for="1_2_days" class="theme-label">1-2 Days</label>
                     </div>
                     <div class="theme-input radio ms-3">
                        <input name="exercise" id="3_4_days" type="radio" value="3-4 Days" {{ $patient->exercise == "3-4 Days"  ? 'checked' : '' }}>
                        <label for="3_4_days" class="theme-label">3-4 Days</label>
                     </div>
                     <div class="theme-input radio ms-3">
                        <input name="exercise" id="5_days" type="radio" value="5+ Days" {{ $patient->exercise == "5+ Days"  ? 'checked' : '' }}>
                        <label for="5_days" class="theme-label">5+ Days</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-4 mb-3">
               <div class="form-group theme-form-group">
                  <div class="d-block ">
                     <label class="theme-label" for="exercise">Medical History<span class="required">*</span></label>
                  </div>
                  <div class="input-wrapper d-flex">
                     <div class="theme-input radio">
                        <input name="illness" id="yes" type="radio" value="yes" {{ $patient->illness == "yes"  ? 'checked' : '' }}>
                        <label for="yes" class="theme-label" >Yes</label>
                     </div>
                     <div class="theme-input radio ms-3">
                        <input name="illness" type="radio" id="no" value="no" {{ $patient->illness == "no"  ? 'checked' : '' }}>
                        <label for="no" class="theme-label">No</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-4 mb-3">
               <div class="form-group theme-form-group">
                  <div class="d-block ">
                     <label class="theme-label" for="alchohol_consumption">Alcohol Consumption <span class="required">*</span></label>
                  </div>
                  <div class="input-wrapper d-flex">
                     <div class="theme-input radio">
                        <input name="alchohol_consumption" id="alchohol_yes" type="radio" value="yes" {{ $patient->alchohol_consumption == "yes"  ? 'checked' : '' }}>
                        <label for="alchohol_yes" class="theme-label" >Yes</label>
                     </div>
                     <div class="theme-input radio ms-3">
                        <input name="alchohol_consumption" type="radio" id="alchohol_no" value="no" {{ $patient->alchohol_consumption == "no"  ? 'checked' : '' }}>
                        <label for="alchohol_no" class="theme-label">No</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-4 mb-3">
               <div class="form-group theme-form-group">
                  <div class="d-block ">
                     <label class="theme-label" for="diet">Diet<span class="required">*</span></label>
                  </div>
                  <div class="input-wrapper d-flex">
                     <div class="theme-input radio">
                        <input name="diet" id="diet_yes" type="radio" value="yes" {{ $patient->diet == "yes"  ? 'checked' : '' }}>
                        <label for="diet_yes" class="theme-label" >Yes</label>
                     </div>
                     <div class="theme-input radio ms-3">
                        <input name="diet" type="radio" id="diet_no" value="no" {{ $patient->diet == "no"  ? 'checked' : '' }}>
                        <label for="diet_no" class="theme-label">No</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-4 mb-3">
               <div class="form-group theme-form-group">
                  <div class="d-block ">
                     <label class="theme-label" for="smoke">Smoke<span class="required">*</span></label>
                  </div>
                  <div class="input-wrapper d-flex">
                     <div class="theme-input radio">
                        <input name="smoke" id="smoke_yes" type="radio" value="yes" {{ $patient->smoke == "yes"  ? 'checked' : '' }}>
                        <label for="smoke_yes" class="theme-label" >Yes</label>
                     </div>
                     <div class="theme-input radio ms-3">
                        <input name="smoke" type="radio" id="smoke_no" value="no" {{ $patient->smoke == "no"  ? 'checked' : '' }}>
                        <label for="smoke_no" class="theme-label">No</label>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer justify-content-center">
              <button type="submit" value="Update" id="validation-next" class="btn btn-back mt-4">
                  <i class="lni lni-save"></i>
                  Save
              </button>
         </div>
         </div>
      </form>
    </div>
</div>
<script>
   $(document).ready(function () {
   $('#clinic-dropdown').on('change', function () {
       var idCountry = this.value;
       $("#doctor-dropdown").html('');
       $.ajax({
           url: "{{ route('patients.fetchDoctors')}}",
           type: "POST",
           data: {
               clinic_id: idCountry,
           },
           dataType: 'json',
           success: function (result) {
               $('#doctor-dropdown').html('<option value="">Select Doctor</option>');
               $.each(result.doctors, function (key, value) {
                   $("#doctor-dropdown").append('<option value="' + value.user.id + '">' + value.user.first_name + '</option>');
               });
               $('#city-dd').html('<option value="">Select City</option>');
           }
       });
   });
});
</script>