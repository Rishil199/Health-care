<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Add User Details</h5>
        <button type="button" class="close btn" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{ route('users.store') }}" method="post" class="add_user_form" id="add_user_form" autocomplete="off">
            @csrf
			    <div class="branch-panel">
			        <div class="row">
			        <div class="col-md-6">
			            <div class="form-group">
			                <label for="first_name">First Name <span class="text-danger">*</span></label>
			                <input class="form-control" id="first_name" name="first_name" type="text" placeholder="First Name" required />
			            </div>
			        </div>
			        <div class="col-md-6">
			            <div class="form-group">
			                <label for="last_name">Last Name <span class="text-danger">*</span></label>
			                <input class="form-control" id="last_name" name="last_name" type="text" placeholder="Last Name" required />
			            </div>
			        </div>
			        <div class="col-md-6">
			            <div class="form-group">
			                <label for="email">Email <span class="text-danger">*</span></label>
			                <input class="form-control" id="email" name="email" type="text" placeholder="User Email" required />
			            </div>
			        </div>
			        <div class="col-md-6 form-group mb-3">
                        <label for="picker1">Select Role</label>
                        <select class="form-control" name="roles_type">
                        	<option value="">Select Role</option>
					        @foreach($roles as $value)
					            <option value="{{ $value->id }}">{{ $value->name }}</option>
					        @endforeach
                        </select>
                    </div>
		            <div class="col-md-12 text-right">
                    	<button class="btn btn-info mt-4" id="validation-next" type="submit">Add</button>
	                </div>
			        </div>
			    </div>
        </form>
    </div>
</div>
