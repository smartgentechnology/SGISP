
$(function(){
	//发送邮件
	$("[class='automail']").click(function(){
		var id=$(this).attr("name");
		var url=$('#automailurl').attr('name');
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
	//发送邮件
	$("[class='testmail']").click(function(){
		var id=$(this).attr("name");
		var url=$('#testmailurl').attr('name');
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
	//发送邮件
	$("[class='automailen']").click(function(){
		var id=$(this).attr("name");
		var url=$('#automailenurl').attr('name');
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
	//发送邮件
	$("[class='testmailen']").click(function(){
		var id=$(this).attr("name");
		var url=$('#testmailenurl').attr('name');
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
});