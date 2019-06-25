
$(function(){
	//功能检验预览
	$("[class='gongneng']").click(function(){
		var id=$(this).attr("name");
		var url=$('#gongneng_view').attr('name');
		$.ajax({
			url:url,
			type:'GET',
			data:{
				id:id
			},
			success: function(msg){
				if(msg.state!='error'){
					var str='<table width="100%" class="table table-striped table-bordered table-hover"><tr><td>检验日期</td><td>质检人员</td><td>检验结果</td><td>不合格描述</td></tr>';
					
					for(var i=0;i<msg.data.length;i++){
						str=str+"<tr><td>"+msg.data[i]['quality_date']+"</td><td>"+msg.data[i]['quality_id']+"</td><td>"+msg.data[i]['result']+"</td><td>"+msg.data[i]['describe']+"</td></tr>";
					}
					
					str=str+"</table>";
					$('#lab_gongneng_view').html(str);
				}else{
					$('#lab_gongneng_view').text('');
				}
				
			}
		});
		$('#gongneng_view').modal({
			backdrop: 'static',//点击空白处不关闭对话框
			keyboard: false,//键盘关闭对话框
			show:true//弹出对话框
		});
	});
	
	//功能检验预览
	$("[class='baozhuang']").click(function(){
		var id=$(this).attr("name");
		var url=$('#baozhuang_view').attr('name');
		$.ajax({
			url:url,
			type:'GET',
			data:{
				id:id
			},
			success: function(msg){
				if(msg.state!='error'){
					var str='<table width="100%" class="table table-striped table-bordered table-hover"><tr><td>检验日期</td><td>质检人员</td><td>检验结果</td><td>不合格描述</td></tr>';
					
					for(var i=0;i<msg.data.length;i++){
						str=str+"<tr><td>"+msg.data[i]['quality_date']+"</td><td>"+msg.data[i]['quality_id']+"</td><td>"+msg.data[i]['result']+"</td><td>"+msg.data[i]['describe']+"</td></tr>";
					}
					
					str=str+"</table>";
					$('#lab_baozhuang_view').html(str);
				}else{
					$('#lab_baozhuang_view').text('');
				}
				
			}
		});
		$('#baozhuang_view').modal({
			backdrop: 'static',//点击空白处不关闭对话框
			keyboard: false,//键盘关闭对话框
			show:true//弹出对话框
		});
	});
	
	//修改按钮
	$('#lc_fanxiuquality_edit').click(function(){
		var id="";
		var flag=0;
		$('#sample_1 .checkboxes:checked').each(function () {
			id+=$(this).val()+",";
			flag+=1;
		});
		if(flag>1){
			$('#edit').css("display","none");
			alert('不能同时修改多个记录！');
		}else if(id==''){
			$('#edit').css("display","none");
			alert('至少选择一条记录！');
		}else if(flag=1){
			$('#fanxiuquality_id_e').val(id);
			//显示修改窗口
			$('#edit').css("display","");		
		}								
	});
	
	
	//修改部门验证
	var form3 = $('#form_fanxiuquality_edit');
	var error3 = $('.alert-error', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-inline', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "",
		
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
			var url=$('#form_fanxiuquality_edit').attr('name');
			var result=$('#fanxiuquality_qresult_e').val();
			var describe=$('#fanxiuquality_describe_e').val();
			var id=$('#fanxiuquality_id_e').val();
			if(result==2){
				if(describe==""){
					alert("不合格描述不能为空！");
				}else{
					$.ajax({
						url:url,
						type:'POST',
						data:{
							result:result,
							describe:describe,
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
			}else{
				$.ajax({
					url:url,
					type:'POST',
					data:{
						result:result,
						describe:describe,
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
	
	
});