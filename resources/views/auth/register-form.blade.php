@extends( 'layouts.app' )
@section( 'title', 'Register' )
@section( 'content' )
	<div class="container">
		<div class="row" style="margin-top:40px;">
			<div class="col-md-6">
				<h1 class="text-center">Client Portal App</h1>
			</div>
			<div class="col-md-6">
				<form action="{{ url( 'register' ) }}" method="post">
					{{ csrf_field() }}
					<div class="panel panel-default">
						<div class="panel-heading">Register</div>
						<div class="panel-body">
							@if ( $errors->any() )
								<div class="alert alert-danger">
									<ul>
										@foreach ( $errors->all() as $error )
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif
							<div class="form-group">
								<label>Name <span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="NAME" value="" placeholder="Name" required="required" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Surname </label>
								<input class="form-control" type="text" name="SURNAME" placeholder="Surname" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Date of Birth <span class="text-danger">*</span></label>
								<input class="form-control" type="date" name="DOB" placeholder="Date of Birth" required="required">
							</div>
							<div class="form-group">
								<label>Email Address <span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="EMAIL" placeholder="Email Address" required="required">
							</div>
							<div class="form-group">
								<label>Password <span class="text-danger">*</span></label>
								<input class="form-control" type="password" name="PASSWORD" placeholder="Password" required="required" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Password Conf <span class="text-danger">*</span></label>
								<input class="form-control" type="password" name="PASSWORD_CONF" placeholder="Password Conf" required="required" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Phone Number <span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="PHONE_NUMBER" value="+6289514512776" placeholder="Phone Number" required="required">
							</div>
							<div class="row">
								<div class="col-md-6">
									Have an account? <a href="{{ url( 'login' ) }}">Log in</a>.
								</div>
								<div class="col-md-6">
									<button type="submit" class="btn btn-primary btn-block pull-right">Register</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection