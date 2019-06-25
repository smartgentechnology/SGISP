// JavaScript Document
$(function(){
	//添加所有按钮
	$('#lc_columnset_addall').click(function(){
		var url=$(this).attr('name');
		var module=$('#columnset_module_a').val();
		$.ajax({
			url:url,
			type:'GET',
			data:{
				module:module
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
	});
	//添加按钮
	$('#lc_columnset_add').click(function(){
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
	$('#lc_columnset_edit').click(function(){
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample_1 .checkboxes:checked').each(function () {
			id+=$(this).val()+",";
			flag+=1;
		});
		if(flag>1){
			$('#edit').css("display","none");
			alert('不能同时修改多个计划！');
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
						$("#columnset_columnid_e option[value='"+msg.data['columnid']+"']").attr("selected", true);
						$('#columnset_rank_e').val(msg.data['rank']);
						$('#columnset_width_e').val(msg.data['width']);
						$('#columnset_module_e').val(msg.data['module']);
						$('#columnset_id_e').val(msg.data['id']);
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
	$('#lc_columnset_del').click(function(){
		//关闭窗口
		$('#add').css("display","none");
		$('#edit').css("display","none");
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
	//添加部门验证
	var form2 = $('#form_columnset_add');
	var error2 = $('.alert-error', form2);
	var success2 = $('.alert-success', form2);
	form2.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			columnset_rank_a: {
				required: true
			},
			columnset_width_a: {
				required: true
			}
		},

		messages: { // custom messages for radio buttons and checkboxes
			columnset_rank_a : {  
				required : "顺序不能为空！",
			},
			columnset_width_a: {
				required: "宽度不能为空！",
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
			var url=$('#form_columnset_add').attr('name');
			var columnid=$('#columnset_columnid_a').val();
			var rank=$('#columnset_rank_a').val();
			var width=$('#columnset_width_a').val();
			var module=$('#columnset_module_a').val();
			
			$.ajax({
				url:url,
				type:'POST',
				data:{
					columnid:columnid,
					rank:rank,
					width:width,
					module:module
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
	//修改部门验证
	var form3 = $('#form_columnset_edit');
	var error3 = $('.alert-error', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			columnset_rank_e: {
				required: true
			},
			columnset_width_e: {
				required: true
			}
		},

		messages: { // custom messages for radio buttons and checkboxes
			columnset_rank_e : {  
				required : "顺序不能为空！",
			},
			columnset_width_e: {
				required: "宽度不能为空！",
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
			var url=$('#form_columnset_edit').attr('name');
			var columnid=$('#columnset_columnid_e').val();
			var rank=$('#columnset_rank_e').val();
			var width=$('#columnset_width_e').val();
			var module=$('#columnset_module_e').val();
			var id=$('#columnset_id_e').val();
			$.ajax({
				url:url,
				type:'POST',
				data:{
					columnid:columnid,
					rank:rank,
					width:width,
					module:module,
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