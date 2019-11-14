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
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection