/*fax.js*/
var current_fs, next_fs, previous_fs;
var animating;

function isNumber(evt) {
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		evt.preventDefault(evt);
		return false;
	}
	return true;
}

function validateEmail(email) { 
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/; 
	return re.test(email); 
}

function pe(evt) {
	evt.preventDefault(evt);
	return false;
}

function validatePostal(postal){
	postal = postal.replace(/\s/g, '');
	var postalAlpha = postal.replace(/[0-9]/g, '');
	if(postal.length!=6){
		return false;
	}
	if(postalAlpha=='' || postalAlpha.length!=2){
		return false;
	}
	return true;
}

function validateHouse(house){
	if(house.length>6){
		return false;
	}
	return true;
}

function isRequired(idval, alertval){
	$('#'+alertval).hide();
	if(!$('#'+idval).val()){
		$('#'+alertval).show();
		return false;
	}
	return true;
}

function isRequiredJaNee(){
	$('#alert-ja-nee').hide();
	if(!$('.nee').is(':checked') && !$('.ja').is(':checked')) {
		$('#alert-ja-nee').show();
		return false;
	}
	return true;
}

function isDateOk(idval, alertval){
	$('#'+alertval).hide();
	var dd = $('#'+idval).val();
	var optionVal = $("select[name=my_html_select_box] option:selected").val();
	//swap the date and month
	//reconstruct
	ndd = dd[3] + dd[4] + dd[2] + dd[0] + dd[1] + dd[5] + dd[6] + dd[7] + dd[8] + dd[9]
	
	var dt = new Date(ndd);
	var now = new Date();

	var diff = now - dt;

	if(optionVal==1){
		//56 DAYS (OPTION 1)
		var days = (1000 * 60 * 60 * 24 * 57);
		var msg = 'De beslitermijn van 8 weken is nog niet verstreken';
	} else if(optionVal==2){
		//84 DAYS (OPTION 2)
		var days = (1000 * 60 * 60 * 24 * 85);
		var msg = 'De beslistermijn van 12 weken is nog niet verstreken';
	} else if(optionVal==3){
		//126 DAYS (OPTION 3)
		var days = (1000 * 60 * 60 * 24 * 127);
		var msg = 'De beslistermijn van 18 weken is nog niet verstreken';
	} else if(optionVal==4){
		//30 DAYS (OPTION 4)
		var days = (1000 * 60 * 60 * 24 * 31);
		var msg = 'OPTION 4';
	} else if(optionVal==5){
		//20 DAYS (OPTION 5)
		var days = (1000 * 60 * 60 * 24 * 21);
		var msg = 'OPTION 5';
	} else if(optionVal==6){
		//14 DAYS (OPTION 6)
		var days = (1000 * 60 * 60 * 24 * 15);
		var msg = 'error message 6';
	} else {
		//5 DAYS (OPTION 7)
		var days = (1000 * 60 * 60 * 24 * 6);
		var msg = 'OPTION 7';
	}

	if( diff < days ) {
		$('#'+alertval).html(msg).show();
		return false;
	}
	return true;
}

function isF17Ok(idval, alertval){
	$('#'+alertval).hide();
	if($('#'+idval).val().length != 10)	{
		$('#'+alertval).show();
		return false;
	}
	return true;
}

function isEmailValid(idval, alertval){
	$('#'+alertval).hide();
	if( $('#'+idval).val() ){
		if( !validateEmail( $('#'+idval).val() )) {
			$('#'+alertval).show();
			return false;
		}
	}
	return true;
}

function isRequiredf4a(){
	$('#alert-f4a').hide();
	if($('#meneer').is(':checked') || $('#mevrouw').is(':checked')) {
		$('#alert-f4a').hide();
		return true;
	}
	$('#alert-f4a').show();
	return false;
}




function isPostalOk(){	
	$('#alert-clipostcode-len').hide();
	if (!validatePostal($('#cli-postcode').val())){
		$('#alert-clipostcode-len').show();
		$('#cli-residence, #cli-addr').val('');
		return false;
	}
	return true;
}

function isHouseNumberOk(){
	$('#alert-clihomenumber-len').hide();
	if (!validateHouse($('#cli-home-number').val())){
		$('#alert-clihomenumber-len').show();
		$('#cli-residence, #cli-addr').val('');
		return false;
	}
	return true;
}

function isPhoneOk(){
	$('#numerror').hide();
	var isnum = /^\d+$/.test($('#cli-phone').val());
	if(!isnum || $('#cli-phone').val().length != 10) {
		$('#numerror').show();
		return false;
	}
	return true;
}


function upperCaseF(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}

function titleCase(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase() + string.slice(1);
    }, 1);
}

function capitalizefirst(s){
    return s.toLowerCase().replace( /\b./g, function(a){ return a.toUpperCase(); } );
}

function jsUcfirst(string) 
    {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }





function clearErrors(){
	$('#alert-clipostcode-len').hide();
	$('#alert-clihomenumber-len').hide();
	$('#alert-cliemail-form').hide();
	$('#alert-cliadd').hide();
	$('#alert-cliname').hide();
	$('#alert-cliaddr').hide();
	$('#alert-clipostcode').hide();
	$('#alert-clires').hide();
	$('#alert-clihomenumber').hide();
	$('#alert-clireknr').hide();
	$('#alert-cliemail').hide();
	$('#alert-clicomment').hide();
	$('#alert-f4a').hide();
	$('#alert-f2').hide();
	$('#alert-f1').hide();
	$('#alert-ja-nee').hide();
	$('#alert-besto').hide();
	$('#alert-f12').hide();
	$('#alert-f13').hide();
	$('#alert-f14').hide();
	$('#alert-f15').hide();
	$('#alert-f17').hide();
	$('#dterror').hide();
	$('#numerror').hide();
	$('#sserror').hide();
	$('#fserror').hide();
	$('#neeerror').hide();
	$('#fierror').hide();
	$('#tserror').hide();
	$('#emailerror').hide();
}

