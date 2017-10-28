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
					<div class="small-box bg-yellow">
						<div class="inner">
							<strong>{{ $account->account_alias}}</strong>
							<p>{{ $account->account_id }}</p>
							<span>Sell Code Remaining: {{ $account->codes->where('usage', 0)->count() * 5 }}</span>
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
					<div class="small-box bg-yellow">
						<div class="inner">
							<strong>{{ $account->downline_1 }}</strong>
							<p>Account</p>
						</div>
						<a href="#" class="small-box-footer">
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
					<div class="small-box bg-yellow">
						<div class="inner">
							<strong>Account</strong>
							<p>Account</p>
						</div>
						<a href="#" class="small-box-footer">
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
					<div class="small-box bg-yellow">
						<div class="inner">
							<strong>Account</strong>
							<p>Account</p>
						</div>
						<a href="#" class="small-box-footer">
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
					<div class="small-box bg-yellow">
						<div class="inner">
							<strong>Account</strong>
							<p>Account</p>
						</div>
						<a href="#" class="small-box-footer">
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
					<div class="small-box bg-yellow">
						<div class="inner">
							<strong>Account</strong>
							<p>Account</p>
						</div>
						<a href="#" class="small-box-footer">
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