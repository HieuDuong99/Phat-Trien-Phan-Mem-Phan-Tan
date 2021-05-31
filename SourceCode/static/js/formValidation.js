	var firstNameValid= false, lastNameValid= false, birthdayValid= false, genderValid= false, addressValid= false, emailValid= false, phoneValid= false, passwordValid= false, facebookValid= false;
	function firstNameVerify() {
		if ($('#first_name').val().trim() == '') {
			$('.error.first_name').text('Bắt buộc.');
			$('#first_name').addClass('invalid');
			firstNameValid= false;
		} else {
			$('.error.first_name').text('');
			$('#first_name').removeClass('invalid');
			firstNameValid= true;
		}
	}
	function lastNameVerify() {
		if ($('#last_name').val().trim() == '') {
			$('.error.last_name').text('Bắt buộc.');
			$('#last_name').addClass('invalid');
			lastNameValid= false;
		} else {
			$('.error.last_name').text('');
			$('#last_name').removeClass('invalid');
			lastNameValid= true;
		}
	}
	function birthdayVerify() {
		if ($('#birthday').val().trim() == '') {
			$('.error.birthday').text('Bắt buộc.');
			$('#birthday').addClass('invalid');
			birthdayValid= false;
		} else {
			if ($('#birthday').val().substr(0,4) == new Date().getFullYear()-18) {
					if (Number($('#birthday').val().substr(5,2)) == new Date().getMonth()+1) {
						if (Number($('#birthday').val().substr(8,2)) <= new Date().getDate()) {
							$('.error.birthday').text('');
							$('#birthday').removeClass('invalid');
							birthdayValid= true;
						} else {
							$('.error.birthday').text('Must be 18+');
							$('#birthday').addClass('invalid');
							birthdayValid= false;
						}
					} else {
						if (Number($('#birthday').val().substr(5,2)) < new Date().getMonth()+1) {
							$('.error.birthday').text('');
							$('#birthday').removeClass('invalid');
							birthdayValid= true;
						} else {
							$('.error.birthday').text('Must be 18+');
							$('#birthday').addClass('invalid');
							birthdayValid= false;
						} 
					}
				} else {
					if ($('#birthday').val().substr(0,4) < new Date().getFullYear()-18) {
						$('.error.birthday').text('');
						$('#birthday').removeClass('invalid');
						birthdayValid= true;
					} else {
						$('.error.birthday').text('Must be 18+');
						$('#birthday').addClass('invalid');
						birthdayValid= false;
					}
				} 
			}
	}
	function addressVerify() {
		if ($('#address').val().trim() == '') {
			$('.error.address').text('Bắt buộc.');
			$('#address').addClass('invalid');
			addressValid= false;
		} else {
			$('.error.address').text('');
			$('#address').removeClass('invalid');
			addressValid= true;
		}
	}
	function phoneVerify() {
		if ($('#phone').val().trim() == '') {
			$('.error.phone').text('Bắt buộc.');
			$('#phone').addClass('invalid');
			phoneValid= false;
		} else {
			if ($('#phone').val().match(/^0{1}[35789]{1}[0-9]{8}$/)/*.match(/(^[0]{1})((((3[2-9]{1})|(5[2689]{1})|(7[06789]{1})|(8[1-9]{1})|(9[0-9]{1}))[0-9]{7,8}$)|(((12[0-9]{1})|(16[2-9]{1})|(18[68]{1})|(19))[0-9]{6,7}$))/)*/ == null) {
				$('.error.phone').text('Số điện thoại không hợp lệ.');
				$('#phone').addClass('invalid');
				phoneValid= false;
			} else {
				$('.error.phone').text('');
				$('#phone').removeClass('invalid');
				phoneValid= true;
			}
		}
	}
	function passwordVerify() {
		if ($('#password').val() == '') {
			$('.error.password').text('Bắt buộc.');
			$('#password').addClass('invalid');
			passwordValid= false;
		} else {
			if ($('#password').val().match(/\W|_/) != null || $('#password').val().match(/[A-Z]/) == null || $('#password').val().match(/\d/) == null || $('#password').val().length < 6 || $('#password').val().length > 20) {
				$('.error.password').text('Mật khẩu phải từ 6-20 kí tự, có ít nhất 1 chữ in hoa và 1 số, không chứa kí tự đặc biệt và dấu cách.');
				$('#password').addClass('invalid');
				passwordValid= false;
			} else {
				$('.error.password').text('');
				$('#password').removeClass('invalid');
				passwordValid= true;
			}
		}
	}
	function emailVerify() {
		if ($('#email').val().trim() == '') {
			$('.error.email').text('Bắt buộc.');
			$('#email').addClass('invalid');
			emailValid= false;
		} else {
			if ($('#email').val().match(/^[\w.]+@([a-zA-Z_]+\.)+[a-zA-Z_]{2,4}$/) == null) {
				$('.error.email').text('Email không hợp lệ.');
				$('#email').addClass('invalid');
				emailValid= false;
			} else {
				$('.error.email').text('');
				$('#email').removeClass('invalid');
				emailValid= true;
			}
		}
		
	}
	function genderVerify() {
		if ($('#male').prop('checked') != true && $('#female').prop('checked') != true) {
			$('.error.gender').text('Bắt buộc.');
			$('.error.gender').css('display', 'block');
			genderValid= false;
		} else {
			$('.error.gender').text('');
			$('.error.gender').css('display', 'none');
			genderValid= true;
		}
	}
	function facebookVerify() {
		if ($('#facebook').val().trim() == '') {
			$('.error.facebook').text('Bắt buộc.');
			$('#facebook').addClass('invalid');
			facebookValid= false;
		} else {
			if ($('#facebook').val().match(/(http[s]?:\/\/(www.facebook|[a-zA-Z]{2}-[a-zA-Z]{2}.facebook|facebook)\.com\/(pages\/[a-zA-Z0-9\.-]+\/[0-9]+|[a-zA-Z0-9\.-]+)[/]?$)|((www.facebook|[a-zA-Z]{2}-[a-zA-Z]{2}.facebook|facebook)\.com\/(pages\/[a-zA-Z0-9\.-]+\/[0-9]+|[a-zA-Z0-9\.-]+)[/]?$)/) == null) {
				$('.error.facebook').text('Link Facebook không hợp lệ');
				$('#facebook').addClass('invalid');
				facebookValid= false;
			} else {
				$('.error.facebook').text('');
				$('#facebook').removeClass('invalid');
				facebookValid= true;
			}
		}
	}
	$('#first_name').on('blur', function() {firstNameVerify()});
	$('#last_name').on('blur', function() {lastNameVerify()});
	$('#birthday').on('blur', function() {birthdayVerify()});
	$('#address').on('blur', function() {addressVerify()});
	$('#phone').on('blur', function() {phoneVerify()});
	$('#password').on('blur', function() {passwordVerify()});
	$('#email').on('blur', function() {emailVerify()});
	$('#facebook').on('blur', function() {facebookVerify()});
	$('.field.gender input').on('change', function() {genderVerify()});
	$('form').on('submit', function() {
		var validation;
		firstNameVerify(); lastNameVerify(); birthdayVerify(); addressVerify(); phoneVerify(); passwordVerify(); emailVerify(); genderVerify(); facebookVerify();
		if (passwordValid==false) {$('#password').focus()}
		if (facebookValid==false) {$('#facebook').focus()}
		if (phoneValid==false) {$('#phone').focus()}
		if (emailValid==false) {$('#email').focus()}
		if (addressValid==false) {$('#address').focus()}
		if (birthdayValid==false) {$('#birthday').focus()}
		if (lastNameValid==false) {$('#last_name').focus()}
		if (firstNameValid==false) {$('#first_name').focus()}
		validation= firstNameValid && lastNameValid && birthdayValid && genderValid && addressValid && emailValid && phoneValid && passwordValid && facebookValid;
		return validation;
	})
	$('input').on('focus', function() {
		if ($(this).next('.error').text() != '') {
		$(this).next('.error').css('display', 'block');
		}
	});
	$('input').on('blur', function() {
		$(this).next('.error').css('display', 'none');
	});