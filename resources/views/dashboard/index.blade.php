@extends( 'layouts.app' )
@section( 'title', 'Dashboard' )
@section( 'content' )
	@include('layouts.navbar')
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">Account Info</div>
					<div class="panel-body">
						@if ( isset( $userdata ) )
						<div class="form-group">
							<label>Name <span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="NAME" value="{{ $userdata->NAME }}" placeholder="Name" disabled>
						</div>
						<div class="form-group">
							<label>Surname <span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="SURNAME" value="{{ $userdata->SURNAME }}" placeholder="Surname" disabled>
						</div>
						<div class="form-group">
							<label>Date of Birth <span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="DOB" value="{{ $userdata->DOB }}" placeholder="Date of Birth" disabled>
						</div>
						<div class="form-group">
							<label>Email Address <span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="EMAIL" value="{{ $userdata->EMAIL }}" placeholder="Email Address" disabled>
						</div>
						<div class="form-group">
							<label>Phone Number <span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="PHONE_NUMBER" value="{{ $userdata->PHONE_NUMBER }}" placeholder="Phone Number" disabled>
						</div>
						<div class="form-group">
							<label>Address <span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="ADDRESS" value="{{ $userdata->ADDRESS }}" placeholder="Address" disabled>
						</div>
						<div class="form-group">
							<label>Country <span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="COUNTRY" value="{{ $userdata->COUNTRY }}" placeholder="Country" disabled>
						</div>
						<div class="form-group">
							<label>Trading Account Number <span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="TRADING_ACCOUNT_NUMBER" value="{{ $userdata->TRADING_ACCOUNT_NUMBER }}" placeholder="Trading Account Number" disabled>
						</div>
						<div class="form-group">
							<label>Balance <span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="BALANCE" value="{{ $userdata->BALANCE }}" placeholder="Balance" disabled>
						</div>
						<div class="form-group">
							<label>Open Trades <span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="OPEN_TRADES" value="{{ $userdata->OPEN_TRADES }}" placeholder="Open Trades" disabled>
						</div>
						<div class="form-group">
							<label>Close Trades <span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="CLOSE_TRADES" value="{{ $userdata->CLOSE_TRADES }}" placeholder="Close Trades" disabled>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection