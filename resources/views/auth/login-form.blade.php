@extends( 'layouts.app' )
@section( 'title', 'Login' )
@section( 'content' )
	<div class="container">
		<div class="row" style="margin-top:40px;">
			<div class="col-md-6">
				<h1 class="text-center">Back Office App</h1>
			</div>
			<div class="col-md-6">
				<form action="{{ url( 'login' ) }}" method="post">
					{{ csrf_field() }}
					<div class="panel panel-default">
						<div class="panel-heading">Login</div>
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
								<label>Email Address <span class="text-danger">*</span></label>
								<input class="form-control" type="email" name="EMAIL" placeholder="Email Address" required="required">
							</div>
							<div class="form-group">
								<label>Password <span class="text-danger">*</span></label>
								<input class="form-control" type="password" name="PASSWORD" placeholder="Password" autocomplete="off" required="required">
							</div>
							<div class="row">
								<div class="col-md-12">
									<table class="table table-bordered" style="font-size:10px;">
										<tr>
											<td>Email Admin</td>
											<td>admin@email.com</td>
										</tr>
										<tr>
											<td>Password Admin</td>
											<td>1234567890</td>
										</tr>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
								</div>
								<div class="col-md-6">
									<input type="submit" class="btn btn-primary btn-block pull-right" value="Login">
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection