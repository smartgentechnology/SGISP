// JavaScript Document
$(function(){
	//审核按钮
	$('#lc_fanxiuaudit_edit').click(function(){
		var url=$(this).attr('name');
		var id="";
		$('#sample_1 .checkboxes:checked').each(function () {
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
	
	//入库确认按钮
	$('#lc_fanxiuruku_edit').click(function(){
		var url=$(this).attr('name');
		var id="";
		$('#sample_1 .checkboxes:checked').each(function () {
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
	
	//返修退回按钮
	$('#lc_fanxiuexpress_edit').click(function(){
		var id="";
		$('#sample_1 .checkboxes:checked').each(function () {
			id+=$(this).val()+",";
		});
		$('#fanxiuexpress_id_e').val(id);
		//显示修改窗口
		$('#edit').css("display","");				
	});
	
	//退回信息
	var form3 = $('#form_fanxiuexpress_edit');
	var error3 = $('.alert-error', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		rules: {
			fanxiuexpress_expressid_e: {
				required: true
			}
		},

		messages: { // custom messages for radio buttons and checkboxes
			fanxiuexpress_expressid_e : {  
				required : "快递单号不能为空！",
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
			var url=$('#form_fanxiuexpress_edit').attr('name');
			var express=$('#fanxiuexpress_express_e').val();
			var expressid=$('#fanxiuexpress_expressid_e').val();
			var id=$('#fanxiuexpress_id_e').val();
			$.ajax({
				url:url,
				type:'POST',
				data:{
					express:express,
					expressid:expressid,
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