// JavaScript Document
$(function(){
	//添加按钮
	$('#lc_pschedule_add').click(function(){
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
	//导出按钮
	/*
	$('#lc_pschedule_export').click(function(){
		var url=$(this).attr('name');
		$.ajax({
			url:url,
			success: function(msg){
				
				
			}
		});								
	});
	*/
	//隐藏添加面板
	$('#removeadd').click(function(){
		$('#add').css("display","none");			 
	});
	//隐藏修改面板
	$('#removeedit').click(function(){
		$('#edit').css("display","none");			 
	});
	//修改按钮
	$('#lc_pschedule_edit').click(function(){
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample .checkboxes:checked').each(function () {
			id+=$(this).val();
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
						$("#pschedule_model_e").val(msg.data['model']);
						$('#pschedule_batch_e').val(msg.data['batch']);
						$('#pschedule_number_e').val(msg.data['number']);
						$('#pschedule_remark_e').val(msg.data['remark']);
						$('#pschedule_ontime_e').val(msg.data['ontime']);
						$('#pschedule_downtime_e').val(msg.data['downtime']);
						$('#pschedule_id_e').val(msg.data['id']);
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
	$('#lc_pschedule_del').click(function(){
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
	//添加
	var form2 = $('#form_pschedule_add');
	var error2 = $('.alert-error', form2);
	var success2 = $('.alert-success', form2);
	form2.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			pschedule_model_a: {
				required: true
			},
			pschedule_batch_a: {
				required: true
			},
			pschedule_number_a: {
				required: true,
				digits: true
			},
			pschedule_ontime_a: {
				required: true
			},
			pschedule_downtime_a: {
				required: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			pschedule_model_a : {  
				required : "型号不能为空！",
			},
			pschedule_batch_a: {
				required : "批号不能为空！",
			},
			pschedule_number_a : {
				required : "数量不能为空！",
				digits: "数量只能是数字!",
			},
			pschedule_ontime_a : {  
				required : "上线日期不能为空！",
			},
			pschedule_downtime_a : {  
				required : "下线日期不能为空！",
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
			var url=$('#form_pschedule_add').attr('name');
			var model=$('#pschedule_model_a').val();
			var batch=$('#pschedule_batch_a').val();
			var number=$('#pschedule_number_a').val();
			var remark=$('#pschedule_remark_a').val();
			var ontime=$('#pschedule_ontime_a').val();
			var downtime=$('#pschedule_downtime_a').val();
			if(number==0){
				alert("数量不能为0！");	
			}else{
				$.ajax({
					url:url,
					type:'POST',
					data:{
						model:model,
						batch:batch,
						number:number,
						remark:remark,
						ontime:ontime,
						downtime:downtime
						
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
	//修改
	var form3 = $('#form_pschedule_edit');
	var error3 = $('.alert-error', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			pschedule_model_a: {
				required: true
			},
			pschedule_batch_a: {
				required: true
			},
			pschedule_number_a: {
				required: true,
				digits: true
			},
			pschedule_ontime_a: {
				required: true
			},
			pschedule_downtime_a: {
				required: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			pschedule_model_a : {  
				required : "型号不能为空！",
			},
			pschedule_batch_a: {
				required : "批号不能为空！",
			},
			pschedule_number_a : {
				required : "数量不能为空！",
				digits: "数量只能是数字!",
			},
			pschedule_ontime_a : {  
				required : "上线日期不能为空！",
			},
			pschedule_downtime_a : {  
				required : "下线日期不能为空！",
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
			var url=$('#form_pschedule_edit').attr('name');
			var model=$('#pschedule_model_e').val();
			var batch=$('#pschedule_batch_e').val();
			var number=$('#pschedule_number_e').val();
			var remark=$('#pschedule_remark_e').val();
			var ontime=$('#pschedule_ontime_e').val();
			var downtime=$('#pschedule_downtime_e').val();
			var id=$('#pschedule_id_e').val();
			if(number==0){
				alert("数量不能为0！");	
			}else{
				$.ajax({
					url:url,
					type:'POST',
					data:{
						model:model,
						batch:batch,
						number:number,
						remark:remark,
						ontime:ontime,
						downtime:downtime,
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
	//计划月份
	$('#pschedule_ontime_a').datepicker({
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
        $( "#pschedule_downtime_a" ).datepicker( "option", "minDate", selectedDate );
      }  

	});
	$('#pschedule_downtime_a').datepicker({
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
        $( "#pschedule_ontime_a" ).datepicker( "option", "maxDate", selectedDate );
      } 

	});
	//计划月份
	$('#pschedule_ontime_e').datepicker({
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
			$( "#pschedule_downtime_e" ).datepicker( "option", "minDate", selectedDate );
		}    

	});
	$('#pschedule_downtime_e').datepicker({
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
        $( "#pschedule_ontime_e" ).datepicker( "option", "maxDate", selectedDate );
      }    

	});
	//计划上线导出
	$('#pschedule_ontime_dir_start').datepicker({
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
			$( "#pschedule_ontime_dir_end" ).datepicker( "option", "minDate", selectedDate );
		}   

	});
	$('#pschedule_ontime_dir_end').datepicker({
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
        $( "#pschedule_ontime_dir_start" ).datepicker( "option", "maxDate", selectedDate );
      }    

	});
	//计划下线导出
	$('#pschedule_downtime_dir_start').datepicker({
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
			$( "#pschedule_downtime_dir_end" ).datepicker( "option", "minDate", selectedDate );
		}  

	});
	$('#pschedule_downtime_dir_end').datepicker({
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
        $( "#pschedule_downtime_dir_start" ).datepicker( "option", "maxDate", selectedDate );
      }  

	});
});