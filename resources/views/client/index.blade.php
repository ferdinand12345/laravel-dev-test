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
						<table id="table" class="table table-striped table-bordered" style="width:100%">
							<thead>
								<tr>
									<th>NAME</th>
									<th>SURNAME</th>
									<th>DOB</th>
									<th>EMAIL</th>
									<th>ACTION</th>
								</tr>
							</thead>
							<tbody>
								@if( !empty( $client_data ) )
									@foreach( $client_data as $client )
										<tr>
											<td>{{ $client->NAME }}</td>
											<td>{{ $client->SURNAME }}</td>
											<td>{{ $client->DOB }}</td>
											<td>{{ $client->EMAIL }}</td>
											<td>
												<a class="btn btn-primary btn-xs" href="{{ url( 'client/'.$client->ID ) }}">View / Edit</a> 
											</td>
										</tr>
									@endforeach
								@endif
							</tbody>
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
			$('#table').DataTable();
		} );
	</script>
@endsection