@extends( 'layouts.app' )
@section( 'title', 'Client - Data' )
@section( 'content' )
	@include('layouts.navbar')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Client Data <span class="pull-right"><a class="btn btn-primary btn-xs" href="{{ url( 'create-user' ) }}">Create Client</a></span>
					</div>
					<div class="panel-body">
						<div class="col-md-6">
							<form action="{{ url( 'client/'.$client->ID ) }}" method="post">
								{{ csrf_field() }}
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
									<input class="form-control" type="text" name="NAME" value="{{ $client->NAME }}" placeholder="Name" required="required" autocomplete="off">
								</div>
								<div class="form-group">
									<label>Surname </label>
									<input class="form-control" type="text" name="SURNAME" value="{{ $client->SURNAME }}" placeholder="Surname" autocomplete="off">
								</div>
								<div class="form-group">
									<label>Date of Birth <span class="text-danger">*</span></label>
									<input class="form-control" type="date" name="DOB" value="{{ $client->DOB }}" placeholder="Date of Birth" required="required">
								</div>
								<div class="form-group">
									<label>Email Address <span class="text-danger">*</span></label>
									<input class="form-control" type="email" name="EMAIL" value="{{ $client->EMAIL }}" placeholder="Email Address" required="required">
								</div>
								<div class="form-group">
									<label>Password <span class="text-danger">*</span></label>
									<input class="form-control" type="password" value="" name="PASSWORD" placeholder="Password" required="required" autocomplete="off">
								</div>
								<div class="form-group">
									<label>Password Conf <span class="text-danger">*</span></label>
									<input class="form-control" type="password" name="PASSWORD_CONF" placeholder="Password Conf" required="required" autocomplete="off">
								</div>
								<div class="form-group">
									<label>Phone Number <span class="text-danger">*</span></label>
									<input class="form-control" type="text" name="PHONE_NUMBER" value="{{ $client->PHONE_NUMBER }}" placeholder="Phone Number" required="required">
								</div>
								<div class="form-group">
									<label>Address <span class="text-danger">*</span></label>
									<textarea class="form-control" name="ADDRESS" maxlength="100" placeholder="Address" style="resize:none;">{{ $client->ADDRESS }}</textarea>
								</div>
								<div class="form-group">
									<label>Country <span class="text-danger">*</span></label>
									<select class="form-control" name="COUNTRY" required="required">
										<option>-</option>
										<option value="ID">Indonesia</option>
										<option value="SG">Singapore</option>
									</select>
								</div>
								<div class="form-group">
									<label>Trading Account Number </label>
									<input class="form-control" type="number" name="TRADING_ACCOUNT_NUMBER" value="{{ $client->TRADING_ACCOUNT_NUMBER }}" placeholder="Trading Account Number" autocomplete="off">
								</div>
								<div class="form-group">
									<label>Balance</label>
									<input class="form-control" type="number" name="BALANCE" value="{{ $client->BALANCE }}" placeholder="Balance" autocomplete="off">
								</div>
								<div class="row">
									<div class="col-md-6">
									</div>
									<div class="col-md-6">
										<button type="submit" class="btn btn-primary btn-block pull-right">Save</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section( 'scripts' )
	<script type="text/javascript">
		$( document).ready( function() {
		} );
	</script>
@endsection