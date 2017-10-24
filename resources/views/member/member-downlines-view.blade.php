@extends('layouts.app')

@section('title') Member Downlines @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>Member Downlines</h3>
			<hr>
			<div class="row">
	
				<div class="col-lg-2 col-xs-4">
				<!-- small box -->
					<div class="small-box bg-aqua">
						<div class="inner">
							<h3>150</h3>
							<p>New Orders</p>
						</div>
						<a href="#" class="small-box-footer">
							More info <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
			</div>
		</section>

	</div>

</div>
@endsection