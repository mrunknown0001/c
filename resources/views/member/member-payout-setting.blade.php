@extends('layouts.app')

@section('title') Member Payout Setting @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>Current Payout Setting:: 
			@if(count($default) == 0)
			<i><u>Payout Not Set</u></i>
			@else
			{{ $default->mop }}
			@endif
			</h3>
			<hr>
			<div class="row">
				<div class="col-md-6">
					@include('includes.all')
					{{-- date('F d, Y h:i a') --}}
					<form action="{{ route('post_update_member_default_payout') }}" method="POST" autocomplete="off">
						<div class="form-group">
							<select name="mode_of_payout" id="mop" class="form-control">
								<option value="">Select Mode of Payout</option>
								@foreach($options as $opt)
								<option value="{{ $opt->name }}" @if($default->mop == $opt->name) selected @endif>{{ strtoupper($opt->name) }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<input type="text" name="name" id="name" class="form-control text-capitalize" value="{{ $default->name }}" placeholder="Full Name" />
						</div>
						<div class="form-group">
							<input type="text" name="bank" id="bank" class="form-control text-capitalize" value="{{ $default->bank }}" placeholder="Bank" />
						</div>
						<div class="form-group">
							<input type="text" name="account_number" id="account_number" class="form-control" value="{{ $default->bank_account }}" placeholder="Account Number" />
						</div>
						<div class="form-group">
							<input type="text" name="contact_number" id="contact_number" class="form-control" value="{{ $default->contact_number }}" placeholder="Contact Number" />
						</div>
						<div class="form-group">
							<input type="text" name="wallet_address" id="wallet_address" class="form-control" value="{{ $default->wallet_address }}" placeholder="Wallet Address" />
						</div>

						<div class="form-group">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<button class="btn btn-primary">Update Payout Details</button>
						</div>

					</form>
				</div>
			</div>
		</section>	
	</div>

</div>
<script type="text/javascript">
	window.onload = function() {
		$('#name').prop('readonly', true);
		$('#bank').prop('readonly', true);
		$('#account_number').prop('readonly', true);
		$('#contact_number').prop('readonly', true);
		$('#wallet_address').prop('readonly', true);

		if($('#mop').val() == 'Bank Deposit') {
			$('#name').removeAttr('readonly');
			$('#bank').removeAttr('readonly');
			$('#account_number').removeAttr('readonly');

			$('#name').prop('required', true);
			$('#bank').prop('required', true);
			$('#account_number').prop('required', true);
		}
		else if($('#mop').val() == 'Cebuana') {
			$('#name').removeAttr('readonly');
			$('#contact_number').removeAttr('readonly');

			$('#name').prop('required', true);
			$('#contact_number').prop('required', true);
		}
		else if($('#mop').val() == 'Coins.Ph') {
			$('#wallet_address').removeAttr('readonly');

			$('#wallet_address').prop('required', true);
		}
		else if($('#mop').val() == 'Security Bank eCash') {
			$('#contact_number').removeAttr('readonly');

			$('#contact_number').prop('required', true);
		}

		$('#mop').change(function () {
			if($('#mop').val() == 'Bank Deposit') {
				$('#name').removeAttr('readonly');
				$('#bank').removeAttr('readonly');
				$('#account_number').removeAttr('readonly');

				$('#name').prop('required', true);
				$('#bank').prop('required', true);
				$('#account_number').prop('required', true);

				$('#contact_number').prop('readonly', true);
				$('#contact_number').prop('value', '');
				$('#wallet_address').prop('readonly', true);
				$('#wallet_address').prop('value', '');
			}
			else if($('#mop').val() == 'Cebuana') {
				$('#name').removeAttr('readonly');
				$('#contact_number').removeAttr('readonly');

				$('#name').prop('required', true);
				$('#contact_number').prop('required', true);

				$('#bank').prop('readonly', true);
				$('#bank').prop('value', '');
				$('#account_number').prop('readonly', true);
				$('#account_number').prop('value', '');
				$('#wallet_address').prop('readonly', true);
				$('#wallet_address').prop('value', '');
			}
			else if($('#mop').val() == 'Coins.Ph') {
				$('#wallet_address').removeAttr('readonly');

				$('#wallet_address').prop('required', true);

				$('#name').prop('readonly', true);
				$('#name').prop('value', '');
				$('#bank').prop('readonly', true);
				$('#bank').prop('value', '');
				$('#account_number').prop('readonly', true);
				$('#account_number').prop('value', '');
				$('#contact_number').prop('readonly', true);
				$('#contact_number').prop('value', '');

			}
			else if($('#mop').val() == 'Security Bank eCash') {
				$('#contact_number').removeAttr('readonly');
				$('#name').removeAttr('readonly');

				$('#contact_number').prop('required', true);
				$('#name').prop('required', true);

				$('#bank').prop('readonly', true);
				$('#bank').prop('value', '');
				$('#account_number').prop('readonly', true);
				$('#account_number').prop('value', '');
				$('#wallet_address').prop('readonly', true);
				$('#wallet_address').prop('value', '');
			}
		});
	}

</script>
@endsection