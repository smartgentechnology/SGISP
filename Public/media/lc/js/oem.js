// JavaScript Document
$(function(){
	//添加按钮
	$('#lc_oem_add').click(function(){
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
	$('#lc_oem_edit').click(function(){
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample .checkboxes:checked').each(function () {
			id+=$(this).val()+",";
			flag+=1;
		});
		if(flag>1){
			$('#edit').css("display","none");
			alert('不能同时修改多个代理商证书！');
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
						$("#oem_name_e").val(msg.data['oem_name']);
						$('#oem_products_e').val(msg.data['oem_products']);
						$('#oem_area_e').val(msg.data['oem_area']);
						$('#startdate_e').val(msg.data['startdate']);
						$('#enddate_e').val(msg.data['enddate']);
						$('#oem_id_e').val(msg.data['oem_id']);
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
	$('#lc_oem_del').click(function(){
		//关闭窗口
		$('#add').css("display","none");
		$('#edit').css("display","none");
		var url=$(this).attr('name');
		var id="";
		$('#sample .checkboxes:checked').each(function () {
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
	//添加部门验证
	var form2 = $('#form_oem_add');
	var error2 = $('.alert-error', form2);
	var success2 = $('.alert-success', form2);
	form2.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			oem_name_a: {
				required: true
			},
			oem_img_a: {
				required: true
			},
			oem_products_a: {
				required: true
			},
			oem_area_a: {
				required: true
			},
			startdate_a: {
				required: true
			},
			enddate_a: {
				required: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			oem_name_a: {  
				required : "代理商名称不能为空！",
			},
			oem_img_a: {
				required: "上传OEM证书不能为空！",
			},
			oem_products_a: {
				required: "代理产品不能为空！",
			},
			oem_area_a: {
				required: "代理区域不能为空！",
			},
			startdate_a: {
				required: "生效日期不能为空！",
			},
			enddate_a: {
				required: "失效日期不能为空！",
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
		
		
	});
	//修改部门验证
	var form3 = $('#form_oem_edit');
	var error3 = $('.alert-error', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			oem_name_e: {
				required: true
			},
			oem_products_e: {
				required: true
			},
			oem_area_e: {
				required: true
			},
			startdate_e: {
				required: true
			},
			enddate_e: {
				required: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			oem_name_e: {  
				required : "代理商名称不能为空！",
			},
			oem_products_e: {
				required: "代理产品不能为空！",
			},
			oem_area_e: {
				required: "代理区域不能为空！",
			},
			startdate_e: {
				required: "生效日期不能为空！",
			},
			enddate_e: {
				required: "失效日期不能为空！",
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
		
	});
	
	//前日期
	$('#startdate_a').datepicker({
		dateFormat: "yy-mm-dd", 
		monthNames: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		monthNamesShort: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		dayNames: [ "星期日","星期一","星期二","星期三","星期四","星期五","星期六" ], 
		dayNamesShort: [ "周日","周一","周二","周三","周四","周五","周六" ], 
		dayNamesMin: [ "日","一","二","三","四","五","六" ], 
		showMonthAfterYear: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear: true,
		yearRange: "-10:+10",
		onClose: function( selectedDate ) {
        $( "#enddate_a" ).datepicker( "option", "minDate", selectedDate );
      }
	});
	//后日期
	$('#enddate_a').datepicker({
		dateFormat: "yy-mm-dd", 
		monthNames: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		monthNamesShort: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		dayNames: [ "星期日","星期一","星期二","星期三","星期四","星期五","星期六" ], 
		dayNamesShort: [ "周日","周一","周二","周三","周四","周五","周六" ], 
		dayNamesMin: [ "日","一","二","三","四","五","六" ], 
		showMonthAfterYear: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear: true,
		yearRange: "-10:+10",
		onClose: function( selectedDate ) {
        $( "#startdate_a" ).datepicker( "option", "maxDate", selectedDate );
      }

	});
	//前日期
	$('#startdate_e').datepicker({
		dateFormat: "yy-mm-dd", 
		monthNames: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		monthNamesShort: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		dayNames: [ "星期日","星期一","星期二","星期三","星期四","星期五","星期六" ], 
		dayNamesShort: [ "周日","周一","周二","周三","周四","周五","周六" ], 
		dayNamesMin: [ "日","一","二","三","四","五","六" ], 
		showMonthAfterYear: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear: true,
		yearRange: "-10:+10",
		onClose: function( selectedDate ) {
        $( "#enddate_e" ).datepicker( "option", "minDate", selectedDate );
      }
	});
	//后日期
	$('#enddate_e').datepicker({
		dateFormat: "yy-mm-dd", 
		monthNames: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		monthNamesShort: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		dayNames: [ "星期日","星期一","星期二","星期三","星期四","星期五","星期六" ], 
		dayNamesShort: [ "周日","周一","周二","周三","周四","周五","周六" ], 
		dayNamesMin: [ "日","一","二","三","四","五","六" ], 
		showMonthAfterYear: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear: true,
		yearRange: "-10:+10",
		onClose: function( selectedDate ) {
        $( "#startdate_e" ).datepicker( "option", "maxDate", selectedDate );
      }

	});
	//前日期
	$('#oem_startdate_dir_start').datepicker({
		dateFormat: "yy-mm-dd", 
		monthNames: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		monthNamesShort: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		dayNames: [ "星期日","星期一","星期二","星期三","星期四","星期五","星期六" ], 
		dayNamesShort: [ "周日","周一","周二","周三","周四","周五","周六" ], 
		dayNamesMin: [ "日","一","二","三","四","五","六" ], 
		showMonthAfterYear: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear: true,
		yearRange: "-10:+10",
		onClose: function( selectedDate ) {
        $( "#oem_startdate_dir_end" ).datepicker( "option", "minDate", selectedDate );
      }
	});
	//后日期
	$('#oem_startdate_dir_end').datepicker({
		dateFormat: "yy-mm-dd", 
		monthNames: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		monthNamesShort: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		dayNames: [ "星期日","星期一","星期二","星期三","星期四","星期五","星期六" ], 
		dayNamesShort: [ "周日","周一","周二","周三","周四","周五","周六" ], 
		dayNamesMin: [ "日","一","二","三","四","五","六" ], 
		showMonthAfterYear: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear: true,
		yearRange: "-10:+10",
		onClose: function( selectedDate ) {
        $( "#oem_startdate_dir_start" ).datepicker( "option", "maxDate", selectedDate );
      }

	});
	//前日期
	$('#oem_enddate_dir_start').datepicker({
		dateFormat: "yy-mm-dd", 
		monthNames: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		monthNamesShort: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		dayNames: [ "星期日","星期一","星期二","星期三","星期四","星期五","星期六" ], 
		dayNamesShort: [ "周日","周一","周二","周三","周四","周五","周六" ], 
		dayNamesMin: [ "日","一","二","三","四","五","六" ], 
		showMonthAfterYear: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear: true,
		yearRange: "-10:+10",
		onClose: function( selectedDate ) {
        $( "#oem_enddate_dir_end" ).datepicker( "option", "minDate", selectedDate );
      }
	});
	//后日期
	$('#oem_enddate_dir_end').datepicker({
		dateFormat: "yy-mm-dd", 
		monthNames: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		monthNamesShort: [ "一月","二月","三月","四月","五月","六月", 
		"七月","八月","九月","十月","十一月","十二月" ], 
		dayNames: [ "星期日","星期一","星期二","星期三","星期四","星期五","星期六" ], 
		dayNamesShort: [ "周日","周一","周二","周三","周四","周五","周六" ], 
		dayNamesMin: [ "日","一","二","三","四","五","六" ], 
		showMonthAfterYear: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear: true,
		yearRange: "-10:+10",
		onClose: function( selectedDate ) {
        $( "#oem_enddate_dir_start" ).datepicker( "option", "maxDate", selectedDate );
      }

	});
	
});