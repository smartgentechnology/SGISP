// JavaScript Document
$(function(){
	//出厂添加按钮
	$('#lc_chuchang_add').click(function(){
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
	$('#chuchang_removeedit').click(function(){
		$('#chuchang_edit').css("display","none");			 
	});
	
	//出厂修改按钮
	$('#lc_chuchang_edit').click(function(){
		$('#chuchang_edit').css("display","none");
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample_1 .checkboxes:checked').each(function () {
			id+=$(this).val();
			flag+=1;
		});
		if(flag>1){
			$('#chuchang_edit').css("display","none");
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
						$("#chuchang_model_e").text(msg.data['model']);
						$('#chuchang_batch_e').text(msg.data['batch']);
						$('#chuchang_starttime_e').text(msg.data['starttime']);
						$('#chuchang_number_e').val(msg.data['number']);
						$('#chuchang_people_e').val(msg.data['people']);
						$('#chuchang_remark_e').val(msg.data['remark']);
						$('#chuchang_remark_label').html('备注');
						$('#chuchang_batch_e').val(msg.data['batch']);
						$('#chuchang_flag_e').val(0);
						$('#chuchang_button_e').val(1);
						$('#chuchang_id_e').val(msg.data['id']);
						//显示修改窗口
						$('#chuchang_edit').css("display","");
					}else{
						alert(msg.info);
					}
					
				}
			});
		}								
	});
	//出厂完成按钮
	$('#lc_chuchang_end').click(function(){
		$('#chuchang_edit').css("display","none");
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample_1 .checkboxes:checked').each(function () {
			id+=$(this).val();
			flag+=1;
		});
		if(flag>1){
			$('#chuchang_edit').css("display","none");
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
						$("#chuchang_model_e").text(msg.data['model']);
						$('#chuchang_batch_e').text(msg.data['batch']);
						$('#chuchang_starttime_e').text(msg.data['starttime']);
						$('#chuchang_number_e').val(msg.data['number']);
						$('#chuchang_people_e').val(msg.data['people']);
						$('#chuchang_remark_e').val(msg.data['remark']);
						$('#chuchang_remark_label').html('备注');
						$('#chuchang_batch_e').val(msg.data['batch']);
						$('#chuchang_flag_e').val(1);
						$('#chuchang_button_e').val(2);
						$('#chuchang_id_e').val(msg.data['id']);
						//显示修改窗口
						$('#chuchang_edit').css("display","");
					}else{
						alert(msg.info);
					}
					
				}
			});
		}								
	});
	//出厂修改人数按钮
	$('#lc_chuchang_mdpeople').click(function(){
		$('#chuchang_edit').css("display","none");
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample_1 .checkboxes:checked').each(function () {
			id+=$(this).val();
			flag+=1;
		});
		if(flag>1){
			$('#chuchang_edit').css("display","none");
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
						$("#chuchang_model_e").text(msg.data['model']);
						$('#chuchang_batch_e').text(msg.data['batch']);
						$('#chuchang_starttime_e').text(msg.data['starttime']);
						$('#chuchang_number_e').val(msg.data['number']);
						$('#chuchang_people_e').val(msg.data['people']);
						$('#chuchang_remark_e').val(msg.data['remark']);
						$('#chuchang_remark_label').html('备注');
						$('#chuchang_batch_e').val(msg.data['batch']);
						$('#chuchang_flag_e').val(msg.data['flag']);
						$('#chuchang_button_e').val(3);
						$('#chuchang_id_e').val(msg.data['id']);
						//显示修改窗口
						$('#chuchang_edit').css("display","");
					}else{
						alert(msg.info);
					}
					
				}
			});
		}
	});
	//报废按钮
	$('#lc_chuchang_scrap').click(function(){
		$('#chuchang_edit').css("display","none");
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample_1 .checkboxes:checked').each(function () {
			id+=$(this).val();
			flag+=1;
		});
		if(flag>1){
			$('#chuchang_edit').css("display","none");
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
						$("#chuchang_model_e").text(msg.data['model']);
						$('#chuchang_batch_e').text(msg.data['batch']);
						$('#chuchang_starttime_e').text(msg.data['starttime']);
						$('#chuchang_number_e').val(msg.data['number']);
						$('#chuchang_people_e').val(msg.data['people']);
						$('#chuchang_remark_e').val(msg.data['remark']);
						$('#chuchang_remark_label').html('备注<span class="required">*</span>');
						$('#chuchang_batch_e').val(msg.data['batch']);
						$('#chuchang_flag_e').val(5);
						$('#chuchang_button_e').val(4);
						$('#chuchang_id_e').val(msg.data['id']);
						//显示修改窗口
						$('#chuchang_edit').css("display","");
					}else{
						alert(msg.info);
					}
					
				}
			});
		}
	});
	
	//出厂修改按钮提交数据
	var form1 = $('#form_chuchang_edit');
	var error1 = $('.alert-error', form1);
	var success1 = $('.alert-success', form1);
	form1.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			chuchang_number_e: {
				required: true,
				digits: true
			},
			chuchang_people_e: {
				required: true,
				digits: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			chuchang_number_e : {
				required : "数量不能为空！",
				digits: "数量只能是数字!",
			},
			chuchang_people_e : {
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
			var url=$('#form_chuchang_edit').attr('name');
			var number=$('#chuchang_number_e').val();
			var people=$('#chuchang_people_e').val();
			var remark=$('#chuchang_remark_e').val();
			var starttime=$('#chuchang_starttime_e').text();
			var batch=$('#chuchang_batch_e').val();
			var flag=$('#chuchang_flag_e').val();
			var buttonid=$('#chuchang_button_e').val();
			var id=$('#chuchang_id_e').val();
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