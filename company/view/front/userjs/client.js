// JavaScript Document
$(function(){
	var sender;
	$.ajax({
		url:'getuser.php',
		dataType:'text',
		success: function(data){
			sender=data;
		}	
	});
	var receiver;
	$.ajax({
		url:'getreceiver.php',
		dataType:'text',
		success: function(data){
			receiver=data;
		}
	});
	function showtime(){
		var mydate = new Date();
		var str = mydate.getHours() + ":";
		str += mydate.getMinutes() + ":";
		str += mydate.getSeconds();
		return str;
	}
	var str=showtime();
	$('#send').click(function(){
		send();
	});
	function send(){
			var sendtext=$('#sendtext').val();
			if(sendtext==''){
				alert('不能发送空内容！');	
			}else{
				
				$.ajax({
					url:'clientact.php',
					type:'POST',
					async:true,
					data:{
						sender:sender,
						receiver:receiver,
						rec_content:sendtext
					},
					success: function(data){
						if(data==1){
							$('#record').append('<div class="media"><a class="pull-right" href="#"><img class="media-object" src="view/front/userimage/logo.jpg"></a><div class="media-body text-right"><h5 class="media-heading">'+sender+'-'+str+'</h5><h5>'+sendtext+'</h5></div></div>');
							$('#sendtext').val('');
							$('#record').scrollTop($('#record')[0].scrollHeight);
						}
					}	
				});
				
				
			}
	}
	$('#sendtext').keydown(function(event){
		if(event.ctrlKey && event.which == 13 || event.which == 10) {
			send();
		} else if (event.shiftKey && event.which==13 || event.which == 10) {
			send();
		} 

	});
	var setting={
		url:'clientcomet.php',
		cache:false,
		async:true,
		type:'POST',
		data:{time:"10"}, 
		success: function(res){
				eval("var data="+res); 
				if(data!=""){
					$('#record').append('<div class="media"><a class="pull-left" href="#"><img class="media-object" src="view/front/userimage/logo.jpg"></a><div class="media-body"><h5 class="media-heading">'+data.sender+'-'+data.showtime+'</h5><h5>'+data.rec_content+'</h5></div></div>');
					$('#record').scrollTop($('#record')[0].scrollHeight);
				}
				window.setTimeout(function(){$.ajax(setting)},1000);
		}
	};
	$.ajax(setting);
});
