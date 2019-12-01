@extends( 'layouts.app' )
@section( 'title', 'Contacts - Data' )
@section( 'content' )
	<style type="text/css">
		th, td { white-space: nowrap; }
		div.dataTables_wrapper {
			width: inherit;
			margin: 0 auto;
		}
		.toolbar {
			float: left;
		}
	</style>
	@include('layouts.navbar')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Contacts Data <span class="pull-right"><a class="btn btn-primary btn-xs" href="{{ url( 'contacts/create' ) }}">Create</a></span>
					</div>
					<div class="panel-body">
						<table id="table" class="table table-striped table-bordered display nowrap" style="width:100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>FIRSTNAME</th>
									<th>LASTNAME</th>
									<th>EMAIL</th>
									<th>COUNTRY</th>
									<th>CITY</th>
									<th>ZIP CODE</th>
									<th>PHONE NUMBER</th>
									<th>GROUPS</th>
									<th>#</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" data-backdrop="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Detail</h4>
				</div>
				<div class="modal-body">
					<div style="height:190px;background-image: url({{ url( 'assets/images/default-avatar.png' ) }});background-repeat: no-repeat;background-position: center;background-size: auto 180px;"></div>
					<table class="table" width="100%">
						<tr>
							<td width="20%">Firstname</td>
							<td width="1%">:</td>
							<td width="79%"><span id="detail-FIRSTNAME"></span></td>
						</tr>
						<tr>
							<td>Lastname</td>
							<td>:</td>
							<td><span id="detail-LASTNAME"></span></td>
						</tr>
						<tr>
							<td>Email</td>
							<td>:</td>
							<td><span id="detail-EMAIL"></span></td>
						</tr>
						<tr>
							<td>Phone Number</td>
							<td>:</td>
							<td><span id="detail-PHONE_NUMBER"></span></td>
						</tr>
						<tr>
							<td>Address</td>
							<td>:</td>
							<td><span id="detail-ADDRESS"></span></td>
						</tr>
						<tr>
							<td>Country</td>
							<td>:</td>
							<td><span id="detail-COUNTRY_NAME"></span></td>
						</tr>
						<tr>
							<td>City</td>
							<td>:</td>
							<td><span id="detail-CITY_NAME"></span></td>
						</tr>
						<tr>
							<td>ZIP</td>
							<td>:</td>
							<td><span id="detail-ZIP_CODE"></span></td>
						</tr>
						<tr>
							<td>Note</td>
							<td>:</td>
							<td><textarea id="detail-NOTE" disabled="disabled" rows="5" class="form-control" style="resize: none;"></textarea></td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<a href="javascript:;" class="btn btn-default" data-dismiss="modal">Close</a>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" data-backdrop="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Delete</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure to delete this data?</p>
				</div>
				<div class="modal-footer">
					<a href="javascript:;" class="btn btn-default" data-dismiss="modal">Close</a>
					<button onclick="return delete_data();" type="button" class="btn btn-danger">Yes, delete it</button>
				</div>
			</div>
		</div>
	</div>
