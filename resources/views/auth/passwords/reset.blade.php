@extends('layouts.frontend')

@section('content')
<div class="auth">
    <div class="title">{{ __('Reset Password') }}</div>
    <div class="auth__card">

        <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email" class="label">{{ __('E-Mail Address') }}</label>

                    <input id="email" type="email" class="input{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif

                </div>

                <div class="form-group">
                    <label for="password" class="label">{{ __('Password') }}</label>
                    <input id="password" type="password" class="input{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif

                </div>

                <div class="form-group">
                    <label for="password-confirm" class="label">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="input" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn--brand full-width">
                    {{ __('Reset Password') }}
                </button>

            </form>
        </div>
    </div>

</div>
@endsection
