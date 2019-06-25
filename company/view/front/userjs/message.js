// JavaScript Document
$(function(){
	$('#tijiao').click(function(){
		var name=$('#name').val();
		var phone=$('#phone').val();
		var mail=$('#mail').val();
		var question=$('#question').val();
		var nick_name=$('#nick_name').val();
		var captcha=$('#captcha').val();
		var captchas;
		$.ajax({
			url:'getcaptcha.php',
			dataType:'text',
			async: false,
			success: function(data){
				captchas=data;
			}	
		});
		if(name==''){
			$('#msg').text("我们怎么称呼您啊？");
		}else if(phone=='' && mail==''){
			$('#msg').text("手机和邮箱至少留一个吧！");
		}else if(captcha==''){
			$('#msg').text("验证码不能为空！");
		}else if(captchas!=captcha){
			$('#msg').text("验证码不正确！");
		}else{
			$.ajax({
				url:'messagepost.php',
				type:'POST',
				data:{
					nick_name:nick_name,
					name:name,
					phone:phone,
					mail:mail,
					question:question
				},
				success: function(data){
					if(data==1){
						alert('留言添加成功！');
						$('#name').val('');
						$('#phone').val('');
						$('#mail').val('');
						$('#question').val('');
						$('#captcha').val('');
					}else{
						alert('留言添加失败！');	
					}
				}
			});
		}
	});
});