@endsection
@section( 'scripts' )
	<script type="text/javascript">

		function detail_data() {
			if( detail_id != '' ) {
				$.ajax( {
					url: "{{ url( 'contacts/detail/' ) }}/" + detail_id,
					type: "GET",
					headers: {
						'X-CSRF-TOKEN': '{{ csrf_token() }}'
					},
					success: function( res ) {
						if( res.status == true ) {
							$( "#detail-FIRSTNAME" ).html( res.data.FIRSTNAME );
							$( "#detail-LASTNAME" ).html( res.data.LASTNAME );
							$( "#detail-EMAIL" ).html( res.data.EMAIL );
							$( "#detail-COUNTRY_NAME" ).html( res.data.COUNTRY_NAME );
							$( "#detail-ADDRESS" ).html( res.data.ADDRESS );
							$( "#detail-PHONE_NUMBER" ).html( res.data.PHONE_NUMBER );
							$( "#detail-CITY_NAME" ).html( res.data.CITY_NAME );
							$( "#detail-ZIP_CODE" ).html( res.data.ZIP_CODE );
							$( "#detail-NOTE" ).html( res.data.NOTE );
						}
						else {
							alert( "Something is wrong in delete process.." )
						}
					},
					error: function() {
						console.log( "Error" );
					}
				} );
			}
		}

		function delete_data() {
			if( delete_id != '' ) {
				$.ajax( {
					url: "{{ url( 'contacts/delete' ) }}",
					type: "POST",
					data: "ID=" + delete_id,
					headers: {
						'X-CSRF-TOKEN': '{{ csrf_token() }}'
					},
					success: function( res ) {
						if( res.status == true ) {
							$( '#table' ).DataTable().ajax.reload();
							$( "#modal-delete .close" ).click()
						}
						else {
							alert( "Something is wrong in delete process.." )
						}
					},
					error: function() {
						console.log( "Error" );
					}
				} );
			}
		}

		function set_delete_id( id ) {
			delete_id = id;
		}

		function set_detail_id( id ) {
			$( "#detail-FIRSTNAME" ).html( '' );
			$( "#detail-LASTNAME" ).html( '' );
			$( "#detail-EMAIL" ).html( '' );
			$( "#detail-ADDRESS" ).html( '' );
			$( "#detail-COUNTRY_NAME" ).html( '' );
			$( "#detail-PHONE_NUMBER" ).html( '' );
			$( "#detail-CITY_NAME" ).html( '' );
			$( "#detail-ZIP_CODE" ).html( '' );
			$( "#detail-NOTE" ).html( '' );
			detail_id = id;
			detail_data();
		}

		$( document).ready( function() {
			var delete_id = '';
			var detail_id = '';
			$( '#table' ).DataTable( {
				"processing": true,
				"serverSide": true,
				"scrollX": true,
				"bSort" : false,
				"dom": '<"toolbar">frtip',
				"fixedColumns":   {
					leftColumns: 1,
					rightColumns: 1
				},
				"ajax": {
					type: 'post',
					url: '{{ url( 'contacts/data' ) }}?group=',
					headers: {
						'X-CSRF-TOKEN': '{{ csrf_token() }}'
					}
				},
				"columns": [
					{ data: 'ID', name: 'ID' },
					{ data: 'FIRSTNAME', name: 'FIRSTNAME' },
					{ data: 'LASTNAME', name: 'LASTNAME' },
					{ data: 'EMAIL', name: 'EMAIL' },
					{ data: 'COUNTRY_NAME', name: 'COUNTRY_NAME' },
					{ data: 'CITY_NAME', name: 'CITY_NAME' },
					{ data: 'ZIP_CODE', name: 'ZIP_CODE' },
					{ data: 'PHONE_NUMBER', name: 'PHONE_NUMBER' },
					{ data: 'GROUPS', name: 'GROUPS' },
					{ 
						data: null, 
						render: function ( data, type, row ) {
							return '<a class="btn btn-default btn-xs" href="{{ url( 'contacts/edit' ) }}/' + data.ID + '">' + 'Edit</a> <a onclick="return set_detail_id(' + data.ID + ');" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-detail" href="javascript:;">' + 'View</a> <a onclick="return set_delete_id(' + data.ID + ');" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-delete" href="javascript:;">' + 'Delete</a>';
						} 
					}
				]
			} );
			$( ".dataTables_length select" ).addClass( "select2-datatable" );
			$( "div.toolbar" ).html( 
				'Groups: ' +  
				'<select onchange="return set_url();" id="group-selection" class="form-control select2-datatable">' +  
				'<option>-</option>' + 
				@if( !empty( $group_data ) )
					@foreach( $group_data as $group )
						'<option value="{{ $group->NAME }}">{{ $group->NAME }}</option>' + 
					@endforeach
				@endif
				'</select>' 
			);
			$( ".select2-datatable" ).select2( {
				theme: "bootstrap",
				containerCssClass: ':all:'
			} );
		} );
		function set_url( ) {
			$('#table').DataTable().ajax.url( '{{ url( 'contacts/data' ) }}?group=' + $( "#group-selection" ).val() ).load();
		}
	</script>
@endsection
