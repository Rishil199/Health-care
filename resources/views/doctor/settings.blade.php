<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<div class="modal-content">
    <div class="modal-header">
        <div class="title">
            <strong>Change Settings<strong>
        </div>
    </div>
    <div class="modal-body">
        <form action="{{ route('settings.store') }}" method="post" class="add_settings_form" id="add_settings_form" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-3">
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
                <div class="col-md-4 mb-3">
                    <div class="form-group theme-form-group ">
                        <label  class="theme-label " for="end_time">End Time<span class="required">*</span></label>
                        <div class="theme-form-input">
                            <input class="form-control " id="end_time" name="end_time" type="text" placeholder="End Time"  value="{{ date('H:i A', strtotime($generalSettings?->end_time )) ? date('H:i A', strtotime($generalSettings?->end_time )) : ' '}}" required />
                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                        </div>
                        @error('end_time')
                        <p class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 mb-3">
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
           
             <div class="modal-footer justify-content-center text-center">
                    <button type="submit" value="Add" name="add_settings" class="add_settings btn btn-info" id="validation-next">
                        <i class="lni lni-save"></i>
                        Save
                    </button>
                    <button type="button" class="btn btn-outline-dark mt-0 mx-3 text-center" data-bs-dismiss="modal">Cancel</button>
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