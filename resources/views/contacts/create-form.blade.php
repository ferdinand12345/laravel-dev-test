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
						@if( $create_status == true )
							<div class="alert alert-info">
								Success!
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
						<form action="{{ url( 'contacts/create' ) }}" method="post" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="row">
								<div class="col-md-4"></div>
								<div class="col-md-4">
									<div class="panel panel-primary">
										<div class="panel-body">
											<div id="image-preview" style="height:190px;background-image: url({{ url( 'assets/images/default-avatar.png' ) }});background-repeat: no-repeat;background-position: center;background-size: auto 180px;">
											</div>
										</div>
									</div>
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-md-4">
									<label>Firstname</label>
									<input type="text" class="form-control" value="" name="FIRSTNAME" placeholder="Firstname" required="required">
								</div>
								<div class="col-md-4">
									<label>Lastname</label>
									<input type="text" class="form-control" value="" placeholder="Lastname" name="LASTNAME">
								</div>
								<div class="col-md-4">
									<label>Avatar</label>
									<input type="file" class="form-control" id="image-upload" name="AVATAR">
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-md-4">
									<label>Email</label>
									<input type="email" class="form-control" value="" name="EMAIL" placeholder="Email" required="required">
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-md-12">
									<label>Address</label>
									<textarea class="form-control" name="ADDRESS" rows="2" placeholder="Address" style="resize: none;"></textarea>
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-md-4">
									<label>Country</label>
									<select class="form-control select2-country" name="COUNTRY_ID" required="required">
										@if( !empty( $country_data ) )
											@foreach( $country_data as $country )
												<option value="{{ $country->ID }}">{{ $country->NAME }}</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="col-md-4">
									<label>City</label>
									<input type="text" class="form-control" value="" name="CITY_NAME" placeholder="City" required="required">
								</div>
								<div class="col-md-4">
									<label>ZIP</label>
									<input type="text" class="form-control" value="" name="ZIP_CODE" placeholder="ZIP" required="">
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-md-4">
									<label>Phone Number</label>
									<input type="text" class="form-control" value="" name="PHONE_NUMBER" placeholder="Phone Number" required="required">
								</div>
								<div class="col-md-8">
									<label>Groups</label>
									<select name="GROUPS[]" class="select2-tags form-control" multiple="multiple"></select>
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-md-12">
									<label>Note</label>
									<textarea class="form-control" name="NOTE" rows="7" placeholder="Note" style="resize: none;"></textarea>
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-md-12">
									<input type="submit" class="btn btn-primary pull-right">
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
		function read_upload_url( input ) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function( e ) {
					$( '#image-preview' ).css( 'background-image', 'url('+ e.target.result +')' );
					$( '#image-preview' ).hide();
					$( '#image-preview' ).fadeIn( 2000 );
				}
				reader.readAsDataURL(input.files[0]);
			}
		}

		$( document).ready( function() {
			$( ".select2-country" ).select2( {
				theme: "bootstrap",
				placeholder: "Select a State",
				maximumSelectionSize: 6,
				containerCssClass: ':all:'
			} );
			$( "#image-upload" ).change(function() {
				read_upload_url(this);
			});
			$( ".select2-tags" ).select2( {
				tags: true,
				tokenSeparators: [',', ' ']
			} )
		} );
	</script>
@endsection