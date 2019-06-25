// JavaScript Document
$(function(){
	//焊接数据开始
	//焊接添加按钮
	$('#lc_hanjie_add').click(function(){
		var url=$(this).attr('name');
		$.ajax({
			url:url,
			success: function(msg){
				if(msg.state=='ok'){
					location.reload();
				}else{
					alert(msg.info);
				}
				
			}
		});								
	});
	//隐藏修改面板
	$('#hanjie_removeedit').click(function(){
		$('#hanjie_edit').css("display","none");			 
	});
	
	//焊接修改按钮
	$('#lc_hanjie_edit').click(function(){
		$('#hanjie_edit').css("display","none");
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample_1 .checkboxes:checked').each(function () {
			id+=$(this).val();
			flag+=1;
		});
		if(flag>1){
			$('#hanjie_edit').css("display","none");
			alert('不能同时修改多个记录！');
		}else{
			$.ajax({
				url:url,
				type:'GET',
				data:{
					id:id,
					buttonid:1
				},
				success: function(msg){
					if(msg.state!='error'){
						//设置修改窗口的值
						$("#hanjie_model_e").text(msg.data['model']);
						$('#hanjie_batch_e').text(msg.data['batch']);
						$('#hanjie_starttime_e').text(msg.data['starttime']);
						$('#hanjie_number_e').val(msg.data['number']);
						$('#hanjie_people_e').val(msg.data['people']);
						$('#hanjie_remark_e').val(msg.data['remark']);
						$('#hanjie_remark_label').html('备注');
						$('#hanjie_batch_e').val(msg.data['batch']);
						$('#hanjie_flag_e').val(0);
						$('#hanjie_button_e').val(1);
						$('#hanjie_id_e').val(msg.data['id']);
						//显示修改窗口
						$('#hanjie_edit').css("display","");
					}else{
						alert(msg.info);
					}
					
				}
			});
		}								
	});
	//焊接完成按钮
	$('#lc_hanjie_end').click(function(){
		$('#hanjie_edit').css("display","none");
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample_1 .checkboxes:checked').each(function () {
			id+=$(this).val();
			flag+=1;
		});
		if(flag>1){
			$('#hanjie_edit').css("display","none");
			alert('不能同时完成多个记录！');
		}else{
			$.ajax({
				url:url,
				type:'GET',
				data:{
					id:id,
					buttonid:2
				},
				success: function(msg){
					if(msg.state!='error'){
						//设置修改窗口的值
						$("#hanjie_model_e").text(msg.data['model']);
						$('#hanjie_batch_e').text(msg.data['batch']);
						$('#hanjie_starttime_e').text(msg.data['starttime']);
						$('#hanjie_number_e').val(msg.data['number']);
						$('#hanjie_people_e').val(msg.data['people']);
						$('#hanjie_remark_e').val(msg.data['remark']);
						$('#hanjie_remark_label').html('备注');
						$('#hanjie_batch_e').val(msg.data['batch']);
						$('#hanjie_flag_e').val(1);
						$('#hanjie_button_e').val(2);
						$('#hanjie_id_e').val(msg.data['id']);
						//显示修改窗口
						$('#hanjie_edit').css("display","");
					}else{
						alert(msg.info);
					}
					
				}
			});
		}								
	});
	
	//焊接修改人数按钮
	$('#lc_hanjie_mdpeople').click(function(){
		$('#hanjie_edit').css("display","none");
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample_1 .checkboxes:checked').each(function () {
			id+=$(this).val();
			flag+=1;
		});
		if(flag>1){
			$('#hanjie_edit').css("display","none");
			alert('不能同时完成多个记录！');
		}else{
			$.ajax({
				url:url,
				type:'GET',
				data:{
					id:id,
					buttonid:3
				},
				success: function(msg){
					if(msg.state!='error'){
						//设置修改窗口的值
						$("#hanjie_model_e").text(msg.data['model']);
						$('#hanjie_batch_e').text(msg.data['batch']);
						$('#hanjie_starttime_e').text(msg.data['starttime']);
						$('#hanjie_number_e').val(msg.data['number']);
						$('#hanjie_people_e').val(msg.data['people']);
						$('#hanjie_remark_e').val(msg.data['remark']);
						$('#hanjie_remark_label').html('备注');
						$('#hanjie_batch_e').val(msg.data['batch']);
						$('#hanjie_flag_e').val(msg.data['flag']);
						$('#hanjie_button_e').val(3);
						$('#hanjie_id_e').val(msg.data['id']);
						//显示修改窗口
						$('#hanjie_edit').css("display","");
					}else{
						alert(msg.info);
					}
					
				}
			});
		}
	});
	//焊接报废按钮
	$('#lc_hanjie_scrap').click(function(){
		$('#hanjie_edit').css("display","none");
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample_1 .checkboxes:checked').each(function () {
			id+=$(this).val();
			flag+=1;
		});
		if(flag>1){
			$('#hanjie_edit').css("display","none");
			alert('不能同时完成多个记录！');
		}else{
			$.ajax({
				url:url,
				type:'GET',
				data:{
					id:id,
					buttonid:4
				},
				success: function(msg){
					if(msg.state!='error'){
						//设置修改窗口的值
						$("#hanjie_model_e").text(msg.data['model']);
						$('#hanjie_batch_e').text(msg.data['batch']);
						$('#hanjie_starttime_e').text(msg.data['starttime']);
						$('#hanjie_number_e').val(msg.data['number']);
						$('#hanjie_people_e').val(msg.data['people']);
						$('#hanjie_remark_e').val(msg.data['remark']);
						$('#hanjie_remark_label').html('备注<span class="required">*</span>');
						$('#hanjie_batch_e').val(msg.data['batch']);
						$('#hanjie_flag_e').val(5);
						$('#hanjie_button_e').val(4);
						$('#hanjie_id_e').val(msg.data['id']);
						//显示修改窗口
						$('#hanjie_edit').css("display","");
					}else{
						alert(msg.info);
					}
					
				}
			});
		}								
	});
	//焊接修改按钮提交数据
	var form1 = $('#form_hanjie_edit');
	var error1 = $('.alert-error', form1);
	var success1 = $('.alert-success', form1);
	form1.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			hanjie_number_e: {
				required: true,
				digits: true
			},
			hanjie_people_e: {
				required: true,
				digits: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			hanjie_number_e : {
				required : "数量不能为空！",
				digits: "数量只能是数字!",
			},
			hanjie_people_e : {
				required : "人数不能为空！",
				digits: "人数只能是数字!",
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
			var url=$('#form_hanjie_edit').attr('name');
			var number=$('#hanjie_number_e').val();
			var people=$('#hanjie_people_e').val();
			var remark=$('#hanjie_remark_e').val();
			var starttime=$('#hanjie_starttime_e').text();
			var batch=$('#hanjie_batch_e').val();
			var flag=$('#hanjie_flag_e').val();
			var buttonid=$('#hanjie_button_e').val();
			var id=$('#hanjie_id_e').val();
			if(number==0){
				alert("数量不能为0！");	
			}else if(flag==5 && remark.length==0){
				alert("报废备注不能为空！");
			}else{
				
				$.ajax({
					url:url,
					type:'POST',
					data:{
						number:number,
						people:people,
						remark:remark,
						starttime:starttime,
						batch:batch,
						flag:flag,
						buttonid:buttonid,
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
	//焊接数据结束

	
	
});