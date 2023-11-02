<div class="modal-content">
    <div class="modal-header">
        <div 
        class="title">
        <strong>
            Add Branch Details
        </strong>
        </div>
        <button type="button" class="btn-close btn" data-bs-dismiss="modal" aria-label="Close">
         <svg fill="#000000" width="20" height="20" version="1.1" id="lni_lni-close" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
            <path d="M34.5,32L62.2,4.2c0.7-0.7,0.7-1.8,0-2.5c-0.7-0.7-1.8-0.7-2.5,0L32,29.5L4.2,1.8c-0.7-0.7-1.8-0.7-2.5,0
               c-0.7,0.7-0.7,1.8,0,2.5L29.5,32L1.8,59.8c-0.7,0.7-0.7,1.8,0,2.5c0.3,0.3,0.8,0.5,1.2,0.5s0.9-0.2,1.2-0.5L32,34.5l27.7,27.8
               c0.3,0.3,0.8,0.5,1.2,0.5c0.4,0,0.9-0.2,1.2-0.5c0.7-0.7,0.7-1.8,0-2.5L34.5,32z" fill="#fff"></path>
         </svg>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{ route('clinics.store') }}" method="post" class="add_branch_form" id="add_branch_form" autocomplete="off" name="Branch"> 
            @csrf
            <input type="hidden" name="clinic_id" value={{ $id }} />
            <div class="row">
                @include('admin.clinics.branch', ['modal_view' => true])
                <div class="modal-footer justify-content-center">
                    <button class="btn btn-back" id="validation-next" type="submit" value="Add"> <i class="lni lni-save"></i>
                        Add 
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
