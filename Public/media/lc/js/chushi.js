// JavaScript Document
$(function(){
	//初试添加按钮
	$('#lc_chushi_add').click(function(){
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
	$('#chushi_removeedit').click(function(){
		$('#chushi_edit').css("display","none");			 
	});
	
	//初试修改按钮
	$('#lc_chushi_edit').click(function(){
		$('#chushi_edit').css("display","none");
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample_1 .checkboxes:checked').each(function () {
			id+=$(this).val();
			flag+=1;
		});
		if(flag>1){
			$('#chushi_edit').css("display","none");
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
						$("#chushi_model_e").text(msg.data['model']);
						$('#chushi_batch_e').text(msg.data['batch']);
						$('#chushi_starttime_e').text(msg.data['starttime']);
						$('#chushi_number_e').val(msg.data['number']);
						$('#chushi_people_e').val(msg.data['people']);
						$('#chushi_remark_e').val(msg.data['remark']);
						$('#chushi_remark_label').html('备注');
						$('#chushi_batch_e').val(msg.data['batch']);
						$('#chushi_flag_e').val(0);
						$('#chushi_button_e').val(1);
						$('#chushi_id_e').val(msg.data['id']);
						//显示修改窗口
						$('#chushi_edit').css("display","");
					}else{
						alert(msg.info);
					}
					
				}
			});
		}								
	});
	//初试完成按钮
	$('#lc_chushi_end').click(function(){
		$('#chushi_edit').css("display","none");
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample_1 .checkboxes:checked').each(function () {
			id+=$(this).val();
			flag+=1;
		});
		if(flag>1){
			$('#chushi_edit').css("display","none");
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
						$("#chushi_model_e").text(msg.data['model']);
						$('#chushi_batch_e').text(msg.data['batch']);
						$('#chushi_starttime_e').text(msg.data['starttime']);
						$('#chushi_number_e').val(msg.data['number']);
						$('#chushi_people_e').val(msg.data['people']);
						$('#chushi_remark_e').val(msg.data['remark']);
						$('#chushi_remark_label').html('备注');
						$('#chushi_batch_e').val(msg.data['batch']);
						$('#chushi_flag_e').val(1);
						$('#chushi_button_e').val(2);
						$('#chushi_id_e').val(msg.data['id']);
						//显示修改窗口
						$('#chushi_edit').css("display","");
					}else{
						alert(msg.info);
					}
					
				}
			});
		}								
	});
	//初试修改人数按钮
	$('#lc_chushi_mdpeople').click(function(){
		$('#chushi_edit').css("display","none");
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample_1 .checkboxes:checked').each(function () {
			id+=$(this).val();
			flag+=1;
		});
		if(flag>1){
			$('#chushi_edit').css("display","none");
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
						$("#chushi_model_e").text(msg.data['model']);
						$('#chushi_batch_e').text(msg.data['batch']);
						$('#chushi_starttime_e').text(msg.data['starttime']);
						$('#chushi_number_e').val(msg.data['number']);
						$('#chushi_people_e').val(msg.data['people']);
						$('#chushi_remark_e').val(msg.data['remark']);
						$('#chushi_remark_label').html('备注');
						$('#chushi_batch_e').val(msg.data['batch']);
						$('#chushi_flag_e').val(msg.data['flag']);
						$('#chushi_button_e').val(3);
						$('#chushi_id_e').val(msg.data['id']);
						//显示修改窗口
						$('#chushi_edit').css("display","");
					}else{
						alert(msg.info);
					}
					
				}
			});
		}
	});
	//报废按钮
	$('#lc_chushi_scrap').click(function(){
		$('#chushi_edit').css("display","none");
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample_1 .checkboxes:checked').each(function () {
			id+=$(this).val();
			flag+=1;
		});
		if(flag>1){
			$('#chushi_edit').css("display","none");
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
						$("#chushi_model_e").text(msg.data['model']);
						$('#chushi_batch_e').text(msg.data['batch']);
						$('#chushi_starttime_e').text(msg.data['starttime']);
						$('#chushi_number_e').val(msg.data['number']);
						$('#chushi_people_e').val(msg.data['people']);
						$('#chushi_remark_e').val(msg.data['remark']);
						$('#chushi_remark_label').html('备注<span class="required">*</span>');
						$('#chushi_batch_e').val(msg.data['batch']);
						$('#chushi_flag_e').val(5);
						$('#chushi_button_e').val(4);
						$('#chushi_id_e').val(msg.data['id']);
						//显示修改窗口
						$('#chushi_edit').css("display","");
					}else{
						alert(msg.info);
					}
					
				}
			});
		}
	});
	
	//初试修改按钮提交数据
	var form1 = $('#form_chushi_edit');
	var error1 = $('.alert-error', form1);
	var success1 = $('.alert-success', form1);
	form1.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			chushi_number_e: {
				required: true,
				digits: true
			},
			chushi_people_e: {
				required: true,
				digits: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			chushi_number_e : {
				required : "数量不能为空！",
				digits: "数量只能是数字!",
			},
			chushi_people_e : {
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
			var url=$('#form_chushi_edit').attr('name');
			var number=$('#chushi_number_e').val();
			var people=$('#chushi_people_e').val();
			var remark=$('#chushi_remark_e').val();
			var starttime=$('#chushi_starttime_e').text();
			var batch=$('#chushi_batch_e').val();
			var flag=$('#chushi_flag_e').val();
			var buttonid=$('#chushi_button_e').val();
			var id=$('#chushi_id_e').val();
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
	//初试数据结束

	
	
});