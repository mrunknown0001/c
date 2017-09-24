@if(session('error_msg'))
	<div class="alert alert-danger text-center top-space">
		<a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<b>{{ session('error_msg') }}</b>
	</div>
@endif