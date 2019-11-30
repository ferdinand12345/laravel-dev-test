@extends( 'layouts.app' )
@section( 'title', 'Contacts - Data' )
@section( 'content' )
	@include('layouts.navbar')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Contacts Data <span class="pull-right"><a class="btn btn-primary btn-xs" href="{{ url( 'contacts/create' ) }}">Create</a></span>
					</div>
					<div class="panel-body">
						<table id="table" class="table table-striped table-bordered" style="width:100%">
							<thead>
								<tr>
									<th width="25%">FIRSTNAME</th>
									<th width="25%">LASTNAME</th>
									<th width="15%">COUNTRY</th>
									<th width="25%">EMAIL</th>
									<th width="10%">#</th>
								</tr>
							</thead>
							<tbody>
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