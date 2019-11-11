@extends( 'layouts.app' )
@section( 'title', 'Page Title' )
@section( 'content' )
	<div class="container">
		<div class="row" style="margin-top:40px;">
			<div class="col-md-6">
				<!-- <h1 class="text-center">Client Portal App</h1> -->
			</div>
			<div class="col-md-6">
				<form action="{{ url( 'register' ) }}" method="post">
					<div class="panel panel-default">
						<!-- <div class="panel-heading">Register</div> -->
						<div class="panel-body">
							<!--div class="form-group">
								<label>Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="name" placeholder="Name">
							</div>
							<div class="form-group">
								<label>Surname <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="surname" placeholder="Surname">
							</div>
							<div class="form-group">
								<label>Date of Birth <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="dob" placeholder="Date of Birth">
							</div-->
							{{ csrf_field() }}
							<input type="hidden" name="NAME" value="Ferdinand">
							<input type="hidden" name="SURNAME" value="Ferdinand">
							<input type="hidden" name="DOB" value="1993-11-26">
							<input type="hidden" name="EMAIL" value="ferdshinodas@gmail.com">
							<input type="hidden" name="PHONE_NUMBER" value="+6289514512776">
							<input type="hidden" name="PASSWORD" value="123456">
							<input type="submit" name="submit">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection