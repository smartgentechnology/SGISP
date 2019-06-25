var Login = function () {
    
    return {
        //main function to initiate the module
        init: function () {
        	
           $('.login-form').validate({
	            errorElement: 'label', //default input error message container
	            errorClass: 'help-inline', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            rules: {
	                manager_name: {
	                    required: true
	                },
	                manager_passwd: {
	                    required: true
	                },
	                remember: {
	                    required: false
	                }
	            },

	            messages: {
	                manager_name: {
	                    required: "用户名不能为空！"
	                },
	                manager_passwd: {
	                    required: "密码不能为空！"
	                }
	            },
				/*隐藏总提示
	            invalidHandler: function (event, validator) { //display error alert on form submit   
	                $('.alert-error', $('.login-form')).show();
	            },
				*/
	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.control-group').addClass('error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.control-group').removeClass('error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.addClass('help-small no-left-padding').insertAfter(element.closest('.input-icon'));
	            },
				/*隐藏JS提交
	            submitHandler: function (form) {
	                window.location.href = "Index/login";
	            }
				*/
	        });
			/*隐藏JS提交
	        $('.login-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.login-form').validate().form()) {
	                    window.location.href = "Index/login";
	                }
	                return false;
	            }
	        });
			*/
			
        }

    };

}();