<div class="modal-content">
    <div class="modal-header">
        <div 
        class="title">
        <strong>
            {{$clinic->user->first_name ?? 'user not found'}}  {{$clinic->user->name ?? 'user not found'}} - Add Branch Details
        </strong>
        </div>
    </div>
    <div class="modal-body">
        <form action="{{ route('clinics.store') }}" method="post" class="add_branch_form" id="add_branch_form" autocomplete="off" name="Branch"> 
            @csrf
            <input type="hidden" name="clinic_id" value={{ $id }} />
            <div class="row">
                @include('admin.clinics.branch', ['modal_view' => true])
                <div class="modal-footer justify-content-center">
                    <button class="btn btn-back" id="validation-next" type="submit" value="Add"> <i class="lni lni-save"></i>
                        Save 
                    </button>
                    <button  type="button" class="btn btn-outline-dark mt-0  mx-3" data-bs-dismiss="modal">  
                        Cancel 
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
