// JavaScript Document
$(function(){
	//入库类型添加按钮
	$('#lc_rukuleixing_add').click(function(){
		$('#rukuleixing_edit').css("display","none");
		$('#rukuleixing_add').css("display","");						
	});
	$('#rukuleixing_type_a').change(function(){
		var dept_id=$('#rukuleixing_type_a').val();
		if(dept_id==5){
			$('#chengpinleixing_flag_div_a').css("display","");
		}else{
			$('#chengpinleixing_flag_div_a').css("display","none");	
		}
		if(dept_id==6){
			$('#rukuleixing_flag_div_a').css("display","");
		}else{
			$('#rukuleixing_flag_div_a').css("display","none");	
		}
		
	});
	$('#rukuleixing_type_e').change(function(){
		var dept_id=$('#rukuleixing_type_e').val();
		if(dept_id==5){
			$('#chengpinleixing_flag_div_e').css("display","");
		}else{
			$('#chengpinleixing_flag_div_e').css("display","none");	
		}
		if(dept_id==6){
			$('#rukuleixing_flag_div_e').css("display","");
		}else{
			$('#rukuleixing_flag_div_e').css("display","none");	
		}
		
	});
	//隐藏添加面板
	$('#removeedit_add').click(function(){
		$('#rukuleixing_add').css("display","none");			 
	});
	//隐藏修改面板
	$('#removeedit_edit').click(function(){
		$('#rukuleixing_edit').css("display","none");			 
	});
	
	//入库类型修改按钮
	$('#lc_rukuleixing_edit').click(function(){
		$('#rukuleixing_add').css("display","none");
		$('#rukuleixing_edit').css("display","none");
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample_1 .checkboxes:checked').each(function () {
			id+=$(this).val();
			flag+=1;
		});
		if(flag>1){
			$('#rukuleixing_edit').css("display","none");
			alert('不能同时修改多个记录！');
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
						$("#rukuleixing_type_e option[value='"+msg.data['type']+"']").attr("selected", true);
						if(msg.data['type']==5){
							$('#chengpinleixing_flag_div_e').css("display","");
							$("#chengpinleixing_flag_e option[value='"+msg.data['flag']+"']").attr("selected", true);
						}else{
							$('#chengpinleixing_flag_div_e').css("display","none");	
						}
						if(msg.data['type']==6){
							$('#rukuleixing_flag_div_e').css("display","");
							$("#rukuleixing_flag_e option[value='"+msg.data['flag']+"']").attr("selected", true);
						}else{
							$('#rukuleixing_flag_div_e').css("display","none");	
						}
						$('#rukuleixing_number_e').val(msg.data['number']);
						$('#rukuleixing_remark_e').val(msg.data['remark']);
						$('#rukuleixing_id_e').val(msg.data['id']);
						//显示修改窗口
						$('#rukuleixing_edit').css("display","");
					}else{
						alert(msg.info);
					}
					
				}
			});
		}								
	});
	
	
	//删除按钮
	$('#lc_rukuleixing_del').click(function(){
		//关闭窗口
		$('#rukuleixing_add').css("display","none");
		$('#rukuleixing_edit').css("display","none");
		var url=$(this).attr('name');
		var id="";
		$('#sample_1 .checkboxes:checked').each(function () {
			id+=$(this).val()+",";
		});
		
		if(window.confirm('你确定要删除编号为：'+id+'的这些记录吗？')){
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
	//入库类型添加按钮提交数据
	var form1 = $('#form_rukuleixing_add');
	var error1 = $('.alert-error', form1);
	var success1 = $('.alert-success', form1);
	form1.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			rukuleixing_number_a: {
				required: true,
				digits: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			rukuleixing_number_a : {
				required : "数量不能为空！",
				digits: "数量只能是数字!",
			}
		},
		
		invalidHandler: function (event, validator) { //display error alert on form submit   
			success1.hide();
			error1.show();
			App.scrollTo(error1, -200);
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
			var url=$('#form_rukuleixing_add').attr('name');
			var type=$('#rukuleixing_type_a').val();
			if(type==5){
				var flag=$('#chengpinleixing_flag_a').val();
			}else if(type==6){
				var flag=$('#rukuleixing_flag_a').val();
			}
			var number=$('#rukuleixing_number_a').val();
			if(number==0){
				alert("入库数量不能为0！");	
			}else{
				var remark=$('#rukuleixing_remark_a').val();
				var batch=$('#rukuleixing_batch_a').val();
				var model=$('#rukuleixing_model_a').val();
				$.ajax({
					url:url,
					type:'POST',
					data:{
						type:type,
						flag:flag,
						number:number,
						remark:remark,
						batch:batch,
						model:model
						
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
		}
	});
	//入库类型数据结束
	
	//入库类型修改按钮提交数据
	var form2 = $('#form_rukuleixing_edit');
	var error2 = $('.alert-error', form2);
	var success2 = $('.alert-success', form2);
	form2.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			rukuleixing_number_e: {
				required: true,
				digits: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			rukuleixing_number_e : {
				required : "数量不能为空！",
				digits: "数量只能是数字!",
			}
		},
		
		invalidHandler: function (event, validator) { //display error alert on form submit   
			success2.hide();
			error2.show();
			App.scrollTo(error1, -200);
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
			var url=$('#form_rukuleixing_edit').attr('name');
			var type=$('#rukuleixing_type_e').val();
			if(type==5){
				var flag=$('#chengpinleixing_flag_e').val();
			}else if(type==6){
				var flag=$('#rukuleixing_flag_e').val();
			}
			var number=$('#rukuleixing_number_e').val();
			if(number==0){
				alert("入库数量不能为0！");	
			}else{
				var remark=$('#rukuleixing_remark_e').val();
				var batch=$('#rukuleixing_batch_e').val();
				var model=$('#rukuleixing_model_e').val();
				var id=$('#rukuleixing_id_e').val();
				$.ajax({
					url:url,
					type:'POST',
					data:{
						type:type,
						flag:flag,
						number:number,
						remark:remark,
						batch:batch,
						model:model,
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
			
		}
	});
	//入库类型数据结束

	
	
});