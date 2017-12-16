@extends('layouts.app')

@section('title') Member Downlines @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>Member Account Downlines</h3>
			<hr>
			<div class="row">
				<div class="col-lg-4 col-xs-4 col-lg-offset-4">
						@if($account->status == 1)
						<div class="small-box bg-yellow">
						@else
						<div class="small-box bg-red">
						@endif
						<div class="inner">
							
							<strong>{{ $account->account_alias}}</strong>

							@if($account->status == 1)
							<p>{{ $account->account_id }}</p>
							<span>Sell Code Remaining: {{ count($account->codes->where('usage', 0)) }}</span>
							@else
							<p>Deactivated</p>
							@endif
						</div>
						<!-- <a href="#" class="small-box-footer">
							More info <i class="fa fa-arrow-circle-right"></i>
						</a> -->
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-lg-1"></div>
				<div class="col-lg-2 col-xs-4">
					@if($account->downline_1 != null)
					@if($account->downline_one->status == 1)
					<div class="small-box bg-yellow">
					@else
					<div class="small-box bg-red">
					@endif
						<div class="inner">
							<strong>{{ $downline1->account_alias }}</strong>
							
							@if($account->downline_one->status == 1)
							<p>{{ $downline1->account_id }}</p>
							@else
							<p>Deactivated</p>
							@endif

						</div>
						<a href="{{ route('member_view_account_downlines', ['account_id' => $downline1->id]) }}" class="small-box-footer">
							More info <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
					@else
					<div class="small-box bg-default">
						<div class="inner">
							<strong>No Downline 1</strong>
							<p>Slot Available</p>
						</div>
						<a href="javascript:void(0);" class="small-box-footer">
							<i class="fa fa-ban"></i>
						</a>
					</div>
					@endif
				</div>	
				<div class="col-lg-2 col-xs-4">
					@if($account->downline_2 != null)
					@if($account->downline_two->status == 1)
					<div class="small-box bg-yellow">
					@else
					<div class="small-box bg-red">
					@endif
						<div class="inner">
							<strong>{{ $downline2->account_alias }}</strong>
							
							@if($account->downline_two->status == 1)
							<p>{{ $downline2->account_id }}</p>
							@else
							<p>Deactivated</p>
							@endif
							
						</div>
						<a href="{{ route('member_view_account_downlines', ['account_id' => $downline2->id]) }}" class="small-box-footer">
							More info <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
					@else
					<div class="small-box bg-default">
						<div class="inner">
							<strong>No Downline 2</strong>
							<p>Slot Available</p>
						</div>
						<a href="javascript:void(0);" class="small-box-footer">
							<i class="fa fa-ban"></i>
						</a>
					</div>
					@endif
				</div>	
				<div class="col-lg-2 col-xs-4">
					@if($account->downline_3 != null)
					@if($account->downline_three->status == 1)
					<div class="small-box bg-yellow">
					@else
					<div class="small-box bg-red">
					@endif
						<div class="inner">
							<strong>{{ $downline3->account_alias }}</strong>
							
							@if($account->downline_three->status == 1)
							<p>{{ $downline3->account_id }}</p>
							@else
							<p>Deactivated</p>
							@endif
							
						</div>
						<a href="{{ route('member_view_account_downlines', ['account_id' => $downline3->id]) }}" class="small-box-footer">
							More info <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
					@else
					<div class="small-box bg-default">
						<div class="inner">
							<strong>No Downline 3</strong>
							<p>Slot Available</p>
						</div>
						<a href="javascript:void(0);" class="small-box-footer">
							<i class="fa fa-ban"></i>
						</a>
					</div>
					@endif
				</div>	
				<div class="col-lg-2 col-xs-4">
					@if($account->downline_4 != null)
					@if($account->downline_four->status == 1)
					<div class="small-box bg-yellow">
					@else
					<div class="small-box bg-red">
					@endif
						<div class="inner">
							<strong>{{ $downline4->account_alias }}</strong>
							
							@if($account->downline_four->status == 1)
							<p>{{ $downline4->account_id }}</p>
							@else
							<p>Deactivated</p>
							@endif
							
						</div>
						<a href="{{ route('member_view_account_downlines', ['account_id' => $downline4->id]) }}" class="small-box-footer">
							More info <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
					@else
					<div class="small-box bg-default">
						<div class="inner">
							<strong>No Downline 4</strong>
							<p>Slot Available</p>
						</div>
						<a href="javascript:void(0);" class="small-box-footer">
							<i class="fa fa-ban"></i>
						</a>
					</div>
					@endif
				</div>	
				<div class="col-lg-2 col-xs-4">
					@if($account->downline_5 != null)
					@if($account->downline_five->status == 1)
					<div class="small-box bg-yellow">
					@else
					<div class="small-box bg-red">
					@endif
						<div class="inner">
							<strong>{{ $downline5->account_alias }}</strong>
							
							@if($account->downline_five->status == 1)
							<p>{{ $downline5->account_id }}</p>
							@else
							<p>Deactivated</p>
							@endif
							
						</div>
						<a href="{{ route('member_view_account_downlines', ['account_id' => $downline5->id]) }}" class="small-box-footer">
							More info <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
					@else
					<div class="small-box bg-default">
						<div class="inner">
							<strong>No Downline 5</strong>
							<p>Slot Available</p>
						</div>
						<a href="javascript:void(0);" class="small-box-footer">
							<i class="fa fa-ban"></i>
						</a>
					</div>
					@endif
				</div>
				<div class="col-lg-1"></div>
			</div>
		</section>

	</div>

</div>
@endsection