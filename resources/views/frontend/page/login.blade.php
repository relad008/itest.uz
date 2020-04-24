@extends('layouts.frontend')

@section('content')
	<div class="auth">
		<h1 class="title">@lang('auth.enter')</h1>
		{!! Form::open([
			'action' => 'Auth\LoginController@handle',
			'class' => 'js-signin-form'
		]) !!}
			<div class="auth__card">
				@foreach($errors->all() as $key => $message)
					<div class="text-danger js-login-errors mb-lg" style="font-size:13px">
                        {{ $message }}
						@if ($errors->has('verified'))
						<u><a href="{{ action('Auth\RegisterController@resendVerifyMail', [
							'email' => old('login')
						]) }}" class="mb-lg">отправить заново</a></u>
						@endif
					</div>
                @endforeach
				@if (session('status'))
					<div class="alert alert-success mb-lg p-sm">
						{{ session('status') }}
					</div>
				@endif
				@if (session('warning'))
					<div class="alert alert-warning mb-lg p-sm">
						{{ session('warning') }}
					</div>
				@endif
				<small class="text-danger js-login-errors mb-lg"></small>
				<div class="form-group">
					<!-- <input type="text" class="input js-signin-phone" data-mask="+999(99)999-99-99" id="signin_phone" required>
					<label class="label">@lang('auth.phone')</label> -->
					<input type="text" name="login" class="input" value="{{ old('login') }}">
					<label class="label">Email или номер телефона</label>
				</div>
				<div class="form-group mb-lg">
					<input type="password" name="password" class="input js-signin-password js-password-input" id="signin_password" required>
					<label class="label">@lang('auth.password')</label>
					<i class="icon-eye-closed form-group__eye-icon js-show-password" id="signin_password"></i>
				</div>
				<div class="form-group mb-lg text-left">
					<label class="checkbox">
						<input type="checkbox" name="remember" value="1">
						<span>@lang('auth.remember')</span>
					</label>
				</div>
				<button type="submit" class="btn btn--brand full-width">@lang('auth.login')</button>
			</div>	<!-- /.auth__card -->
		</form>
		<p class="mb-md"><a href="{{ action('Frontend\PageController@passRecovery') }}" class="link text">@lang('auth.cant_login')</a></p>
		<p><a href="{{ url('/register') }}" class="link text-lg">@lang('auth.not_reg_yet')</a></p>
	</div>	<!-- /.auth -->
@endsection

@section('scripts')
	<script src="{{ asset('assets/tmp/js/signin.js?v=noAjax') }}"></script>
	<script src="{{ asset('assets/tmp/js/signup.js?v=noAjax') }}"></script>
	<script type="text/javascript">
		// show/hide password
		var openEyeClass = 'form-group__eye-icon--open',
			passwordInput = doc.getElementsByClassName('js-password-input')[0];

        new SignIn({
            auth_url: "{{ route('login') }}"
        }).init();

		doc.getElementsByClassName('js-show-password')[0].addEventListener('click', function() {
			var _this = this;

			if (_this.classList.contains(openEyeClass)) {
				_this.classList.remove(openEyeClass);
				passwordInput.setAttribute('type', 'password');
				passwordInput.focus();
			}
			else {
				_this.classList.add(openEyeClass);
				passwordInput.setAttribute('type', 'text');
				passwordInput.focus();
			}
		});
	</script>
@endsection