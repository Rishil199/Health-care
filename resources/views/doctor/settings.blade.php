<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<div class="modal-content">
    <div class="modal-header">
        <div class="title">
            <strong>Change Settings<strong>
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
        <form action="{{ route('settings.store') }}" method="post" class="add_settings_form" id="add_settings_form" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-group theme-form-group">
                        <label  class="theme-label " for="start_time">Start Time<span class="required">*</span></label>
                        <div class="theme-form-input">
                            <input class="form-control " id="start_time" name="start_time" type="text" placeholder="Start Time" value="{{ date('H:i A', strtotime($generalSettings?->start_time )) ? date('H:i A', strtotime($generalSettings?->start_time )) : ' '}}" required />
                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                        </div>
                        @error('start_time')
                        <p class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group theme-form-group ">
                        <label  class="theme-label " for="end_time">End Time<span class="required">*</span></label>
                        <div class="theme-form-input">
                            <input class="form-control " id="end_time" name="end_time" type="text" placeholder="End Time"  value="{{ date('H:i A', strtotime($generalSettings?->end_time )) ? date('H:i A', strtotime($generalSettings? ->end_time )) : ' '}}" required />
                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                        </div>
                        @error('end_time')
                        <p class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group theme-form-group">
                        <label  class="theme-label" for="duration">Duration (in Minute.)<span class="required">*</span></label>
                        <div class="theme-form-input">
                            <input class="form-control" id="duration" name="duration" type="number" placeholder="Duration" value="{{  $generalSettings?->duration}}"  required />
                        @error('duration')
                        <p class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                    <div class="form-group theme-form-group">
                        {{-- <label  class="theme-label" for="break_time">Break Time (in Minute.)<span class="required">*</span></label> --}}
                        <div class="theme-form-input">
                            {{-- <input class="form-control" id="break_time" name="break_time" type="number" placeholder="break_time" value="{{  $generalSettings?->break_time}}"  required /> --}}
                        @error('break_time')
                        <p class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </p>
                        @enderror
                    </div>
                </div>
            </div>
             <div class="modal-footer justify-content-center text-center">
                    <button type="submit" value="Add" name="add_settings" class="add_settings btn btn-info mt-4" id="validation-next">
                        <i class="lni lni-save"></i>
                        Add
                    </button>
                </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('#start_time').bootstrapMaterialDatePicker({
        format: 'HH:mm',
        ampm: true,
        shortTime: true,
        date: false,
        time: true,
        monthPicker: false,
        year: false,
        switchOnClick: true,
        minTime: '00:01am',
        maxTime: '11:59pm',
      });
    $('#end_time').bootstrapMaterialDatePicker({
        format: 'HH:mm',
        ampm: true,
        shortTime: true,
        date: false,
        time: true,
        monthPicker: false,
        year: false,
        switchOnClick: true,
        minTime: '00:01am',
        maxTime: '11:59pm',
      });
</script>