var Signup = {
	sendCodeBtn: $('.js-send-code'),
	phoneInput: $('.js-signup-phone'),
	steps: $('.js-step'),
	goBtn: $('.js-signup-go'),
	sendAgain: $('.js-send-again'),
	form: $('.js-signup-form'),

	phoneExists: false,
	urls: {
		send_code: null,
		check_phone: null,

	},

	/**
	 * Send activation code
	 * 
	 * @return void
	 */
	sendCode: function()
	{
		axios.post(Signup.urls.send_code, {
			phone: Signup.phoneInput.val()
		}, {
			validateStatus: function (status) {
				return status < 500;
			}
		}).then(function(response) {
			$('.js-signup-error').remove();
			const data = response.data;
		    if (data.success === true){
		    	Signup.steps.eq(0).addClass('hide');
		    	Signup.steps.eq(1).removeClass('hide');
		    } else {
		    	Signup.showError(data);
		    }
		})
	},

	onClickSendCode: function()
	{
		this.sendCodeBtn.on('click', function(e) {
			if (Signup.form.valid()) {
				Signup.sendCode();
			}
			e.preventDefault();
		})
	},

	/**
	 * Send Again
	 * 
	 * @return void
	 */
	onClickSendAgain: function()
	{
		this.sendAgain.on('click', function(e) {
			Signup.sendCode();
			e.preventDefault();
		});
	},

	onClickGoBtn: function()
	{
		this.goBtn.on('click', function(e) {
			e.preventDefault();
			var to = $(this).data('to');
			for (i = 1; i < 4; i++) {
				if (to == i) {
					Signup.steps.eq(i-1).removeClass('hide');
				} else {
					Signup.steps.eq(i-1).addClass('hide');
				}
			}
		})
	},

	errorTemplete: function(error)
	{
		return $('<div/>').addClass('alert alert-danger alert-dismissible fade show js-signup-error')
			.html(error)
			.append($('<button/>', {
					'class': 'close',
					'data-dismiss': 'alert'
				})
				.html('<span aria-hidden="true">&times;</span>')
			);
	},

	showError: function(data)
	{
		for (i in data.errors) {
			for (j in data.errors[i]) {
				Signup.form.parent()
					.prepend(Signup.errorTemplete(data.errors[i][j]))
			}
		}
	},

	onFormSubmit: function() {
		// var data, inputs;
		// this.form.on('submit', function(e) {
		// 	inputs = Signup.form.serializeArray()
		// 	data = {};

		// 	inputs.forEach(function(item, i) {
		// 		data[item.name] = item.value
		// 	});

		// 	axios.post('oauth/register', data, {
		// 		validateStatus: function (status) {
		// 			return status < 500;
		// 		}
		// 	}).then(function(response) {
		// 		$('.js-signup-error').remove();
		// 		data = response.data;
		// 		if (data.errors) {
		// 			Signup.showError(data);
		// 		} else {
		// 			window.location.href = '/cabinet';
		// 		}
		// 	});

		// 	e.preventDefault();
		// });
	},

	checkPhone: function(phone)
	{
		var request = axios.post(Signup.urls.check_phone, {
			phone: phone
		})
		request.then(function(response) {
			var error = response.data.error;
			Signup.phoneExists = response.data.error;
			Signup.form.validate().element('.js-signup-phone');
		}).catch(function() {
			return Signup.phoneExists = false;
		});
	},

	phoneEvents: function()
	{
		this.phoneInput.on('blur', function() {
			Signup.checkPhone($(this).val())
		})

		// Send only if an error has
		this.phoneInput.on('keypress', function() {
			if (Signup.phoneExists) {
				Signup.checkPhone($(this).val())
			}
		})
	},

	/**
	 * TEMP REGISTRATION
	 */
	tempReg: function()
	{
		// this.form.on('submit', function(e) {
			// inputs = Signup.form.serializeArray()
			// data = {};

			// inputs.forEach(function(item, i) {
			// 	data[item.name] = item.value
			// });

			// axios.post('oauth/register', data, {
			// 	validateStatus: function (status) {
			// 		return status < 500;
			// 	}
			// }).then(function(response) {
			// 	$('.js-signup-error').remove();
			// 	data = response.data;
			// 	if (data.errors) {
			// 		Signup.showError(data);
			// 	} else {
			// 		window.location.href = '/cabinet/#/profile';
			// 	}
			// });

			// e.preventDefault();
		// });
	},

	init: function(options)
	{
		this.urls = options.urls || this.urls;
		// this.onClickSendCode();
		this.onClickSendAgain();
		this.phoneEvents();
		this.onClickGoBtn();
		// this.onFormSubmit();
		this.tempReg();

		jQuery.validator.addMethod('unique_phone', function(value, element) {
			return !Signup.phoneExists;
		}, 'Phone exists');

		this.form.validate({
			rules: {
				phone: {
					unique_phone: true
				}
			},
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
}