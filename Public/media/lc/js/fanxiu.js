// JavaScript Document
$(function(){
	//方案预览
	$("[class='expressid']").click(function(){
		var id=$(this).attr("name");
		var url=$('#expressid_view').attr('name');
		$.ajax({
			url:url,
			type:'GET',
			data:{
				id:id
			},
			success: function(msg){
				if(msg.state!='error'){
					var str='<table width="100%"><tr><td>时间</td><td>记录</td></tr>';
					for(var i=0;i<msg.data.length;i++){
						str=str+"<tr><td>"+msg.data[i]['AcceptTime']+"</td><td>"+msg.data[i]['AcceptStation']+"</td></tr>";
					}
					str=str+"</table>";
					$('#lab_expressid_view').html(str);
				}else{
					$('#lab_expressid_view').text('');
				}
				
			}
		});
		$('#expressid_view').modal({
			backdrop: 'static',//点击空白处不关闭对话框
			keyboard: false,//键盘关闭对话框
			show:true//弹出对话框
		});
	});
	//修改按钮
	$('#lc_fanxiu_edit').click(function(){
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample .checkboxes:checked').each(function () {
			id+=$(this).val()+",";
			flag+=1;
		});
		if(flag>1){
			$('#edit').css("display","none");
			$('#cause').css("display","none");
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
						$('#fanxiu_customer_e').val(msg.data['customer']);
						$("#fanxiu_result_e option[value='"+msg.data['result']+"']").attr("selected", true);
						$("#fanxiu_product_e option[value='"+msg.data['product']+"']").attr("selected", true);
						$("#fanxiu_product_e").trigger("liszt:updated");
						$('#fanxiu_barcode_e').val(msg.data['barcode']);
						$('#fanxiu_pdate_e').val(msg.data['pdate']);
						$("#fanxiu_person_e option[value='"+msg.data['person']+"']").attr("selected", true);
						$("#fanxiu_person_e").trigger("liszt:updated");
						$('#fanxiu_remark_e').val(msg.data['remark']);
						$('#fanxiu_id_e').val(msg.data['id']);
						$('#fanxiu_qty_e').val(msg.data['qty']);
						
						//显示修改窗口
						$('#edit').css("display","");
						$('#cause').css("display","none");
						$('#remark').css("display","none");
					}else{
						alert(msg.info);
					}
					
				}
			});
		}								
	});
	//隐藏批改备注面板
	$('#removeremark').click(function(){
		$('#remark').css("display","none");			 
	});
	//隐藏修改面板
	$('#removeedit').click(function(){
		$('#edit').css("display","none");			 
	});
	//分析原因修改面板
	$('#causeedit').click(function(){
		$('#cause').css("display","none");			 
	});
	
	//修改部门验证
	var form3 = $('#form_fanxiu_edit');
	var error3 = $('.alert-error', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			fanxiu_customer_e: {
				required: true
			},
			fanxiu_barcode_e: {
				required: true
			},
			fanxiu_qty_e: {
				required: true
			}
		},

		messages: { // custom messages for radio buttons and checkboxes
			fanxiu_customer_e : {  
				required : "客户不能为空！",
			},
			fanxiu_barcode_e : {  
				required : "条形码不能为空！",
			},
			fanxiu_qty_e : {  
				required : "数量不能为空！",
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
			var url=$('#form_fanxiu_edit').attr('name');
			var customer=$('#fanxiu_customer_e').val();
			var result=$('#fanxiu_result_e').val();
			var product=$('#fanxiu_product_e').val();
			var person=$('#fanxiu_person_e').val();
			var barcode=$('#fanxiu_barcode_e').val();
			var remark=$('#fanxiu_remark_e').val();
			var pdate=$('#fanxiu_pdate_e').val();
			var id=$('#fanxiu_id_e').val();
			var qty=$('#fanxiu_qty_e').val();
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
					pdate:pdate,
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
	$('#fanxiu_pdate_e').datepicker({
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
	//修改按钮
	$('#lc_fanxiu_fenxi').click(function(){
		var url=$(this).attr('name');
		var id="";
		var flag=0;
		$('#sample .checkboxes:checked').each(function () {
			id+=$(this).val()+",";
			flag+=1;
		});
		if(flag>1){
			$('#edit').css("display","none");
			$('#cause').css("display","none");
			alert('不能同时修改多条信息！');
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
						$("#fanxiucause_bad_e option[value='"+msg.data["bad"]+"']").attr("selected", true);
						$('#fanxiucause_bad_cause_e').val(msg.data["bad_cause"]);
						$('#fanxiucause_improve_e').val(msg.data["improve"]);
						$('#fanxiucause_id_e').val(msg.data['id']);
						//显示修改窗口
						$('#edit').css("display","none");
						$('#cause').css("display","");
						$('#remark').css("display","none");
					}else{
						alert(msg.info);
					}
					
				}
			});
		}								
	});
	//修改部门验证
	var form2 = $('#form_fanxiu_cause');
	var error2 = $('.alert-error', form2);
	var success2 = $('.alert-success', form2);
	form2 .validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			fanxiucause_bad_cause_e: {
				required: true
			},
			fanxiucause_improve_e: {
				required: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			fanxiucause_bad_cause_e : {  
				required : "原因分析不能为空！",
			},
			fanxiucause_improve_e : {  
				required : "改进方案不能为空！",
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
			var url=$('#form_fanxiu_cause').attr('name');
			var bad=$('#fanxiucause_bad_e').val();
			var bad_cause=$('#fanxiucause_bad_cause_e').val();
			var improve=$('#fanxiucause_improve_e').val();
			var id=$('#fanxiucause_id_e').val();
			$.ajax({
				url:url,
				type:'POST',
				data:{
					bad:bad,
					bad_cause:bad_cause,
					improve:improve,
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
	//批改备注按钮
	$('#lc_fanxiu_remark').click(function(){
		var url=$(this).attr('name');
		var id="";
		var flag=0;
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
				if(msg.state!='error'){
					//设置修改窗口的值	
					$('#fanxiu_remark_r').val(msg.data);
					$('#fanxiu_id_r').val(id);
					//显示修改窗口
					$('#edit').css("display","none");
					$('#cause').css("display","none");
					$('#remark').css("display","");
					
				}else{
					alert(msg.info);
				}
				
			}
		});								
	});
	
	//修改部门验证
	var form2 = $('#form_fanxiu_remark');
	var error2 = $('.alert-error', form2);
	var success2 = $('.alert-success', form2);
	form2 .validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {},

		messages: {},
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
			var url=$('#form_fanxiu_remark').attr('name');
			var remark=$('#fanxiu_remark_r').val();
			var id=$('#fanxiu_id_r').val();
			$.ajax({
				url:url,
				type:'POST',
				data:{
					remark:remark,
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