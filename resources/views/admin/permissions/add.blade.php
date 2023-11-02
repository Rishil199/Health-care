<div class="modal-content">
    <div class="modal-header">
        <div class="title">
            <strong>Add New Permission <strong>
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
        <form action="{{ route('permissions.store') }}" method="post" class="add_permissions_form" id="add_permissions_form" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="form-group theme-form-group">
                        <label  class="theme-label" for="name">Permission Name <span class="required">*</span></label>
                        <div class="theme-form-input">
                            <input class="form-control" id="permissions" name="name" type="text" placeholder="Permission Name" required />
                        </div>
                        @error('name')
                        <p class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </p>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" value="Add" name="add_permission" id="validation-next" class="btn btn-back mt-4">
                        <i class="lni lni-save"></i>
                        Add
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>