// JavaScript Document
$(function(){
	
	//添加用户验证
	var form2 = $('#form_manager_resetpw');
	var error2 = $('.alert-error', form2);
	var success2 = $('.alert-success', form2);
	form2.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			manager_passwd: {
				minlength: 6,
				required: true
			},
			manager_repasswd: {
				minlength: 6,
				required: true
			}
		},

		messages: { // custom messages for radio buttons and checkboxes
			manager_passwd : {
				minlength: "长度最小6个字符",
				required : "密码不能为空！",
			},
			manager_repasswd : {
				minlength: "长度最小6个字符",
				required : "重复密码不能为空！",
			} 
		},
		
		invalidHandler: function (event, validator) { //display error alert on form submit   
			success2.hide();
			error2.show();
			App.scrollTo(error2, -200);
		},

		highlight: function (element) { // hightlight error inputs
			$(element)
				.closest('.help-inline').removeClass('ok'); // display OK icon
			$(element)
				.closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
		},

		unhighlight: function (element) { // revert the change dony by hightlight
			$(element)
				.closest('.control-group').removeClass('error'); // set error class to the control group
		},
		
		submitHandler: function (form) {
			var url=$('#form_manager_resetpw').attr('name');
			var manager_passwd=$('#manager_passwd').val();
			var manager_repasswd=$('#manager_passwd').val();
			if(manager_passwd===manager_repasswd){
				var manager_id=$('#manager_id').val();
				$.ajax({
					url:url,
					type:'POST',
					data:{
						manager_id:manager_id,
						manager_passwd:manager_passwd
					},
					success: function(msg){
						if(msg.state!='error'){
							alert(msg.info);
							location.reload();
						}else{
							alert(msg.info);
						}
						
					}
				});	
			}else{
				alert('重复密码必须跟密码一致！');	
			}
			
			
		}
	});
	
	
});