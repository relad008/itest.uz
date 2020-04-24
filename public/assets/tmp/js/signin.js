function SignIn(options) {
	var _t = {};
	_t.form = $('.js-signin-form');
	_t.phone = $('.js-signin-phone');
	_t.password = $('.js-signin-password');

	_t.onAuth = function()
	{
		// _t.form.on('submit', function(e) {
		// 	if (_t.form.valid()) {
		// 		axios.post(_t.form.attr('action'), {
		// 			phone: _t.phone.val(),
		// 			password: _t.password.val()
		// 		}).then(function(response) {
		// 			if (response.data.errors) {
		// 				var errorEl = document.getElementsByClassName('js-login-errors')[0];
		// 				errorEl.style.display = 'block';
		// 				errorEl.textContent = response.data.errors.email_or_password[0];
		// 			} else {
		// 				window.location.href = '/cabinet/';
		// 			}
		// 		})
		// 	}
		// 	e.preventDefault();
		// })
	}
	_t.init = function()
	{
		_t.options = options;
		_t.onAuth();

		_t.form.validate({
			highlight: function(element) {
		        $(element).addClass('is-invalid');
		    },
		    unhighlight: function(element) {
		        $(element).removeClass('is-invalid');
		    },
		    errorPlacement: function(error, element) {
		        if(element.parent('.input-group').length) {
		            error.addClass('invalid-feedback').insertAfter(element.parent());
		        } else {
		            error.addClass('invalid-feedback').insertAfter(element);
		        }
		    }
		});
	}

	return _t;
}