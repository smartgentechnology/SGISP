// JavaScript Document
$(function(){
	//添加按钮
	$('#lc_workplan_add').click(function(){
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
	$('#lc_workplan_edit').click(function(){
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample .checkboxes:checked').each(function () {
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
						$("#workplan_dept_id_e option[value='"+msg.data['dept_id']+"']").attr("selected", true);
						$('#workplan_month_e').val(msg.data['month']);
						$('#workplan_number_e').val(msg.data['number']);
						$('#workplan_content_e').val(msg.data['content']);
						$('#workplan_resource_e').val(msg.data['resource']);
						$('#workplan_date_e').val(msg.data['date']);
						$("#workplan_manager_id_e option[value='"+msg.data['manager_id']+"']").attr("selected", true);
						$("#workplan_state_e option[value='"+msg.data['state']+"']").attr("selected", true);
						$('#workplan_remarks_e').val(msg.data['remarks']);
						$('#workplan_id_e').val(msg.data['id']);
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
	$('#lc_workplan_del').click(function(){
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
	//添加部门验证
	var form2 = $('#form_workplan_add');
	var error2 = $('.alert-error', form2);
	var success2 = $('.alert-success', form2);
	form2.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			workplan_month_a: {
				required: true
			},
			workplan_number_a: {
				digits: true
			},
			workplan_content_a: {
				required: true
			},
			workplan_date_a: {
				required: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			workplan_month_a : {  
				required : "计划月份不能为空！",
			},
			workplan_number_a: {
				digits: "计划编号只能是数字",
			},
			workplan_content_a : {  
				required : "计划内容不能为空！",
			},
			workplan_date_a : {  
				required : "计划完成时间不能为空！",
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
			var url=$('#form_workplan_add').attr('name');
			var dept_id=$('#workplan_dept_id_a').val();
			var month=$('#workplan_month_a').val();
			var number=$('#workplan_number_a').val();
			var content=$('#workplan_content_a').val();
			var date=$('#workplan_date_a').val();
			var manager_id=$('#workplan_manager_id_a').val();
			var state=$('#workplan_state_a').val();
			var remarks=$('#workplan_remarks_a').val();
			var resource=$('#workplan_resource_a').val();
			$.ajax({
				url:url,
				type:'POST',
				data:{
					dept_id:dept_id,
					month:month,
					number:number,
					content:content,
					date:date,
					manager_id:manager_id,
					state:state,
					remarks:remarks,
					resource:resource
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
	var form3 = $('#form_workplan_edit');
	var error3 = $('.alert-error', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			workplan_month_e: {
				required: true
			},
			workplan_number_e: {
				digits: true
			},
			workplan_content_e: {
				required: true
			},
			workplan_date_e: {
				required: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			workplan_month_e : {  
				required : "计划月份不能为空！",
			},
			workplan_number_e: {
				digits: "计划编号只能是数字",
			},
			workplan_content_e : {  
				required : "计划内容不能为空！",
			},
			workplan_date_e : {  
				required : "计划完成时间不能为空！",
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
			var url=$('#form_workplan_edit').attr('name');
			var dept_id=$('#workplan_dept_id_e').val();
			var month=$('#workplan_month_e').val();
			var number=$('#workplan_number_e').val();
			var content=$('#workplan_content_e').val();
			var date=$('#workplan_date_e').val();
			var manager_id=$('#workplan_manager_id_e').val();
			var state=$('#workplan_state_e').val();
			var remarks=$('#workplan_remarks_e').val();
			var resource=$('#workplan_resource_e').val();
			var id=$('#workplan_id_e').val();
			$.ajax({
				url:url,
				type:'POST',
				data:{
					dept_id:dept_id,
					month:month,
					number:number,
					content:content,
					date:date,
					manager_id:manager_id,
					state:state,
					remarks:remarks,
					resource:resource,
					id:id
					
				},
				success: function(msg){
					if(msg.state!='error'){
						alert(msg.info);
						//$('#work'+id).html('<td><input type="checkbox" class="checkboxes" value="'+msg.data["id"]+'" /></td><td>'+msg.data["number"]+'</td><td>'+msg.data["content"]+'</td><td>'+msg.data["date"]+'</td><td>'+msg.data["manager_name"]+'</td><td>'+msg.data["state"]+'</td><td>'+msg.data["remarks"]+'</td><td>'+msg.data["add_time"]+'</td>');
						location.reload();
						//$('#edit').css("display","none");
					}else{
						alert(msg.info);
					}
					
				}
			});
			
		}
	});
	//计划月份
	$('#workplan_month_a').datepicker({
		dateFormat: "yy-mm", 
		monthNames: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		monthNamesShort: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		changeYear: true,          // 年下拉菜单  
		changeMonth: true,             // 月下拉菜单  
		showButtonPanel: true,         // 显示按钮面板  
		showMonthAfterYear: true,  // 月份显示在年后面  
		currentText: "本月",         // 当前日期按钮提示文字  
		closeText: "关闭",           // 关闭按钮提示文字  
		yearRange: "-10:+10",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function(dateText, inst) {// 关闭事件   
		}  

	});
	$('#workplan_month_e').datepicker({
		dateFormat: "yy-mm", 
		monthNames: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		monthNamesShort: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		changeYear: true,          // 年下拉菜单  
		changeMonth: true,             // 月下拉菜单  
		showButtonPanel: true,         // 显示按钮面板  
		showMonthAfterYear: true,  // 月份显示在年后面  
		currentText: "本月",         // 当前日期按钮提示文字  
		closeText: "关闭",           // 关闭按钮提示文字  
		yearRange: "-10:+10",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function(dateText, inst) {// 关闭事件   
		}  

	});
	/**/
	$('#workplan_dept_id_a').change(function(){
		var depturl=$('#change_deptid_a').attr('name');
		var monthurl=$('#change_month_a').attr('name');
		var dept_id=$('#workplan_dept_id_a').val();
		var month=$('#workplan_month_a').val();
		$.ajax({
			url:depturl,
			type:'GET',
			data:{
				dept_id:dept_id,
				month:month
			},
			success: function(msg){
				if(msg.state!='error'){
					$('#workplan_manager_id_a').empty();
					var plan_number;
					$.ajax({
						url:monthurl,
						success: function(msg){
							plan_number=msg.data;
							$('#workplan_number_a').val(plan_number);
						}	
					});
					if(msg.data!=0){
						for(var i=0; i<msg.data.length;i++){
							$('#workplan_manager_id_a').append("<option value="+msg.data[i]['id']+">"+msg.data[i]['name']+"</option>");
						}
					}
				}else{
					alert(msg.info);
				}
				
			}
		});
		
	});
	$('#workplan_month_a').change(function(){
		var depturl=$('#change_deptid_a').attr('name');
		var monthurl=$('#change_month_a').attr('name');
		var dept_id=$('#workplan_dept_id_a').val();
		var month=$('#workplan_month_a').val();
		$.ajax({
			url:depturl,
			type:'GET',
			data:{
				dept_id:dept_id,
				month:month
			},
			success: function(msg){
				if(msg.state!='error'){
					
					var plan_number;
					$.ajax({
						url:monthurl,
						success: function(msg){
							plan_number=msg.data;
							$('#workplan_number_a').val(plan_number);
						}	
					});
					
					
				}else{
					alert(msg.info);
				}
				
			}
		});
		
	});
	/**/
	$('#workplan_dept_id_e').change(function(){
		var depturl=$('#change_deptid_e').attr('name');
		var monthurl=$('#change_month_e').attr('name');
		var dept_id=$('#workplan_dept_id_e').val();
		var month=$('#workplan_month_e').val();
		$.ajax({
			url:depturl,
			type:'GET',
			data:{
				dept_id:dept_id,
				month:month
			},
			success: function(msg){
				if(msg.state!='error'){
					$('#workplan_manager_id_e').empty();
					var plan_number;
					$.ajax({
						url:monthurl,
						success: function(msg){
							plan_number=msg.data;
							$('#workplan_number_e').val(plan_number);
						}	
					});
					if(msg.data!=0){
						for(var i=0; i<msg.data.length;i++){
							$('#workplan_manager_id_e').append("<option value="+msg.data[i]['id']+">"+msg.data[i]['name']+"</option>");
						}
					}
				}else{
					alert(msg.info);
				}
				
			}
		});
		
	});
	$('#workplan_month_e').change(function(){
		var depturl=$('#change_deptid_e').attr('name');
		var monthurl=$('#change_month_e').attr('name');
		var dept_id=$('#workplan_dept_id_e').val();
		var month=$('#workplan_month_e').val();
		$.ajax({
			url:depturl,
			type:'GET',
			data:{
				dept_id:dept_id,
				month:month
			},
			success: function(msg){
				if(msg.state!='error'){
					var plan_number;
					$.ajax({
						url:monthurl,
						success: function(msg){
							plan_number=msg.data;
							$('#workplan_number_e').val(plan_number);
						}	
					});
					
					
				}else{
					alert(msg.info);
				}
				
			}
		});
		
	});
	//计划日期查询
	$('#workplan_month_dir_start').datepicker({
		dateFormat: "yy-mm-dd", 
		monthNames: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		monthNamesShort: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		changeYear: true,          // 年下拉菜单  
		changeMonth: true,             // 月下拉菜单  
		showButtonPanel: true,         // 显示按钮面板  
		showMonthAfterYear: true,  // 月份显示在年后面  
		currentText: "本月",         // 当前日期按钮提示文字  
		closeText: "关闭",           // 关闭按钮提示文字  
		yearRange: "-10:+10",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function( selectedDate ) {
			$( "#workplan_month_dir_end" ).datepicker( "option", "minDate", selectedDate );
		}   

	});
	$('#workplan_month_dir_end').datepicker({
		dateFormat: "yy-mm-dd", 
		monthNames: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		monthNamesShort: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		changeYear: true,          // 年下拉菜单  
		changeMonth: true,             // 月下拉菜单  
		showButtonPanel: true,         // 显示按钮面板  
		showMonthAfterYear: true,  // 月份显示在年后面  
		currentText: "本月",         // 当前日期按钮提示文字  
		closeText: "关闭",           // 关闭按钮提示文字  
		yearRange: "-10:+10",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function( selectedDate ) {
        $( "#workplan_month_dir_start" ).datepicker( "option", "maxDate", selectedDate );
      }    

	});
	//完成日期查询
	$('#workplan_date_dir_start').datepicker({
		dateFormat: "yy-mm-dd", 
		monthNames: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		monthNamesShort: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		changeYear: true,          // 年下拉菜单  
		changeMonth: true,             // 月下拉菜单  
		showButtonPanel: true,         // 显示按钮面板  
		showMonthAfterYear: true,  // 月份显示在年后面  
		currentText: "本月",         // 当前日期按钮提示文字  
		closeText: "关闭",           // 关闭按钮提示文字  
		yearRange: "-10:+10",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function( selectedDate ) {
			$( "#workplan_date_dir_end" ).datepicker( "option", "minDate", selectedDate );
		}  

	});
	$('#workplan_date_dir_end').datepicker({
		dateFormat: "yy-mm-dd", 
		monthNames: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		monthNamesShort: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		changeYear: true,          // 年下拉菜单  
		changeMonth: true,             // 月下拉菜单  
		showButtonPanel: true,         // 显示按钮面板  
		showMonthAfterYear: true,  // 月份显示在年后面  
		currentText: "本月",         // 当前日期按钮提示文字  
		closeText: "关闭",           // 关闭按钮提示文字  
		yearRange: "-10:+10",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function( selectedDate ) {
        $( "#workplan_date_dir_start" ).datepicker( "option", "maxDate", selectedDate );
      }  

	});
	
});