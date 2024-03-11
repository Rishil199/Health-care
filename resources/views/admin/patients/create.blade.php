@use ('App\Models\User')
<div class="modal-content">
    <div class="modal-header">
        <div class="title">
            <strong>Add New Patient <strong>
        </div>
    </div>
    <div class="modal-body">
        <form action="{{ route('patients.store') }}" method="post" class="add-patients-form" id="add-patients-form"
            autocomplete="off">
            @csrf
            <input type="hidden" value="{{ uniqid() }}" name="patient_number">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-group theme-form-group">
                        <label class="theme-label" for="first_name">Name <span class="required">*</span></label>
                        <div class="theme-form-input">
                            <input class="form-control" id="first_name" name="first_name" type="text"
                                placeholder="Enter Name" required />
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="last_name">Last Name <span class="required">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="last_name" name="last_name" type="text" placeholder="Patient Last Name" required />
                  </div>
               </div>
            </div> --}}
                <div class="col-md-6 mb-3">
                    <div class="form-group theme-form-group">
                        <label class="theme-label" for="email">Email <span class="required">*</span></label>
                        <div class="theme-form-input">
                            <input class="form-control" id="email" name="email" type="email"
                                placeholder="Enter Email" required />
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group theme-form-group">
                        <label class="theme-label" for="phone_no">Phone No. <span class="text-danger">*</span></label>
                        <div class="theme-form-input">
                            <input class="form-control" id="phone_no" name="phone_no" type="tel"
                                placeholder="Enter Phone No." required />
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
                                <label for="male" class="theme-label">Male</label>
                            </div>
                            <div class="theme-input radio ms-3">
                                <input name="gender" type="radio" id="female" value="female">
                                <label for="female" class="theme-label">Female</label>
                            </div>
                        </div>
                    </div>
                </div>
                {{--  <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="admit_date">Admit Date: <span class="text-danger">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="datepicker" name="admit_date" type="text" placeholder="Patient admit date" required />
                  </div>
               </div>
            </div> --}}
                <div class="col-md-6 mb-3">
                    <div class="form-group theme-form-group">
                        <label class="theme-label" for="address">Address <span class="text-danger">*</span></label>
                        <div class="theme-form-input">
                            <textarea class="form-control" id="address" name="address" type="text" placeholder="Enter Address" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="form-group theme-form-group">
                        <div class="d-block">
                            <label class="theme-label" for="height">Height <span class="text-danger">*</span></label>
                        </div>
                        <div class="input-wrapper d-flex">
                            <div class="theme-form-input">
                                <input class="form-control " type="text" name="height" placeholder="(In CM)"
                                    id="height" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="form-group theme-form-group">
                        <div class="d-block">
                            <label class="theme-label" for="weight">Weight <span
                                    class="text-danger">*</span></label>
                        </div>
                        <div class="input-wrapper d-flex">
                            <div class="theme-form-input">
                                <input class="form-control " type="text" name="weight" placeholder="(In KG)"
                                    id="weight" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 row mb-3">
					<div class="col-md-6">
						<div class="form-group theme-form-group">
							<div class="d-block ">
								<label class="theme-label" for="blood_group">Blood Group </label>
							</div>
							<div class="input-wrapper d-flex">
								<div class="theme-form-input ">
									<input class="form-control " type="text" name="blood_group"
										placeholder="Blood Group" id="blood_group">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group theme-form-group">
							<div class="d-block">
								<label class="theme-label" for="blood_pressure">Blood Pressure</label>
							</div>
							<div class="input-wrapper d-flex">
								<div class="theme-form-input ">
									<input class="form-control " type="text" name="blood_pressure"
										placeholder="119/70" id="blood_pressure">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 row">
					<div class="col-md-6">
						<div class="form-group theme-form-group">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" id="inlineCheck" value="1"
									name="is_patient_has_relative">
								<label class="form-check-label text-secondary fs-6" for="inlineCheck">Patient has
									relative</label>
							</div>
						</div>
					</div>
	
					<div class="col-md-6">
						<div class="form-group theme-form-group">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1"
									name="is_mediclaim_available">
								<label class="form-check-label text-secondary fs-6" for="inlineCheckbox1">Medical
									Insurance Available</label>
							</div>
						</div>
					</div>
				</div>
                <div class="col-md-12 mb-3 row">
                    <div class="col-md-4">
                        <div class="form-group theme-form-group hide">
                            <label class="theme-label" for="relation">Relation</label>
                            <div class="theme-form-input hide">
                                <input class="form-control" id="relation" name="relation" type="text"
                                    placeholder="Enter Relation" />
                            </div>
                        </div>
                    </div>
					<div class="col-md-4">
						<div class="form-group theme-form-group hide">
							<label class="theme-label" for="relative_name">Relative Name </label>
							<div class="theme-form-input ">
								<input class="form-control" id="relative_name" name="relative_name" type="text"
									placeholder="Enter Relative Name" />
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group theme-form-group hide">
							<label class="theme-label" for="emergency_contact">Emergency contact </label>
							<div class="theme-form-input ">
								<input class="form-control" id="emergency_contact" name="emergency_contact"
									type="tel" placeholder="Emergency contact" />
							</div>
						</div>
					</div>
                </div>
                @if (Auth::user()->hasRole(User::ROLE_SUPER_ADMIN))
                    <div class="col-md-6 mb-3">
                        <div class="form-group theme-form-group">
                            <label class="theme-label" for="picker1">Choose Clinic</label>
                            <div class="theme-form-input">
                                <select class="form-control form-select" name="clinic_id" id="clinic-dropdown">
                                    <option value="">Choose Clinic</option>
                                    @foreach ($clinics as $value)
                                        <option value="{{ $value->user_id }}">{{ $value?->user?->first_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
                @if (Auth::user()->hasAnyRole(User::ROLE_SUPER_ADMIN))
                    <div class="col-md-6 mb-3">
                        <div class="form-group theme-form-group">
                            <label class="theme-label" for="picker1">Choose Doctor</label>
                            <div class="theme-form-input">
                                <select class="form-control form-select" name="doctor_id" id="doctor-dropdown">
                                    <option value="">Choose Doctor</option>
                                    @foreach ($doctors as $value)
                                        <option value="{{ $value->id }}">{{ $value->user->first_name }}
                                            {{ $value->user->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- @if (Auth::user()->hasAnyRole([User::ROLE_RECEPTIONIST, User::ROLE_CLINIC]))
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="picker1">Select Doctor</label>
                  <div class="theme-form-input">
                     <select class="form-control form-select" name="doctor_id" id="doctor-dropdown">
                        <option value="">Select Doctor</option>
                        @foreach ($doctors as $value)
                        <option value="{{ $value->id }}">{{ $value->user->first_name }} {{ $value->user->last_name }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
            </div>
            @endif --}}
                {{-- <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="disease_name">Disease Name <span class="text-danger">*</span></label>
                  <div class="theme-form-input">
                     <input class="form-control" id="disease_name" name="disease_name" type="text" placeholder="Disease Name." required />
                  </div>
               </div>
            </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="prescription">Prescription <span class="text-danger">*</span></label>
                  <div class="theme-form-input">
                     <textarea class="form-control" id="prescription" name="prescription" type="text" placeholder="Prescription List" style="resize: none;" required></textarea>
                  </div>
               </div>
            </div> 
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <label class="theme-label" for="allergies">Allergies</label>
                  <div class="theme-form-input">
                     <textarea class="form-control" id="allergies" name="allergies" type="text" placeholder="Allergies List" style="resize: none;"></textarea>
                  </div>
               </div>
            </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <div class="d-block ">
                     <label class="theme-label" for="illness">Medical History <span class="required">*</span></label>
                  </div>
                  <div class="input-wrapper d-flex">
                     <div class="theme-input radio">
                        <input name="illness" id="yes" type="radio" value="yes">
                        <label for="yes" class="theme-label" >Yes</label>
                     </div>
                     <div class="theme-input radio ms-3">
                        <input name="illness" type="radio" id="no" value="no">
                        <label for="no" class="theme-label">No</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <div class="d-block ">
                     <label class="theme-label" for="exercise">Exercise<span class="required">*</span></label>
                  </div>
                  <div class="input-wrapper d-flex">
                     <div class="theme-input radio ms-3">
                        <input name="exercise" id="never" type="radio" value="never">
                        <label for="never" class="theme-label" >Never</label>
                     </div>
                     <div class="theme-input radio ms-3">
                        <input name="exercise" id="1_2_days" type="radio" value="1-2 Days">
                        <label for="1_2_days" class="theme-label">1-2 Days</label>
                     </div>
                     <div class="theme-input radio ms-3">
                        <input name="exercise" id="3_4_days" type="radio" value="3-4 Days">
                        <label for="3_4_days" class="theme-label">3-4 Days</label>
                     </div>
                     <div class="theme-input radio ms-3">
                        <input name="exercise" id="5_days" type="radio" value="5+ Days">
                        <label for="5_days" class="theme-label">5+ Days</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <div class="d-block ">
                     <label class="theme-label" for="alchohol_consumption">Alcohol Consumption <span class="required">*</span></label>
                  </div>
                  <div class="input-wrapper d-flex">
                     <div class="theme-input radio">
                        <input name="alchohol_consumption" id="alchohol_yes" type="radio" value="yes">
                        <label for="alchohol_yes" class="theme-label" >Yes</label>
                     </div>
                     <div class="theme-input radio ms-3">
                        <input name="alchohol_consumption" type="radio" id="alchohol_no" value="no">
                        <label for="alchohol_no" class="theme-label">No</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <div class="d-block ">
                     <label class="theme-label" for="diet">Diet<span class="required">*</span></label>
                  </div>
                  <div class="input-wrapper d-flex">
                     <div class="theme-input radio">
                        <input name="diet" id="diet_yes" type="radio" value="yes">
                        <label for="diet_yes" class="theme-label" >Yes</label>
                     </div>
                     <div class="theme-input radio ms-3">
                        <input name="diet" type="radio" id="diet_no" value="no">
                        <label for="diet_no" class="theme-label">No</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 mb-3">
               <div class="form-group theme-form-group">
                  <div class="d-block ">
                     <label class="theme-label" for="smoke">Smoke<span class="required">*</span></label>
                  </div>
                  <div class="input-wrapper d-flex">
                     <div class="theme-input radio">
                        <input name="smoke" id="smoke_yes" type="radio" value="yes">
                        <label for="smoke_yes" class="theme-label" >Yes</label>
                     </div>
                     <div class="theme-input radio ms-3">
                        <input name="smoke" type="radio" id="smoke_no" value="no">
                        <label for="smoke_no" class="theme-label">No</label>
                     </div>
                  </div>
               </div>
            </div> --}}
            </div>
            <div class="modal-footer justify-content-center">
                <button type="submit" value="Add" id="validation-next" class="btn btn-back mt-4">
                    <i class="lni lni-save"></i>
                    Save
                </button>
                <button  type="button" class="btn btn-outline-dark  mt-4 mx-3" data-bs-dismiss="modal">  
                    Cancel 
                </button>
            </div>
    </div>
    </form>
</div>
</div>
<script>
    $(document).ready(function() {
        $('#clinic-dropdown').on('change', function() {
            var idCountry = this.value;
            $("#doctor-dropdown").html('');
            $.ajax({
                url: "{{ route('patients.fetchDoctors') }}",
                type: "POST",
                data: {
                    clinic_id: idCountry,
                },
                dataType: 'json',
                success: function(result) {
                    $('#doctor-dropdown').html('<option value="">Select Doctor</option>');
                    $.each(result.doctors, function(key, value) {
                        $("#doctor-dropdown").append('<option value="' + value.user
                            .id + '">' + value.user.first_name + '</option>');
                    });
                    $('#city-dd').html('<option value="">Select City</option>');
                }
            });
        });
        $(".hide").hide();
        $("#inlineCheck").click(function() {
            $('.hide').toggle();
        });
    });
</script>
