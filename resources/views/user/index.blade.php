@extends( 'layouts.app' )
@section( 'title', 'User - Data' )
@section( 'content' )
	@include('layouts.navbar')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						User Data <span class="pull-right"><a class="btn btn-primary btn-xs" href="{{ url( 'create-user' ) }}">Create User</a></span>
					</div>
					<div class="panel-body">
						<table id="table" class="table table-striped table-bordered" style="width:100%">
							<thead>
								<tr>
									<th width="50%">EMAIL</th>
									<th width="50%">ROLE</th>
								</tr>
							</thead>
							<tbody>
								@if( !empty( $user_data ) )
									@foreach( $user_data as $user )
										<tr>
											<td>{{ $user->EMAIL }}</td>
											<td>{{ $user->ROLE_NAME }}</td>
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
			$( '#table' ).DataTable();
		} );
	</script>
@endsection