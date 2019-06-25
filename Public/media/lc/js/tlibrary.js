// JavaScript Document
$(function(){
	//添加按钮
	$('#lc_tlibrary_add').click(function(){
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
	$('#lc_tlibrary_edit').click(function(){
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample .checkboxes:checked').each(function () {
			id+=$(this).val()+",";
			flag+=1;
		});
		if(flag>1){
			$('#edit').css("display","none");
			alert('不能同时修改多个翻译！');
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
						$("#tlibrary_flag_e option[value='"+msg.data['flag']+"']").attr("selected", true);
						$('#tlibrary_cn_e').val(msg.data['cn']);
						$('#tlibrary_en_e').val(msg.data['en']);
						$('#tlibrary_abben_e').val(msg.data['abben']);
						$('#tlibrary_sp_e').val(msg.data['sp']);
						$('#tlibrary_jp_e').val(msg.data['jp']);
						$('#tlibrary_ru_e').val(msg.data['ru']);
						$('#tlibrary_remarks_e').val(msg.data['remarks']);
						$('#tlibrary_id_e').val(msg.data['id']);
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
	$('#lc_tlibrary_del').click(function(){
		//关闭窗口
		$('#add').css("display","none");
		$('#edit').css("display","none");
		var url=$(this).attr('name');
		var id="";
		$('#sample .checkboxes:checked').each(function () {
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
	//添加翻译验证
	var form2 = $('#form_tlibrary_add');
	var error2 = $('.alert-error', form2);
	var success2 = $('.alert-success', form2);
	form2.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			tlibrary_cn_a: {
				required: true
			},
			tlibrary_en_a: {
				required: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			tlibrary_cn_a: {
				required: "中文不能为空！",
			},
			tlibrary_en_a : {  
				required : "英文不能为空！",
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
			var url=$('#form_tlibrary_add').attr('name');
			var flag=$('#tlibrary_flag_a').val();
			var cn=$('#tlibrary_cn_a').val();
			var en=$('#tlibrary_en_a').val();
			var abben=$('#tlibrary_abben_a').val();
			var sp=$('#tlibrary_sp_a').val();
			var jp=$('#tlibrary_jp_a').val();
			var ru=$('#tlibrary_ru_a').val();
			var remarks=$('#tlibrary_remarks_a').val();
			
			$.ajax({
				url:url,
				type:'POST',
				data:{
					flag:flag,
					cn:cn,
					en:en,
					abben:abben,
					sp:sp,
					jp:jp,
					ru:ru,
					remarks:remarks
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
	//修改翻译验证
	var form3 = $('#form_tlibrary_edit');
	var error3 = $('.alert-error', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			tlibrary_cn_a: {
				required: true
			},
			tlibrary_en_a: {
				required: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			tlibrary_cn_a: {
				required: "中文不能为空！",
			},
			tlibrary_en_a : {  
				required : "英文不能为空！",
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
			var url=$('#form_tlibrary_edit').attr('name');
			var flag=$('#tlibrary_flag_e').val();
			var cn=$('#tlibrary_cn_e').val();
			var en=$('#tlibrary_en_e').val();
			var abben=$('#tlibrary_abben_e').val();
			var sp=$('#tlibrary_sp_e').val();
			var jp=$('#tlibrary_jp_e').val();
			var ru=$('#tlibrary_ru_e').val();
			var remarks=$('#tlibrary_remarks_e').val();
			var id=$('#tlibrary_id_e').val();
			$.ajax({
				url:url,
				type:'POST',
				data:{
					flag:flag,
					cn:cn,
					en:en,
					abben:abben,
					sp:sp,
					jp:jp,
					ru:ru,
					remarks:remarks,
					id:id
					
				},
				success: function(msg){
					if(msg.state!='error'){
						alert(msg.info);
						
						location.reload();
						//$('#edit').css("display","none");
					}else{
						alert(msg.info);
					}
					
				}
			});
			
		}
	});
	
	
});