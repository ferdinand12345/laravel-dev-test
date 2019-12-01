@extends( 'layouts.app' )
@section( 'title', 'Contacts - Data' )
@section( 'content' )
	<style type="text/css">
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
@endsection
@section( 'scripts' )
	<script type="text/javascript">

		$( document).ready( function() {
			const data_group = '';
			$( '#table' ).DataTable( {
				"processing": true,
				"serverSide": true,
				"scrollX": true,
				"dom": '<"toolbar">frtip',
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
							return '<a class="btn btn-default btn-xs" href="{{ url( 'contacts/edit' ) }}/' + data.ID + '">' + 'Edit</a> <a class="btn btn-default btn-xs" href="{{ url( 'contacts/edit' ) }}/' + data.ID + '">' + 'View</a> <a class="btn btn-default btn-xs" href="{{ url( 'contacts/edit' ) }}/' + data.ID + '">' + 'Delete</a>';
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