$( function() {
	$( "#f2" ).datepicker({
		dateFormat: "dd/mm/yy"
	});
	$('#cli-reknr').mask('ZZ11ZZZZ1111111111',{
		translation: {
			'Z': {pattern: /[a-zA-Z]/,optional: false},
		  '1': {pattern: /[0-9]/,optional: false}
		}
	});
	
	$("#cli-postcode, #cli-home-number").focusout(function(){		
		var postal = $('#cli-postcode').val();
		var house = $('#cli-home-number').val();
		// postal = postal.trim();
		postal = postal.replace(/\s/g, '');
		house = house.replace(/\s/g, '');
		// house = house.trim();
		// console.log(postal+'--'+postal.length);
		// console.log(house+'--'+house.length);
		
		if(postal && house && (postal.length==6)){
			$.ajaxSetup({
				headers: {
				  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			  });
			$.ajax({
				type: "POST",
				url: '/post',
				dataType: "json",
				data: {postal:postal,house:house},
				success: function(response){
					if(response.status==1){
						$('#cli-addr').val(response.data.address);
						$('#cli-residence').val(response.data.city);
						isRequired('cli-addr', 'alert-cliaddr');
						isRequired('cli-residence', 'alert-clires');
					}
				}
			});
		}
	});

	//$('#neeerror').hide();

	$('.help-btn').on('click', function(){
		c_box = $(this).attr('data-infobox');
		$('#'+c_box).toggle();
	});

	//entry for mouse over
	$('.help-btn').mouseenter(function(){
		c_box = $(this).attr('data-infobox');
		$('#'+c_box).show();
	});

	$('.help-btn').mouseleave(function(){
		c_box = $(this).attr('data-infobox');
		$('#'+c_box).hide();
	});

	$('#nee').on('click', function(){
		isRequiredJaNee();
		if(this.checked) {
			$('#neeerror').hide();
		} 
	});

	$('#meneer').on('click', function(){
		if(this.checked) {
		} 
	});

	$('#mevrouw').on('click', function(){

		if(this.checked) {
		} 
	});

	$('.f4a').on('change', function(){
		isRequiredf4a();
	})


	$('#ja').on('click', function(){
		isRequiredJaNee();
		if(this.checked) {
			$('#neeerror').show();
		} 
	}); 

	$('#f2').on('change', function() {
		$('#dterror').hide();
		$('#alert-f2').hide();
		if (isRequired('f2', 'alert-f2'))
		{
			isDateOk('f2', 'dterror');
		}		
	});

//$('#f1').on('change', function() {
//		isRequired('f1', 'alert-f1');		
//	});

	$('#besto').on('focusout', function() {
		$('#fierror').hide();
		isRequired('besto', 'alert-besto');	
		isRequired('f12', 'alert-f12');	
		// if(isRequired('f17', 'alert-f17'))
		// {
		// 	isF17Ok('f17', 'fierror');
		// }
		isEmailValid('f18', 'emailerror');	
	});

	$('#f12').on('change', function() {
		isRequired('f12', 'alert-f12');		
	});

	// $('#f17').on('change', function() {
	// 	$('#fierror').hide();
	// 	if(isRequired('f17', 'alert-f17'))
	// 	{
	// 		isF17Ok('f17', 'fierror');
	// 	}		
	// });

	$('#f18').on('change', function() {
		isEmailValid('f18', 'emailerror');	
	});

	$('#cli-phone').bind('keypress keydown keyup', function(e){
		if(e.keyCode == 109) {e.preventDefault(); }
	});

	$('#cli-add').on('change', function() {
		isRequired('cli-add', 'alert-cliadd');
	});

	$('#cli-name').on('change', function() {
		isRequired('cli-name', 'alert-cliname');
	});


	$('#cli-addr').on('change', function() {
		isRequired('cli-addr', 'alert-cliaddr');
	});

	$('select[name=my_html_select_box]').on('change', function() {
		isRequired('selectOP', 'alert-f1');
	});
	
	$('#cli-residence').on('change', function() {
		isRequired('cli-residence', 'alert-clires');
	});

	$('#cli-postcode').on('change', function(){
		$('#alert-clipostcode-len').hide();
		if(isRequired('cli-postcode', 'alert-clipostcode')){
			isPostalOk();
		}
	});

	$('#cli-home-number').on('change', function(){
		$('#alert-clihomenumber-len').hide();
		if(isRequired('cli-home-number', 'alert-clihomenumber')){
			isHouseNumberOk();
		}
	});

	$('#cli-phone').on('change', function(){
		$('#numerror').hide();
		if(isRequired('cli-phone', 'alert-cliphone')){
			isPhoneOk();
		}
	});
	
	$('#cli-reknr').on('change', function(){
		$('#numerror').hide();
		if(isRequired('cli-reknr', 'alert-clireknr')){
			// isReknrOk();
		}
	});


	$('#cli-email').on('change', function(){
		$('#alert-cliemail-form').hide();
		if(isRequired('cli-email', 'alert-cliemail')){
			isEmailValid('cli-email', 'alert-cliemail-form');
		}
	});

	$('form').submit(function(event) {
		no_errors = true
		///clar all error
		clearErrors();

		if(!isRequiredf4a()){
			no_errors = false;
		}
		//console.log(no_errors+" 1");

		if(!isRequired('cli-add', 'alert-cliadd')){
			no_errors = false;
		}

		//console.log(no_errors+" 2");

		if(!isRequired('cli-name', 'alert-cliname')){
			no_errors = false;
		}

		//console.log(no_errors+" 3");

		if(!isRequired('cli-addr', 'alert-cliaddr')){
			no_errors = false;
		}

		//console.log(no_errors+" 4");

		if(!isRequired('cli-residence', 'alert-clires')){
			no_errors = false;
		}

		//console.log(no_errors+" 5");

		if(!isRequired('cli-postcode', 'alert-clipostcode')){
			no_errors = false;
		} else {
			if(!isPostalOk()){
				no_errors = false;
			}
		}

		//console.log(no_errors+" 6");

		if(!isRequired('cli-home-number', 'alert-clihomenumber')){
			no_errors = false;
		} else {
			if(!isHouseNumberOk()){
				no_errors = false;
			}
		}

		//console.log(no_errors+" 7");

		if(!isRequired('cli-phone', 'alert-cliphone')){
			no_errors = false;
		} else {
			if(!isPhoneOk()){
				no_errors = false;
			}
		}

		if(!isRequired('cli-reknr', 'alert-clireknr')){
			no_errors = false;
		} 
		// else {
		// 	if(!isReknrOk()){
		// 		no_errors = false;
		// 	}
		// }		
		
		//console.log(no_errors+" 8");

		if(!isRequired('cli-email', 'alert-cliemail')){
			no_errors = false;
		} else {
			if (!isEmailValid('cli-email', 'alert-cliemail-form'))
			{
				no_errors = false;
			}
		}

		//console.log(no_errors+" 9");


	//	if(!$('#cli-comment').val()){
	//		$('#alert-clicomment').show();
	//		no_errors = false;
	//	}

		//console.log(no_errors);
		if (!no_errors){
			event.preventDefault(event);
			return false;
		}
		
	});

	$('.next').click(function(ev){

		//for first form
		if($(this).is('#fb')) {
			no_errors = true;
			clearErrors();

			if (!isRequired('f2', 'alert-f2')){
				no_errors = false;
			} else {
				if(!isDateOk('f2', 'dterror')){
					no_errors = false;
				}
			}

			if(!isRequired('selectOP', 'alert-f1')){
				no_errors = false;
			}

			if(!isRequiredJaNee()){
				no_errors = false;
			} else {
				if ($('#ja').is(":checked")){
					$('#neeerror').show();
					//no_errors = false;
				}
			}

			if (!no_errors) return false;
			
		}

		//second form
		if($(this).is('#sb')) {
			no_errors = true;
			clearErrors();

			if(!isRequired('besto', 'alert-besto')){
				no_errors = false;
			}

			if(!isRequired('f12', 'alert-f12')){
				no_errors = false;
			}

		//	if(!$('#f13').val()){
		//		$('#alert-f13').show();
		//		no_errors = false;
		//	}

		//	if(!$('#f14').val()){
		//		$('#alert-f14').show();
		//		no_errors = false;
		//	}
		//	if(!$('#f15').val()){
		//		$('#alert-f15').show();
		//		no_errors = false;
		//	}
			// if(!isRequired('f17', 'alert-f17')){
			// 	no_errors = false;
			// } else {
			// 	if(!isF17Ok('f17', 'fierror')){
			// 		no_errors = false;
			// 	}
			// }
			
			if (!isEmailValid('f18', 'emailerror')){
				no_errors = false;
			}
			
			if (!no_errors) return false;
			
		}

		//third form


		//validate here
		if(animating) return false;
		animating = true;
		
		current_fs = $(this).parent();
		next_fs = $(this).parent().next();
	
		//activate next step on progressbar using the index of next_fs
		$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
		
		//show the next fieldset
		next_fs.show(); 
		//hide the current fieldset with style
		current_fs.animate({opacity: 0}, {
			step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({
				'transform': 'scale('+scale+')',
				'position': 'relative'
			});
			next_fs.css({'left': left, 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		//easing: 'easeInOutBack'
	});

	});
	$(".previous").click(function(){
		if(animating) return false;
		animating = true;
		
		current_fs = $(this).parent();
		previous_fs = $(this).parent().prev();
		
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		/*easing: 'easeInOutBack'*/
	});
});
});

