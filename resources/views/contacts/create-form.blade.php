@extends( 'layouts.app' )
@section( 'title', 'Contacts - Create' )
@section( 'content' )
	@include('layouts.navbar')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Create <span class="pull-right"><a class="btn btn-primary btn-xs" href="{{ url( 'contacts' ) }}">Back</a></span>
					</div>
					<div class="panel-body">
						<form action="{{ url( 'contacts/create' ) }}" method="post">
							{{ csrf_field() }}
							<div class="row">
								<div class="col-md-4">
									<label>Firstname</label>
									<input type="text" class="form-control" value="Ferd" name="FIRSTNAME" placeholder="Firstname" required="required">
								</div>
								<div class="col-md-4">
									<label>Lastname</label>
									<input type="text" class="form-control" value="Shinoda" placeholder="Lastname" name="LASTNAME">
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-md-4">
									<label>Email</label>
									<input type="email" class="form-control" value="ferdshinodas@gmail.com" name="EMAIL" placeholder="Email" required="required">
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-md-12">
									<label>Address</label>
									<textarea class="form-control" name="ADDRESS" rows="2" placeholder="Address" style="resize: none;">Jl.XXX No.4</textarea>
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-md-4">
									<label>Country</label>
									<select class="form-control select2-country" name="COUNTRY_ID" required="required">
										<option>-</option>
										@if( !empty( $country_data ) )
											@foreach( $country_data as $country )
												<option value="{{ $country->ID }}">{{ $country->NAME }}</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="col-md-4">
									<label>City</label>
									<input type="text" class="form-control" value="Jakarta" name="CITY_NAME" placeholder="City" required="required">
								</div>
								<div class="col-md-4">
									<label>ZIP</label>
									<input type="text" class="form-control" value="12345" name="ZIP_CODE" placeholder="ZIP" required="">
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-md-4">
									<label>Phone Number</label>
									<input type="text" class="form-control" value="089514512776" name="PHONE_NUMBER" placeholder="Phone Number" required="required">
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-md-12">
									<label>Note</label>
									<textarea class="form-control" name="NOTE" rows="7" placeholder="Address" style="resize: none;">Aku masih disini, menunggumu kembali.</textarea>
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-md-12">
									<input type="submit" class="btn btn-primary pull-right" name="SUBMIT">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section( 'scripts' )
	<script type="text/javascript">
		$( document).ready( function() {
			$( ".select2-country" ).select2( {
				theme: "bootstrap",
				placeholder: "Select a State",
				maximumSelectionSize: 6,
				containerCssClass: ':all:'
			} );

		} );
	</script>
@endsection