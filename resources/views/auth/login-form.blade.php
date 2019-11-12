@extends( 'layouts.app' )
@section( 'title', 'Login' )
@section( 'content' )
	<div class="container">
		<div class="row" style="margin-top:40px;">
			<div class="col-md-6">
				<h1 class="text-center">Client Portal App</h1>
			</div>
			<div class="col-md-6">
				<form action="{{ url( 'login' ) }}" method="post">
					{{ csrf_field() }}
					<div class="panel panel-default">
						<div class="panel-heading">Register</div>
						<div class="panel-body">
							<div class="form-group">
								<label>Email Address <span class="text-danger">*</span></label>
								<input class="form-control" type="email" name="EMAIL" value="ferdshinodas@gmail.com" placeholder="Email Address">
							</div>
							<div class="form-group">
								<label>Password <span class="text-danger">*</span></label>
								<input class="form-control" type="password" name="PASSWORD" value="123456" placeholder="Password">
							</div>
							<div class="row">
								<div class="col-md-6">
									Don't have an account? <a href="{{ url( 'register' ) }}">Register</a>.
								</div>
								<div class="col-md-6">
									<button type="submit" class="btn btn-primary btn-block pull-right">Login</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection