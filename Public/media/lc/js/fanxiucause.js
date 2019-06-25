
$(function(){
	
	$("#fanxiucause_barcode_e").focus();
	
	$('#fanxiucause_barcode_e').on('change', function(){
		var url=$('#form_fanxiucause_edit').attr('name');										  
		var barcode=$('#fanxiucause_barcode_e').val();
		if(barcode==''){
		}else{
			$.ajax({
				url:url,
				type:'GET',
				data:{
					barcode:barcode
				},
				success: function(msg){
					if(msg.state!='error'){
						//设置修改窗口的值
						$("#fanxiucause_bad_e option[value='"+msg.data["bad"]+"']").attr("selected", true);
						$('#fanxiucause_bad_cause_e').val(msg.data["bad_cause"]);
						$('#fanxiucause_improve_e').val(msg.data["improve"]);
						$('#fanxiucause_receive_date_e').val(msg.data["receive_date"]);
						$('#fanxiucause_result_e').val(msg.data['result']);
						$('#fanxiucause_product_e').val(msg.data['product']);
						$('#fanxiucause_hv_e').val(msg.data['hv']);
						$('#fanxiucause_sv_e').val(msg.data['sv']);
						$('#fanxiucause_hsv_e').val(msg.data['hsv']);
						$('#fanxiucause_fault_e').val(msg.data['fault']);
						if(msg.data['qz']!=''){
							$('#imgqz').attr("src",msg.data['qz']);
						}
						if(msg.data['qb']!=''){
							$('#imgqb').attr("src",msg.data['qb']);
						}
						$('#fanxiucause_maint_e').val(msg.data['maint']);
						if(msg.data['hz']!=''){
							$('#imghz').attr("src",msg.data['hz']);
						}
						if(msg.data['hb']!=''){
							$('#imghb').attr("src",msg.data['hb']);
						}
						$('#fanxiucause_id_e').val(msg.data['id']);
					}else{
						alert(msg.info);
						location.reload();
					}
					
				}
			});
		}
		
	});
	
	
	//修改部门验证
	var form3 = $('#form_fanxiucause_edit');
	var error3 = $('.alert-error', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
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
			var url=$('#form_fanxiucause_edit').attr('name');
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
	
	
});