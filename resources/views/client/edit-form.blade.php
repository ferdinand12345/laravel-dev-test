@extends( 'layouts.app' )
@section( 'title', 'Client - Data' )
@section( 'content' )
	@include('layouts.navbar')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Client Data
					</div>
					<div class="panel-body">
						<div class="col-md-6">
							@if ( $save_status == true )
								<div class="alert alert-info">
									Client has been updated.
								</div>
							@endif
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
									<input id="datepicker" width="270" class="form-control" type="date" name="DOB" value="{{ $client->DOB }}" placeholder="Date of Birth" required="required">
									<small class="form-text text-muted">2000-12-31</small>
								</div>
								<div class="form-group">
									<label>Email Address <span class="text-danger">*</span></label>
									<input class="form-control" type="email" name="EMAIL" value="{{ $client->EMAIL }}" placeholder="Email Address" required="required">
								</div>
								<div class="form-group">
									<label>Password</label>
									<input class="form-control" type="password" value="" name="PASSWORD" placeholder="Password" autocomplete="off">
									<small class="form-text text-muted">Minimum 6 digits.</small>
								</div>
								<div class="form-group">
									<label>Password Conf</label>
									<input class="form-control" type="password" name="PASSWORD_CONF" placeholder="Password Conf" autocomplete="off">
									<small class="form-text text-muted">Minimum 6 digits.</small>
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
										@foreach( $country_data as $country )
											@php
												$selected = ( $country['CODE'] == $client->COUNTRY ? ' selected' : '' )
											@endphp
											<option value="{{ $country['CODE'] }}"{{ $selected }}>{{ $country['NAME'] }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>Trading Account Number </label>
									<input class="form-control" type="text" name="TRADING_ACCOUNT_NUMBER" value="{{ $client->TRADING_ACCOUNT_NUMBER }}" placeholder="Trading Account Number" autocomplete="off">
								</div>
								<div class="form-group">
									<label>Balance</label>
									<input class="form-control" type="text" name="BALANCE" value="{{ $client->BALANCE }}" placeholder="Balance" autocomplete="off">
									<small class="form-text text-muted">Decimal value.</small>
								</div>
								<div class="form-group">
									<label>Open Trades</label>
									<input class="form-control" type="text" name="OPEN_TRADES" value="{{ $client->OPEN_TRADES }}" placeholder="Open Trades" autocomplete="off">
									<small class="form-text text-muted">Decimal value.</small>
								</div>
								<div class="form-group">
									<label>Close Trades</label>
									<input class="form-control" type="text" name="CLOSE_TRADES" value="{{ $client->CLOSE_TRADES }}" placeholder="Close Trades" autocomplete="off">
									<small class="form-text text-muted">Decimal value.</small>
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
			$( '#datepicker' ).datepicker( {
				format: 'yyyy-mm-dd',
				value: '2000-12-31',
				maxDate: '2000-12-31',
				uiLibrary: 'bootstrap'
			} );
		} );
	</script>
@endsection