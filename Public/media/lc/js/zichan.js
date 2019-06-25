// JavaScript Document
$(function(){
	//添加按钮
	$('#lc_zichan_add').click(function(){
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
	$('#lc_zichan_edit').click(function(){
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
						$("#zichan_leixing_e option[value='"+msg.data['leixing']+"']").attr("selected", true);
						$('#zichan_bianma_e').val(msg.data['bianma']);
						$('#zichan_bianmaxiuding_e').val(msg.data['bianmaxiuding']);
						$('#zichan_mingcheng_e').val(msg.data['mingcheng']);
						$('#zichan_mingchengxiuding_e').val(msg.data['mingchengxiuding']);
						$("#zichan_leibie_e option[value='"+msg.data['leibie']+"']").attr("selected", true);
						$('#zichan_xinghao_e').val(msg.data['xinghao']);
						$('#zichan_danjia_e').val(msg.data['danjia']);
						$('#zichan_shuliang_e').val(msg.data['shuliang']);
						$("#zichan_danwei_e option[value='"+msg.data['danwei']+"']").attr("selected", true);
						$('#zichan_ruriqi_e').val(msg.data['ruriqi']);
						$("#zichan_bumen_e option[value='"+msg.data['bumen']+"']").attr("selected", true);
						$('#zichan_didian_e').val(msg.data['didian']);
						$("#zichan_zhuangtai_e option[value='"+msg.data['zhuangtai']+"']").attr("selected", true);
						$('#zichan_beizhu_e').val(msg.data['beizhu']);
						$('#zichan_remark_e').val(msg.data['remark']);
						$('#zichan_chuchangbianhao_e').val(msg.data['chuchangbianhao']);
						$('#zichan_changjia_e').val(msg.data['changjia']);
						$('#zichan_shouxiaoriqi_e').val(msg.data['shouxiaoriqi']);
						$('#zichan_jianyanriqi_e').val(msg.data['jianyanriqi']);
						$('#zichan_daoqiriqi_e').val(msg.data['daoqiriqi']);
						$('#zichan_jigou_e').val(msg.data['jigou']);
						$('#zichan_xiaozhunleixing_e').val(msg.data['xiaozhunleixing']);
						$('#zichan_id_e').val(msg.data['id']);
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
	$('#lc_zichan_del').click(function(){
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
	var form2 = $('#form_zichan_add');
	var error2 = $('.alert-error', form2);
	var success2 = $('.alert-success', form2);
	form2.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			zichan_mingcheng_a: {
				required: true
			},
			zichan_shuliang_a: {
				digits: true,
				required: true
			},
			zichan_didian_a: {
				required: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			zichan_mingcheng_a : {  
				required : "名称不能为空！",
			},
			zichan_shuliang_a: {
				digits: "数量只能是数字！",
				required: "数量不能为空！",
			},
			zichan_didian_a : {  
				required : "存放地点不能为空！",
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
			var url=$('#form_zichan_add').attr('name');
			var leixing=$('#zichan_leixing_a').val();
			var bianma=$('#zichan_bianma_a').val();
			var bianmaxiuding=$('#zichan_bianmaxiuding_a').val();
			var mingcheng=$('#zichan_mingcheng_a').val();
			var mingchengxiuding=$('#zichan_mingchengxiuding_a').val();
			var leibie=$('#zichan_leibie_a').val();
			var xinghao=$('#zichan_xinghao_a').val();
			var danjia=$('#zichan_danjia_a').val();
			var shuliang=$('#zichan_shuliang_a').val();
			var danwei=$('#zichan_danwei_a').val();
			var ruriqi=$('#zichan_ruriqi_a').val();
			var bumen=$('#zichan_bumen_a').val();
			var didian=$('#zichan_didian_a').val();
			var zhuangtai=$('#zichan_zhuangtai_a').val();
			var beizhu=$('#zichan_beizhu_a').val();
			var remark=$('#zichan_remark_a').val();
			var chuchangbianhao=$('#zichan_chuchangbianhao_a').val();
			var changjia=$('#zichan_changjia_a').val();
			var shouxiaoriqi=$('#zichan_shouxiaoriqi_a').val();
			var jianyanriqi=$('#zichan_jianyanriqi_a').val();
			var daoqiriqi=$('#zichan_daoqiriqi_a').val();
			var jigou=$('#zichan_jigou_a').val();
			var xiaozhunleixing=$('#zichan_xiaozhunleixing_a').val();
			
			$.ajax({
				url:url,
				type:'POST',
				data:{
					leixing:leixing,
					bianma:bianma,
					bianmaxiuding:bianmaxiuding,
					mingcheng:mingcheng,
					mingchengxiuding:mingchengxiuding,
					leibie:leibie,
					xinghao:xinghao,
					danjia:danjia,
					shuliang:shuliang,
					danwei:danwei,
					ruriqi:ruriqi,
					bumen:bumen,
					didian:didian,
					zhuangtai:zhuangtai,
					beizhu:beizhu,
					remark:remark,
					chuchangbianhao:chuchangbianhao,
					changjia:changjia,
					shouxiaoriqi:shouxiaoriqi,
					jianyanriqi:jianyanriqi,
					daoqiriqi:daoqiriqi,
					jigou:jigou,
					xiaozhunleixing:xiaozhunleixing
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
	var form3 = $('#form_zichan_edit');
	var error3 = $('.alert-error', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			zichan_mingcheng_a: {
				required: true
			},
			zichan_shuliang_a: {
				digits: true,
				required: true
			},
			zichan_didian_a: {
				required: true
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			zichan_mingcheng_a : {  
				required : "名称不能为空！",
			},
			zichan_shuliang_a: {
				digits: "数量只能是数字！",
				required: "数量不能为空！",
			},
			zichan_didian_a : {  
				required : "存放地点不能为空！",
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
			var url=$('#form_zichan_edit').attr('name');
			var leixing=$('#zichan_leixing_e').val();
			var bianma=$('#zichan_bianma_e').val();
			var bianmaxiuding=$('#zichan_bianmaxiuding_e').val();
			var mingcheng=$('#zichan_mingcheng_e').val();
			var mingchengxiuding=$('#zichan_mingchengxiuding_e').val();
			var leibie=$('#zichan_leibie_e').val();
			var xinghao=$('#zichan_xinghao_e').val();
			var danjia=$('#zichan_danjia_e').val();
			var shuliang=$('#zichan_shuliang_e').val();
			var danwei=$('#zichan_danwei_e').val();
			var ruriqi=$('#zichan_ruriqi_e').val();
			var bumen=$('#zichan_bumen_e').val();
			var didian=$('#zichan_didian_e').val();
			var zhuangtai=$('#zichan_zhuangtai_e').val();
			var beizhu=$('#zichan_beizhu_e').val();
			var remark=$('#zichan_remark_e').val();
			var chuchangbianhao=$('#zichan_chuchangbianhao_e').val();
			var changjia=$('#zichan_changjia_e').val();
			var shouxiaoriqi=$('#zichan_shouxiaoriqi_e').val();
			var jianyanriqi=$('#zichan_jianyanriqi_e').val();
			var daoqiriqi=$('#zichan_daoqiriqi_e').val();
			var jigou=$('#zichan_jigou_e').val();
			var xiaozhunleixing=$('#zichan_xiaozhunleixing_e').val();
			var id=$('#zichan_id_e').val();
			$.ajax({
				url:url,
				type:'POST',
				data:{
					leixing:leixing,
					bianma:bianma,
					bianmaxiuding:bianmaxiuding,
					mingcheng:mingcheng,
					mingchengxiuding:mingchengxiuding,
					leibie:leibie,
					xinghao:xinghao,
					danjia:danjia,
					shuliang:shuliang,
					danwei:danwei,
					ruriqi:ruriqi,
					bumen:bumen,
					didian:didian,
					zhuangtai:zhuangtai,
					beizhu:beizhu,
					remark:remark,
					chuchangbianhao:chuchangbianhao,
					changjia:changjia,
					shouxiaoriqi:shouxiaoriqi,
					jianyanriqi:jianyanriqi,
					daoqiriqi:daoqiriqi,
					jigou:jigou,
					xiaozhunleixing:xiaozhunleixing,
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
	//计划月份
	$('#zichan_ruriqi_a').datepicker({
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
		yearRange: "-20:+20",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function(dateText, inst) {// 关闭事件   
		}  

	});
	$('#zichan_shouxiaoriqi_a').datepicker({
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
		yearRange: "-20:+20",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function(dateText, inst) {// 关闭事件
		}  

	});
	$('#zichan_jianyanriqi_a').datepicker({
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
		yearRange: "-20:+20",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function(dateText, inst) {// 关闭事件
			$( "#zichan_daoqiriqi_a" ).datepicker( "option", "minDate", selectedDate );
		}  

	});
	$('#zichan_daoqiriqi_a').datepicker({
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
		yearRange: "-20:+20",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function(dateText, inst) {// 关闭事件
			$( "#zichan_jianyanriqi_a" ).datepicker( "option", "maxDate", selectedDate );
		}  

	});
	//计划月份
	$('#zichan_ruriqi_e').datepicker({
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
		yearRange: "-20:+20",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function(dateText, inst) {// 关闭事件   
		}  

	});
	$('#zichan_shouxiaoriqi_e').datepicker({
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
		yearRange: "-20:+20",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function(dateText, inst) {// 关闭事件
		}  

	});
	$('#zichan_jianyanriqi_e').datepicker({
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
		yearRange: "-20:+20",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function(dateText, inst) {// 关闭事件
			$( "#zichan_daoqiriqi_e" ).datepicker( "option", "minDate", selectedDate );
		}  

	});
	$('#zichan_daoqiriqi_e').datepicker({
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
		yearRange: "-20:+20",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function(dateText, inst) {// 关闭事件
			$( "#zichan_jianyanriqi_e" ).datepicker( "option", "maxDate", selectedDate );
		}  

	});
	//计划日期查询
	$('#zichan_ruriqi_start').datepicker({
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
		yearRange: "-20:+20",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function( selectedDate ) {
			$( "#zichan_ruriqi_end" ).datepicker( "option", "minDate", selectedDate );
		}   

	});
	$('#zichan_ruriqi_end').datepicker({
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
		yearRange: "-20:+20",
		startView: "months",
		maxViewMode:"years",
		minViewMode:"months",
		onClose: function( selectedDate ) {
        $( "#zichan_ruriqi_start" ).datepicker( "option", "maxDate", selectedDate );
      }    

	});
});