@extends('layouts.frontend')

@section('content')
	<div class="auth">
		<h1 class="title">@lang('auth.pass_recovery')</h1>
		<div class="auth__card">
			@if (session('status'))
				<div class="alert alert-success" role="alert">
					{{ session('status') }}
				</div>
			@endif
			<form method="POST" action="{{ route('password.email') }}">
				@csrf
				<div class="form-group">
					<input name="email" type="text" class="input{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}">
					<label class="label">Email*</label>
					@if ($errors->has('email'))
						<span class="text-danger" role="alert">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif
				</div>
				<button type="submit" class="btn btn--brand full-width">@lang('auth.do_pass_recovery')</button>
			</form>
		</div>	<!-- /.auth__card -->
		<p><a href="{{ route('login') }}" class="link text"><i class="icon-arrow-left text-sm mr-sm"></i>@lang('auth.back')</a></p>
	</div>	<!-- /.auth -->
@endsection


@section('scripts')
    <script src="{{ asset('assets/tmp/js/signup.js') }}"></script>
    <script src="{{ asset('assets/tmp/js/signin.js') }}"></script>
@endsection