// JavaScript Document
$(function(){
	/*一级分类*/
	$('#fahuo_fenlei_a').change(function(){
		$('#fahuo_fenlei_b').empty();
		$('#fahuo_fenlei_c').empty();
		$('#fahuo_fenlei_d').empty();
		var fahuourl=$('#change_fenlei').attr('name');
		var fenlei=$('#fahuo_fenlei_a').val();
		$.ajax({
			url:fahuourl,
			type:'GET',
			data:{
				fenlei:fenlei
			},
			success: function(msg){
				if(msg.state!='error'){
					$('#fahuo_fenlei_b').empty();
					$('#fahuo_fenlei_c').empty();
					$('#fahuo_fenlei_d').empty();
					$('#fahuo_fenlei_b').append("<option value='0'></option>");
					$('#fahuo_fenlei_c').append("<option value='0'></option>");
					$('#fahuo_fenlei_d').append("<option value='0'></option>");
					if(msg.data!=0){
						for(var i=0; i<msg.data.length;i++){
							$('#fahuo_fenlei_b').append("<option value="+msg.data[i]['cinvccode']+">"+msg.data[i]['cinvcname']+"</option>");
						}
					}
				}else{
					alert(msg.info);
				}
				
			}
		});
		
	});
	/*二级分类*/
	$('#fahuo_fenlei_b').change(function(){
		$('#fahuo_fenlei_c').empty();
		$('#fahuo_fenlei_d').empty();								 
		var fahuourl=$('#change_fenlei').attr('name');
		var fenlei=$('#fahuo_fenlei_b').val();
		$.ajax({
			url:fahuourl,
			type:'GET',
			data:{
				fenlei:fenlei
			},
			success: function(msg){
				if(msg.state!='error'){
					$('#fahuo_fenlei_c').empty();
					$('#fahuo_fenlei_d').empty();
					$('#fahuo_fenlei_c').append("<option value='0'></option>");
					$('#fahuo_fenlei_d').append("<option value='0'></option>");
					if(msg.data!=0){
						for(var i=0; i<msg.data.length;i++){
							$('#fahuo_fenlei_c').append("<option value="+msg.data[i]['cinvccode']+">"+msg.data[i]['cinvcname']+"</option>");
						}
					}
				}else{
					alert(msg.info);
				}
				
			}
		});
		
	});
	/*三级分类*/
	$('#fahuo_fenlei_c').change(function(){
		$('#fahuo_fenlei_d').empty();
		var fahuourl=$('#change_fenlei').attr('name');
		var fenlei=$('#fahuo_fenlei_c').val();
		$.ajax({
			url:fahuourl,
			type:'GET',
			data:{
				fenlei:fenlei
			},
			success: function(msg){
				if(msg.state!='error'){
					$('#fahuo_fenlei_d').empty();
					$('#fahuo_fenlei_d').append("<option value='0'></option>");
					if(msg.data!=0){
						for(var i=0; i<msg.data.length;i++){
							$('#fahuo_fenlei_d').append("<option value="+msg.data[i]['cinvccode']+">"+msg.data[i]['cinvcname']+"</option>");
						}
					}
				}else{
					alert(msg.info);
				}
				
			}
		});
		
	});
	
	//添加部门验证
	var form2 = $('#form_fahuo_dir');
	var error2 = $('.alert-error', form2);
	var success2 = $('.alert-success', form2);
	form2.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			fahuo_fenlei_a: {
				required: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			fahuo_fenlei_a : {  
				required : "一级分类不能为空！",
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
	});
	
});