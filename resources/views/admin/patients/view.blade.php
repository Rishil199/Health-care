@use ('App\Models\User')

<div class="modal-content">
    <div class="modal-header">
        <div class="title">
            <strong>View Patient Detail</strong>
        </div>
    </div>
    <div class="modal-body mx-5">
        <div class="view-block">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="theme-form-group ">
                        <label class="theme-label" for="firstName">Name</label>
                        <div class="theme-form-input">
                           <span>{{ $patient->user->first_name ?? '-'}} {{ $patient->user->last_name ?? '-'}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="theme-form-group ">
                        <label class="theme-label" for="email">Email</label>
                        <div class="theme-form-input">
                           <span>{{ $patient->user->email ?? '-'}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="theme-form-group">
                        <label class="theme-label" for="phone_no">Phone No</label>
                        <div class="theme-form-input">
                         <span>{{ $patient->user->phone_no?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="theme-form-group ">
                        <label class="theme-label" for="gender">Gender</label>
                        <div class="theme-form-input">
                           <span>{{ $patient->gender?? '-' }}</span>
                        </div>
                    </div>
                </div>



                <div class="col-md-4 mb-3">
                    <div class="theme-form-group ">
                        <label class="theme-label" for="address">Address</label>
                        <div class="theme-form-input">
                            <span>{{ $patient->address ?? '-'}}<span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="form-group theme-form-group">
                        <div class="d-block">
                            <label class="theme-label" for="height">Height </label>
                        </div>
                        <div class="input-wrapper d-flex">
                            <div class="theme-form-input">
                             <span>{{ $patient->height ?? '-'}}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="form-group theme-form-group">
                        <div class="d-block">
                            <label class="theme-label" for="weight">Weight </label>
                        </div>
                        <div class="input-wrapper d-flex">
                            <div class="theme-form-input">
                               <span>{{ $patient->weight?? '-'}} </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="theme-form-group ">
                        <label class="theme-label" for="birth_date">Admit Date</label>
                        <div class="theme-form-input">
                        <span>{{ $patient->admit_date ? date('d/m/Y', strtotime($patient->admit_date)) : '-' }}</span>
                        </div>
                    </div>
                </div>
            

                <div class="col-md-4 mb-3">
                    <div class="form-group theme-form-group">
                        <div class="d-block ">
                            <label class="theme-label" for="blood_group">Blood Group </label>
                        </div>
                        <div class="input-wrapper d-flex">
                            <div class="theme-form-input ">
                                <span>{{$patient->blood_group ??'-'}}</span>
                            </div>
                        </div>
                            </div>
                    </div>


                    <div class="col-md-4 mb-3">
                        <div class="form-group theme-form-group">
                                <div class="d-block">
                                    <label class="theme-label" for="blood_pressure" >Blood Pressure</label>
                                </div>
                                <div class="input-wrapper d-flex">
                                    <div class="theme-form-input ">
                                      <span> {{ $patient->blood_pressure ?? '-'}} </span>
                                    </div>
                                </div>
                                </div>
                            </div>
                    

                <div class="col-md-4 mb-3">
                    <div class="theme-form-group ">
                        <label class="theme-label" for="disease_name">Disease Name</label>
                        <div class="theme-form-input">
                           <span>{{ $patient->disease_name ?? '-' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="theme-form-group ">
                        <label class="theme-label" for="prescription">Prescription</label>
                        <div class="theme-form-input">
                           <span>{{ $patient->prescription  ?? '-' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="theme-form-group ">
                        <label class="theme-label" for="allergies">Allergies</label>
                        <div class="theme-form-input">
                            <span>{{ $patient->allergies ?? '-'  }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="theme-form-group">
                        <label class="theme-label" for="illness">Medical History</label>
                        <div class="theme-form-input">
                        <span>   <span>{{ $patient->illness == "yes"  ? 'Yes' : 'No' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="theme-form-group ">
                        <label class="theme-label" for="exercise">Exercise</label>
                        <div class="theme-form-input">
                        <span>{{ $patient->exercise == "yes"  ? 'Yes' : 'No' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="theme-form-group ">
                        <label class="theme-label" for="alchohol_consumption">Alchohol Consumption</label>
                        <div class="theme-form-input">
                           <span>{{ $patient->alchohol_consumption == "yes"  ? 'Yes' : 'No' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="theme-form-group ">
                        <label class="theme-label" for="diet">Diet</label>
                        <div class="theme-form-input">
                           <span>{{ $patient->diet == "yes"  ? 'Yes' : 'No' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="theme-form-group">
                        <label class="theme-label" for="smoke">Smoke</label>
                        <div class="theme-form-input">
                           <span>{{ $patient->smoke == "yes"  ? 'Yes' : 'No' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @if(Auth::user()->hasRole(User::ROLE_SUPER_ADMIN))
            <div class="theme-form-input mb-4">
                <h5 class="mt-5">Medical history -</h5>
                 </div>
                 <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table table-light">
                                <tr>
                                    <th scope="col">Sr.no</th>
                                    <th scope="col">Doctor Name</th>
                                    <th scope="col">Appointment Date</th>
                                    <th scope="col">Appointment Time</th>
                                    <th scope="col">Observation</th>
                                    <th scope="col">Prescription</th>
                                    <th scope="col">Weight</th>
                                    <th scope="col">Blood Pressure</th>
                                    <th scope="col">Diet Plan</th>
                                    <th scope="col">Next Date</th>               
                                </tr>
                            </thead>
                            @if($patient_history->isEmpty())
                            <tbody>
                                <tr>
                                    <td colspan="10" class="text-center font-semibold">No history available</td>
                                </tr>
                            </tbody>
                            @else
                            <tbody>
                                <?php $count=0;?>
                                @foreach($patient_history as $history)
                                <?php $count++;?>
                                <tr>
                                    <td>{{$count}}</td>
                                    <td>{{$history->doctor?->user?->first_name}}</td>
                                    <td>{{ \Carbon\Carbon::parse($history->appointment_date)->format('d-m-Y')}}</td>
                                    <td>{{ $history->time_start }} - {{ $history->time_end }}</td>
                                    <td>{{ $history->disease_name !==null && $history->disease_name !=='' ? $history->disease_name:'-'}}</td>
                                    <td>{{ $history->prescription ?? '-'}}</td>
                                    <td>{{ $history->weight ?? '-' }}</td>
                                    <td>{{ $history->blood_pressure ?? '-' }}</td>
                                    <td>{{ $history->dietplan ?? '-' }}</td>
                                    <td>{{ $history->next_date ? \Carbon\Carbon::parse($history->next_date)->format('d-m-Y') : '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            @endif
                        </table>
                    </div>
                </div>                
            @endif
            <div class="text-end">
                <button type="button" class="btn btn-dark " data-bs-dismiss="modal"> Back 
            </button>
        </div>
           
        </div>
       
    </div>
</div>
