// JavaScript Document
$(function(){
	//添加按钮
	$('#lc_nav_add').click(function(){
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
	$('#lc_nav_edit').click(function(){
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
						$("#nav_pid_e option[value='"+msg.data['pid']+"']").attr("selected", true);
						$('#nav_name_e').val(msg.data['name']);
						$('#nav_mca_e').val(msg.data['mca']);
						$('#nav_ico_e').val(msg.data['ico']);
						$('#nav_color_e').val(msg.data['color']);
						$('#nav_order_number_e').val(msg.data['order_number']);
						$('#nav_id_e').val(msg.data['id']);
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
	var form2 = $('#form_nav_add');
	var error2 = $('.alert-error', form2);
	var success2 = $('.alert-success', form2);
	form2.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			nav_name_a: {
				required: true
			},
			nav_mca_a: {
				required: true
			},
			nav_order_number_a: {
				digits: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			nav_name_a : {  
				required : "菜单名不能为空！",
			},
			nav_mca_a : {  
				required : "链接不能为空！",
			},
			nav_order_number_a: {
				digits: "只能输入整数",
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
			var url=$('#form_nav_add').attr('name');
			var pid=$('#nav_pid_a').val();
			var name=$('#nav_name_a').val();
			var mca=$('#nav_mca_a').val();
			var ico=$('#nav_ico_a').val();
			var color=$('#nav_color_a').val();
			var order_number=$('#nav_order_number_a').val();
			
			$.ajax({
				url:url,
				type:'POST',
				data:{
					pid:pid,
					name:name,
					mca:mca,
					ico:ico,
					color:color,
					order_number:order_number
					
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
	var form3 = $('#form_nav_edit');
	var error3 = $('.alert-error', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			nav_name_a: {
				required: true
			},
			nav_mca_a: {
				required: true
			},
			nav_order_number_a: {
				digits: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			nav_name_a : {  
				required : "菜单名不能为空！",
			},
			nav_mca_a : {  
				required : "链接不能为空！",
			},
			nav_order_number_a: {
				digits: "只能输入整数",
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
			var url=$('#form_nav_edit').attr('name');
			var pid=$('#nav_pid_e').val();
			var name=$('#nav_name_e').val();
			var mca=$('#nav_mca_e').val();
			var ico=$('#nav_ico_e').val();
			var color=$('#nav_color_e').val();
			var order_number=$('#nav_order_number_e').val();
			var id=$('#nav_id_e').val();
			$.ajax({
				url:url,
				type:'POST',
				data:{
					pid:pid,
					name:name,
					mca:mca,
					ico:ico,
					color:color,
					order_number:order_number,
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