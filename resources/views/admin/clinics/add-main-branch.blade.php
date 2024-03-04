<div class="modal-content">
    <div class="modal-header">
        <div 
        class="title">
        <strong>
            Add Main Branch
        </strong>
        </div>
    </div>
    <div class="modal-body">
        <form action="{{ route('clinics.store') }}" method="post" class="add_branch_form" id="add_branch_form" autocomplete="off">
            @csrf
            <div class="row">
                @include('admin.clinics.branch', ['modal_view' => true])
                {{-- <div class="col-md-6 mb-3">
                    <div class="form-group theme-form-group">
                        <div class="form-label label-title d-block">
                            <label for="status" class="theme-label">Branch  <span class="text-danger">*</span></label>
                        </div>
                        <div class="input-wrapper d-flex">
                            <div class="input-block">
                                <input name="branch_type[]" type="radio" value="1" id="mainBranch" checked>
                                <label for="mainBranch" class="theme-label">Main Branch</label>
                            </div>
                            <div class="input-block ml-3">
                                <input name="branch_type[]" type="radio" value="0" id="subBranch" disabled='disabled'>
                                <label for="subBranch" class="theme-label">Sub Branch</label>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="modal-footer justify-content-center">
                    <button class="btn btn-back" id="validation-next" type="submit" value="Add"> <i class="lni lni-save"></i>
                        Save 
                    </button>
                    <button  type="button" class="btn btn-outline-dark mx-3" data-bs-dismiss="modal">   
                        Cancel 
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
