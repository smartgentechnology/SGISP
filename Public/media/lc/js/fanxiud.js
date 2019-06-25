// JavaScript Document
$(function(){
	$('#fanxiudadd').css("display","");
	//添加按钮
	$('#lc_fanxiud_add').click(function(){
		var url=$(this).attr('name');
		$.ajax({
			url:url,
			success: function(msg){
				if(msg.state!='error'){
					$('#edit').css("display","none");
					$('#fanxiudadd').css("display","");				
				}else{
					alert(msg.info);
				}
				
			}
		});								
	});
	//隐藏添加面板
	$('#removeadd').click(function(){
		$('#fanxiudadd').css("display","none");
	});
	//隐藏修改面板
	$('#removeedit').click(function(){
		$('#edit').css("display","none");			 
	});
	
	//修改按钮
	$('#lc_fanxiud_edit').click(function(){
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
						$('#fanxiud_customer_e').val(msg.data['customer']);
						$("#fanxiud_product_e option[value='"+msg.data['product']+"']").attr("selected", true);
						$("#fanxiud_product_e").trigger("liszt:updated");
						$("#fanxiud_result_e option[value='"+msg.data['result']+"']").attr("selected", true);
						$("#fanxiud_person_e option[value='"+msg.data['person']+"']").attr("selected", true);
						$("#fanxiud_person_e").trigger("liszt:updated");
						$('#fanxiud_pdate_e').val(msg.data['pdate']);
						$('#fanxiud_barcode_e').val(msg.data['barcode']);
						$('#fanxiud_remark_e').val(msg.data['remark']);
						$('#fanxiud_id_e').val(msg.data['id']);
						$('#fanxiud_qty_e').val(msg.data['qty']);
						//显示修改窗口
						$('#fanxiudadd').css("display","none");
						$('#edit').css("display","");
					}else{
						alert(msg.info);
					}
					
				}
			});
		}								
	});
	
	
	
	//删除按钮
	$('#lc_fanxiud_del').click(function(){
		//关闭窗口
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
	
	//制单按钮
	$('#lc_fanxiud_tabflag').click(function(){
		//关闭窗口
		$('#edit').css("display","none");
		var url=$(this).attr('name');
		var id="";
		$('#sample .checkboxes:checked').each(function () {
			id+=$(this).val()+",";
		});
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
	});
	//取消制单按钮
	$('#lc_fanxiud_qutabflag').click(function(){
		//关闭窗口
		$('#edit').css("display","none");
		var url=$(this).attr('name');
		var id="";
		$('#sample .checkboxes:checked').each(function () {
			id+=$(this).val()+",";
		});
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
	});
	
	
	//添加部门验证
	var form2 = $('#form_fanxiud_add');
	var error2 = $('.alert-error', form2);
	var success2 = $('.alert-success', form2);
	form2.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			fanxiud_customer_a: {
				required: true
			},
			fanxiud_barcode_a: {
				required: true
			},
			fanxiud_product_a: {
				required: true
			}
		},

		messages: { // custom messages for radio buttons and checkboxes
			fanxiud_customer_a : {  
				required : "客户不能为空！",
			},
			fanxiud_barcode_a : {  
				required : "条形码不能为空！",
			},
			fanxiud_product_a : {  
				required : "型号不能为空！",
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
			var url=$('#form_fanxiud_add').attr('name');
			var customer=$('#fanxiud_customer_a').val();
			var result=$('#fanxiud_result_a').val();
			var person=$('#fanxiud_person_a').val();
			var product=$('#fanxiud_product_a').val();
			var barcode=$('#fanxiud_barcode_a').val();
			var remark=$('#fanxiud_remark_a').val();
			var qty=$('#fanxiud_qty_a').val();
			if(result==5){
				if(qty!=""){
					$.ajax({
						url:url,
						type:'POST',
						data:{
							customer:customer,
							result:result,
							person:person,
							product:product,
							barcode:barcode,
							remark:remark,
							qty:qty
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
				}else{
					alert("批量退回-生产数量不能为空！");
				}
			}else{
				$.ajax({
					url:url,
					type:'POST',
					data:{
						customer:customer,
						result:result,
						person:person,
						product:product,
						barcode:barcode,
						remark:remark,
						qty:qty
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
	//修改部门验证
	var form3 = $('#form_fanxiud_edit');
	var error3 = $('.alert-error', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			fanxiud_customer_e: {
				required: true
			},
			fanxiud_barcode_e: {
				required: true
			},
			fanxiud_qty_e: {
				required: true
			},
			fanxiud_product_e: {
				required: true
			}
		},

		messages: { // custom messages for radio buttons and checkboxes
			fanxiud_customer_e : {  
				required : "客户不能为空！",
			},
			fanxiud_barcode_e : {  
				required : "条形码不能为空！",
			},
			fanxiud_qty_e : {  
				required : "数量不能为空！",
			},
			fanxiud_product_e: {
				required: "型号不能为空！",
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
			var url=$('#form_fanxiud_edit').attr('name');
			var customer=$('#fanxiud_customer_e').val();
			var result=$('#fanxiud_result_e').val();
			var person=$('#fanxiud_person_e').val();
			var product=$('#fanxiud_product_e').val();
			var pdate=$('#fanxiud_pdate_e').val();
			var barcode=$('#fanxiud_barcode_e').val();
			var remark=$('#fanxiud_remark_e').val();
			var id=$('#fanxiud_id_e').val();
			var qty=$('#fanxiud_qty_e').val();
			$.ajax({
				url:url,
				type:'POST',
				data:{
					customer:customer,
					result:result,
					person:person,
					product:product,
					pdate:pdate,
					barcode:barcode,
					remark:remark,
					id:id,
					qty:qty
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
	//修改生产日期
	$('#fanxiud_pdate_e').datepicker({
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
		yearRange: "-30:+30",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function(dateText, inst) {// 关闭事件   
		}  

	});
	
	//计划日期查询
	$('#fanxiud_rdate_dir_start').datepicker({
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
		yearRange: "-30:+30",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function( selectedDate ) {
			$( "#fanxiud_rdate_dir_end" ).datepicker( "option", "minDate", selectedDate );
		}   

	});
	$('#fanxiud_rdate_dir_end').datepicker({
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
		yearRange: "-30:+30",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function( selectedDate ) {
        $( "#fanxiud_rdate_dir_start" ).datepicker( "option", "maxDate", selectedDate );
      }    

	});
	//完成日期查询
	$('#fanxiud_pdate_dir_start').datepicker({
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
		yearRange: "-30:+30",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function( selectedDate ) {
			$( "#fanxiud_pdate_dir_end" ).datepicker( "option", "minDate", selectedDate );
		}  

	});
	$('#fanxiud_pdate_dir_end').datepicker({
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
		yearRange: "-30:+30",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function( selectedDate ) {
        $( "#fanxiud_pdate_dir_start" ).datepicker( "option", "maxDate", selectedDate );
      }  

	});
	
});