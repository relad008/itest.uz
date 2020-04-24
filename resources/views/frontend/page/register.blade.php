@extends('layouts.frontend')

@section('content')
	<div class="auth">
		<h1 class="title">@lang('auth.signup')</h1>
		<div class="auth__card">
			@foreach($errors->all() as $message)
				<div class="text-danger js-login-errors mb-lg" style="font-size:13px">
					{!! $message !!}
				</div>
			@endforeach
			{!! Form::open([
				'action' => 'Auth\RegisterController@register',
				'class'	 => 'js-signup-form'
			]) !!}
                <div class="js-step">
					<div class="form-group">
						<input name="name" class="input js-signup-name" value="{{ old('name') }}" type="text" id="signup_name" required>
						<label for="signup_name" class="label">@lang('auth.full_name')*</label>
					</div>
					<div class="form-group">
						<input name="phone" type="text" class="input js-signup-phone" value="{{ old('phone') }}" id="signup_phone" data-mask="+999(99)999-99-99" data-clearifnotmatch="true" required>
						<label for="signup_phone" class="label">@lang('auth.phone')*</label>
					</div>
					<div class="form-group">
						<input name="email" type="email" class="input js-signup-email" value="{{ old('email') }}" id="signup_email" required>
						<label for="signup_email" class="label">E-mail*</label>
					</div>
					<div class="form-group mb-lg">
						<input name="password" type="password" class="input js-password-input js-signup-password" id="signup_password" required minlength="6">
						<label for="signup_password" class="label">@lang('auth.password')*</label>
						<i class="icon-eye-closed form-group__eye-icon js-show-password"></i>
					</div>
					<button type="submit" class="btn btn--brand full-width js-send-code">@lang('auth.signup')</button>
                    <div class="text-sm text-center pt-sm">
                        {!! __('auth.user_agreement') !!}
                    </div>
				</div>
				<div class="hide js-step">
					<div class="text-left">
						<p class="mb-lg text lh-base">
							@lang('auth.code_sent') <span class="font-semibold">+99890323****</span>
						</p>
						<div class="form-group">
                            <input name="code" class="input form-control" type="text" id="signup_code">
							<label class="label">@lang('auth.code')</label>
						</div>
                        <button class="btn btn--brand js-signup-btn" type="submit">@lang('auth.continue')</button>
                        <button class="btn js-signup-go" data-to="1">@lang('auth.back')</button>
                        <p class="text-center mt-md">
	                        <a href="#" class="link js-signup-go" data-to="3">@lang('auth.no_sms')</a>
                        </p>
					</div>
				</div>	<!-- /.js-step -->
				<div class="hide js-step">
					<div class="text-left">
						<p class="mb-sm text font-semibold">@lang('auth.no_sms_question')</p>
						<p class="mb-xl text lh-base">@lang('auth.no_sms_info')</p>
                        <button class="btn btn--brand js-send-again">@lang('auth.repeat')</button>
                        <button class="btn js-signup-go" data-to="2">@lang('auth.back')</button>
					</div>
				</div>	<!-- .js-step -->
			</form>
		</div>	<!-- /.auth__card -->
		<p><a href="{{ route('login') }}" class="link text-lg">@lang('auth.have_acc')</a></p>
	</div>	<!-- /.auth -->
@endsection

@section('scripts')
    <script src="{{ asset('assets/tmp/js/signin.js?v=noAjax') }}"></script>
    <script src="{{ asset('assets/tmp/js/signup.js?v=noAjax') }}"></script>
	<script type="text/javascript">
        var doc = document;
        
        doc.addEventListener('DOMContentLoaded', function(){
            Signup.init({
                urls: {
                    send_code: "{{ action('Auth\RegisterController@sendSms') }}",
                    check_phone: "{{ action('Auth\RegisterController@checkPhone') }}",
                }
            });
        });
		// show/hide password
		var openEyeClass = 'form-group__eye-icon--open',
			passwordInput = doc.getElementsByClassName('js-password-input')[0];

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