// JavaScript Document
$(function(){
	//添加按钮
	$('#lc_train_add').click(function(){
		var url=$(this).attr('name');
		$.ajax({
			url:url,
			success: function(msg){
				if(msg.state!='error'){
					$('#edit').css("display","none");
					$('#end').css("display","none");
					$('#add').css("display","");
					$('#hr').css("display","none");
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
	//隐藏完成面板
	$('#removeeend').click(function(){
		$('#end').css("display","none");			 
	});
	//隐藏稽核面板
	$('#removehr').click(function(){
		$('#hr').css("display","none");			 
	});
	
	//修改按钮
	$('#lc_train_edit').click(function(){
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
						$("#train_dept_id_e option[value='"+msg.data['dept_id']+"']").attr("selected", true);
						$("#train_ontime_e").val(msg.data['ontime']);
						$('#train_number_e').val(msg.data['number']);
						$('#train_content_e').val(msg.data['train_content']);
						$('#train_people_e').val(msg.data['train_people']);
						$('#train_lecturer_e').val(msg.data['lecturer']);
						$('#train_remark_e').val(msg.data['remark']);
						$('#train_id_e').val(msg.data['id']);
						$("#train_flag_e option[value='"+msg.data['flag']+"']").attr("selected", true);
						//显示修改窗口
						$('#add').css("display","none");
						$('#end').css("display","none");
						$('#edit').css("display","");
						$('#hr').css("display","none");
					}else{
						alert(msg.info);
					}
					
				}
			});
		}								
	});
	//完成按钮
	$('#lc_train_end').click(function(){
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample .checkboxes:checked').each(function () {
			id+=$(this).val();
			flag+=1;
		});
		if(flag>1){
			$('#edit').css("display","none");
			alert('不能同时完成多个计划！');
		}else{
			$.ajax({
				url:url,
				type:'GET',
				data:{
					id:id
				},
				success: function(msg){
					if(msg.state!='error'){
						//设置完成窗口的值
						
						$('#train_id_end').val(msg.data['id']);
						
						//显示修改窗口
						$('#add').css("display","none");
						$('#end').css("display","");
						$('#edit').css("display","none");
						$('#hr').css("display","none");
					}else{
						alert(msg.info);
					}
					
				}
			});
		}								
	});
	//完成按钮
	$('#lc_train_hr').click(function(){
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample .checkboxes:checked').each(function () {
			id+=$(this).val();
			flag+=1;
		});
		if(flag>1){
			$('#edit').css("display","none");
			alert('不能同时稽核多个计划！');
		}else{
			$.ajax({
				url:url,
				type:'GET',
				data:{
					id:id
				},
				success: function(msg){
					if(msg.state!='error'){
						//设置完成窗口的值
						$('#train_id_hr').val(msg.data['id']);
						//显示修改窗口
						$('#add').css("display","none");
						$('#hr').css("display","");
						$('#edit').css("display","none");
						$('#end').css("display","none");
					}else{
						alert(msg.info);
					}
					
				}
			});
		}								
	});
	
	//删除按钮
	$('#lc_train_del').click(function(){
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
	var form2 = $('#form_train_add');
	var error2 = $('.alert-error', form2);
	var success2 = $('.alert-success', form2);
	form2.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			train_ontime_a: {
				required: true
			},
			train_number_a: {
				required: true
			},
			train_content_a: {
				required: true
			},
			train_people_a: {
				required: true
			},
			train_lecturer_a: {
				required: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			train_ontime_a : {  
				required : "计划日期不能为空！",
			},
			train_number_a: {
				required : "编号不能为空！",
			},
			train_content_a : {
				required : "培训主题或内容不能为空！",
			},
			train_people_a : {  
				required : "培训对象不能为空！",
			},
			train_lecturer_a : {  
				required : "培训讲师不能为空！",
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
			var url=$('#form_train_add').attr('name');
			var formData = new FormData($('#form_train_add')[0]);
			$.ajax({
				url:url,
				type:'POST',
				data:formData,
				dataType:'json',
				async: false,  
				cache: false,  
				contentType: false,  
				processData: false,
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
	
	//修改
	var form3 = $('#form_train_edit');
	var error3 = $('.alert-error', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			train_ontime_e: {
				required: true
			},
			train_number_e: {
				required: true
			},
			train_content_e: {
				required: true
			},
			train_people_e: {
				required: true
			},
			train_lecturer_e: {
				required: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			train_ontime_e : {  
				required : "计划日期不能为空！",
			},
			train_number_e: {
				required : "编号不能为空！",
			},
			train_content_e : {
				required : "培训主题或内容不能为空！",
			},
			train_people_e : {  
				required : "培训对象不能为空！",
			},
			train_lecturer_e : {  
				required : "培训讲师不能为空！",
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
			var url=$('#form_train_edit').attr('name');
			var formData = new FormData($('#form_train_edit')[0]);
			$.ajax({
				url:url,
				type:'POST',
				data:formData,
				dataType:'json',
				async: false,  
				cache: false,  
				contentType: false,  
				processData: false,
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
	//修改
	var form4 = $('#form_train_end');
	var error4 = $('.alert-error', form4);
	var success4 = $('.alert-success', form4);
	form4.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			train_downtime_e: {
				required: true
			},
			train_hours_e: {
				required: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			train_downtime_e : {  
				required : "完成日期不能为空！",
			},
			train_hours_e : {  
				required : "培训时长不能为空！",
			}
		},
		
		invalidHandler: function (event, validator) { //display error alert on form submit   
			success4.hide();
			error4.show();
			App.scrollTo(error4, -200);
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
			var url=$('#form_train_end').attr('name');
			var formData = new FormData($('#form_train_end')[0]);
			$.ajax({
				url:url,
				type:'POST',
				data:formData,
				dataType:'json',
				async: false,  
				cache: false,  
				contentType: false,  
				processData: false,
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
	//修改
	var form5 = $('#form_train_hr');
	var error5 = $('.alert-error', form5);
	var success5 = $('.alert-success', form5);
	form5.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			train_checkcontent_e: {
				required: true
			},
			train_money_e: {
				required: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			train_checkcontent_e : {  
				required : "奖励对象不能为空！",
			},
			train_money_e : {  
				required : "奖励金额不能为空！",
			}
		},
		
		invalidHandler: function (event, validator) { //display error alert on form submit   
			success5.hide();
			error5.show();
			App.scrollTo(error5, -200);
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
			var url=$('#form_train_hr').attr('name');
			var checkcontent=$('#train_checkcontent_e').val();
			var money=$('#train_money_e').val();
			var id=$('#train_id_hr').val();
			$.ajax({
				url:url,
				type:'POST',
				data:{
					checkcontent:checkcontent,
					id:id,
					money:money,
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
	
	
	$('#train_dept_id_a').change(function(){
		var monthurl=$('#change_month_a').attr('name');
		var dept_id=$('#train_dept_id_a').val();
		var month=$('#train_ontime_a').val();
		$.ajax({
			url:monthurl,
			type:'GET',
			data:{
				dept_id:dept_id,
				month:month
			},
			success: function(msg){
				if(msg.state!='error'){
					var plan_number;
					plan_number=msg.data;
					$('#train_number_a').val(plan_number);
				}else{
					alert(msg.info);
				}
				
			}
		});
		
	});
	
	$('#train_ontime_a').change(function(){
		var monthurl=$('#change_month_a').attr('name');
		var dept_id=$('#train_dept_id_a').val();
		var month=$('#train_ontime_a').val();
		$.ajax({
			url:monthurl,
			type:'GET',
			data:{
				dept_id:dept_id,
				month:month
			},
			success: function(msg){
				if(msg.state!='error'){
					var plan_number;
					plan_number=msg.data;
					$('#train_number_a').val(plan_number);
				}else{
					alert(msg.info);
				}
				
			}
		});
		
	});
	
	$('#train_dept_id_e').change(function(){
		var monthurl=$('#change_month_e').attr('name');
		var dept_id=$('#train_dept_id_e').val();
		var month=$('#train_ontime_e').val();
		var id=$('#train_id_e').val();
		$.ajax({
			url:monthurl,
			type:'GET',
			data:{
				dept_id:dept_id,
				month:month,
				id:id
			},
			success: function(msg){
				if(msg.state!='error'){
					var plan_number;
					plan_number=msg.data;
					$('#train_number_e').val(plan_number);
				}else{
					alert(msg.info);
				}
				
			}
		});
		
	});
	
	$('#train_ontime_e').change(function(){
		var monthurl=$('#change_month_e').attr('name');
		var dept_id=$('#train_dept_id_e').val();
		var month=$('#train_ontime_e').val();
		var id=$('#train_id_e').val();
		$.ajax({
			url:monthurl,
			type:'GET',
			data:{
				dept_id:dept_id,
				month:month,
				id:id
			},
			success: function(msg){
				if(msg.state!='error'){
					var plan_number;
					plan_number=msg.data;
					$('#train_number_e').val(plan_number);
				}else{
					alert(msg.info);
				}
				
			}
		});
		
	});
	
	//计划月份
	$('#train_ontime_a').datepicker({
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
	
	//计划月份
	$('#train_ontime_e').datepicker({
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
	
	//计划完成日期
	$('#train_downtime_e').datepicker({
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
		onClose: function(dateText, inst) {// 关闭事件  
		}  

	});
	
	//计划日期查询
	$('#train_ontime_dir_start').datepicker({
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
			$( "#train_ontime_dir_end" ).datepicker( "option", "minDate", selectedDate );
		}   

	});
	
	$('#train_ontime_dir_end').datepicker({
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
        $( "#train_ontime_dir_start" ).datepicker( "option", "maxDate", selectedDate );
      	}    

	});
	
	//完成日期查询
	$('#train_downtime_dir_start').datepicker({
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
			$( "#train_downtime_dir_end" ).datepicker( "option", "minDate", selectedDate );
		}  

	});
	$('#train_downtime_dir_end').datepicker({
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
        $( "#train_downtime_dir_start" ).datepicker( "option", "maxDate", selectedDate );
      	}  

	});
});