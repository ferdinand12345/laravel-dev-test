@extends( 'layouts.app' )
@section( 'title', 'User - Create' )
@section( 'content' )
	@include('layouts.navbar')
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">Create User</div>
					<div class="panel-body">
						@if ( $create_status == true )
							<div class="alert alert-info">
								User has been created.
							</div>
						@endif
						@if ( $errors->any() )
							<div class="alert alert-danger">
								<ul>
									@foreach ( $errors->all() as $error )
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
						<form action="{{ url( 'create-user' ) }}" method="post">
							{{ csrf_field() }}
							<div class="form-group">
								<label>Role <span class="text-danger">*</span></label>
								<select class="form-control" name="ROLE_ID" required="required">
									<option value="">-</option>
									@foreach( $role_data as $role )
										<option value="{{ $role->ID }}">{{ $role->NAME }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label>Email Address <span class="text-danger">*</span></label>
								<input class="form-control" type="email" name="EMAIL" value="kucing@gmail.com" placeholder="Email Address" autocomplete="off" required="required">
							</div>
							<div class="form-group">
								<label>Password <span class="text-danger">*</span></label>
								<input class="form-control" type="password" name="PASSWORD" value="1234567890" placeholder="Password" autocomplete="off" required="required">
							</div>
							<div class="form-group">
								<label>Password Conf<span class="text-danger">*</span></label>
								<input class="form-control" type="password" name="PASSWORD_CONF" value="1234567890" placeholder="Password" autocomplete="off" required="required">
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary pull-right">Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection