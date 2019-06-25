// JavaScript Document
$(function(){
	//添加按钮
	$('#lc_column_add').click(function(){
		var url=$(this).attr('name');
		$.ajax({
			url:url,
			success: function(msg){
				if(msg.state!='error'){
					$('#edit').css("display","none");
					$('#add').css("display","");				
				}else{
					alert(msg.info);
				}
				
			}
		});								
	});
	//隐藏添加面板
	$('#removeadd').click(function(){
		$('#add').css("display","none");			 
	});
	//隐藏修改面板
	$('#removeedit').click(function(){
		$('#edit').css("display","none");			 
	});
	//修改按钮
	$('#lc_column_edit').click(function(){
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample_1 .checkboxes:checked').each(function () {
			id+=$(this).val()+",";
			flag+=1;
		});
		if(flag>1){
			$('#edit').css("display","none");
			alert('不能同时修改多个菜单！');
		}else{
			$.ajax({
				url:url,
				type:'GET',
				data:{
					id:id
				},
				success: function(msg){
					if(msg.state!='error'){
						//设置修改窗口的值
						$("#column_module_e option[value='"+msg.data['module']+"']").attr("selected", true);
						$('#column_name_e').val(msg.data['name']);
						$('#column_field_e').val(msg.data['field']);
						$('#column_rank_e').val(msg.data['rank']);
						$('#column_width_e').val(msg.data['width']);
						$('#column_id_e').val(msg.data['id']);
						//显示修改窗口
						$('#add').css("display","none");
						$('#edit').css("display","");
					}else{
						alert(msg.info);
					}
					
				}
			});
		}								
	});
	//删除按钮
	$('#lc_nav_del').click(function(){
		//关闭窗口
		$('#add').css("display","none");
		$('#edit').css("display","none");
		var url=$(this).attr('name');
		var id="";
		$('#sample_1 .checkboxes:checked').each(function () {
			id+=$(this).val()+",";
		});
		if(window.confirm('你确定要删除这些记录吗？')){
			$.ajax({
				url:url,
				type:'GET',
				data:{
					id:id
				},
				success: function(msg){
					if(msg.state=='ok'){
						alert(msg.info);
						location.reload();
					}else{
						alert(msg.info);
					}
					
				}
			});	
		}
			
									
	});
	//添加菜单验证
	var form2 = $('#form_column_add');
	var error2 = $('.alert-error', form2);
	var success2 = $('.alert-success', form2);
	form2.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			column_name_a: {
				required: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			column_name_a : {  
				required : "栏目名称不能为空！",
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
			var url=$('#form_column_add').attr('name');
			var module=$('#column_module_a').val();
			var name=$('#column_name_a').val();
			var field=$('#column_field_a').val();
			var rank=$('#column_rank_a').val();
			var width=$('#column_width_a').val();
			$.ajax({
				url:url,
				type:'POST',
				data:{
					module:module,
					name:name,
					field:field,
					rank:rank,
					width:width
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
			
		}
	});
	//修改用户验证
	var form3 = $('#form_column_edit');
	var error3 = $('.alert-error', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			column_name_e: {
				required: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			column_name_e : {  
				required : "栏目名称不能为空！",
			}
		},
		
		invalidHandler: function (event, validator) { //display error alert on form submit   
			success3.hide();
			error3.show();
			App.scrollTo(error3, -200);
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
			var url=$('#form_column_edit').attr('name');
			var module=$('#column_module_e').val();
			var name=$('#column_name_e').val();
			var field=$('#column_field_e').val();
			var rank=$('#column_rank_e').val();
			var width=$('#column_width_e').val();
			var id=$('#column_id_e').val();
			$.ajax({
				url:url,
				type:'POST',
				data:{
					module:module,
					name:name,
					field:field,
					rank:rank,
					width:width,
					id:id
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
			
		}
	});
	
});