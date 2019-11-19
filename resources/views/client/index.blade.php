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
						<table id="example" class="table table-striped table-bordered" style="width:100%">
							<thead>
								<tr>
									<th>Name</th>
									<th>Position</th>
									<th>Office</th>
									<th>Age</th>
									<th>Start date</th>
									<th>Salary</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Tiger Nixon</td>
									<td>System Architect</td>
									<td>Edinburgh</td>
									<td>61</td>
									<td>2011/04/25</td>
									<td>$320,800</td>
								</tr>
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
			$('#example').DataTable();
		} );
	</script>
@endsection