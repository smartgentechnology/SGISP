// JavaScript Document
$(function(){
	$('#baozhuang_sn_a').focus();
	var addurl=$('#baozhuang_sn_action').attr('name');
	//包装添加
	$('#baozhuang_sn_a').keydown(function(event){
		if(event.keyCode==13){
			var batch=$('#baozhuang_batch_a').val();
			var model=$('#baozhuang_model_a').val();
			var sn=$('#baozhuang_sn_a').val();
			if(sn !=""){
				if(sn.length==15){
					$.ajax({
						url:addurl,
						type:'POST',
							data:{
								batch:batch,
								model:model,
								sn:sn
							},
						success: function(msg){
							if(msg.state=='ok'){
								location.reload();
							}else{
								alert(msg.info);
								$('#baozhuang_sn_a').val('');
								$('#baozhuang_sn_a').focus();
							}
							
						}
					});			
				}else{
					alert("条形码的长度只能是15位！");
					$('#baozhuang_sn_a').focus();
					$('#baozhuang_sn_a').val('');
					
				}
			}	
		}
		
									
	});
	
	//包装删除按钮
	$('#lc_baozhuang_del').click(function(){
		var url=$(this).attr('name');
		var id="";
		$('#sample_1 .checkboxes:checked').each(function () {
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
	
	
});